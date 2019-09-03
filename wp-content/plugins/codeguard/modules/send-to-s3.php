<?php

if ( ! class_exists( 'send_to_s3' ) ) {
	class send_to_s3 extends module_as3b {

		public function run() {
			require_once( main::getPluginDir() . '/libs/classes/S3.php' );
			require_once( main::getPluginDir() . '/libs/beacon.php' );
			$ad = $this->params['access_details'];
			codeguard_beacon( 'send', $this->params, $ad['backup_id'] );
			$files = $this->params['files'];
			$dir   = ( isset( $ad['dir'] ) ) ? $ad['dir'] : '/';

			$s3         = new S3( $ad['AccessKeyId'], $ad['SecretAccessKey'] );
			S3::$useSSL = true;
			S3::setExceptions( true );

			try {
				main::log( lang::get( 'Starting upload to CodeGuard', false ) );

				$this->obtain_lock( 'export' );

				$this->update_state( array( 'step' => 'uploading archive' ) );

				$n = count( $files );
				for ( $i = 0; $i < $n; $i++ ) {
					$filePath = preg_replace( '#[/\\\\]+#', '/', BACKUP_DIR . '/' . $dir . '/' . $files[ $i ] );
					if ( @filesize( $filePath ) < 1 ) {
						throw new Exception( 'Zip file part has size 0' );
					}
					$keyis = ( $dir ) ? $dir . '/' . basename( $filePath ) : basename( $filePath );
					$keyis = ltrim( preg_replace( '#[/\\\\]+#', '/', $keyis ), '/' );//if first will be '/', file not will be uploaded, but result will be ok

					try {

						main::log( str_replace( '%s', basename( $filePath ), lang::get( 'Uploading part: %s', false ) ) );
						$s3->putObjectFile( $filePath, $ad['bucket'], $ad['prefix'] . '/' . $keyis, S3::ACL_PRIVATE );

					} catch ( Exception $e ) {

						  main::log( str_replace( '%s', basename( $filePath ), lang::get( 'Failed to upload part: %s', false ) ) );

					}
				}
				$details = array( 'zip_count' => $n );

				$putRes = $s3->putObjectString( json_encode( $details ), $ad['bucket'], $ad['prefix'] . '/' . $ad['backup_id'] . '/details.json', S3::ACL_PRIVATE );

				$this->delete_state();
				main::log( lang::get( 'Finished uploading backup', false ) );
			} catch ( JobLockException $e ) {
				codeguard_beacon( 'sendfail', $this->params, $ad['backup_id'], $e->getMessage() );
				main::log( 'Error: ' . $e->getMessage() );
				$this->setError( $e->getMessage() );
			} catch ( S3Exception $e ) {
				codeguard_beacon( 'sendfail', $this->params, $ad['backup_id'], $e->getMessage() );
				main::log( 'Error: ' . $e->getMessage() );
				$this->setError( 'Error sending to CodeGuard' );
				return false;
			} catch ( Exception $e ) {
				codeguard_beacon( 'sendfail', $this->params, $ad['backup_id'], $e->getMessage() );
				main::log( 'Error: ' . $e->getMessage() );
				$this->setError( 'Error sending to CodeGuard' );
				return false;
			}
			return true;

		}

	}
}
