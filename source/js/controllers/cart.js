import $ from '../framework/$'
import serialize from '../plugins/serialize'
import accounting from '../plugins/accounting'
import axios from '../plugins/axios'

function init() {
    bindEvents()

    axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8;'

    axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest'
}

function bindEvents() {
    $(':couponForm').on('submit', (e, el) => updateCoupon(e, $(el)))

    $(':toggleEditForm').on('click', (e, el) => toggleEditForm(e, el))

    $(':editForm').on('submit', (e, el) => updateForm(e, el))
}

function updateForm(e, el) {
    let denomination = null

    e.preventDefault()

    $('.u-edit:not(.u-edit--disabled)').addClass('u-edit--disabled')

    if (denomination = el.querySelector('[data-ref="denominationInput"]')) {
        denomination.value = el.querySelector('select[name="amount"]').value
    }

    el.submit()
}

function toggleEditForm(e, el) {
    let classList = el.nextSibling.classList,
        disabledClass = 'u-edit--disabled'

    if (classList.contains(disabledClass)) {
        classList.remove(disabledClass)

        return
    }

    classList.add(disabledClass)
}

function updateCoupon(e, el) {
    // TODO: replace with Axios
    ajax('POST', '/', serialize(el[0]), function(response, statusCode) {
        let obj = JSON.parse('' + response),
            cart = obj.cart

        $(':discount')[0].innerText = accounting.formatMoney(cart.totalDiscount)
    })

    e.preventDefault()
}

function ajax(type, url, data = false, handler) {
    let request = new XMLHttpRequest()

    request.onreadystatechange = function() {
        if (request.readyState == XMLHttpRequest.DONE) {
            if (request.status == 200) {
                handler(request.responseText, 200)
            } else if (request.status == 400) {
                handler(request.responseText, 400)
            } else {
                handler(request.responseText, false)
            }
        }
    }

    request.open(type, url, true)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8;')
    request.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
    request.send(data)
}

export default Object.assign(init, {})
