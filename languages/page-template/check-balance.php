<?php
/*
Template Name:Check Balance
*/
get_header('single');
?>
<?php
while ( have_posts() ) :the_post();?>
<a href="/shop/" class="u-promo-back u-step-back" data-ref="stepBack">Back to All Gift Cards</a>
<div class="c-page-header">
	<span class="c-page-header__heading" data-ref="tabTitle">Check Card Balance</span>
</div>
<div class="u-balance-wrapper">
	<form id="check_balance" method="POST">
		<input type="hidden" name="action" value="check_balance">
		
		<div class="c-box u-balance-box">
			<img src="/assets/img/logos/TDB-05.png" class="u-balance-box__logo">
			<input type="text" name="number" class="c-box__input u-balance-box__input" placeholder="Your Card Number...">
			<input type="text" name="regcode" class="c-box__input u-balance-box__input" placeholder="Your Card Reg Code...">
			<div class="g-recaptcha" data-sitekey="<?php echo get_field('google_captcha_key','options');?>"></div>
			<div class="c-form-error recaptcha-error"></div>
			<button class="button t-heading-six u-balance-box__button">Check Card Balance</button>
		</div>
	</form>
	<div class="u-balance-wrapper__balance">
		<div class="u-balance-wrapper__content">
			<div class="u-balance-instructions instructions" data-ref="instructions">
				<h2 class="t-heading-three u-balance-wrapper__heading">Enter your gift card number (without spaces) to view your balance</h2>
			</div>
			<div class="u-balance-instructions amountDisplay u-balance-instructions--disabled" data-ref="amountDisplay">
				<h2 class="t-heading-three u-balance-wrapper__heading">Your Current Balance is</h2>
				<span class="u-balance-wrapper__price" data-ref="amount"></span>
			</div>
		</div>
	</div>
</div>
<?php endwhile;?>
<?php
get_footer();?>
<script type="text/javascript" src="https://www.google.com/recaptcha/api.js" ></script>
	<script type="text/javascript">
	jQuery( document ).ready(function() {
		
  
  jQuery(document).on('click', '.u-balance-box__button', function(e){
  	e.preventDefault();
  	
  	response = grecaptcha.getResponse();
  	var cardnumber =jQuery('#check_balance').find('input[name="number"]').val();
  	var regcode =jQuery('#check_balance').find('input[name="regcode"]').val();
		if (response.length === 0) {
			jQuery( '.recaptcha-error').text( "reCAPTCHA is mandatory" );
			return false;
		}else{
			jQuery( '.recaptcha-error').text('');
		}
		if(cardnumber != "" && regcode !=""){
			jQuery( '.recaptcha-error').text('');
			jQuery.ajax({
        type:    "POST",
        url:     "<?php echo admin_url('admin-ajax.php'); ?>",
        data:    {action:'check_balance',cardnumber:cardnumber,regcode:regcode}, // serializes the form's elements.
        success: function(data)
        {
          console.log(data); 
          result = JSON.parse(data);
         if (result.status == 'failure') {
            message = 'That card number doesn\'t appear to be valid.'
	        } else {
	            message = result.balance;
	        }

	        jQuery('.u-balance-wrapper__price').text(message)

	        jQuery('.instructions').addClass('u-balance-instructions--disabled')

	        jQuery('.amountDisplay').removeClass('u-balance-instructions--disabled')
        }
    	});
		}else{
			jQuery( '.recaptcha-error').append('Please enter card detail');
			
		}
  });
});
</script>