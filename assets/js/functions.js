/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function isValidDate(date) {
    //return true;
    ////var date_regex = /^([1-9]\/(0[1-9]|1\d|2\d|3[01])\/(19|20)\d{2}$/;
    //2/14/2024
    console.log('date',date);
    var date_regex = /^([1-9]|1[0-2])\/([1-9]|1\d|2\d|3[01])\/(19|20)\d{2}$/;
    return date_regex.test(date);
}

function isValidEmail(email)
{
    return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email);
}


function isMobileDevice() {
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        return true;
    } else {
        return false;
    }
}

const getMobileOS = () => {
    const ua = navigator.userAgent
    if (/android/i.test(ua)) {
        return "Android"
    } else if (/iPad|iPhone|iPod/.test(ua) || navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1) {
        return "iOS"
    }
    return "Other"
}

const isNumericInput = (event) => {
    const key = event.keyCode;
    return ((key >= 48 && key <= 57) || // Allow number line
            (key >= 96 && key <= 105) // Allow number pad
            );
};

const isModifierKey = (event) => {
    const key = event.keyCode;
    return (event.shiftKey === true || key === 35 || key === 36) || // Allow Shift, Home, End
            (key === 8 || key === 9 || key === 13 || key === 46) || // Allow Backspace, Tab, Enter, Delete
            (key > 36 && key < 41) || // Allow left, up, right, down
            (// Allow Ctrl/Command + A,C,V,X,Z
                    (event.ctrlKey === true || event.metaKey === true) && (key === 65 || key === 67 || key === 86 || key === 88 || key === 90)
                    );
};

const enforceFormat = (event) => {
    // Input must be of a valid number format or a modifier key, and not longer than ten digits
    if (!isNumericInput(event) && !isModifierKey(event)) {
        event.preventDefault();
    }
};

const formatToPhone = (event) => {
    if (isModifierKey(event)) {
        return;
    }

    // I am lazy and don't like to type things more than once
    const target = event.target;
    const input = target.value.replace(/\D/g, '').substring(0, 10); // First ten digits of input only
    const areaCode = input.substring(0, 3);
    const middle = input.substring(3, 6);
    const last = input.substring(6, 10);

    if (input.length > 6) {
        target.value = `${areaCode}-${middle}-${last}`;
    } else if (input.length > 3) {
        target.value = `${areaCode}-${middle}`;
    } else if (input.length > 0) {
        target.value = `${areaCode}`;
    }
};

const inputElements = document.getElementsByClassName('PhoneNumber');
for (let item of inputElements) {
    item.addEventListener('keydown', enforceFormat);
    item.addEventListener('keyup', formatToPhone);
}


const formatToDate = (event) => {
    if (isModifierKey(event)) {
        return;
    }

    //m/d/Y
    const target = event.target;
    const input = target.value.replace(/\D/g, '').substring(0, 8); // First ten digits of input only
    const month = input.substring(0, 2);
    const day = input.substring(2, 4);
    const year = input.substring(4, 8);

    if (input.length > 4) {
        target.value = `${month}/${day}/${year}`;
    } else if (input.length > 2) {
        target.value = `${month}/${day}`;
    } else if (input.length > 0) {
        target.value = `${month}`;
    }
};


const inputdatesElements = document.getElementsByClassName('u-date-input');
for (let item of inputdatesElements) {
    item.addEventListener('keydown', enforceFormat);
    item.addEventListener('keyup', formatToDate);
}
function getKeyCode(event) {
    var key;
    if (event.key !== undefined) {
        key = event.key;
    } else if (event.keyCode !== undefined) {
        key = event.keyCode;
    }
    return key;

}

function autocomplete(inp, arr, $) {
    /*the autocomplete function takes two arguments,
     the text field element and an array of possible autocompleted values:*/
    var currentFocus;
    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", function (e) {
        var a, b, i, val = this.value;
        /*close any already open lists of autocompleted values*/
        closeAllLists();
        if (!val) {
            return false;
        }
        currentFocus = -1;
        /*create a DIV element that will contain the items (values):*/
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(a);
        /*for each item in the array...*/
        for (i = 0; i < arr.length; i++) {
            /*check if the item starts with the same letters as the text field value:*/
            var location = arr[i]['location'];
            var href = arr[i]['href'];
            if (location.substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                /*create a DIV element for each matching element:*/
                b = document.createElement("DIV");
                jQuery(b).data('href', href);
                /*make the matching letters bold:*/
                b.innerHTML = "<strong>" + location.substr(0, val.length) + "</strong>";
                b.innerHTML += location.substr(val.length);
                /*insert a input field that will hold the current array item's value:*/
                b.innerHTML += "<input type='hidden' value='" + location + "'>";
                /*execute a function when someone clicks on the item value (DIV element):*/
                b.addEventListener("click", function (e) {
                    /*insert the value for the autocomplete text field:*/
                    inp.value = this.getElementsByTagName("input")[0].value;
                    if (!$('.autocomplete-catering').length) {
                        //console.log(jQuery(this).data('href'));
                        window.location.assign(jQuery(this).data('href'));
                    } else {
                        //console.log(window.location.origin, window.location.path, window.location);
                        window.location.assign(window.location.origin + window.location.pathname + '?location=' + jQuery(this).data('href'));
                    }
                    /*close the list of autocompleted values,
                     (or any other open lists of autocompleted values:*/
                    closeAllLists();
                });
                a.appendChild(b);
            }
        }
    });
    /*execute a function presses a key on the keyboard:*/
    inp.addEventListener("keydown", function (e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x)
            x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
            /*If the arrow DOWN key is pressed,
             increase the currentFocus variable:*/
            currentFocus++;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 38) { //up
            /*If the arrow UP key is pressed,
             decrease the currentFocus variable:*/
            currentFocus--;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 13) {
            /*If the ENTER key is pressed, prevent the form from being submitted,*/
            e.preventDefault();
            if (currentFocus > -1) {
                /*and simulate a click on the "active" item:*/
                if (x)
                    x[currentFocus].click();
            }
        }
    });
    function addActive(x) {
        /*a function to classify an item as "active":*/
        if (!x)
            return false;
        /*start by removing the "active" class on all items:*/
        removeActive(x);
        if (currentFocus >= x.length)
            currentFocus = 0;
        if (currentFocus < 0)
            currentFocus = (x.length - 1);
        /*add class "autocomplete-active":*/
        x[currentFocus].classList.add("autocomplete-active");
    }
    function removeActive(x) {
        /*a function to remove the "active" class from all autocomplete items:*/
        for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
        }
    }
    function closeAllLists(elmnt) {
        /*close all autocomplete lists in the document,
         except the one passed as an argument:*/
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }
    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });
}

function autocompleteDropdown(inp, arr, $) {
    /*the autocomplete function takes two arguments,
     the text field element and an array of possible autocompleted values:*/
    var options = '<option value="">Select Location</option>';


    for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        var location = arr[i]['location'];
        var href = arr[i]['href'];
        options += '<option value="' + href + '">' + location + '</option>';


    }
    $(inp).html(options).change(function () {


        jQuery.ajax({
            type: "POST",
            url: woocommerce_params.ajax_url,
            dataType: "json",
            data: {action: 'catering_location', location: jQuery(this).val()},
            success: function (data)
            {
                $('.search-location').parent().find('.choices__item.choices__item--selectable').html('<option value="" selected="">Select Location</option>');


                if (data.status == '200') {
                    //$('.search-no-results').hide();
                    $('.search-results').find('.data-description').text(data.description);
                    $('.search-results').find('.data-title').text(data.title);
                    $('.search-results').find('.data-phone').text(data.phone);
                    $('.search-results').find('.data-links').html(data.links);
                    //$('.search-results').css('display', 'flex');

                    $([document.documentElement, document.body]).animate({
                        scrollTop: $('.search-results').offset().top - 200
                    }, 2000);
                } else {
//                    $('.search-results').hide();
//                    $('.search-no-results').show();

                }
            }

        });


        //window.location.assign(window.location.origin + window.location.pathname + '?location=' + jQuery(this).val());

    });



}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}


