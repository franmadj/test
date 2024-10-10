import $ from '../framework/$'
import serialize from '../plugins/serialize'
import axios from '../plugins/axios'

let selectedMethod = false
let getCardType = false

function init() {

    bindEvents()

    axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8;'

    axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest'

    let url = window.location.href 
    let segments = url.split( '/' );
    let segment4 = segments[4];
    if( !segment4 ) {
        console.log('Checkout Only');
        initUpdateMethod()
    }else{
        console.log('Checkout others');
    }
    // When the 'ship to billing address' input is changed, if they've enabled it, submit the billing address to the
    // cart + fetch the Shipping Methods. If they disabled it, do nothing. (Because the event listener on the Shipping
    // Address will submit when they're done.)

    if ($(':methodSelection').els[0] && $(':methodSelection').els[0].checked) {
        toggleLoading(true)
        axios.post('/', serialize($(':shippingMethod').els[0])).then(function (response) {
            let cart = response.data.cart

            if (cart.shippingMethod) {
                selectedMethod = true
            }

            updateTotals()
        })
    }


    let cardType = document.querySelector('[data-ref="cardType"]')
    
    $(':cardNumber').on('input', (e, el) => {
        let carNumber = el.value
        cardType.value = detectCardType(carNumber)
        getCardType = detectCardType(carNumber)
    })

    function detectCardType(number) {
        var re = {
            electron: /^(4026|417500|4405|4508|4844|4913|4917)\d+$/,
            maestro: /^(5018|5020|5038|5612|5893|6304|6759|6761|6762|6763|0604|6390)\d+$/,
            dankort: /^(5019)\d+$/,
            interpayment: /^(636)\d+$/,
            unionpay: /^(62|88)\d+$/,
            visa: /^4[0-9]{12}(?:[0-9]{3})?$/,
            mastercard: /^5[1-5][0-9]{14}$/,
            amex: /^3[47][0-9]{13}$/,
            diners: /^3(?:0[0-5]|[68][0-9])[0-9]{11}$/,
            discover: /^6(?:011|5[0-9]{2})[0-9]{12}$/,
            jcb: /^(?:2131|1800|35\d{3})\d{11}$/
        };
        if (re.electron.test(number)) {
            return 'ELECTRON';
        } else if (re.maestro.test(number)) {
            return 'MAESTRO';
        } else if (re.dankort.test(number)) {
            return 'DANKORT';
        } else if (re.interpayment.test(number)) {
            return 'INTERPAYMENT';
        } else if (re.unionpay.test(number)) {
            return 'UNIONPAY';
        } else if (re.visa.test(number)) {
            return 'VISA';
        } else if (re.mastercard.test(number)) {
            return 'MC';
        } else if (re.amex.test(number)) {
            return 'AMEX';
        } else if (re.diners.test(number)) {
            return 'DINERS';
        } else if (re.discover.test(number)) {
            return 'DISCOVER';
        } else if (re.jcb.test(number)) {
            return 'JCB';
        } else {
            return undefined;
        }
    }

}

function bindEvents() {
    bindMethods()

    $(':sameAddress').on('change', (e) => {
        toggleShippingAddress(e)

        // DEV: if the user wants to use the billing address as shipping, submit it.
        if (e.target.checked) {
            axios.post('/', serialize($(':addressForm').els[0]))
        }
    });

    $('.c-box[data-ref="billingAddress"] input, .c-box[data-ref="billingAddress"] select').on('change', function (e) {
        let shippingName = e.target.getAttribute('name').replace('billing', 'shipping')

        if (! $(':sameAddress').els[0].checked) {
            return
        }

        if (e.target.nodeName == 'SELECT') {
            document.querySelector('select[name="shippingAddress[stateId]"]').value = e.target.value
        } else {
            $('input[name="' + shippingName + '"]').els[0].value = e.target.value
        }
    })

    $(':methodSelection').on('change', (e) => {
        axios.post('/', serialize($(':shippingMethod').els[0])).then(function (response) {
            let cart = response.data.cart

            if (cart.shippingMethod) {
                selectedMethod = true
            }
        })
    })

    $(':updateEmail').on('blur', (e) => {
        let user_email = e.target.value
        window.Rebound.check({
          publicToken: "tcrsxgzztvagmjfdwrhraz",
          email: user_email
        });
    })

    $(':updateAddress').on('blur', (e) => {
        let form = $(e.target).closest('form').els[0]

        toggleLoading(true)

        let $parent = $(e.target).closest('form')

        validateZipCode($parent[0].querySelector('input[name*="zipCode"]'))

        axios.post('/', serialize(form)).then(function (response) {
            if (Object.keys(response.data.cart.availableShippingMethods).length) {
                updateMethods(response.data.cart.availableShippingMethods, response.data.cart.shippingMethod)
            } else {
                toggleLoading(false)
            }
        })
    })

    $('.c-tooltip').on('mouseenter', (e, el) => {
        toggleToolTip(e, el, true)
    })

    $('.c-tooltip').on('mouseleave', (e, el) => {
        toggleToolTip(e, el, false)
    })

    $(':name').on('change', (e) => {
        let hiddenInput = $(':' + e.target.getAttribute('data-reference'))

        hiddenInput.els[0].value = e.target.value
    })

    bindOrderButton()
}

function bindOrderButton() {
    $(':placeOrder').on('click', (e, el) => {
        // DEV: If they've already clicked, don't allow further clicks. It's possible that they could be double-charged, so
        // this helps prevent any situations like that from arising.
        if (el.className.indexOf('loading') > -1) {
            return
        }

        if (! $('.c-methods__item input:checked').length > 0 || ! selectedMethod) {
            let div = document.createElement('div')

            $('[data-type="shippingMethod"]').remove()

            div.innerText = 'A shipping method is required.'
            div.classList.add('c-form-error')
            div.setAttribute('data-ref', 'formError')
            div.setAttribute('data-type', 'shippingMethod')

            $(':methodContainer').append(div)

            return
        }

        if((getCardType != "VISA") && (getCardType != "MC") && (getCardType != "AMEX")){
            let div = document.createElement('div')

            $('[data-type="cardTypeError"]').remove()

            div.innerText = 'Only Visa, Master Card & American Express Card Accepted.'
            div.classList.add('c-form-error')
            div.setAttribute('data-ref', 'formError')
            div.setAttribute('data-type', 'cardTypeError')

            $(':cardNumber').closest('.c-box__col').append(div)

            return
        }

        // TODO: For some reason the verifyZipCode is running twice and not removeing toggleLoading. Putting it in this conditioanl doesn't work
        if (! validateFields()) {
            return
        }

        toggleLoading(true)

        el.classList.add('is-loading')

        if ($(':sameAddress').els[0].checked) {
            let inputs = $(':billingAddress').els[0].querySelectorAll('input[name*="billingAddress"], select[name="billingAddress[stateId]"]')

            Array.prototype.forEach.call(inputs, (input) => {
                let fieldName = input.getAttribute('name').match(/billingAddress\[(.*)\]/),
                    shippingInput = null

                if (fieldName.length > 1) {
                    shippingInput = $(':shippingAddress').els[0].querySelector('[name="shippingAddress[' + fieldName[1] + ']"]')

                    if (shippingInput.nodeName == 'SELECT') {
                        document.querySelector('select[name="shippingAddress[stateId]"]').value = input.value
                    }

                    shippingInput.value = input.value
                }
            })
        }

        // Submit address details
        ajax('POST', '/', serialize($(':addressForm').els[0]), function(response, statusCode) {
            let obj = JSON.parse('' + response),
                cart = obj.cart

            if (statusCode == 200) {

                if ($(':optDealsMarketing').els[0].checked) {
                    console.log('deals checked');
                    let email = cart.email
                    let phone = cart.billingAddress.phone
                    let firstName = cart.billingAddress.firstName
                    let lastName = cart.billingAddress.lastName
                    let zipCode = cart.billingAddress.zipCode
                    let address = cart.billingAddress.address1 + ' ' + cart.billingAddress.address2 + ', ' + cart.billingAddress.city
                    let sub_form_data = 'ListID=23622320156&SiteGUID=4E1BF72E-AE6F-45FA-A257-C55651B6770A&SuppressConfirmation=no&EmailAddress=' + email + '&FirstName=' + firstName + '&LastName=' + lastName + '&StoreCode=UNK&Address=' + address + '&State=&Zip=' + zipCode + '&Phone=' + phone + '&Action=subscribe'
                    
                    let url = 'http://TexasdeBrazil.fbmta.com/members/subscribe.aspx?' + sub_form_data

                    axios.get(url).then(function (response) {
                        console.log(response)
                    })
                }else{
                    console.log('deals not checked')
                }
                $(':paymentForm').els[0].submit()
            }

            toggleLoading(false)
        })
        // Submit payment details, allowing the form to send the user wherever (form[0].submit())
    })
}

function toggleLoading(status) {
    if (status) {
        $(':wrappingContainer').addClass('js-is-loading')
    } else {
        $(':wrappingContainer').removeClass('js-is-loading')
    }
}

function updateMethods(methods, currentMethod) {
    let parentDiv = document.createElement('div')

    for (let method in methods) {
        var div = document.createElement('div'),
            method = methods[method],
            formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
                minimumFractionDigits: 2
            });

        div.innerHTML = '<div class="c-methods__item"> \
            <label> \
                <input type="radio" name="shippingMethod" value="' + method.handle + '" class="c-methods__input" data-ref="methodSelection"' + (currentMethod && currentMethod == method.handle ? ' checked' : '') + (method.handle == "noShipping" ? ' checked' : '') + '> \
                <span class="t-style-one c-methods__type">' + method.name + ':</span> \
            </label> \
            <span class="t-align-right t-style-one c-methods__amount">' + formatter.format(method.amount) + '</span> \
            </div>'

        parentDiv.innerHTML += div.innerHTML
        if(method.handle == "noShipping"){selectedMethod = true}
    }

    $(':methodContainer').els[0].innerHTML = parentDiv.innerHTML

    bindMethods()
}

function bindMethods() {
    updateTotals()

    $(':methodSelection').on('change', (e) => {
        toggleLoading(true)

        // TODO: Convert to a regular promise chain, instead of callback
        axios.post('/', serialize($(':shippingMethod').els[0])).then(function (response) {
            let cart = response.data.cart

            if (cart.shippingMethod) {
                selectedMethod = true
            }

            updateTotals()
        })
    })
}

function updateTotals() {
    axios.get('/ajax/totals').then(function (response) {
        $(':totalsContainer').els[0].innerHTML = response.data

        bindOrderButton()

        toggleLoading(false)
    })
}

function initUpdateMethod() {

    toggleLoading(true)

    let form_data = "sameAddress=1&shippingAddress[zipCode]=75248&email=customerrelations@texasdebrazil.com&billingAddress[lastName]=Brazil&billingAddress[firstName]=Texas&" + window.csrfTokenName + "=" + window.csrfTokenValue + "&action=commerce%2Fcart%2FupdateCart"

    axios.post('/', form_data).then(function (response) {

        if (Object.keys(response.data.cart.availableShippingMethods).length) {
            updateMethods(response.data.cart.availableShippingMethods, response.data.cart.shippingMethod)
        } else {
            toggleLoading(false)
        }
    })
}

function validateZipCode(field) {
    // DEV: This specific URL is required to turn off CSRF protection in general.php. (This path is the REQUEST_URI,
    //  which is checked agains the $apiActions array)

    if (! field.value) {
        $(field).removeClass('u-error')

        $('[data-type="zipCode"]').remove()

        return
    }

    axios.post('/actions/fedex/verifyZipCode/', {zipCode: field.value}, { headers: {'Content-Type':'application/json;charset=UTF-8'}}).then(function (response) {
        let div = document.createElement('div'),
            obj = response.data;

        $('[data-type="zipCode"]').remove()

        if (! obj.result) {
            $(field).addClass('u-error')

            div.innerText = 'This Zip Code doesn\'t appear to be valid.'
            div.classList.add('c-form-error')
            div.setAttribute('data-ref', 'formError')
            div.setAttribute('data-type', 'zipCode')

            $(field).closest('.c-box').append(div)

            return false;
        }

        $(field).removeClass('u-error')

        $('[data-type="zipCode"]').remove()

        return true;
    })
}

function validateFields() {
    let valid = true,
        results = []

    $('.u-error').removeClass('u-error')
    $('.u-error--select').removeClass('u-error--select')

    $(':formError').remove()

    results.push(validateWithinParentElement('billingAddress'))

    if (! document.querySelector('[data-ref="sameAddress"]').checked) {
        results.push(validateWithinParentElement('shippingAddress'))
    }

    results.push(validateWithinParentElement('paymentForm'))

    // TODO: the zipCode 'flickering' issue is somewhere around here.
    // The error is being removed somewhere in this method.
    $('input[name*="zipCode"]').each((el) => {
        results.push(validateZipCode(el))
    })

    if (! $('input[name="shippingMethod"]:checked').length) {
        let div = document.createElement('div')

        div.innerText = 'A shipping method is required.'
        div.classList.add('c-form-error')
        div.setAttribute('data-ref', 'formError')
        div.setAttribute('data-type', 'shippingMethod')

        $(':methodContainer').append(div)

        results.push(false)
    }

    return results.indexOf(false) === -1
}

function validateWithinParentElement(type) {
    let inputs = document.querySelectorAll('[data-ref="' + type + '"] input[required], [data-ref="' + type + '"] textarea[required], [data-ref="' + type + '"] select[required]'),
        disallowedSelectValues = [
            'State',
            'Signature Option',
        ],
        blankInputs = Array.prototype.filter.call(inputs, (el) => {
            let pattern = el.getAttribute('data-pattern')

            if (pattern) {
                let regex = null

                if (pattern == '#card#') {
                    return ! validateCardNumber(el.value)
                }

                regex = new RegExp(pattern, 'g')

                return ! regex.test(el.value)
            }

            if (el.nodeName !== 'SELECT') {
                return ! el.value
            }

            return el.value && disallowedSelectValues.indexOf(el.value) > -1
        })

    if (! blankInputs.length) {
        return true
    }

    Array.prototype.forEach.call(blankInputs, (el) => {
        let div = document.createElement('div')

        if (el.nodeName == 'SELECT') {
            $(el).closest('.choices').addClass('u-error--select')
        } else {
            el.classList.add('u-error')
        }

        if (el.getAttribute('data-error-text')) {
            div.innerText = el.getAttribute('data-error-text')
        } else {
            div.innerText = el.getAttribute('data-name') + ' is required.'
        }

        div.classList.add('c-form-error')
        div.setAttribute('data-ref', 'formError')
        div.setAttribute('data-type', el.getAttribute('data-name'))

        $(':' + type).append(div)
    })

    return false
}

function toggleShippingAddress(e) {
    $(':shippingAddress').els[0].classList.toggle('c-box--disabled')
}

function toggleToolTip(e, el, showToolTip) {
    let disabledClass = 'c-tooltip--disabled'

    if (e.target.classList.contains('c-tooltip__text')) {
        return
    }

    if (showToolTip) {
        el.classList.remove(disabledClass)

        return
    }

    el.classList.add(disabledClass)
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

function validateCardNumber (value) {
    // accept only digits, dashes or spaces
    if (/[^0-9-\s]+/.test(value)) return false

    // Remove everything but numbers for validation
    value = value.replace(/\D/g, "")

    let luhnChk = (function (arr) {
        return function (ccNum) {
            var
                len = ccNum.length,
                bit = 1,
                sum = 0,
                val;

            while (len) {
                val = parseInt(ccNum.charAt(--len), 10);
                sum += (bit ^= 1) ? arr[val] : val;
            }

            return sum && sum % 10 === 0;
        };
    }([0, 2, 4, 6, 8, 1, 3, 5, 7, 9]));

    return luhnChk(value)
}

export default Object.assign(init, {})
