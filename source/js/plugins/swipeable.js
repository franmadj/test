import Motion from './motion'

class Swipeable {
    constructor($container) {
        let scope = this

        scope.$container = $container
        scope.containerWidth = null,

        scope.$content = $container.find(':swipeable')
        scope.contentWidth = null,
        scope.contentPosition = null

        scope.swiping = false
        scope.rafId = null
        scope.startPos = null
        scope.pointer = 0
        scope.position = 0
        scope.previous = scope.position
        scope.velocity = 0
        scope.friction = 0

        scope.tween = null

        scope._initEvents()
    }

    /**
     * Swipe content by specified amount
     *
     * @param {number} amount
     */
    swipe(amount) {
        if (!amount) return

        let scope = this,
            newPosition = scope.contentPosition + amount,
            stoppingPoint = (scope.contentWidth - scope.containerWidth) * -1

        if (newPosition > 0 || scope.containerWidth >= scope.contentWidth) {
            newPosition = 0
        } else if (newPosition < stoppingPoint) {
            newPosition = stoppingPoint
        }

        scope.$content.css('transform', `translateX(${newPosition}px)`)
    }

    /**
     * Pan content left
     */
    panLeft(percentage) {
        let scope = this,
            currentPosition = scope._getContentPosition(),
            distance = scope._getContainerWidth() * percentage,
            newPosition = currentPosition + distance

        scope._interrupt()

        if (newPosition > 0 && newPosition > currentPosition) {
            newPosition = 0
        }

        scope._pan(currentPosition, newPosition)
    }

    /**
     * Pan content right
     */
    panRight(percentage) {
        let scope = this,
            containerWidth = scope._getContainerWidth(),
            currentPosition = scope._getContentPosition(),
            distance = containerWidth * percentage,
            newPosition = currentPosition - distance,
            stoppingPoint = (scope._getContentWidth() - containerWidth) * -1

        scope._interrupt()

        if (newPosition < stoppingPoint) {
            newPosition = stoppingPoint
        }

        scope._pan(currentPosition, newPosition)
    }

    /**
     * Store the content position
     *
     * @private
     * @returns {number}
     */
    _getContentPosition() {
        let transform = this.$content.css('transform').match(/-?\d+/)
        this.contentPosition = Number(transform)

        return this.contentPosition
    }

    /**
     * Get container width
     *
     * @private
     * @returns {number}
     */
    _getContainerWidth() {
        this.containerWidth = this.$container[0].offsetWidth

        return this.containerWidth
    }

    /**
     * Get content width
     *
     * @private
     * @returns {number}
     */
    _getContentWidth() {
        this.contentWidth = this.$content[0].scrollWidth

        return this.contentWidth
    }

    /**
     * Calculate amount to move content
     *
     * @private
     */
    _move() {
        let scope = this

        scope.rafId = requestAnimationFrame(scope._move.bind(scope))

        if (scope.swiping) {
            scope.previous = scope.position
            scope.position = scope.pointer
            scope.velocity = scope.position - scope.previous
        } else {
            scope.position += scope.velocity
            scope.velocity *= scope.friction
        }

        scope.swipe(scope.position - scope.startPos)
    }

    /**
     * Initiate pan animation
     *
     * @private
     * @param {number} start
     * @param {number} finish
     */
    _pan(start, finish) {
        let scope = this

        scope.tween = new Motion({
            start,
            finish,
            onUpdate(position) {
                scope.$content.css('transform', `translateX(${position}px)`)
                scope.contentPosition = position
            }
        })

        scope.tween.go()
    }

    /**
     * Initialize event binding
     */
    _initEvents() {
        let scope = this
        var tickleStart = false

        scope.$content.on({
            click(e) {
                scope._interrupt()

                //e.preventDefault()
                //scope._pointerEnd()
                tickleStart = false
                //$('.side-panel__button').html('clicked');
            },
            touchstart(e) {
                scope._pointerMove(e)

                // TODO: Bind other touch event handlers within here
                tickleStart = false
                //$('.side-panel__button').html('touchstart');
            },
            touchend() {
                scope._pointerEnd()
                //$('.side-panel__button').html('touchend');
                tickleStart = false
            },
            touchmove(e) {
                if(tickleStart==false){
                    scope._pointerStart(e,true)
                    tickleStart = true
                    //$('.side-panel__button').html('started');
                }else{
                    //$('.side-panel__button').html('moving');
                    scope._pointerMove(e,true)
                    // Prevents navigating through browser history
                    e.preventDefault()
                }
            },
            mousedown(e) {
                // TODO: Bind other mouse event handlers within here
                scope._pointerStart(e)
            },
            mouseout() {
                scope._pointerEnd()
            },
            mouseup() {
                scope._pointerEnd()
            },
            mousemove(e) {
                scope._pointerMove(e)
            },
            dragstart(e) {
                e.preventDefault()
            }
        })


    }

    /**
     * Handle pointer start
     *
     * @param {Object} e
     * @param {boolean} isTouch
     */
    _pointerStart(e, isTouch = false) {
        let scope = this

        scope._interrupt()

        scope.swiping = true
        scope.startPos = isTouch ? e.touches[0].clientX : e.clientX

        scope._getContainerWidth()
        scope._getContentWidth()
        scope._getContentPosition()

        scope._move()
    }

    /**
     * Handle pointer move
     *
     * @param {Object} e
     * @param {boolean} isTouch
     */
    _pointerMove(e, isTouch) {
        this.pointer = isTouch ? e.touches[0].clientX : e.clientX
    }

    /**
     * Handle pointer end
     */
    _pointerEnd() {
        this.swiping = false
    }

    /**
     * Stop current animation
     *
     * @private
     */
    _interrupt() {
        cancelAnimationFrame(this.rafId)

        if (this.tween !== null) {
            this.tween.stop()
        }
    }

    _update() {
        let scope = this

        setTimeout(function () {
            scope._interrupt()

            scope.swiping = true
            scope.startPos = 0

            scope._getContainerWidth()
            scope._getContentWidth()
            scope._getContentPosition()

            scope._move()
        }, 250)
    }
}

export default Swipeable
