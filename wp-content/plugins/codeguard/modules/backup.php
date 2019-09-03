<?php
class backup extends module_as3b {

	public $name        = '';
	public $dirs        = array();
	public $size        = '';
	private $minus_path = array();
	private $dir_backup = '';


	//Getting avilable memory from the host.
	public function get_memory() {

		$fh  = fopen( '/proc/meminfo', 'r' );
		$mem = 0;
		while ( $line = fgets( $fh ) ) {
			$pieces = array();
			if ( preg_match( '/^MemFree:\s+(\d+)\skB$/', $line, $pieces ) ) {
				$mem = $pieces[1];
				break;
			}
		}
		fclose( $fh );

		if ( $mem <= 2000000 ) {
			$max_size_archive = 6800000; // 900000;  // bytes
		} else {
			$max_size_archive = 6800000; // 900000;  // bytes
		}

		return $max_size_archive;

	}

	//Deleting failed backups folders helper.
	public function rrmdir( $dir ) {
		if ( is_dir( $dir ) ) {
			$objects = scandir( $dir );
			foreach ( $objects as $object ) {
				if ( $object != '.' && $object != '..' ) {
					if ( is_dir( $dir . '/' . $object ) ) {
						rrmdir( $dir . '/' . $object );
					} else {
						unlink( $dir . '/' . $object );
					}
				}
			}
			rmdir( $dir );
		}
	}



	public function run() {
		try {
			main::log( lang::get( 'Starting backup process', false ) );

			$this->obtain_lock( 'backup' );

			// Delete failed backup folders if present
			$deledirs = main::getNameBackup( '', false, true );
			if ( $deledirs ) {
				foreach ( glob( BACKUP_DIR . '/' . $deledirs . '*' ) as $ziparchive_partial ) {
					main::log( lang::get( $ziparchive_partial . ' directory contents have been cleaned.', false ) );
					$this->rrmdir( $ziparchive_partial );
				}
			}

			$this->init();

			$max_size_archive = $this->get_memory();

			$blacklist_content = $this->getBlacklist();
			main::log( lang::get( 'Blacklist: ' . print_r( $blacklist_content, true ), false ) );

			main::log( lang::get( '' . $max_size_archive . ' memory found.', false ) );

			$mysql = $this->incMysql();
			$mysql->backup( $this->db_file );
			if ( @filesize( $this->db_file ) == 0 ) {
				throw new Exception( lang::get( 'ERROR: The MySQL user associated with WordPress does not have all of the access rights needed to back up your database.', false ) );
			} else {
				$size_dump = round( ( @filesize( $this->db_file ) / 1024 / 1024 ), 2 );
				main::log( str_replace( '%s', $size_dump, lang::get( 'Database backup successfully created (%s Mb): ', false ) ) . str_replace( ABSPATH, '', $this->db_file ) );
			}

			main::log( date_format( new DateTime( 'NOW' ), 'Y/m/d H:i:s' ) . ' ' . lang::get( 'Start get file list', false ) );
			$files = $this->createListFiles();
			main::log( date_format( new DateTime( 'NOW' ), 'Y/m/d H:i:s' ) . ' ' . lang::get( 'End get file list', false ) );
			$files[] = $this->db_file;

			$files_to_zip      = array();
			$files_to_zip_size = 0;
			if ( ( $n = count( $files ) ) > 0 ) {
				include main::getPluginDir() . '/libs/pclzip.lib.php';
				$archive = $this->dir_backup . '/' . $this->getArchive( $this->name );
				$zip     = new PclZip( $archive );
				$this->update_state( array( 'step' => 'archiving files' ) );
				main::log( lang::get( 'Adding files to backup', false ) );
				main::log( lang::get( 'Creating part: ', false ) . basename( $archive ) );
				for ( $i = 0; $i < $n; $i++ ) {
					if ( $files_to_zip_size > $max_size_archive ) {
						$zip->add( $files_to_zip, PCLZIP_OPT_REMOVE_PATH, ABSPATH );

						unset( $zip );
						unset( $files_to_zip );
						unset( $files_to_zip_size );

						$files_to_zip      = array();
						$files_to_zip_size = 0;

						$archive = $this->dir_backup . '/' . $this->getNextArchive( $this->name );
						main::log( lang::get( 'Creating part: ', false ) . basename( $archive ) );
						$zip = new PclZip( $archive );
					}
					$files_to_zip_size += @filesize( $files[ $i ] );
					$files_to_zip[]     = $files[ $i ];
				}
				if ( count( $files_to_zip ) > 0 ) {
					$zip->add( $files_to_zip, PCLZIP_OPT_REMOVE_PATH, ABSPATH );
				}

				// delete dump db
				main::log( lang::get( 'Removing temporary database dump file', false ) );
				main::remove( $this->db_file );

				$dirs = readDirectrory( $this->dir_backup, array( '.zip', '.md5' ) );
				$size = 0;
				if ( ( $n = count( $dirs ) ) > 0 ) {
					for ( $i = 0; $i < $n; $i++ ) {
						$size      += @filesize( $dirs[ $i ] );
						$dirs[ $i ] = basename( $dirs[ $i ] );
					}
				}
				$sizeMb = round( $size / 1024 / 1024, 2 ); // MB
				main::log( str_replace( '%s', $sizeMb, lang::get( 'Finished creating backup (%s Mb)', false ) ) );
				$this->dirs = $dirs;
				$this->size = $size;
			}
			$this->delete_state();
		} catch ( JobLockException $e ) {
			codeguard_beacon( 'backuperror', $this->params, $this->name, $e->getMessage() );
			$this->setError( $e->getMessage() );
		} catch ( Exception $e ) {
			codeguard_beacon( 'backuperror', $this->params, $this->name, $e->getMessage() );
			$this->setError( 'Could not create backup' );
		}
	}

	private function saveMd5( $file, $zip_file ) {
		if ( $this->md5_file ) {
			file_put_contents( $this->md5_file, $file . "\t" . md5_file( $file ) . "\t" . basename( $zip_file ) . "\n", FILE_APPEND );
		}
	}
	public function checkBackup() {
		$archives = glob( "{$this->dir_backup}" );
		if ( empty( $archives ) && count( $archives ) <= 1 ) {
			return false;
		}
		$n = count( $archives );
		$f = "{$this->name}({$n})";
		return $f;
	}

	private function getArchive( $name ) {
		$archives = glob( $this->dir_backup . "/{$name}-*.zip" );
		if ( empty( $archives ) ) {
			return "{$name}-1.zip";
		}
		$n = count( $archives );
		$f = "{$name}-{$n}.zip";
		return $f;
	}

	private function getNextArchive( $name ) {
		$archives = glob( $this->dir_backup . "/{$name}-*.zip" );
		$n        = 1 + count( $archives );
		$a        = "{$name}-{$n}.zip";
		return $a;
	}

	private function init() {
		$time             = isset( $this->params['time'] ) ? $this->params['time'] : 0;
		$this->time       = main::getNameBackup( $time, true );
		$this->name       = main::getNameBackup( $time, false );
		$this->dir_backup = BACKUP_DIR . '/' . $this->name;
		$this->checkBackup();
		if ( ! is_dir( $this->dir_backup ) ) {
			mkdir( $this->dir_backup, 0755 );
			main::setIndex( $this->dir_backup );
		}
		$this->md5_file = $this->dir_backup . '/' . $this->name . '.md5';
		$this->db_file  = $this->dir_backup . '/mysqldump.sql';

	}
}
