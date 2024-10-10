let registry = []

/**
 * Run registered routes
 */
function run() {
	registry.forEach(route => _eval(route))
}

/**
 * Add routes to registry
 *
 * @param {Array} routes
 */
function map(routes) {
	routes.forEach(route => registry.push(route))
}

/**
 * Evaluate a registered route
 *
 * @private
 * @param {Object} route
 */
function _eval(route) {
	if (_isMatch(route.path)) {
		_handle(route)
	}
}

/**
 * Check for matched route
 *
 * @private
 * @returns {boolean}
 */
function _isMatch(path) {
	let url = window.location.pathname.replace(/^\/|\/$/g, '')

	if (path === '$home') {
		return url === ''
	}

	return Boolean(url.match(path))
}

/**
 * Run the route handler(s)
 *
 * @private
 * @param {Object} route
 */
function _handle(route) {
	if (Array.isArray(route.handler)) {
		route.handler.forEach(handle => handle())

		return
	}

	route.handler()
}

export default Object.assign(run, { map })
