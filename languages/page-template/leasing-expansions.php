<?php
/*
Template Name:Leasing & Expansions
*/
get_header();
while ( have_posts() ) :the_post();
	if (has_post_thumbnail( $post->ID ) ): 
  	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
  	$hero_image= $image[0]; 
  else:
  	$hero_image =home_url().'/assets/img/about/about-bg.png';
  endif;
  if(get_field('leasing_expansions_bg_mobile')):
  	$mobile_hero_image = get_field('leasing_expansions_bg_mobile');
  else:
  	$mobile_hero_image = $hero_image;
  endif;
	?>
	<div class="leasing">
   <div class="hero leasing-hero" style="background-image: url(<?php echo $hero_image;?>);" data-ref="responsiveVisualElement" data-mobile="<?php echo $mobile_hero_image;?>" data-desktop="<?php echo $hero_image;?>">
        <div class="leasing-content">
            <div class="leasing-overlay">
                <h3><?php the_field('leasing_expansions_subtitle');?></h3>
                <h1><?php the_field('leasing_expansions_title');?></h1>
                <div class="leasing-cols-frame">
                    <div class="leasing-cols leasing-desc">
                        <?php the_field('leasing_expansions_column_1');?>
                    </div>
                    <div class="leasing-cols leasing-qualifications">
                        <h4><?php the_field('leasing_expansions_column_2_title');?></h4>
                        <div class="leasing-qualifications-desc"><?php the_field('leasing_expansions_column_2');?></div>
                    </div>
                </div>
                <form id="leasingForm" method="POST" data-ref="leasingForm">
                    
                    <div class="c-box">
                        <div class="c-box__col">
                            <input type="text" name="first_name" class="c-box__input" placeholder="First Name*" aria-label="First Name" required>
                            <input type="text" name="last_name" class="c-box__input" placeholder="Last Name*" aria-label="Last Name" required>
                        </div>
                        <div class="c-box__col">
                            <input type="email" name="email" placeholder="Email*" aria-label="Email" class="c-box__input" required>
                        </div>
                        <div class="c-box__col">
                            <input type="text" name="phone" placeholder="Phone*" aria-label="Phone" class="c-box__input" required>
                        </div>
                        <div class="c-box__col c-box__col--shortened">
                            <input type="text" name="address1" placeholder="Street Address*" aria-label="Address Line 1" class="c-box__input" required>
                            <input type="text" name="address2" placeholder="Apt Name, Suite" aria-label="Address Line 2" class="c-box__input">
                        </div>
                        <div class="c-box__col c-box__col--shortened">
                            <input type="text" name="city" placeholder="Town / City*" aria-label="City" class="c-box__input" required>
                            <div class="unstyled c-box__input">
                                
                                <select id="state" name="state" data-ignore="true" data-ref="stateSelect" aria-label="State"><option disabled="" selected="">State</option>
                                  <?php get_template_part('template-parts/state','list');?>
                                </select>
                            </div>
                            <div class="unstyled c-box__input">
                               
                                <select id="country" name="country" data-ignore="true" data-ref="countrySelect" aria-label="Country" required="">
                                  <option disabled="" selected="">Country*</option>
                                  <?php get_template_part('template-parts/country','list');?>
                                </select>
                            </div>
                        </div>
                        <div class="c-box__col">
                            <input type="text" name="zipcode" placeholder="Postal Code / Zip*" aria-label="Zip Code" class="c-box__input" required>
                        </div>
                        <div class="c-box__col">
                            <input type="text" name="company" placeholder="Company*" aria-label="Company" class="c-box__input" required>
                            <input type="text" name="marketInterest" placeholder="Market of Interest" aria-label="Market of Interest" class="c-box__input">
                        </div>
                        <div class="c-box__col">
                            <textarea id="inquiry" name="inquiry" class="c-box__input" placeholder="inquiry*" aria-label="Your Inquiry" rows="6" style="resize: none;" data-ref="limitScroll" required></textarea>
                        </div>
                        <div class="c-box__col">
                            <div class="g-recaptcha mt-3" data-sitekey="6LcnlqEUAAAAAI2gOBufXKF1IBQ1Bcqh8jOzjNte"></div>
                        </div>
                        <div class="c-box__col">
                            <div class="c-form-error recaptcha-error mb-0"></div>
                        </div>
                    </div>
                    <button class="button leasing-submit">Submit</button>
										<strong class="success-msg hidden">Your submission has been successfully sent!<br><br></strong>
                    
                    
                </form>
            </div>
        </div>
    </div>
</div>
<?php endwhile;?>
<?php get_footer();?>
<script type="text/javascript" src="https://www.google.com/recaptcha/api.js"></script>
<script type="text/javascript">
    jQuery( '.leasing-submit' ).click(function(){
        response = grecaptcha.getResponse();
      
        if (response.length === 0) {
            jQuery( '.recaptcha-error').text( "reCAPTCHA is mandatory" );
            return false;
        }else{
            jQuery( '.recaptcha-error').text('');
        }
    });
    jQuery( document ).ready(function( $ ) {
        jQuery.noConflict();
    jQuery(document).on('click', '.leasing-submit', function(e){
      e.preventDefault();
      var form = jQuery("#leasingForm");
      var firstname = jQuery('#leasingForm').find('input[name="first_name"]').val();
      var lastName  = jQuery('#leasingForm').find('input[name="last_name"]').val();
      var email = jQuery('#leasingForm').find('input[name="email"]').val();
      var phone = jQuery('#leasingForm').find('input[name="phone"]').val();
      var company = jQuery('#leasingForm').find('input[name="company"]').val();
      var address1 = jQuery('#leasingForm').find('input[name="address1"]').val();
      var address2 = jQuery('#leasingForm').find('input[name="address2"]').val();
      var city = jQuery('#leasingForm').find('input[name="city"]').val();
      var state = jQuery("#state").val();
      var country = jQuery("#country").val();
      var zipcode = jQuery('#leasingForm').find('input[name="zipcode"]').val();
      var marketInterest = jQuery('#leasingForm').find('input[name="marketInterest"]').val();
      
      var comment = jQuery("#inquiry").val();
      
      jQuery.ajax({
        type: 'POST',
        url: "<?php echo admin_url('admin-ajax.php'); ?>",
        data: {action:'leasing_expansions',first_name:firstname,last_name:lastName,email:email,phone:phone,company:company,street_address:address1,apt_name:address2,towncity:city,state:state,country:country,postal_code:zipcode,market_of_interest:marketInterest,content:comment},
        
        success: function(data){

            var response = JSON.parse(data);
            console.log(response.message+response.redirect);
            jQuery(".success-msg").removeClass('hidden');
            if(response.message == "ok"){
                window.location.replace(response.redirect);
            } 
        }
    });
});
});
</script>