import $ from '../framework/$'
import $screen from '../framework/Screen'

const _doc = document,
    _body = _doc.body

let storedHeader = null

function init() {
    initEvents()
    initScreen()
    chooseHeader()
}

/**
 * Initialize events
 */
function initEvents() {
    $(':navButton').on('click', () => toggleMenu())
}

/**
 * Initialize screen mapping
 */
function initScreen() {
    let $mobileHeader = $(':mobileHeader'),
        $desktopHeader = $(':desktopHeader')

    $screen.map([
        {
            max: 3,
            init: false,
            handler() {
                swapHeader()
            }
        },
        {
            min: 4,
            init: false,
            handler() {
                swapHeader(true)
            }
        }
    ])
}

/**
 * Choose which header to display based on screen size
 */
function chooseHeader() {
    let $mobileHeader = $(':mobileHeader'),
        $desktopHeader = $(':desktopHeader')

    if ($screen.size() <= 3) {
        storedHeader = $desktopHeader.first()
        $desktopHeader.remove()
    } else {
        storedHeader = $mobileHeader.first()
        $mobileHeader.remove()
    }
}

/**
 * Toggle the mobile menu
 */
function toggleMenu() {
    let $header = $(':mobileHeader'),
        $menu = $(':navMenu'),
        $icon = $(':navButtonIcon'),
        $body = $(_body),
        noScrollClass = 'no-scroll'

    if ($menu.isDisabled()) {
        $body.addClass(noScrollClass)
        $icon.activate()
        $header.css('zIndex', 5)
    } else {
        $body.removeClass(noScrollClass)
        $icon.deactivate()
        $header.removeStyle()
    }

    $menu.toggleDisabled()
}

/**
 * Swap current header with stored header
 *
 * @param {boolean} desktop
 */
function swapHeader(desktop) {
    let $currentHeader = desktop ?
        $(':mobileHeader') :
        $(':desktopHeader')

    $('main').prepend(storedHeader)

    if (desktop) {
        closeMenu()
    }

    storedHeader = $currentHeader.first()
    $currentHeader.remove()
}

/**
 * Close the mobile menu
 */
function closeMenu() {
    $(_body).removeClass('no-scroll')
    $(':navButtonIcon').deactivate()
    $(':navMenu').disable()
}

/**
 * Hide the header logo
 */
function hideLogo() {
    $('header:not(.header--fixed) [data-ref="headerLogo"]').hide()
}

export default Object.assign(init, { hideLogo })
