<?php
	global $typeform;
if(!$typeform||$typeform=='sign') $f_sign = 'style="display:block;"'; ?>
	
<!--
<style>
.responsive{
 -webkit-filter: url(#blur);
 filter: url(#blur);
 -webkit-filter: blur(3px);
 filter: blur(3px);
 filter:progid:DXImageTransform.Microsoft.Blur(PixelRadius='3');
 -webkit-transition: 1s -webkit-filter linear;
 transition: 1s filter linear;
}
</style>
<script>
document.getElementsByTagName('body')[0].className += ' responsive';
</script>
-->


<?
	global $rcl_options;
		if($rcl_options['nwl_options_style']=='full_pop'||$rcl_options['nwl_options_style']=='hueman'||$rcl_options['nwl_options_style']=='twenty_sixteen'||$rcl_options['nwl_options_style']=='sparkling'||$rcl_options['nwl_options_style']=='mdesign'||$rcl_options['nwl_options_style']=='flat'){ ?>

	<a href="#" class="close-popup"><span class="close-popup-plus">+</span></a><!--иконка отображается как fa-times-circle -->
	
<div class="form-tab-rcl" id="login-form-rcl" <?php echo $f_sign; ?>>
    <div class="form_head">
<h2><?php _e('Authorization ','wp-recall'); ?></h2>
    </div>
    <div class="form-block-rcl"><?php rcl_notice_form('login'); ?></div>

    <form action="<?php rcl_form_action('login'); ?>" method="post">
        <div class="form-block-rcl default-field"> 
		
		
		<span class="required">*</span>
		
		
            <input required type="text" placeholder="<?php _e('Login','wp-recall'); ?>" value="<?php echo $_REQUEST['user_login']; ?>" name="user_login">
            <i class="rcli fa-user"></i>
            <span class="required">*</span>
        </div>
        <div class="form-block-rcl default-field">
            <input required type="password" placeholder="<?php _e('Password','wp-recall'); ?>" value="<?php echo $_REQUEST['user_pass']; ?>" name="user_pass">
            <i class="rcli fa-lock"></i>
            <span class="required">*</span>
        </div>
        <div class="form-block-rcl">
            <?php do_action( 'login_form' ); ?>

            <div class="default-field rcl-field-input type-checkbox-input">
                <div class="rcl-checkbox-box">
                    <input type="checkbox" id="chck_remember" class="checkbox-custom" value="1" name="rememberme">
                    <label class="block-label" for="chck_remember"><?php _e('Remember','wp-recall'); ?></label>
                </div>
            </div>
        </div>
        <div class="form-block-rcl form-tab">
            <input type="submit" class="recall-button link-tab-form" name="submit-login" value="<?php _e('Entry','wp-recall'); ?>">

		<div class="input-container-footer">
        <div class=""><?php if(!$typeform){ ?>
		<a href="#" class="link-register-rcl link-tab-rcl nwl-register "><?php _e('Registration','wp-recall'); ?></a><?php } ?></div>
		
		<a href="#" class="link-remember-rcl link-tab-rcl nwl-forgot "><?php _e('Lost your Password','wp-recall'); // Забыли пароль ?>?</a>
		</div>
		
            <?php echo wp_nonce_field('login-key-rcl','login_wpnonce',true,false); ?>
            <input type="hidden" name="redirect_to" value="<?php rcl_referer_url('login'); ?>">
        </div>
    </form>
</div>
		
<!-- ИЛИ -->		
<?php 
}else{
?>

<div class="form-tab-rcl" id="login-form-rcl" <?php echo $f_sign; ?>>
    <div class="form_head">
        <div class="form_auth form_active"><?php _e('Authorization','wp-recall'); ?></div>
        <div class="form_reg"><?php if(!$typeform){ ?><a href="#" class="link-register-rcl link-tab-rcl "><?php _e('Registration','wp-recall'); ?></a><?php } ?></div>
    </div>

    <div class="form-block-rcl"><?php rcl_notice_form('login'); ?></div>

    <form action="<?php rcl_form_action('login'); ?>" method="post">
        <div class="form-block-rcl default-field">
            <input required type="text" placeholder="<?php _e('Login','wp-recall'); ?>" value="<?php echo $_REQUEST['user_login']; ?>" name="user_login">
            <i class="rcli fa-user"></i>
            <span class="required">*</span>
        </div>
        <div class="form-block-rcl default-field">
            <input required type="password" placeholder="<?php _e('Password','wp-recall'); ?>" value="<?php echo $_REQUEST['user_pass']; ?>" name="user_pass">
            <i class="rcli fa-lock"></i>
            <span class="required">*</span>
        </div>
        <div class="form-block-rcl">
            <?php do_action( 'login_form' ); ?>

            <div class="default-field rcl-field-input type-checkbox-input">
                <div class="rcl-checkbox-box">
                    <input type="checkbox" id="chck_remember" class="checkbox-custom" value="1" name="rememberme">
                    <label class="block-label" for="chck_remember"><?php _e('Remember','wp-recall'); ?></label>
                </div>
            </div>
        </div>
        <div class="form-block-rcl">
            <input type="submit" class="recall-button link-tab-form" name="submit-login" value="<?php _e('Entry','wp-recall'); ?>">
            <a href="#" class="link-remember-rcl link-tab-rcl "><?php _e('Lost your Password','wp-recall'); // Забыли пароль ?>?</a>
            <?php echo wp_nonce_field('login-key-rcl','login_wpnonce',true,false); ?>
            <input type="hidden" name="redirect_to" value="<?php rcl_referer_url('login'); ?>">
        </div>
    </form>
</div>	
<?php } ?>	