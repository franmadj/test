class Slideshow {
    constructor(conf) {
        let scope = this,
            { el, interval = 5000, disabledClass = '-disabled', onUpdate } = conf

        scope.container = el
        scope.slides = scope._getSlides(el)
        scope.count = scope.slides.length
        scope.currentSlide = 0

        scope.interval = interval
        scope.timer = null

        scope.disabledClass = disabledClass

        scope.onUpdate = onUpdate

        scope.start()
    }

    /**
     * Get slide elements inside of container
     *
     * @private
     * @param {HTMLElement} el
     * @returns {Array}
     */
    _getSlides(el) {
        let query = `[data-ref~="slide"]`,
            els = el.querySelectorAll(query)

        return [...els]
    }

    /**
     * Start timer
     */
    start() {
        let scope = this

        scope.timer = setInterval(() => {
            scope._next()
        }, scope.interval)
    }

    /**
     * Show the next slide
     *
     * @private
     */
    _next() {
        let scope = this

        scope._disable(scope.slides[scope.currentSlide])

        if (scope.currentSlide == scope.count - 1) {
            scope._enable(scope.slides[0])
            scope.currentSlide = 0
        } else {
            scope._enable(scope.slides[++scope.currentSlide])
        }

        scope._onUpdate(scope.currentSlide)
    }

    /**
     * Add disabled class to element
     *
     * @private
     * @param {HTMLElement} el
     */
    _disable(el) {
        el.classList.add(this.disabledClass)
    }

    /**
     * Remove disabled class from element
     *
     * @private
     * @param {HTMLElement} el
     */
    _enable(el) {
        el.classList.remove(this.disabledClass)
    }

    /**
     * Invoke onUpdate callback
     *
     * @private
     * @param {number} index
     */
    _onUpdate(index) {
        if (! this.onUpdate) return

        this.onUpdate.call(this, index)
    }

    /**
     * Show the next slide and reset the timer
     */
    next() {
        this.stop()
        this._next()
        this.start()
    }

    /**
     * Show the slide at the specified index
     *
     * @param {number} index
     */
    show(index) {
        let scope = this,
            slides = scope.slides,
            current = scope.currentSlide

        if (index == current) return

        scope.stop()

        scope.currentSlide = index

        scope._disable(slides[current])
        scope._enable(slides[index])
        scope._onUpdate(index)

        scope.start()
    }

    /**
     * Stop timer
     */
    stop() {
        clearInterval(this.timer)
    }
}

export default Slideshow
