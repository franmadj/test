import $ from '../framework/$'
import Slideshow from '../plugins/slideshow'
import header from './header'
import Modal from '../plugins/modal'

const _doc = document

let Popup = null

function init() {
    Popup = new Modal(document.querySelector('.u-experience-modal'))

    header.hideLogo()

    initSlideshow()

    bindEvents()
}

function bindEvents() {

    window.addEventListener('scroll', function() {
        let scrollProgress = window.pageYOffset - 32;

        if( scrollProgress <= (window.innerHeight+100) && window.innerWidth > 999 ){
            $('.c-video__inner').css('margin-top',scrollProgress+'px')
        }
    })

    $(':experienceModal').on('click', (e, el) => {
        if (window.player) {
            window.player.playVideo()
        }
    })

    $(':modalClose').on('click', (e, el) => {
        if (window.player) {
            window.player.stopVideo()
        }
    })

    $(':experienceModal').on('click', (e, el) => {
        Popup.show()
    })
}

/**
 * Initialize Slideshow plugin
 */
function initSlideshow() {
    let slideCount = $(':slide').length,
        $buttons,
        slideshow

    if (slideCount < 2) return

    $buttons = $(':slideButton')
    slideshow = new Slideshow({
        el: $(':slides')[0],
        interval: 6000,
        onUpdate(i) {
            $buttons.deactivate()
                .eq(i)
                .activate()
        }
    })

    $buttons.on('click', (e, el) => {
        let index = $(el).data('index')

        slideshow.show(index)
    })
}

export default init
