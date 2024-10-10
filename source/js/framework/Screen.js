const _win = window,
    _html = document.documentElement

let registry = [],
    storedSize = size(),
    screenResized = false,
    isWatching = false

/**
 * Add rules to the registry
 *
 * @param {Array} rules
 */
function map(rules) {
    for (var i = 0; i < rules.length; i++) {
        let rule = rules[i]

        register(rule)
    }

    watch()
}

/**
 * Add rule to registry
 *
 * @param {Object} rule
 */
function register(rule) {
    registry.push(rule)

    if (rule.init !== false) {
        run(true, [rule])
    }
}

/**
 * Watch screen resize
 */
function watch() {
    if (! registry.length) {
        return false
    }

    if (! isWatching) {
        isWatching = true

        listen()
    }
}

/**
 * Listen for resize event
 *
 * @private
 */
function listen() {
    _win.addEventListener('resize', () => {
        screenResized = true
    })

    setInterval(throttle, 100)
}

/**
 * Throttle resize event
 *
 * @private
 */
function throttle() {
    if (screenResized) {
        screenResized = false

        run()
    }
}

/**
 * Run the matching rules
 */
function run(init = false, rules = registry) {
    let currentSize = size()

    if (! init && currentSize == storedSize) {
        return
    }

    rules.filter(rule => isMatch(rule, currentSize, init))
        .forEach(rule => rule.handler())

    storedSize = currentSize
}

/**
 * Get current screen size
 *
 * @returns {number}
 */
function size() {
    return _win.getComputedStyle(_html)
        .getPropertyValue('font-family')
        .replace(/\"|\'/g, '')
}

/**
 * Check if rule matches the current size
 *
 * @private
 * @param {Object} rule
 * @returns {boolean}
 */
function isMatch(rule, currentSize, init) {
    let { each = init, max, min, size } = rule

    return (! size && ! min && ! max) ||
        (size && size == currentSize) ||
        (min && currentSize >= min && (each || storedSize < min) && (! max || currentSize <= max)) ||
        (max && currentSize <= max && (each || storedSize > max) && (! min || currentSize >= min))
}

export default { size, map }
