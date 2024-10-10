/**
 * Check if value is an object
 *
 * @param {*} value
 * @returns {boolean}
 */
function isObject(value) {
    // TODO: Improve validity

    return value === Object(value)
}

/**
 * Check if value is a string
 *
 * @param {*} value
 * @returns {boolean}
 */
function isString(value) {
    // TODO: Improve validity

    return value === String(value)
}

/**
 * Check if element matches filter
 *
 * @param {HTMLElement} el
 * @param {string} filter
 * @returns {boolean}
 */
function isMatch(el, filter) {
    return (
        el.matches ||
        el.msMatchesSelector ||
        el.webkitMatchesSelector ||
        el.mozMatchesSelector
    ).call(el, filter)
}

/**
 * Format query for use with querySelector
 *
 * @param {string} query
 * @returns {string}
 */
function formatQuery(query) {
    let formatted = query

    if (isString(query) && /^\:/.test(query)) {
        formatted = `[data-ref~="${query.replace(':', '')}"]`
    }

    return formatted
}

/**
 * Convert number to percentage
 *
 * @param {number} number
 * @returns {number}
 */
function percent(number) {
    // TODO: Handle more use cases like keywords: half, third, etc
    return number / 100
}

export { formatQuery, isMatch, isObject, isString, percent }
