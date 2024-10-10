import $ from '../framework/$'

function init() {
    bindEvents()
}

function bindEvents() {
    $(':leasingForm').on('submit', (e, el) => {
        let stateValue = $(':stateSelect').els[0].value

        e.preventDefault()

        $(':formError').remove()

        if (! stateValue || stateValue == 'State*') {
            let div = document.createElement('div')

            div.innerText = 'State is required.'
            div.className = 'c-form-error'
            div.setAttribute('data-ref', 'formError')

            div.style.textAlign = 'center'
            div.style.color = '#FFFFFF'

            $(el.querySelector('.c-box')).append(div)
        } else {
            el.submit()
        }
    })
}

export default Object.assign(init, {})
