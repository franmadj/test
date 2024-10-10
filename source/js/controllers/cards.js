import $ from '../framework/$'

let tabState = {
    index: null,
    tabs: null,
    total: null,
    disabledClass: 'u-tab--disabled'
}

let themeOptions = null

function init() {
    let themeSelector = document.querySelector('meta[name="themeArray"]')

    initializeTabs()
    bindEvents()

    if (themeSelector) {
        themeOptions = JSON.parse(themeSelector.content)
    }
}

function initializeTabs() {
    tabState.index = 0
    tabState.tabs = $(':tab')
    tabState.total = tabState.tabs.length
}

function bindEvents() {
    $(':moveTabs').on('click', (e, el) => moveTabs($(el)))

    $(':theme').on('click', (e, el) => selectTheme($(el)))

    $(':productForm').on('submit', (e, el) => handleForm(e, $(el)))

    $(':stepBack').on('click', (e) => stepBack(e))

    $(':resetForm').on('click', (e) => refreshPage())

    $(':message').on('keyup', (e, el) => limitChars(e, el))

    $(':themeSelection').on('change', (e, el) => {
        let selectedTheme = Array.prototype.filter.call(themeOptions, function(obj) {
            return obj.id == el.value
        })

        $(':currentCard').els[0].src = selectedTheme[0].url
    })

    $(':ctype').on('change', (e, el) => {
        setTimeout(function() {
            switch (el.value) {
                case 'Digital':
                    $('.c-page-header__text').removeClass('c-invisible')
                    reveal($('.confirm-btn'))
                    conceal($('.add-cart-btn'))
                    break;
                case 'Physical':
                    $('.c-page-header__text').addClass('c-invisible')
                    conceal($('.confirm-btn'))
                    reveal($('.add-cart-btn'))
                    break;
            }
        }, 250)
    })

    window.addEventListener('resize', () => {
        let confirmButton = document.querySelector('[data-el="confirmButton"]')

        if (window.innerWidth < 768) {
            document.querySelector('[data-ref="desktopRow"]').appendChild(confirmButton)
        } else {
            document.querySelector('[data-ref="currentCard"]').parentNode.appendChild(confirmButton)
        }

        let addCartButton = document.querySelector('[data-el="addCartButton"]')

        if (window.innerWidth < 768) {
            document.querySelector('[data-ref="desktopRow"]').appendChild(addCartButton)
        } else {
            document.querySelector('[data-ref="currentCard"]').parentNode.appendChild(addCartButton)
        }
    })

    if (document.querySelector('[data-ref="thumb"]')) {
        $(':thumb').on('click', (e, el) => {
            let $el = $(el)

            $(':currentCard').els[0].src = $el.attr('data-image')

            $('[data-ref="thumb"]').removeClass('selected')

            $el.addClass('selected')
        })
    }
}

function reveal(el) {
    el.removeClass('js-hide')
}

function conceal(el) {
    el.addClass('js-hide')
}

function limitChars(e, el) {
    if (el.value.length > 140) {
        el.value = el.value.substr(0, el.value.length - 1)
    }

    document.querySelector('[data-ref="charCount"]').innerText = el.value.length + '/140';
}

function refreshPage() {
    window.location = window.location;
}

function stepBack(e) {
    let newTab = tabState.tabs.els[tabState.index - 1],
        $selectedStepBack = $('.u-step-back--hidden')

    // If we're at the beginning + moving backward, return false
    if (tabState.index === 0 && direction === 'backward') {
        return false
    }

    $selectedStepBack.removeClass('u-step-back--hidden')

    $selectedStepBack.siblings().addClass('u-step-back--hidden')

    tabState.tabs.each(function(el) {
        $(el).addClass(tabState.disabledClass)
    });

    tabState.index--

    $(tabState.tabs.els[tabState.index]).removeClass(tabState.disabledClass)

    if (newTab) {
        let title = $(newTab).attr('data-title'),
            step = $(newTab).attr('data-step')

        $(':tabTitle')[0].innerText = title

        renderSteps(step)

        e.preventDefault()
    }
}

function handleForm(e, el) {
    e.preventDefault()

    let validInputs = 'select.c-cardType'

    let inputs = el[0].querySelectorAll(validInputs),
        emptyInputs = Array.prototype.filter.call(inputs, function(input) {
            if(input.value == 'Physical'){
                el[0].submit()
            }else{
                return;
            }
        })

    if (! isValid(el[0])) {
        return;
    }

    el[0].submit()
}

function isValid(form) {
    let validInputs = '' +
        'input[type="text"]:not([data-optional]):not(.choices__input), ' +
        'select:not([data-optional])'

    $('[data-ref="formError"]').remove()

    let inputs = form.querySelectorAll(validInputs),
        emptyInputs = Array.prototype.filter.call(inputs, function(input) {
            let inputIsBlank = (input.value == '' || input.value == 'Select a State')

            if (inputIsBlank) {
                let div = document.createElement('div');

                div.classList.add('c-form-error')
                div.setAttribute('data-ref', 'formError')

                div.innerHTML = 'The ' + input.getAttribute('data-name') + ' field is required.'

                $('.c-card-form')[0].appendChild(div)
            }

            return inputIsBlank
        })

    let haveEmailAddress = document.querySelector('[data-ref="ecardEmail"]') !== null

    if (haveEmailAddress) {

        let emailAddress = document.querySelector('[data-ref="ecardEmail"]').value

        if (!validateEmail( emailAddress )) {
            let div = document.createElement('div');

            div.classList.add('c-form-error')
            div.setAttribute('data-ref', 'formError')

            div.innerHTML = 'Invalid Email!'
            
            $('.c-card-form')[0].appendChild(div)

            return false;
        }

    }

    if (document.querySelector('[data-ref="stateSelect"]')) {
        if (document.querySelector('[data-ref="stateSelect"]').value == 'State') {
            let div = document.createElement('div');

            div.classList.add('c-form-error')
            div.setAttribute('data-ref', 'formError')

            div.innerHTML = 'The state field is required.'

            $('.c-card-form')[0].appendChild(div)

            return false;
        }
    }

    return emptyInputs.length == 0
}

function validateEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}

function selectTheme(el) {
    let themeId = el.data('id')

    // add border
    $('.c-option__thumb--selected').removeClass('c-option__thumb--selected')

    el.addClass('c-option__thumb--selected')

    $(':currentCard').els[0].style.backgroundImage = el.els[0].style.backgroundImage

    $(':cardThumbnail').els[0].src = el.els[0].getAttribute('data-image')

    $(':themeInput').els[0].value = themeId
}

function moveTabs(el) {
    let direction = el[0].getAttribute('data-direction'),
        newTab = tabState.tabs.els[tabState.index + 1],
        $selectedStepBack = $('.u-step-back--hidden')

    $selectedStepBack.removeClass('u-step-back--hidden')

    $selectedStepBack.siblings().addClass('u-step-back--hidden')

    // TODO: Abstract start/end checks into tabState

    // if we're at the end + moving forward, return false
    if (tabState.index + 1 === tabState.total && direction === 'forward') {
        return false
    }

    // If we're at the beginning + moving backward, return false
    if (tabState.index === 0 && direction === 'backward') {
        return false
    }

    tabState.tabs.each(function(el) {
        $(el).addClass(tabState.disabledClass)
    });

    tabState.index++

    $(tabState.tabs.els[tabState.index]).removeClass(tabState.disabledClass)

    if (newTab) {
        let title = $(newTab).attr('data-title'),
            step = $(newTab).attr('data-step')

        if ($(':tabTitle').length) {
            $(':tabTitle')[0].innerText = title
        }

        renderSteps(step)
    }

    scrollTo(document.querySelector('body'), 0, 100)
}

function scrollTo(element, to, duration) {
    var difference = to - element.scrollTop,
        perTick = difference / duration * 2;

    if (duration < 0) {
        return;
    }

    setTimeout(function() {
        element.scrollTop = element.scrollTop + perTick;

        scrollTo(element, to, duration - 2);
    }, 10);
}

function renderSteps(step) {
    let outputElement = $(':tabSteps'),
        template = outputElement.attr('data-template'),
        values = [];

    values['currentStep'] = tabState.index + 1
    values['totalSteps'] = tabState.total

    // if (values['currentStep'] == 2) {
    //     $('.c-page-header--disabled').removeClass('c-page-header--disabled');
    // } else {
    //     $('.c-page-header').addClass('c-page-header--disabled');
    // }

    outputElement[0].innerText = template.replace(/{currentStep}|{totalSteps}/gi, function(matched) {
        let key = matched.substring(1, matched.length - 1)

        return values[key]
    })
}

export default Object.assign(init, {})
