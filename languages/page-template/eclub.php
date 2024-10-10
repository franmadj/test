<?php 
/*
Template Name:Join Eclub
*/
get_header('single');
?>
<?php
while ( have_posts() ) :the_post(); ?>
    <div class="c-page-header">
        <h1 class="c-page-header__heading">Join Our eClub for Exclusive Deals</h1>
    </div>
    <div class="o-container">
        <div class="o-grid u-eclub-wrapper">
            <div class="o-col" data-el="target-o-col-first">
                <div class="c-box u-eclub-form">
                    <form action="http://TexasdeBrazil.fbmta.com/members/subscribe.aspx" method="post" data-ref="clubForm">
                        <input type="hidden" name="Action" id="Action" value="subscribe">
                        <input type="hidden" name="Action" id="Action" value="subscribe">
                        <input type="hidden" name="_InputSource_" value="w">
                        <input type="hidden" name="ListID" value="23622320156">
                        <input type="hidden" name="SiteGUID" value="4E1BF72E-AE6F-45FA-A257-C55651B6770A">
                        <input type="hidden" name="SuppressConfirmation" value="yes">
                        <input type="hidden" name="ReturnURL" value="<?php home_url();?>/thanks?from=eclub">
                        <div class="c-box__col">
                            <input type="email" name="EmailAddress" placeholder="Your Email*" aria-label="Email" class="c-box__input" required>
                        </div>
                        <div class="c-box__col">
                            <input type="text" name="FirstName" placeholder="First Name*" aria-label="First Name" class="c-box__input" required>
                        </div>
                        <div class="c-box__col">
                            <input type="text" name="LastName" placeholder="Last Name*" aria-label="Last Name" class="c-box__input" required>
                        </div>
                        <div class="c-box__col">
                            <label class="u-date-label t-uppercase" for="birthdate">Birthdate *</label>
                            <input type="input" name="Birthdate" aria-label="Birthdate" id="birthday" class="c-box__input u-date-input" pattern="\d{4}/\d{1,2}/\d{1,2}" placeholder="<?php echo date('Y/m/d');?>" required>
                        </div>
                        <div class="c-box__col">
                            <label class="u-date-label t-uppercase" for="anniversary">Anniversary</label>
                            <input type="input" name="Anniversary" aria-label="Anniversary" id="anniversary" class="c-box__input u-date-input" pattern="\d{4}/\d{1,2}/\d{1,2}" placeholder="<?php echo date('Y/m/d');?>">
                        </div>
                        <div class="c-box__col">
                            <div class="unstyled">
                                <select name="StoreCode" data-ignore="true" aria-label="Favorite Location" required>
                                    <option disabled selected>Favorite Location*</option>
                                    <?php $args = array(
                                        'post_type'      => 'location',
                                        'post_status'        => 'publish',
                                        'posts_per_page' => -1,
                                        'order'          => 'ASC',
                                        'orderby'        => 'date'
                                     );
                                    $location = new WP_Query( $args );
                                    $i=0;
                                    if ( $location->have_posts() ) : ?>
                                    <?php while ( $location->have_posts() ) : $location->the_post(); ?>
                                   
                                        <option value="<?php echo get_the_ID();?>"><?php echo get_the_title();?></option>
                                    <?php endwhile;
                                endif;wp_reset_postdata();?>
                                </select>
                            </div>
                        </div>
                        <div class="c-box__col">
                            <input type="text" name="Address" placeholder="Address" aria-label="Address" class="c-box__input" maxlength="100">
                        </div>
                        <div class="c-box__col">
                            <div class="unstyled">
                                <select name="State" data-ignore="true" aria-label="State">
                                    <option disabled selected>State</option>
                                    <option value="AK">Alaska</option>
                                    <option value="AL">Alabama</option>
                                    <option value="AR">Arkansas</option>
                                    <option value="AZ">Arizona</option>
                                    <option value="CA">California</option>
                                    <option value="CO">Colorado</option>
                                    <option value="CT">Connecticut</option>
                                    <option value="DC">District of Columbia</option>
                                    <option value="DE">Delaware</option>
                                    <option value="FL">Florida</option>
                                    <option value="GA">Georgia</option>
                                    <option value="HI">Hawaii</option>
                                    <option value="IA">Iowa</option>
                                    <option value="ID">Idaho</option>
                                    <option value="IL">Illinois</option>
                                    <option value="IN">Indiana</option>
                                    <option value="KS">Kansas</option>
                                    <option value="KY">Kentucky</option>
                                    <option value="LA">Louisiana</option>
                                    <option value="MA">Massachusetts</option>
                                    <option value="MD">Maryland</option>
                                    <option value="ME">Maine</option>
                                    <option value="MI">Michigan</option>
                                    <option value="MN">Minnesota</option>
                                    <option value="MO">Missouri</option>
                                    <option value="MS">Mississippi</option>
                                    <option value="MT">Montana</option>
                                    <option value="NC">North Carolina</option>
                                    <option value="ND">North Dakota</option>
                                    <option value="NE">Nebraska</option>
                                    <option value="NH">New Hampshire</option>
                                    <option value="NJ">New Jersey</option>
                                    <option value="NM">New Mexico</option>
                                    <option value="NV">Nevada</option>
                                    <option value="NY">New York</option>
                                    <option value="OH">Ohio</option>
                                    <option value="OK">Oklahoma</option>
                                    <option value="OR">Oregon</option>
                                    <option value="PA">Pennsylvania</option>
                                    <option value="RI">Rhode Island</option>
                                    <option value="SC">South Carolina</option>
                                    <option value="SD">South Dakota</option>
                                    <option value="TN">Tennessee</option>
                                    <option value="TX">Texas</option>
                                    <option value="UT">Utah</option>
                                    <option value="VT">Vermont</option>
                                    <option value="VA">Virginia</option>
                                    <option value="WA">Washington</option>
                                    <option value="WI">Wisconsin</option>
                                    <option value="WV">West Virginia</option>
                                    <option value="WY">Wyoming</option>
                                </select>
                            </div>
                        </div>
                        <div class="c-box__col">
                            <input type="text" name="Zip" placeholder="Zip Code *" aria-label="Zip Code" class="c-box__input" required>
                        </div><div class="c-box__col">
                        <input type="text" name="Phone" placeholder="Phone Number" aria-label="Phone Number" class="c-box__input" required>
                    </div>
                    <div class="u-form-check">
                        <input type="checkbox" name="acceptedConditions" aria-label="Accept Conditions?" id="conditions" class="u-form-check__input" data-ref="conditionsChecked">
                        <label for="conditions" class="u-form-check__label u-conditions-text">By checking this box, you agree to receive promotional emails and other marketing materials from Texas de Brazil. The information that is requested will not be sold or shared with a third party; it is for Texas de Brazil marketing purposes ONLY. If you wish to unsubscribe, Texas de Brazil provides an easy one-click method to be removed from the distribution list.</label>
                    </div>
                    <div class="u-errors" data-ref="generalErrors"></div>
                    <button class="button u-eclub-submit">Submit</button>
                </form>
            </div>
        </div>
        <div class="o-col" data-el="target-o-col-second">
            <h2><?php the_field('lead');?></h2>
            <div class="u-eclub-content">
                <?php the_field('main_content');?>
            </div>
            <div class="u-highlights eclub-icons-frame" data-ref="eclub-icons">
                <div class="u-highlights__item">
                    <img src="/assets/img/discount.svg" class="u-highlights__image" alt="">
                    <span class="t-heading-six u-highlights__text">$20.00 Discount</span>
                </div>
                <div class="u-highlights__item">
                    <img src="/assets/img/date.svg" class="u-highlights__image" alt="">
                    <span class="t-heading-six u-highlights__text">Birthday &amp; Anniversary Promotion</span>
                </div>
                <div class="u-highlights__item">
                    <img src="/assets/img/offers.svg" class="u-highlights__image" alt="">
                    <span class="t-heading-six u-highlights__text">Exclusive Special Offers</span>
                </div>
            </div>
            <?php if(get_field('tagline')):?>
                <p class="u-eclub-addendum"><?php the_field('tagline');?></p>
            <?php endif; ?>
        </div>
    </div>
    </div>
<?php endwhile;?>
<?php 
get_footer();
?>