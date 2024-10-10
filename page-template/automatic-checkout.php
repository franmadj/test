<?php
/*
  Template Name: Automatic checkout
 */

$GLOBALS['autCheckout']->addItemToCart($_GET);
get_header();

    ?>
    <div class="privacy-policy c-page-header">
        <div class="privacy-policy-content">

            <?php
            while (have_posts()) :
                the_post();

                the_content();


            endwhile; // End of the loop.
            ?>

        </div>
    </div><!-- #primary -->


<?php get_footer(); ?>

<script type="text/javascript">


</script>
<style>
    .c-box__input{
        padding-left: 17px;
        color:#efece966;
        font-weight: 100;
    }
    .datepicker-wai .date input{
        display: none;
        background: #191919;
        border: none;
        color: #b9b7b2;
        margin: 0.1rem;
        width: 100%;
        text-align: left;

    }

    #myDatepicker{
        width: 100%;
    }
    .u-contact-form > div {
        position: relative;

    }
    .u-contact-form > div.c-box__col > span{
        position: absolute;
        left: 4px;
        top: 6px;
        color:#efece966;
    }

    .u-contact-form textarea::-webkit-input-placeholder {
        color: #b9b7b2;
    }

    .u-contact-form textarea:-moz-placeholder { /* Firefox 18- */
        color: #b9b7b2; 
    }

    .u-contact-form textarea::-moz-placeholder {  /* Firefox 19+ */
        color: #b9b7b2; 
    }

    .u-contact-form textarea:-ms-input-placeholder {
        color: #b9b7b2;  
    }

    .u-contact-form textarea::placeholder {
        color: #b9b7b2;
    }
    /*.u-contact-form > div.c-box__col:nth-child(2) > span{
        left: 83px;
    }*/


</style>
