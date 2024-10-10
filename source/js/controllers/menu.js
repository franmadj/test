import $ from '../framework/$'
import Swipeable from '../plugins/swipeable'

const _win = window,
    _body = document.body

let categories = null,
    maps = [],
    activeMap

/**
 * Initialize controller
 */
function init() {
    initSwiping()
    bindEvents()

    lazyLoadImages()
}

/**
 * Initialize Swipeable instances
 */
function initSwiping() {
    let $imageMaps = $(':imageMap')
    categories = new Swipeable($(':categories'))

    $(':imageMap').each(el => maps.push(new Swipeable($(el))))

    activeMap = maps[0]
}

/**
 * Initialize event binding
 */
function bindEvents() {
    $(':panelButton').on('click', (e, el) => togglePanel($(el)))
    $(':categoryButton').on('click', (e, el) => toggleCategory($(el)))
    $(':hotSpot').on('click', (e, el) => toggleHotSpot($(el)))
    $(':panLeft').on('click', panLeft)
    $(':panRight').on('click', panRight)

    window.addEventListener('orientationchange', function() {
        maps[0]._update()
    })
}

function lazyLoadImages() {
    let images = document.querySelectorAll('img[data-src]')

    for (var i = 0; i < images.length; i++) {
        let img = images[i]

        img.setAttribute('src', img.getAttribute('data-src'))
        img.onload = () => {
            img.removeAttribute('data-src')
        }
    }
}

/**
 * Toggle panel
 */
function togglePanel($btn) {
    let $panel = $($btn.els[0].nextSibling)

    $btn.toggleActive()
    $panel.toggleDisabled()
}

/**
 * Toggle menu category
 *
 * @param {$} $btn
 */
function toggleCategory($btn) {
    if ($btn.isActive()) return

    let category = $btn.data('category'),
        filter = `[data-category="${category}"]`,
        $lists = $(':list'),
        $infos = $(':info'),
        $imageMaps = $(':imageMap')

    $btn.activate()
        .siblings()
        .deactivate()

    $lists.disable()
        .filter(filter)
        .enable()

    $infos.disable()
        .filter(filter)
        .enable()

    $imageMaps.deactivate()
        .filter(filter)
        .activate()

    activeMap = maps[$btn.data('index')]
}

/**
 * Toggle the specified hotspot
 *
 * @param {$} hotspot
 * @param {boolean} disable
 */
function toggleHotSpot($hotSpot) {
    let $content = $hotSpot.find(':hotSpotContent'),
        $all = $(':hotSpotContent')

    if ($content.isDisabled()) {
        $all.disable()
        $content.enable()
    } else {
        $content.disable()
    }
}

/**
 * Pan active image map to the left
 */
function panLeft() {
    activeMap.panLeft(0.25)
}

/**
 * Pan active image map to the right
 */
function panRight() {
    activeMap.panRight(0.25)
}

export default Object.assign(init, {})
