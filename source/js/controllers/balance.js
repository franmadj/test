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
    $(':balanceForm').on('submit', (e, el) => handleFormSubmission(e, el))
}

function handleFormSubmission(e, el) {
    e.preventDefault()

    axios.post('/', serialize(el)).then(function(response) {
        let result = response.data,
            formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
                minimumFractionDigits: 2
            }),
            message = ''

        if (result.error) {
            message = 'That card number doesn\'t appear to be valid.'
        } else {
            message = formatter.format(result['balance'])
        }

        $(':amount').text(message)

        $(':instructions').addClass('u-balance-instructions--disabled')

        $(':amountDisplay').removeClass('u-balance-instructions--disabled')
    })
}

export default Object.assign(init, {})
