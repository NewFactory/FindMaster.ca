<?php
/**
 * Represents the view for the plugin settings page.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   Universal_Connector_Admin
 * @author    Comelite IT Solutions LLC
 * @license   GPL-2.0+
 * @link      https://comelite.net
 * @copyright 2016 Comelite IT Solutions. All Rigths Reserved
 */

/**
 *-----------------------------------------
 * Do not delete this line
 * Added for security reasons: http://codex.wordpress.org/Theme_Development#Template_Files
 *-----------------------------------------
 */
defined('ABSPATH') or die("Direct access to the script does not allowed");
/*-----------------------------------------*/
?>

<?php
$settings_tabs = Universal_Connector_Settings::$settings_tabs;
?>

<div class="wrap">

    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>    

    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-1">

            <!-- main content -->
            <div id="post-body-content">

                <div class="meta-box-sortables1 ui-sortable1">
                    <div class="postbox">
                        <div class="inside">
                            <?php settings_errors();?>
							<h3 id="universal-connected" style="color: green; font-style: italic;">If you have the widget code, you only need to login to connect.</h3>					
							<iframe id="universal-site" src="https://universalchat.org/pages/dashboard" style="min-height: 550px; width : 100%; border: none; margin-top: 20px"></iframe>		
							
                            <form id="plugin-settings-form" action="options.php" method="POST">
                                <?php
								settings_fields(Universal_Connector_Settings::$settings_group_id);
								foreach ($settings_tabs as $tab_id => $tab) {
									echo '<div class="table ui-tabs-hide" id="' . $tab_id . '">';
									do_settings_sections($tab_id);
									echo '</div>';
								}								
								?>
                            </form>
                        </div>
                    </div>
                </div>

            </div><!-- #post-body-content -->

            <!-- sidebar -->
            <?php include_once '_sidebar-right.php';?>
            <!-- end sidebar -->

        </div><!-- #post-body-->

        <br class="clear">
    </div>  <!-- #poststuff -->


</div>

<script type='text/javascript'>

function listenMessage(msg) {
	console.log('got a new message:');
	console.log(msg);
	var data = msg.data;
	var type = data.type || data;
	
	switch(type){
		case 'mainWidgetCode':
		{
			var mainWidgetCode = data.mainWidgetCode;
			if(mainWidgetCode != null && mainWidgetCode != "")
			{
				jQuery('#universal_html_widget_code').val(data.mainWidgetCode);
				jQuery("#plugin-settings-form").submit();	
			}					
			return;
		}
		case 'ReadyForGettingCode':
		{
			var widgetCode = jQuery('#universal_html_widget_code').val();
			
			if(widgetCode == null || widgetCode == "")
			{
				sendMessage('EmptyWidgetCode');
			}
			return;
		}			
	}
}

function sendMessage(msg){
	var iframe = document.getElementById('universal-site').contentWindow;
	iframe.postMessage(msg, "*");
}

if (window.addEventListener) {
	window.addEventListener('message', listenMessage, false);
} else {
	window.attachEvent('onmessage', listenMessage);
}

jQuery(document).ready(function() {
		
	var widgetCode = jQuery('#universal_html_widget_code').val();	 
	 	 
	if(widgetCode != null && widgetCode != "")
	{
		jQuery('#universal-connected').html("Connected");
	}
	
});
</script>
