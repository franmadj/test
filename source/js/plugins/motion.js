class Motion {
    constructor(conf) {
        let { start, finish, onUpdate, duration = 400, easing = 'easeOutQuart' } = conf,
            scope = this

        scope.time = null

        scope.start = start
        scope.finish = finish
        scope.position = start

        scope.direction = finish > start ? 1 : -1
        scope.distance = Math.abs(finish - start)

        scope.duration = duration
        scope.easing = `_${easing}`
        scope.rafId = null

        scope.onUpdate = onUpdate
    }

    /**
     * Start animation
     */
    go() {
        this.time = performance.now()

        this._raf()
    }

    /**
     * Cancel animation
     */
    stop() {
        cancelAnimationFrame(this.rafId)
    }

    /**
     * Animation loop
     *
     * @private
     */
    _raf() {
        let scope = this,
            elapsed = performance.now() - scope.time

        if (scope.distance && elapsed < scope.duration) {
            scope.rafId = requestAnimationFrame(scope._raf.bind(scope))
            scope.position = scope.start + scope.distance * scope[scope.easing](elapsed / scope.duration) * scope.direction

            scope.onUpdate.call(scope, scope.position)
        } else {
            scope.position = scope.finish

            return
        }
    }

    /**
     * Linear easing
     *
     * @private
     * @param {number} t
     * @returns {number}
     */
    _linear(t) {
        return t
    }

    /**
     * Quartic ease-out
     *
     * @private
     * @param {number} t
     * @returns {number}
     */
    _easeOutQuart(t) {
        return 1 - (--t) * t * t * t
    }
}

export default Motion
