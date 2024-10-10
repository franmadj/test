import Selection from './Selection'

const _doc = document

/**
 * Select element(s)
 *
 * @param {HTMLElement|string} query
 * @returns {Selection}
 */
function select(query) {
    return new Selection(query)
}

/**
 * Run callback when document is ready
 *
 * @param {function} callback
 */
function ready(callback) {
    if (_doc.readyState != 'loading'){
        callback()

        return
    }

    _doc.addEventListener('DOMContentLoaded', callback)
}

export default Object.assign(select, { ready })
