import $ from '../framework/$'
import Choices from '../plugins/choices'
import header from './header'
import Modal from '../plugins/modal'

const _doc = document

let Popup = null

let choices = {}

function init() {
    let reserveModal = document.querySelector('.u-reserve-modal')

    if (reserveModal) {
        Popup = new Modal(reserveModal)
    }

    header()

    initChoices()

    updateResponsiveElements()

    bindEvents()
}

function bindEvents() {
    $(':reserveButton').on('click', (e, el) => {
        Popup.show()

        e.preventDefault()
    })

    var dd = new Date()
    var dayOffset = 0
    var getHours = dd.getHours()
    var getNextHours = dd.getHours() + 1
    var getMinutes = dd.getMinutes()
    var getAmPm = 'AM'

    if( getMinutes >= 30  ){
        getMinutes = '30';    
    }else{
        getMinutes = '00';
    }

    if( getNextHours >= 24){
        dayOffset = 86400000;
        getNextHours = '11';
        getMinutes = '00';
    }else if( getNextHours <= 10){
        getNextHours = '11';
        getMinutes = '00';
    }

    if( getNextHours >= 13 ){
        getAmPm = 'PM'
        getNextHours = getNextHours - 12
    }
    
    var date = new Date();
    var today = date.getTime();
    var today = new Date(today+dayOffset);
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0
    var yyyy = today.getFullYear();

    if(dd<10){
        dd='0'+dd;
    } 

    if(mm<10){
        mm='0'+mm;
    } 
    
    var mkTodayDate = mm+'/'+dd+'/'+yyyy;
    var mkTimeInNextHour = getNextHours+':'+getMinutes+' '+getAmPm

    let selecttableFinderDate = document.querySelectorAll('[data-el="tableFinderDate"]')
    Array.prototype.forEach.call(selecttableFinderDate, function (el) {

        el.value = mkTodayDate

    })

    let selecttableFinderHours = document.querySelectorAll('[data-el="tableFinderTime"]')
    Array.prototype.forEach.call(selecttableFinderHours, function (el) {

        el.options[0].innerText = mkTimeInNextHour
        el.options[0].value = mkTimeInNextHour
        el.options[0].setAttribute('selected', 'selected')
        el.options[0].trigger

    })

    let selectTheDefaultHour = document.querySelectorAll('div.choices__list--single [data-value="11:00 AM"]')
    Array.prototype.forEach.call(selectTheDefaultHour, function (el) {
        
        el.innerText = mkTimeInNextHour
        el.setAttribute('data-value', mkTimeInNextHour)

    })

    $(':limitScroll').on('scroll', () => {
        document.body.style.overflowY = 'hidden'
    })

    $(':limitScroll').on('mouseleave', () => {
        document.body.style.overflowY = ''
    })

    $(':tableForm').on('submit', (e, el) => transformPartySizeBeforeSending(e, el, 'selectedLocation'))

    $(':tablePopupForm').on('submit', (e, el) => transformPartySizeBeforeSending(e, el, 'selectedLocationPopup'))

    // TODO: Debounce this to prevent a performance hit
    window.addEventListener('scroll', function() {
        let $fixedHeader = $('.header--fixed')

        if (window.pageYOffset > 135) {
            $fixedHeader.addClass('header--is-fixed')
        } else {
            $fixedHeader.removeClass('header--is-fixed')
        }
    })

    let selects = document.querySelectorAll('select')

    Array.prototype.forEach.call(selects, function (el) {
        el.addEventListener('showDropdown', function () {
            // DEV: Prevent scrolling on iOS devices
            document.body.addEventListener('touchmove', preventScrolling);

            if (window.innerWidth < 769) {
                setTimeout(function() {
                    document.body.style.overflowY = 'hidden'
                }, 15)
            }
        });

        el.addEventListener('hideDropdown', function () {
            // DEV: Re-enable scrolling on iOS devices
            document.body.removeEventListener('touchmove', preventScrolling);

            if (window.innerWidth < 769) {
                document.body.style.overflowY = 'auto'
            }
        });
    })

    window.addEventListener('resize', updateResponsiveElements)

    let $bodyHead = document.querySelector('head')

    if (window.innerWidth < 743) {

        $("input[type=text], textarea").on({ 'touchstart' : function() {
            zoomDisable();
        }});
        $("input[type=text], textarea").on({ 'touchend' : function() {
            setTimeout(zoomEnable, 500);
        }});

        function zoomDisable(){
            document.querySelector('head meta[name=viewport]').setAttribute('content', 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0')
        }
        function zoomEnable(){
            document.querySelector('head meta[name=viewport]').setAttribute('content', 'width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=5')
        } 

    }

}

function preventScrolling (e) {
    if (! e.target.classList.contains('choices__item')) {
        e.preventDefault();
    }
}

/**
 * Initialize Choices plugin
 */
function initChoices() {
    let selects = [..._doc.getElementsByTagName('select')]

    if (selects.length) {
        selects.forEach(select => {
            let key = select.getAttribute('name'),
                index = 0

            if (select.getAttribute('data-ignore')) {
                return
            }

            if (choices.hasOwnProperty(key)) {
                key = key + index.toString()

                index++
            }

            choices[key] = new Choices(select, {
                shouldSort: false,
                shouldSortItems: false
            })
        })

        window.choices = choices
    }
}

function transformPartySizeBeforeSending(e, el, select) {
    e.preventDefault()
    if(validateWithinParentElement(select)){

        let locationSelect = document.getElementById('resturant-select'),
            optionValue = locationSelect.options[0].value,
            values = optionValue.match('(.*)-(.*)')

        // choices['restaurantID'].setValue([
        //     {
        //         value: values[2],
        //         label: values[1]
        //     }
        // ])

        // if (choices.hasOwnProperty('restaurantID0')) {
        //     choices['restaurantID0'].setValue([
        //         {
        //             value: values[2],
        //             label: values[1]
        //         }
        //     ])
        // }

        if (e.target.querySelector('select[name="partySize"]').value == '15+') {
            window.location = window.location.origin + '/group-dining#modal'
        } else {
            e.target.submit()

            choices['restaurantID'].setValue([
                {
                    value: optionValue,
                    label: values[1]
                }
            ])

            if (choices.hasOwnProperty('restaurantID0')) {
                choices['restaurantID0'].setValue([
                    {
                        value: optionValue,
                        label: values[1]
                    }
                ])
            }
        }
    }else{
        return false
    }
}

function validateWithinParentElement(type) {
    let inputs = document.querySelectorAll('[data-ref="' + type + '"]'),
        disallowedSelectValues = [
            'Choose a location',
        ],
        blankInputs = Array.prototype.filter.call(inputs, (el) => {
            $(el).closest('.choices').removeClass('choices__error--select')
            return el.value && disallowedSelectValues.indexOf(el.value) > -1
        })
        
    if (!blankInputs.length) {
        return true
    }

    Array.prototype.forEach.call(blankInputs, (el) => {

        if (el.nodeName == 'SELECT') {
            $(el).closest('.choices').addClass('choices__error--select')
        } else {
            el.classList.add('u-error')
        }
    })

    return false
}



function updateResponsiveElements() {
    let elements = $(':responsiveVisualElement'),
        newSizeToLoad = window.innerWidth >= 768 ? 'desktop' : 'mobile'
    elements.each((el) => {
        el.style.backgroundImage = 'url(' + el.getAttribute('data-' + newSizeToLoad) + ')'
    })
}

export default Object.assign(init, {})
