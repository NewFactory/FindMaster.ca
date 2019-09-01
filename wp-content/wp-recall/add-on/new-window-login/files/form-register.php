<?php 
global $typeform;
$f_reg = ($typeform=='register')? 'style="display:block;"': ''; ?>

<?php 
	global $rcl_options;
		if($rcl_options['nwl_options_style']=='full_pop'||$rcl_options['nwl_options_style']=='hueman'||$rcl_options['nwl_options_style']=='twenty_sixteen'||$rcl_options['nwl_options_style']=='sparkling'||$rcl_options['nwl_options_style']=='mdesign'||$rcl_options['nwl_options_style']=='flat'){ ?>
		
<div class="form-tab-rcl" id="register-form-rcl" <?php echo $f_reg; ?>>
	<div class="form_head">
<h2><?php _e('Registration','wp-recall'); ?></h2>     

	</div>
	
    <div class="form-block-rcl"><?php rcl_notice_form('register'); ?></div>

    <form action="<?php rcl_form_action('register'); ?>" method="post" enctype="multipart/form-data">
        <div class="form-block-rcl default-field">
            <input required type="text" placeholder="<?php _e('Login','wp-recall'); ?>" value="<?php echo $_REQUEST['user_login']; ?>" name="user_login" id="login-user">
            <i class="rcli fa-user"></i>
            <span class="required">*</span>
        </div>
        <div class="form-block-rcl default-field">
            <input required type="email" placeholder="<?php _e('E-mail','wp-recall'); ?>" value="<?php echo $_REQUEST['user_email']; ?>" name="user_email" id="email-user">
            <i class="rcli fa-at"></i>
            <span class="required">*</span>
        </div>
            <div class="form-block-rcl form_extend">
                <?php do_action( 'register_form' ); ?>
            </div>
        <div class="form-block-rcl form-tab">
            <input type="submit" class="recall-button" name="submit-register" value="<?php _e('Signup','wp-recall'); // Зарегистрироваться ?>">
		
		<div class="input-container-footer">
		<div class=""><?php if(!$typeform){ ?><a href="#" class="link-login-rcl link-tab-rcl nwl-login"><?php _e('Authorization ','wp-recall'); ?></a><?php } ?></div>
		</div>
            
            <?php echo wp_nonce_field('register-key-rcl','register_wpnonce',true,false); ?>
            <input type="hidden" name="redirect_to" value="<?php rcl_referer_url('register'); ?>">
        </div>
    </form>
</div>

<!-- ИЛИ -->		<?php } else { ?>

<div class="form-tab-rcl" id="register-form-rcl" <?php echo $f_reg; ?>>
	<div class="form_head">
            <div class="form_auth"><?php if(!$typeform){ ?><a href="#" class="link-login-rcl link-tab-rcl"><?php _e('Authorization ','wp-recall'); ?></a><?php } ?></div>
            <div class="form_reg form_active"><?php _e('Registration','wp-recall'); ?></div>
	</div>
	
    <div class="form-block-rcl"><?php rcl_notice_form('register'); ?></div>

    <form action="<?php rcl_form_action('register'); ?>" method="post" enctype="multipart/form-data">
        <div class="form-block-rcl default-field">
            <input required type="text" placeholder="<?php _e('Login','wp-recall'); ?>" value="<?php echo $_REQUEST['user_login']; ?>" name="user_login" id="login-user">
            <i class="rcli fa-user"></i>
            <span class="required">*</span>
        </div>
        <div class="form-block-rcl default-field">
            <input required type="email" placeholder="<?php _e('E-mail','wp-recall'); ?>" value="<?php echo $_REQUEST['user_email']; ?>" name="user_email" id="email-user">
            <i class="rcli fa-at"></i>
            <span class="required">*</span>
        </div>
            <div class="form-block-rcl form_extend">
                <?php do_action( 'register_form' ); ?>
            </div>
        <div class="form-block-rcl">
            <input type="submit" class="recall-button" name="submit-register" value="<?php _e('Signup','wp-recall'); // Зарегистрироваться ?>">
            
            <?php echo wp_nonce_field('register-key-rcl','register_wpnonce',true,false); ?>
            <input type="hidden" name="redirect_to" value="<?php rcl_referer_url('register'); ?>">
        </div>
    </form>
</div>

	<?php } ?>	