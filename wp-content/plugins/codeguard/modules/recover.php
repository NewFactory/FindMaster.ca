<?php
class recover extends module_as3b {

	private $files = array();

	public function run() {
		// TODO: Fetch backup_id on restore to include in beacon reports
		include_once( main::getPluginDir() . '/libs/beacon.php' );
		codeguard_beacon( 'recover', $this->params );
		try {
			main::log( lang::get( 'Starting restore process', false ) );

			$this->obtain_lock( 'restore' );

			if ( isset( $this->params['name'] ) && isset( $this->params['type'] ) ) {
				if ( $this->params['type'] == 'local' ) {
					$this->local();
				} elseif ( $this->params['type'] == 's3' ) {
					$this->s3();
				}
				main::log( lang::get( 'Finished restore process', false ) );
			} else {
				$this->setError( lang::get( 'Error: Could not find the specified backup.', false ) );
			}
			$this->delete_state();
		} catch ( JobLockException $e ) {
			codeguard_beacon( 'recovererror', $this->params, '', $e->getMessage() );
			$this->setError( $e->getMessage() );
		} catch ( Exception $e ) {
			codeguard_beacon( 'recovererror', $this->params, '', $e->getMessage() );
			$this->setError( 'Could not restore backup' );
		}
	}

	private function s3() {
		$amazon_option = get_option( PREFIX_CODEGUARD . 'setting' );
		if ( $amazon_option ) {
			require_once main::getPluginDir() . '/libs/classes/S3.php';
			try {
				$dir = BACKUP_DIR . '/' . $this->params['name'];

				$s3 = new S3( $amazon_option['access_key_id'], $amazon_option['secret_access_key'] );
				main::log( lang::get( 'Downloading backup', false ) );
				$this->update_state( array( 'step' => 'downloading archive' ) );
				$keys = $s3->getBucket( $amazon_option['bucket'], $amazon_option['prefix'] . '/' . $this->params['name'] );

				if ( isset( $keys ) ) {
					$n = count( $keys );
					main::mkdir( $dir );
					main::log( lang::get( 'Downloading files', false ) );
					for ( $i = 0; $i < $n; $i++ ) {
						$path = explode( '/', $keys[ $i ]['Key'] );
						if ( isset( $path[1] ) && isset( $path[2] ) && ! empty( $path[2] ) ) {
							$part_path = substr( $keys[ $i ]['Key'], strlen( $amazon_option['prefix'] . '/' ) );
							main::log( str_replace( '%s', $part_path, lang::get( 'Downloading part: %s', false ) ) );

							$result = $s3->getObject( $amazon_option['bucket'], $keys[ $i ]['Key'], BACKUP_DIR . '/' . $part_path );

						}
					}
					main::log( lang::get( 'Finished downloading files', false ) );

					$this->local();
					if ( is_dir( $dir ) ) {
						main::remove( $dir );
					}
				} else {
					$this->setError( lang::get( 'Error: Could not download backup.', false ) );
				}
			} catch ( Exception $e ) {
					  include_once( main::getPluginDir() . '/libs/beacon.php' );
					  codeguard_beacon( 'recovererror', $this->params, '', $e->getMessage() );
					  $this->setError( $e->getMessage() );
			} catch ( S3Exception $e ) {
				include_once( main::getPluginDir() . '/libs/beacon.php' );
				codeguard_beacon( 'recovererror', $this->params, '', $e->getMessage() );
				$this->setError( $e->getMessage() );
			}
		} else {
			$this->setError( lang::get( 'Error: Could not connect to CodeGuard. Please update your connection settings.', false ) );
		}
	}

	private function local() {
		$this->files = readDirectrory( BACKUP_DIR . '/' . $this->params['name'], array( '.zip' ) );
		include main::getPluginDir() . '/libs/pclzip.lib.php';

		if ( ( $n = count( $this->files ) ) > 0 ) {
			$files_on_disk   = $this->createListFiles();
			$files_in_backup = array();

			// Extract files
			$this->update_state( array( 'step' => 'restoring files' ) );
			for ( $i = 0; $i < $n; $i ++ ) {
				main::log( str_replace( '%s', basename( $this->files[ $i ] ), lang::get( 'Extracting part: %s', false ) ) );
				$this->archive = new PclZip( $this->files[ $i ] );
				$contents      = $this->archive->listContent();
				foreach ( $contents as $zf ) {
					$filename = ABSPATH . $zf['filename'];
					array_push( $files_in_backup, $filename );
					if ( ! $this->isBlacklisted( $filename ) ) {
						main::log( lang::get( 'Restoring path: ' . $filename, false ) );
						$this->archive->extractByIndex(
							$zf['index'],
							PCLZIP_OPT_PATH, ABSPATH,
							PCLZIP_OPT_REPLACE_NEWER
						);
					} else {
						main::log( lang::get( 'Skipping path: ' . $filename, false ) );
					}
				}
			}

			$user_id = get_current_user_id();

			// Restore database
			$this->update_state( array( 'step' => 'restoring database' ) );
			if ( file_exists( BACKUP_DIR . '/' . $this->params['name'] . '/mysqldump.sql' ) ) {
				main::log( lang::get( 'Starting database restore', false ) );
				$mysql = $this->incMysql();
				$mysql->restore( BACKUP_DIR . '/' . $this->params['name'] . '/mysqldump.sql' );
				main::remove( BACKUP_DIR . '/' . $this->params['name'] . '/mysqldump.sql' );
				main::log( lang::get( 'Finished database restore', false ) );
			}

			// The user's session tokens were replaced when we restored the database,
			// so log them back in
			wp_set_auth_cookie( $user_id );

			// Remove files on disk (excluding blacklisted files) that are not
			// included in the backup
			$this->update_state( array( 'step' => 'removing files' ) );
			$files_to_remove = array_diff( $files_on_disk, $files_in_backup );
			foreach ( $files_to_remove as $f ) {
				main::log( lang::get( 'Removing path: ' . $f, false ) );
				unlink( $f );
			}
		}
	}
}
