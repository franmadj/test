import $ from '../framework/$'


function init() {
    bindEvents()
}

function bindEvents() {
    $(':preventOverScroll').on('mouseenter', () => {
        document.body.style.overflowY = 'auto'
    })

    $(':preventOverScroll').on('mouseleave', () => {
        document.body.style.overflowY = 'auto'
    })
}

export default Object.assign(init, {})
