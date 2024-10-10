<script type="text/javascript">
	$.fn.isOnScreen = function(){
		var win = $(window);
		var viewport = {
			top : win.scrollTop(),
			left : win.scrollLeft()
		};
		viewport.right = viewport.left + win.width();
		viewport.bottom = viewport.top + win.height();

		var bounds = this.offset();
		bounds.right = bounds.left + this.outerWidth();
		bounds.bottom = bounds.top + this.outerHeight();

		return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));

	};

	$(document).ready(function() {
		$(window).on('scroll', function() {
			var dynamicElements = $('.enter-left, .enter-right, .fade-in-element');

            if ($(window).width() > 991) {
				Array.prototype.forEach.call(dynamicElements, function(el) {
					if ($(el).isOnScreen()) {
						$(el).addClass('-is-visible');
					}
				});

    			// DEV: This is the parallax effect on the home slider.
    			// TODO: Move into proper JS routing.
    			// $('.parallax').css({backgroundPosition: 'center -' + window.pageYOffset / 10 + 'px'});
            } else {
                dynamicElements.addClass('-is-visible');
            }
		});
	});
</script>
