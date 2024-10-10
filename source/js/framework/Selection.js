import { formatQuery, isMatch, isObject, isString } from './Utilities'
import $dom from './Dom'
import $events from './Events'

const _win = window,
    _doc = document,
    _html = document.documentElement,
    hideClass = 'js-hide',
    activeClass = '-active',
    disabledClass = '-disabled'

class Selection {
    constructor(query) {
        this.els = $dom.query(query)
        this[0] = this.els[0]
        this.length = this.els.length
    }

    /**
     * Add active class to selection
     *
     * @returns {Selection}
     */
    activate() {
        this.addClass(activeClass)

        return this
    }

    /**
     * Add class to selection
     *
     * @param {string} value
     * @return {Selection}
     */
    addClass(value) {
        this.els.forEach(el => el.classList.add(value))

        return this
    }

    /**
     * Get or set selection's specified attribute
     *
     * @param {string} name
     * @param {number|string} value
     * @returns {number|Selection|string}
     */
    attr(name, value) {
        if (! value) {
            return this.first().getAttribute(name)
        }

        this.els.forEach(el => el.setAttribute(name, value))

        return this
    }

    /**
     * Get the closest specified element(s) to selection
     *
     * @param {HTMLElement|string} ancestor
     * @returns {Selection}
     */
    closest(ancestor) {
        let matches = []

        this.els.forEach(el => {
            let nodes = $dom.closest(el, formatQuery(ancestor))

            matches = matches.concat([...nodes])
        })

        return new Selection(matches)
    }

    /**
     * Set style property to specified value
     *
     * @param {string} property
     * @param {string} [value]
     * @returns {Selection}
     */
    css(property, value) {
        // TODO: Translate spinal-case properties to camelCase
        if (isString(property) && ! value) {
            return this.first().style[property]
        }

        this.els.forEach(el => $dom.css(el, property, value))

        return this
    }

    /**
     * Get or set a data-attribute on the selection
     *
     * @param {string} name
     * @param {string} value
     * @returns {Selection|string}
     */
    data(name, value) {
        let attrName = `data-${name}`

        if (! value) {
            return this.attr(attrName)
        }

        this.attr(attrName, value)

        return this
    }

    /**
     * Remove active class from selection
     *
     * @returns {Selection}
     */
    deactivate() {
        this.removeClass(activeClass)

        return this
    }

    /**
     * Add disabled class to selection
     *
     * @returns {Selection}
     */
    disable() {
        this.addClass(disabledClass)

        return this
    }

    /**
     * Loop over each element of the selection
     *
     * @param {function} handler
     * @returns {Selection}
     */
    each(handler) {
        this.els.forEach((el, i) => handler.apply(el, [el, i]))

        return this
    }

    /**
     * Remove disabled class from selection
     *
     * @returns {Selection}
     */
    enable() {
        this.removeClass(disabledClass)

        return this
    }

    /**
     * Select element by index
     *
     * @param {number} index
     * @returns {Selection}
     */
    eq(index) {
        return new Selection(this.els[index])
    }

    /**
     * Filter selection by query
     *
     * @param {string} query
     * @returns {Selection}
     */
    filter(query) {
        let matches = []

        this.els.forEach(el => {
            if (isMatch(el, formatQuery(query))) {
                matches.push(el)
            }
        })

        return new Selection(matches)
    }

    /**
     * Find matching descendants of selection
     *
     * @param {string} descendant
     * @returns {Selection}
     */
    find(descendant) {
        let matches = []

        this.els.forEach(el => {
            let nodes = el.querySelectorAll(formatQuery(descendant))

            matches = matches.concat([...nodes])
        })

        return new Selection(matches)
    }

    /**
     * Get the first selection element
     *
     * @returns {boolean|HTMLElement}
     */
    first() {
        return this.els[0]
    }

    /**
     * Check if selection has the specified class
     *
     * @param {string} value
     * @returns {boolean}
     */
    hasClass(value) {
        return this.first().classList.contains(value)
    }

    /**
     * Add hide class to selection
     *
     * @return {Selection}
     */
    hide() {
        this.addClass(hideClass)

        return this
    }

    /**
     * Check if selection has the active class
     *
     * @returns {boolean}
     */
    isActive() {
        return this.hasClass(activeClass)
    }

    /**
     * Check if selection has the disabled class
     *
     * @returns {boolean}
     */
    isDisabled() {
        return this.hasClass(disabledClass)
    }

    /**
     * Check if selection has the hide class
     *
     * @returns {boolean}
     */
    isHidden() {
        return this.hasClass(hideClass)
    }

    /**
     * Remove event listeners
     *
     * @param {string} event - Multiple events can be space delimited
     * @returns {Selection}
     */
    off(event) {
        let events = event.split(' ')

        this.els.forEach(el => {
            events.forEach(e => $events.off(el, e))
        })

        return this
    }

    /**
     * Get selection's offset
     *
     * @returns {Object}
     */
    offset() {
        let rectangle = this.first().getBoundingClientRect()

        // TODO: Add ability to set offset values

        return {
            top: rectangle.top + _win.pageYOffset,
            left: rectangle.left + _win.pageXOffset
        }
    }

    /**
     * Add event listener
     *
     * @param {string} event
     * @param {function} handler
     * @returns {Selection}
     */
    on(event, handler) {
        this.els.forEach(el => $events.on(el, event, handler))

        return this
    }

    /**
     * Prepend element to selection
     *
     * @param {HTMLElement} element
     */
    prepend(element) {
        this.els.forEach(el => {
            let parent = el.parentNode

            parent.insertBefore(element, parent.firstChild)
        })

        return this
    }

    append(element) {
        this.els.forEach(el => {
            el.appendChild(element)
        })
    }

    /**
     * Remove selection from DOM
     *
     * @returns {Array}
     */
    remove() {
        let copies = []

        this.els.forEach(el => {
            let parent = el.parentNode

            copies.push(el)
            parent.removeChild(el)
        })

        return copies
    }

    /**
     * Remove specified attribute from selection
     *
     * @param {string} attr
     * @returns {Selection}
     */
    removeAttr(attr) {
        this.els.forEach(el => el.removeAttribute(attr))

        return this
    }

    /**
     * Remove class from selection
     *
     * @param {string} value
     * @return {Selection}
     */
    removeClass(value) {
        this.els.forEach(el => el.classList.remove(value))

        return this
    }

    /**
     * Remove style attribute from selection
     *
     * @returns {Selection}
     */
    removeStyle() {
        this.removeAttr('style')

        return this
    }

    /**
     * Remove hide class from selection
     *
     * @returns {Selection}
     */
    show() {
        this.removeClass(hideClass)

        return this
    }

    /**
     * Get siblings of selection
     *
     * @returns {Selection}
     */
    siblings() {
        let matches = []

        this.els.forEach(el => {
            let nodes = [...el.parentNode.children].filter(child => child !== el)

            matches = matches.concat([...nodes])
        })

        return new Selection(matches)
    }

    /**
     * Get or set selection's text content
     *
     * @param {string} [value]
     * @return {Selection|string}
     */
    text(value) {
        if (! value) {
            return this.first().textContent
        }

        this.els.forEach(el => {
            el.textContent = value
        })

        return this
    }

    /**
     * Toggle hide class on selection
     *
     * @returns {Selection}
     */
    toggle() {
        this.toggleClass(hideClass)

        return this
    }

    /**
     * Toggle active class on selection
     *
     * @returns {Selection}
     */
    toggleActive() {
        this.toggleClass(activeClass)

        return this
    }

    /**
     * Toggle class on selection
     *
     * @param {string} value
     * @returns {Selection}
     */
    toggleClass(value) {
        this.els.forEach(el => el.classList.toggle(value))

        return this
    }

    /**
     * Toggle disabled class on selection
     *
     * @returns {Selection}
     */
    toggleDisabled() {
        this.toggleClass(disabledClass)

        return this
    }

    /**
     * Get selection width
     *
     * @returns {number}
     */
    width() {
        return this.first().offsetWidth
    }
}

export default Selection
