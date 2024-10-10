</main>
<?php get_template_part('_includes/checkout-first-modal'); ?>
</div>
<!--<a href="/reservations/" class="reserve-button" data-ref="reserveButton">Reserve</a>
<a href="https://order.online/store/Texas-de-Brazil-983408/" class="reserve-button eClub-button" data-ref="eClubButton">ORDER PICKUP/DELIVERY</a>-->

<?php 

    wp_footer();
    ?>
    <?php get_template_part('_includes/table', 'finderpopup'); ?>
<script type="text/javascript">
    jQuery(document).ready(function () {
//        jQuery(".animsition").animsition({
//            timeout: true,
//            timeoutCountdown: 2000,
//            loadingInner: '<div class="u-preload-logo__container"><img src="/assets/img/logo-loader.svg" class="u-preload-logo__image" alt="Texas de Brazil is loading."></div>',
//            loadingClass: 'u-preload-logo__wrapper'
//        });
    });

    jQuery(document).ready(function () {
        jQuery('.datepicker').datepicker({
            constrainInput: false
        });
    });

    jQuery('a[href*="#"]:not([data-ignore])').on('click', function (e) {

        e.preventDefault();
        var selector = this.href.match(/(#[[A-Za-z0-9-]*)$/),
                offsetDistance = document.querySelector(selector[1]).getBoundingClientRect().top + window.scrollY;

        jQuery('html, body').animate({
            scrollTop: offsetDistance - 150
        }, 1000);
    });
</script>
</body>
</html>
