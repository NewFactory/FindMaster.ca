<div class="wrap codeguard">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<script>
		jQuery(document).ready(function(){
			jQuery('[data-toggle="tooltip"]').tooltip(); 
			
			jQuery(".update_settings").click(function() {
			  jQuery(".cfTabsContainer").fadeToggle();
			});

			// Pagination controls
			jQuery("div.cg_backup_paginate").jPages({
		      containerID : "cg_backup_list",
		      keyBrowse   : true,
		      previous : "←",
		      next : "→",
		      perPage : 5,
		      delay : 10
		    });

		    /* on select change */
		    jQuery("select").change(function(){
		        /* get new nº of items per page */
		      var newPerPage = parseInt( jQuery(this).val() );
		      /* destroy jPages and initiate plugin again */
		      jQuery("div.cg_backup_paginate").jPages("destroy").jPages({
		            containerID   : "cg_backup_list",
		            previous : "←",
		            next : "→",
		            perPage : newPerPage
		        });
		    });

		});
		process_flag = 0;
		function start_backup(type)
		{
			auth_param = <?php echo isset( $amazon_option['access_key_id'] ) && ! empty( $amazon_option['access_key_id'] ) &&
				isset( $amazon_option['secret_access_key'] ) && ! empty( $amazon_option['secret_access_key'] ) &&
				isset( $amazon_option['bucket'] ) && ! empty( $amazon_option['bucket'] ) ? 'false' : 'true'; ?> ;
			if (auth_param === false || type == 'local') { 
				var data_backup = {};
				data_backup['action'] = 'amazon-s3-backup_create';
				d = new Date();
				data_backup['time'] = Math.ceil(  (d.getTime() + (-d.getTimezoneOffset() * 60000 ) ) / 1000 );
				jQuery('.backup-button, .restore-button').addClass('btn-disabled');
				jQuery('#backup-message > p').html(`
					<img id="backup-spinner" style="vertical-align: middle; padding-right: 10px;" src="<?php ' . admin_url() . '?>images/loading.gif">
					A backup has started! This may take a few moments.
				`);
				jQuery('#backup-message').removeClass('failure-message');
				jQuery('#backup-message').addClass('success-message');
				jQuery("#backup-message").show("slow");
				jQuery("#log-backup").html('');
				jQuery("#action-buttons").css('margin-top', '8px'); 
				jQuery("#support-button").css('margin-top', '8px'); 
				jQuery(".title-logs").css('display', 'block');
				jQuery.ajax({
					type: "POST",
					url: ajaxurl,
					data: data_backup,
					beforeSend: function(){
						process_flag = 1
						processBar();
					},
					success: function(data){
						jQuery('.backup-button, .restore-button').removeClass('btn-disabled');
						process_flag = 0;
						jQuery('#backup-message').hide();
						if (data.result == 'success') {
							jQuery('.title-logs').css('display', 'none');
							jQuery('#backup-message').removeClass('failure-message');
							jQuery('#backup-message').addClass('success-message');
							jQuery('#backup-message > p').html('CodeGuard backup created successfully');
							if (data.error_count <= <?php echo UPGRADE_PROMPT_ERROR_THRESHOLD; ?>) {
								jQuery('#upgrade-prompt').css({'display':'none'});
							}
							showData(data);
						} else {
							jQuery('.title-logs').css('display', 'none');
							jQuery('#backup-message').removeClass('success-message');
							jQuery('#backup-message').addClass('failure-message');
							jQuery('#backup-message > p').html('CodeGuard backup failed: ' + data.error);
							if (data.error_count > <?php echo UPGRADE_PROMPT_ERROR_THRESHOLD; ?>) {
								jQuery('#error-count').html(data.error_count);
								jQuery('#upgrade-prompt').css({'display':'block'});
							}
						}
						jQuery('#backup-message').show('slow').delay(15000).hide( 'slow' );
						jQuery('.table').css('display', 'table');

					},
					error: function(){
						processStop();
					},
					dataType: 'json'
				});
			} else {
				jQuery('#is-amazon-auth').arcticmodal({
					beforeOpen: function(data, el) {
						jQuery('#is-amazon-auth').css('display','block');

					},
					afterClose: function(data, el) {
						jQuery('#is-amazon-auth').css('display','none');
						showSetting(false);
						blick('app_key', 4);
						blick('app_secret', 4);
					}
				});
			}
		}
		function showData(data)
		{
			if ( (typeof data) == 'object' ) {
				size_backup = data.size / 1024 / 1024;
				info = "";
				for(i = 0; i < data.data.length; i++) {
					e = data.data[i].split('/');
					info += '<tr style="border: 0;">' +
					'<td style="border: 0;padding: 0px;"><a href="<?php echo get_option( 'siteurl' ) . '/wpadm_backups/'; ?>' + data.name + '/' + e[e.length - 1] + '">' + e[e.length - 1] + '</td>' +
					'</tr>' ;
				}
				// last backup will be display first in table
				jQuery('.table > tbody > tr:first').before(
				'<tr>'+
				'<td class="pointer" style="text-align: left; padding-left: 7px;" >' +
				data.time + 
				'</td>' +
				'<td class="pointer">' +
				data.name +
				'</td>' +
				'<td class="pointer">' +
				size_backup.toFixed(2) + "Mb" +
				'</td>' +
				'<td>' +
				'<a href="javascript:void(0)" style="display: inline-block;" class="attention-button restore-button" title="<?php echo __( 'Restore', 'codeguard' ); ?>" onclick="recovery_form(\'' + data.type + '\', \'' + data.name + '\')"><span class="pointer dashicons dashicons-backup"></span><?php echo __( 'Restore', 'codeguard' ); ?></a> &nbsp;' +
				'<a href="javascript:void(0)" style="display: inline-block;" class="attention-button" title="<?php echo __( 'Delete', 'codeguard' ); ?>" onclick="delete_backup(\'' + data.name + '\', \'' + data.type + '\')"><span class="pointer dashicons dashicons-trash"></span><?php echo __( 'Delete', 'codeguard' ); ?></a> &nbsp;' +
				'</td>' +
				'</tr>')
			}
		}

	</script>
	<div>
		<?php
		if ( ! empty( $error ) ) {
				echo '<div class="error" style="text-align: center; color: red; font-weight:bold;">
                <p style="font-size: 16px;">
                ' . $error . '
                </p></div>';
		}
		?>
		<?php
		if ( ! empty( $msg ) ) {
				echo '<div class="updated" style="text-align: center; color: red; font-weight:bold;">
                <p style="font-size: 16px;">
                ' . $msg . '
                </p></div>';
		}
		?>
		<div id="is-amazon-auth" style="display: none; width: 400px; text-align: center; background: #fff; border: 2px solid #dde4ff; border-radius: 5px;">
			<div class="title-description" style="font-size: 20px; text-align: center;padding-top:45px; line-height: 30px;">
				<?php echo __( 'Please, add your Amazon credentials', 'codeguard' ); ?>:<br />
				<strong>"<?php echo __( 'Secret Key', 'codeguard' ); ?>"</strong>, <strong>"<?php echo __( 'Key ID', 'codeguard' ); ?>"</strong> & <strong>"<?php echo __( 'Bucket', 'codeguard' ); ?>"</strong> <br />
				in the Setting Form
			</div>
			<div class="button-description" style="padding:20px 0;padding-top:45px">
				<input type="button" value="<?php echo __( 'OK', 'codeguard' ); ?>" onclick="jQuery('#is-amazon-auth').arcticmodal('close');" style="text-align: center; width: 100px;" class="button-wpadm">
			</div>
		</div>
		<div id="helper-keys" style="display: none;width: 400px; text-align: center; background: #fff; border: 2px solid #dde4ff; border-radius: 5px;">
			<div id="key-info" style="display: none;">
				<div class="title-description" style="font-size: 20px; text-align: center;padding-top:20px; line-height: 30px;">
					<?php echo __( 'How to get Amazon S3<br /> Access Key ID & Secret Key?', 'codeguard' ); ?>
				</div>
				<div class="button-description" style="padding:20px 10px;padding-top:20px; text-align: left;">
					<?php
					echo '.__( "If you don\'t have an Amazon Web Services account yet, you need to <a href=http://aws.amazon.com>sign up</a>.
                    Once you\'ve signed up, you will need to <a href=https://console.aws.amazon.com/iam/home?region=us-east-1#users>create a new IAM user</a> and grant access to the specific services which this plugin will use (e.g. S3).","codeguard").'
?>
				</div>
			</div>
			<div id="bucket-info" style="display: none;">
				<div class="button-description" style="padding:20px 10px;padding-top:20px; text-align: left;">
					<div class="title-description" style="font-size: 20px; text-align: left; line-height: 30px;margin-bottom: 5px;">
						<?php echo __( 'What is Amazon Bucket?', 'codeguard' ); ?>
					</div>
					<?php echo __( "Bucket - it's Something like Folder in your PC, but the Bucket stay in the Cloud of your Cloud provider like Dropbox, Amazon S3 etc.<br />Read aditional documentation on <a href=http://docs.aws.amazon.com/AmazonS3/latest/dev/UsingBucket.html target=_blank>Amazon User Guide</a>", 'codeguard' ); ?>.<br />
					<div class="title-description" style="font-size: 20px; text-align: left;padding-top:20px; line-height: 30px; margin-bottom: 5px;">
						<?php echo __( 'How to create an Amazon Bucket?', 'codeguard' ); ?>
					</div>
					<?php echo __( 'For creating a bucket using Amazon S3 console, go to', 'codeguard' ); ?> <a href="http://docs.aws.amazon.com/AmazonS3/latest/UG/CreatingaBucket.html" target="_blank"><?php echo __( 'Creating a Bucket', 'codeguard' ); ?></a>  <?php echo __( 'in the <i>Amazon Simple Storage Service Console User Guide</i>', 'codeguard' ); ?>.
				</div>
			</div>

			<div class="button-description" style="padding:20px 0;padding-top:10px">
				<input type="button" value="OK" onclick="jQuery('#helper-keys').arcticmodal('close');" style="text-align: center; width: 100px;" class="button-wpadm">
			</div>
		</div>
		<div class="block-content" style="margin-top:20px;">
			<div style="padding-top: 10px;"> 
				<img class="log-amazon" src="<?php echo plugins_url( '/images/codeguard_logo.png', dirname( __FILE__ ) ); ?>"/>
				<p style="width: 100%; float: left; margin-top: 5px; margin-bottom: 0px;"><?php echo __( 'Automatic backups of your website and database occur every 24 hours. View more information in the', 'codeguard' ); ?> <a href="https://codeguard.com/login" target="_blank"><?php echo __( 'CodeGuard dashboard', 'codeguard' ); ?>.</a></p>
				<!--
				Display upgrade prompt after reaching a threshold of consecutive errors
				A successful backup or a new key clears this message
				-->
				<div id="upgrade-prompt" class="warning-message" style="display: <?php echo $error_count > UPGRADE_PROMPT_ERROR_THRESHOLD ? 'block' : 'none'; ?>; background-image: url(<?php echo plugins_url( '/images/stripes_bg.png', dirname( __FILE__ ) ); ?>); -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
					<strong><span id="error-count"><?php echo $error_count; ?></span></strong> <?php echo __( 'consecutive errors have occurred during your recent backups. If errors continue to occur, you may be a good candidate for our SFTP + MySQL backup solution. Please visit the', 'codeguard' ); ?> <a href="https://www.codeguard.com/support"><?php echo __( 'CodeGuard support center', 'codeguard' ); ?></a> <?php echo __( 'for more information', 'codeguard' ); ?>.
				</div>
					<!-- display plugins & space size-->
					<?php
					$disable_size_check = filter_var(
						get_option( PREFIX_CODEGUARD . 'disable_size_check' ),
						FILTER_VALIDATE_BOOLEAN
					);
					if ( ! $disable_size_check ) {
						cg_get_space_count();
					}
					?>
					<!-- display plugins & space size-->
			</div>

			<!-- create backup buttons -->
			<div class="" style="margin-top:10px;">
			<div id="backup-message" style="background-image: url(<?php echo plugins_url( '/images/stripes_bg.png', dirname( __FILE__ ) ); ?>); display: none; float:left; clear: both; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
				<p style="text-align: left; margin: 0px;"/>
			</div>
			<div id="restore-message" style="background-image: url(<?php echo plugins_url( '/images/stripes_bg.png', dirname( __FILE__ ) ); ?>); display: none; float:left; clear: both; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
				<p style="text-align: left; margin: 0px;"/>
			</div>
			<div id="action-buttons" style="">
				<div style="float: left; margin-top: 20px; clear: both;">
					<button onclick="start_backup('s3')" class="big-button backup-button"><?php echo __( 'Create Backup', 'codeguard' ); ?></button>
				</div>
				<div style="clear: both;"></div>
			</div>
		</div>
		<div style="margin-bottom: 20px; clear: both;"></div>

		<div>
			<form action="" method="post" id="form_auth_backup" name="form_auth_backup"></form>
			<form action="<?php echo admin_url( 'admin-post.php?action=amazon-s3-backup_delete_backup' ); ?>" method="post" id="delete_backups" name="delete_backups">
				<input type="hidden" name="backup-name" id="backup_name" value="" />
				<input type="hidden" name="backup-type" id="backup_type" value="" />
			</form>

			

			<table class="table site-list" style="margin-top: 5px; display: <?php echo isset( $data['md5'] ) && ( $n = count( $data['data'] ) ) && is_array( $data['data'][0] ) ? 'table' : 'none'; ?>;">
				<thead>
					<tr>
						<th align="left"><?php echo __( 'Backup Time', 'codeguard' ); ?></th>
						<th><?php echo __( 'Name', 'codeguard' ); ?></th>
						<th><?php echo __( 'Size', 'codeguard' ); ?></th>
						<?php if ( is_admin() || is_super_admin() ) { ?>
							<th><?php echo __( 'Action', 'codeguard' ); ?></th>
							<?php
}
						?>
					</tr>
				</thead>
				<tbody id="cg_backup_list">
					<?php
					if ( isset( $data['md5'] ) && isset( $data['data'] ) && ( $n = count( $data['data'] ) ) && is_array( $data['data'][0] ) ) {
						for ( $i = 0; $i < $n; $i++ ) {
							$size = $data['data'][ $i ]['size'] / 1024 / 1024; /// MByte
							$size = round( $size, 2 );
							?>
							<?php if ( strpos( $data['data'][ $i ]['files'], 'json' ) !== false ) {  //checking if json file is there ?>
								<tr>
									<td class="pointer" style="text-align: left; padding-left: 7px;"><?php echo $data['data'][ $i ]['dt']; ?></td>
									<td class="pointer"><?php echo $data['data'][ $i ]['name']; ?></td>
									<td class="pointer"><?php echo $size . 'Mb'; ?></td>
									<?php if ( is_admin() || is_super_admin() ) { ?>
										<td style="width: 300px;">
											<button class="attention-button restore-button" style="display: inline-block;" title="<?php echo __( 'Restore', 'codeguard' ); ?>" onclick="recovery_form('<?php echo $data['data'][ $i ]['type']; ?>', '<?php echo $data['data'][ $i ]['name']; ?>')"><span class="pointer dashicons dashicons-backup"></span><?php echo __( 'Restore', 'codeguard' ); ?></button>&nbsp;
											<button class="attention-button" style="display: inline-block;" title="<?php echo __( 'Delete', 'codeguard' ); ?>" onclick="delete_backup('<?php echo $data['data'][ $i ]['name']; ?>', '<?php echo $data['data'][ $i ]['type']; ?>')"><span class="pointer dashicons dashicons-trash"></span><?php echo __( 'Delete', 'codeguard' ); ?></button>&nbsp;
										</td>
									<?php } ?>
								</tr>
								<?php } ?>
							<?php } ?>
					<?php } ?>
				</tbody>
			</table>

		</div>

			<div class="cfTabsContainer" style="float: left; clear: both; padding-bottom: 0px; padding-top: 0px;<?php echo isset( $amazon_option['codeguard_key'] ) ? 'display:none;' : ''; ?>">
				<div id="setting_active" class="cfContentContainer" style="margin: 15px;">
					<form method="post" action="" >
						<div class="stat-wpadm-registr-info" style="width: auto; margin-bottom: 5px;">
							<div  style="margin-bottom: 12px; margin-top: 20px; font-size: 15px;">
								<?php echo __( 'Copy and paste your <strong>Unique Access Key</strong> here', 'codeguard' ); ?>:
							</div>
							<table class="form-table stat-table-registr" style="margin-top:2px">
								<tbody>
									<tr valign="top">
										<td>
											<input id="codeguard_key" oninput="toggleButton()" class="" type="text" name="codeguard_key" placeholder="<?php echo __( 'Unique Access Key', 'codeguard' ); ?>" value="<?php echo isset( $amazon_option['codeguard_key'] ) ? $amazon_option['codeguard_key'] : ''; ?>" style="width: 100%; padding: 10px 13px; margin-bottom: 10px;">
										</td>
									</tr>
									<tr valign="top">
										<td>
											<input class="big-button" type="submit" value="<?php echo __( 'Save', 'codeguard' ); ?>" id="enterKeyButton">
											<a href="https://www.codeguard.com/wordpress-plugin" style="position: absolute; padding: 20px;" target="_blank"><?php echo __( 'Need a new Access Key?', 'codeguard' ); ?></a>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</form>
				</div>
			</div>
		<a href="javascript:void(0);" style="<?php echo isset( $amazon_option['codeguard_key'] ) ? '' : 'display:none;'; ?>" class="update_settings"><?php echo __( 'Update Settings', 'codeguard' ); ?></a>

		<!-- Backup pagination-->
		<form class="cg_backup_per_page">
	        <label>Backups per page: </label>
	        <select>
	            <option>5</option>
	            <option>10</option>
	            <option>20</option>
	            <option>50</option>
	            <option>100</option>
	        </select>
	    </form>

	    <div class="cg_backup_paginate"></div>
	    <!-- Backup pagination-->

		</div>

	</div>
</div>
