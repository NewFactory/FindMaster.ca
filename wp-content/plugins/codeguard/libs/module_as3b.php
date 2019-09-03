<?php
if ( ! class_exists( 'module_as3b' ) ) {
	class module_as3b {

		public $params       = array();
		public $result       = null;
		public $exclusions   = null;
		public $max_lifetime = 300;

		public function __construct( $params ) {
			$this->result = new result();
			$this->params = $params;
		}

		public function setError( $error ) {
			$this->result->setError( $error )->setResult( RESULT_ERROR );
		}
		public function setResult( $data = array(), $size = '' ) {
			$this->result->setResult( RESULT_SUCCESS )->setSize( $size )->setData( $data );
		}

		public function incMysql() {
			include main::getPluginDir() . '/libs/classes/as3b-mysql.php';
			$mysql = new as3b_mysql();
			$mysql->connect();
			return $mysql;
		}

		public function getBlacklist() {
			$blacklist_contents = array();

			// Look for the blacklist file option
			$blacklist_file_path = $this->getBlacklistFilePath();

			// If one is specified, but not readable raise an exception.
			if ( $blacklist_file_path ) {
				if ( ! is_readable( $blacklist_file_path ) ) {
					throw new Exception( lang::get( 'ERROR: The specified CodeGuard Blacklist file (' . $blacklist_file_path . ') is not present or is not readable.', false ) );
				}
				// Else, fall back to the default
			} else {
				$blacklist_file_path = $this->defaultBlacklistFilePath();
				// If it exists, but is not readable, raise an exception
				if ( file_exists( $blacklist_file_path ) ) {
					if ( ! is_readable( $blacklist_file_path ) ) {
						throw new Exception( lang::get( 'ERROR: The default CodeGuard Blacklist file (' . $blacklist_file_path . ') exists, but is not readable.', false ) );
					}
					//Else, no blacklist file to parse
				} else {
					unset( $blacklist_file_path );
				}
			}

			// If we have a valid, readable file, then parse it
			if ( isset( $blacklist_file_path ) ) {
				main::log( lang::get( 'Blacklist Path: ' . $blacklist_file_path, false ) );
				$blacklist_contents = file( $blacklist_file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
			}

			// Convert relative paths into absolute paths
			$blacklist_contents = array_map(
				function( $p ) {
					return preg_replace( '/^.\//', ABSPATH, $p );
				}, $blacklist_contents
			);

			return array_merge( $blacklist_contents, $this->getDefaultBlacklist() );
		}

		public function getDefaultBlacklist() {
			return array(
				main::getPluginDir() . '/*',
			);
		}

		public function getBlacklistFilePath() {
			return get_option( PREFIX_CODEGUARD . 'blacklist_file_path' );
		}

		public function setBlacklistFilePath( $path ) {
			update_option( PREFIX_CODEGUARD . 'blacklist_file_path', $path );
		}

		private function defaultBlacklistFilePath() {
			return ABSPATH . '.codeguard_blacklist';
		}

		// Given a path, returns whether or not it is blacklisted. Blacklisted
		// paths should not be backed up or modified during restores.
		public function isBlacklisted( $path ) {
			if ( ! isset( $this->exclusions ) ) {
				$this->exclusions = $this->getBlacklist();
			}
			foreach ( $this->exclusions as $e ) {
				if ( preg_match( $this->regexify( $e ), $path ) ) {
					return true;
				}
			}
			return false;
		}

		public function createListFiles() {
			$files = array(
				ABSPATH . '.htaccess',
				ABSPATH . 'index.php',
				ABSPATH . 'license.txt',
				ABSPATH . 'readme.html',
				ABSPATH . 'wp-activate.php',
				ABSPATH . 'wp-blog-header.php',
				ABSPATH . 'wp-comments-post.php',
				ABSPATH . 'wp-config.php',
				ABSPATH . 'wp-config-sample.php',
				ABSPATH . 'wp-cron.php',
				ABSPATH . 'wp-links-opml.php',
				ABSPATH . 'wp-load.php',
				ABSPATH . 'wp-login.php',
				ABSPATH . 'wp-mail.php',
				ABSPATH . 'wp-settings.php',
				ABSPATH . 'wp-signup.php',
				ABSPATH . 'wp-trackback.php',
				ABSPATH . 'xmlrpc.php',
			);

			$folders = array(
				ABSPATH . 'wp-admin',
				ABSPATH . 'wp-content',
				ABSPATH . 'wp-includes',
			);
			if ( ! empty( $this->params['plus-path'] ) ) {
				$plus_path = explode( ',', $this->params['plus-path'] );
				foreach ( $plus_path as $p ) {
					if ( empty( $p ) ) {
						continue;
					}
					$p = ABSPATH . $p;
					if ( file_exists( $p ) ) {
						if ( is_dir( $p ) ) {
							$folders[] = $p;
						} else {
							$files[] = $p;
						}
					}
				}
			}
			foreach ( $folders as $folder ) {
				if ( ! is_dir( $folder ) ) {
					continue;
				}
				$files = array_merge( $files, readdirectrory( $folder ) );
			}

			// Filter out blacklisted files
			$files = array_values(
				array_filter(
					$files, function( $f ) {
						return ! $this->isBlacklisted( $f );
					}
				)
			);

			return $files;
		}

		// Convert custom glob-like pattern to regex.
		//
		// `**` matches anything including directories, subdirectories, and the
		//      files within.
		// `*`  matches anything as long as it does not cross directory
		//      boundaries (`/`).
		// `?`  matches any single character, except for `/`.
		//
		// Other metacharacters are not supported.
		private function regexify( $pattern ) {
			$pattern      = preg_replace( '/\*?\*$/', '**', $pattern );
			$replacements = array(
				'\*\*' => '.*',
				'\*'   => '[^/]*',
				'\?'   => '[^/]',
			);
			return '#^' . strtr( preg_quote( $pattern, '#' ), $replacements ) . '$#';
		}

		private function state_filename() {
			return main::getPluginDir() . '/logs/state';
		}

		protected function update_state( $state ) {
			$state = array_merge( $this->get_state(), $state );
			file_put_contents( $this->state_filename(), json_encode( $state ) );
		}

		protected function get_state() {
			if ( ! file_exists( $this->state_filename() ) ) {
				return array();
			}
			return json_decode( file_get_contents( $this->state_filename() ), true );
		}

		protected function delete_state() {
			unlink( $this->state_filename() );
		}

		protected function set_state( $state ) {
			// If a non-expired state exists, return false
			$states =  $this->get_state();
			$expiration = $states['expiration'];
			if ( isset( $expiration ) && time() < $expiration ) {
				return false;
			}
			if ( ! isset( $state['expiration'] ) ) {
				$state['expiration'] = time() + $this->max_lifetime;
			}
			file_put_contents( $this->state_filename(), json_encode( $state ) );
			return true;
		}

		protected function obtain_lock( $type ) {
			// Prevent other backups/restores by setting the state
			if ( ! $this->set_state( array( 'type' => $type ) ) ) {
				throw new JobLockException( lang::get( 'A restore or backup is already in progress', false ) );
			}
		}
	}

	class JobLockException extends Exception { }
}
