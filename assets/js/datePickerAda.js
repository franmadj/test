/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Date.prototype.addDays = function (days) {
    let date = new Date(this.valueOf());
    date.setDate(date.getDate() + days);
    return date;
}


var DatePicker = DatePicker || {};

var CalendarButtonInput = function (inputNode, buttonNode, datepicker) {
    this.inputNode = inputNode;
    this.buttonNode = buttonNode;
    this.imageNode = false;

    this.datepicker = datepicker;

    this.defaultLabel = 'Choose Date';

    this.keyCode = Object.freeze({
        'ENTER': 13,
        'SPACE': 32
    });
};

CalendarButtonInput.prototype.log = function (value) {
    //return false;
    console.log(value)

}

CalendarButtonInput.prototype.init = function () {
    //this.buttonNode.addEventListener('click', this.handleClick.bind(this));
    this.inputNode.addEventListener('click', this.handleClick.bind(this));
    this.inputNode.addEventListener('keydown', this.handleInputKey.bind(this));
    //this.buttonNode.addEventListener('keydown', this.handleKeyDown.bind(this));
    //this.buttonNode.addEventListener('focus', this.handleFocus.bind(this));
};

CalendarButtonInput.prototype.handleKeyDown = function (event) {
    this.log('CalendarButtonInput handleKeyDown');
    var flag = false;

    switch (event.keyCode) {

        case this.keyCode.SPACE:
        case this.keyCode.ENTER:
            this.datepicker.show();
            this.datepicker.setFocusDay();
            flag = true;
            break;

        default:
            break;
    }

    if (flag) {
        event.stopPropagation();
        event.preventDefault();
    }
};

CalendarButtonInput.prototype.handleClick = function () {
    this.log('handleClick')
    if (!this.datepicker.isOpen()) {
        this.datepicker.show();
        this.datepicker.setFocusDay();
    } else {
        this.datepicker.hide();
    }

    event.stopPropagation();
    event.preventDefault();

};

CalendarButtonInput.prototype.handleInputKey = function (event) {
    this.log('handleInputKey')
    if (this.keyCode.ENTER != event.keyCode)
        return;
    if (!this.datepicker.isOpen()) {
        this.datepicker.show();
        this.datepicker.setFocusDay();
    } else {
        this.datepicker.hide();
    }

    event.stopPropagation();
    event.preventDefault();

};

CalendarButtonInput.prototype.setLabel = function (str) {
    if (typeof str === 'string' && str.length) {
        str = ', ' + str;
    }
    this.buttonNode.setAttribute('aria-label', this.defaultLabel + str);
};

CalendarButtonInput.prototype.setFocus = function () {
    this.buttonNode.focus();
};

CalendarButtonInput.prototype.setDate = function (day) {
    //this.inputNode.value = (day.getMonth() + 1) + '/' + day.getDate() + '/' + day.getFullYear();
//        var now = new Date();
//        if (day >= now) {
//            alert('only past dates');
//            return false;
//        }

    let day_ = day.getDate() < 10 ? '0' + day.getDate() : day.getDate();
    let month = (day.getMonth() + 1) < 10 ? '0' + (day.getMonth() + 1) : (day.getMonth() + 1);


    //if (typeof format_date != 'undefined' && format_date == 'd/m/y')

    if (typeof format_date != 'undefined') {
        //this.inputNode.value = month + '/' + day_ + '/' + day.getFullYear();
        if (format_date == 'd/m/y')
            this.inputNode.value = day_ + '/' + month + '/' + day.getFullYear();
        else if (format_date == 'Y/m/d')
            this.inputNode.value =  day.getFullYear() + '/' + month + '/' + day_;
        else
            this.inputNode.value = month + '/' + day_ + '/' + day.getFullYear();

    } else
        this.inputNode.value = (day.getMonth() + 1) + '/' + day.getDate() + '/' + day.getFullYear();

    //d/m/y




//    if (typeof format_date != 'undefined' && format_date)
//
//        this.inputNode.value = day.getFullYear() + '-' + month + '-' + day_;
//    else
//        this.inputNode.value = (day.getMonth() + 1) + '/' + day.getDate() + '/' + day.getFullYear();

};

CalendarButtonInput.prototype.getDate = function () {
    return this.inputNode.value;
};

CalendarButtonInput.prototype.getDateLabel = function () {
    var label = '';

    var parts = this.inputNode.value.split('/');

    if ((parts.length === 3) &&
            Number.isInteger(parseInt(parts[0])) &&
            Number.isInteger(parseInt(parts[1])) &&
            Number.isInteger(parseInt(parts[2]))) {
        var month = parseInt(parts[0]) - 1;
        var day = parseInt(parts[1]);
        var year = parseInt(parts[2]);

        label = this.datepicker.getDateForButtonLabel(year, month, day);
    }

    return label;
};

CalendarButtonInput.prototype.handleFocus = function () {
    var dateLabel = this.getDateLabel();

    if (dateLabel) {
        this.setLabel('selected date is ' + dateLabel);
    } else {
        this.setLabel('');
    }
};

// Initialize menu button date picker

window.addEventListener('load', function () {

    var datePickers = document.querySelectorAll('.datepicker-wai');

    datePickers.forEach(function (dp) {
        var inputNode = dp.querySelector('input');
        var buttonNode = dp.querySelector('button');
        var dialogNode = dp.querySelector('[role=dialog]');

        var datePicker = new DatePicker(inputNode, buttonNode, dialogNode, dp);
        datePicker.init();
    });

});





/*
 *   This content is licensed according to the W3C Software License at
 *   https://www.w3.org/Consortium/Legal/2015/copyright-software-and-document
 *
 *   File:   datepicker.js
 */

var CalendarButtonInput = CalendarButtonInput || {};
var DatePickerDay = DatePickerDay || {};

var DatePicker = function (inputNode, buttonNode, dialogNode, dp) {
    //console.log('DatePicker', dp);
    this.dayLabels = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    this.monthLabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];


    this.messageCursorKeys = 'Cursor keys can navigate dates';
    this.lastMessage = '';

    this.inputNode = inputNode;
    this.buttonNode = buttonNode;
    this.dialogNode = dialogNode;
    this.messageNode = dialogNode.querySelector('.message');

    this.currentTime = this.inputNode.dataset.currenttime;
    this.jumpDay = this.currentTime > 2030;


    this.dateInput = new CalendarButtonInput(this.inputNode, this.buttonNode, this);

    this.MonthYearNode = this.dialogNode.querySelector('.monthYear');

    //this.prevYearNode = this.dialogNode.querySelector('.prevYear');
    this.prevMonthNode = this.dialogNode.querySelector('.prevMonth');
    this.nextMonthNode = this.dialogNode.querySelector('.nextMonth');
    //this.nextYearNode = this.dialogNode.querySelector('.nextYear');

    this.okButtonNode = this.dialogNode.querySelector('button[value="ok"]');
    this.cancelButtonNode = this.dialogNode.querySelector('button[value="cancel"]');

    this.tbodyNode = this.dialogNode.querySelector('table.dates tbody');

    this.lastRowNode = null;

    this.days = [];

    this.focusDay = new Date();


//        if (this.currentTime > 1500) {
//            
//            this.focusDay = this.focusDay.addDays(1)
//            
//            console.log('this.currentTime >> 1500');
//            
//          
//        }


    this.selectedDay = new Date(0, 0, 1);

    this.isMouseDownOnBackground = false;

    this.keyCode = Object.freeze({
        'TAB': 9,
        'ENTER': 13,
        'ESC': 27,
        'SPACE': 32,
        'PAGEUP': 33,
        'PAGEDOWN': 34,
        'END': 35,
        'HOME': 36,
        'LEFT': 37,
        'UP': 38,
        'RIGHT': 39,
        'DOWN': 40
    });

};

DatePicker.prototype.init = function () {

    this.dateInput.init();

    this.okButtonNode.addEventListener('click', this.handleOkButton.bind(this));
    this.okButtonNode.addEventListener('keydown', this.handleOkButton.bind(this));

    this.cancelButtonNode.addEventListener('click', this.handleCancelButton.bind(this));
    this.cancelButtonNode.addEventListener('keydown', this.handleCancelButton.bind(this));

    this.prevMonthNode.addEventListener('click', this.handlePreviousMonthButton.bind(this));
    this.nextMonthNode.addEventListener('click', this.handleNextMonthButton.bind(this));
    //this.prevYearNode.addEventListener('click', this.handlePreviousYearButton.bind(this));
    //this.nextYearNode.addEventListener('click', this.handleNextYearButton.bind(this));

    this.prevMonthNode.addEventListener('keydown', this.handlePreviousMonthButton.bind(this));
    this.nextMonthNode.addEventListener('keydown', this.handleNextMonthButton.bind(this));
    //this.prevYearNode.addEventListener('keydown', this.handlePreviousYearButton.bind(this));

    //this.nextYearNode.addEventListener('keydown', this.handleNextYearButton.bind(this));

    document.body.addEventListener('mousedown', this.handleBackgroundMouseDown.bind(this), true);
    document.body.addEventListener('mouseup', this.handleBackgroundMouseUp.bind(this), true);

    // Create Grid of Dates

    this.tbodyNode.innerHTML = '';
    var index = 0;
    this.log('var i = 0; i < 6; i++');
    for (var i = 0; i < 6; i++) {
        var row = this.tbodyNode.insertRow(i);
        this.lastRowNode = row;
        row.classList.add('dateRow');
        this.log('var j = 0; j < 7; j++');
        for (var j = 0; j < 7; j++) {
            var cell = document.createElement('td');
            cell.classList.add('dateCell');
            var cellButton = document.createElement('button');
            cellButton.classList.add('dateButton');
            cell.appendChild(cellButton);
            row.appendChild(cell);
            this.log('new DatePickerDay');
            var dpDay = new DatePickerDay(cellButton, this, index, i, j);
            dpDay.init();
            this.days.push(dpDay);
            index++;
        }
    }

    this.updateGrid();
    this.setFocusDay();
};

DatePicker.prototype.log = function (value) {
    return false;
    console.log(value)

}

DatePicker.prototype.updateGrid = function () {

    var i, flag;
    var fd = this.focusDay;

    this.MonthYearNode.innerHTML = this.monthLabels[fd.getMonth()] + ' ' + fd.getFullYear();

    var firstDayOfMonth = new Date(fd.getFullYear(), fd.getMonth(), 1);
    var daysInMonth = new Date(fd.getFullYear(), fd.getMonth() + 1, 0).getDate();
    var dayOfWeek = firstDayOfMonth.getDay();

    firstDayOfMonth.setDate(firstDayOfMonth.getDate() - dayOfWeek);

    var d = new Date(firstDayOfMonth);
    var today = new Date();
    if (this.jumpDay)
        today = today.addDays(1);

    //console.log('today: ',today);
    today.setHours(0, 0, 0, 0);

    for (i = 0; i < this.days.length; i++) {
        //flag = d.getMonth() != fd.getMonth();
        flag = false;
        this.days[i].updateDay(flag, d);
        if ((d.getFullYear() == this.selectedDay.getFullYear()) &&
                (d.getMonth() == this.selectedDay.getMonth()) &&
                (d.getDate() == this.selectedDay.getDate())) {
            this.days[i].domNode.setAttribute('aria-selected', 'true');
        }

        if (typeof date_picker_only_past_dates != 'undefined' && date_picker_only_past_dates) {
            if (today <= d)
                this.days[i].domNode.setAttribute('disabled', 'true');
            else
                this.days[i].domNode.removeAttribute('disabled');
        } else if (typeof date_picker_only_future_dates != 'undefined' && date_picker_only_future_dates) {
            if (today > d) {
                //console.log(today + '>' + d);
                this.days[i].domNode.setAttribute('disabled', 'true');
            } else
                this.days[i].domNode.removeAttribute('disabled');
        }

        d.setDate(d.getDate() + 1);
    }

    if ((dayOfWeek + daysInMonth) < 36) {
        this.hideLastRow();
    } else {
        this.showLastRow();
    }

};

DatePicker.prototype.hideLastRow = function () {
    this.lastRowNode.style.visibility = 'hidden';
};

DatePicker.prototype.showLastRow = function () {
    this.lastRowNode.style.visibility = 'visible';
};

DatePicker.prototype.setFocusDay = function (flag) {

    if (typeof flag !== 'boolean') {
        flag = true;
    }

    var fd = this.focusDay;

    if (this.jumpDay)
        fd.addDays(1);

    //console.log('this.focusDay addDays: ', fd);





    function checkDay(d) {
        d.domNode.setAttribute('tabindex', '-1');
        if ((d.day.getDate() == fd.getDate()) && (d.day.getMonth() == fd.getMonth()) && (d.day.getFullYear() == fd.getFullYear())) {
            d.domNode.setAttribute('tabindex', '0');
            if (flag) {
                d.domNode.focus();
            }
        }
    }

    this.days.forEach(checkDay.bind(this));
};

DatePicker.prototype.updateDay = function (day) {
    var d = this.focusDay;
    this.focusDay = day;
    if ((d.getMonth() !== day.getMonth()) ||
            (d.getFullYear() !== day.getFullYear())) {
        this.updateGrid();
        this.setFocusDay();
    }
};

DatePicker.prototype.getDaysInLastMonth = function () {
    var fd = this.focusDay;
    var lastDayOfMonth = new Date(fd.getFullYear(), fd.getMonth(), 0);
    return lastDayOfMonth.getDate();
};

DatePicker.prototype.getDaysInMonth = function () {
    var fd = this.focusDay;
    var lastDayOfMonth = new Date(fd.getFullYear(), fd.getMonth() + 1, 0);
    return lastDayOfMonth.getDate();
};

DatePicker.prototype.show = function () {

    this.dialogNode.style.display = 'block';
    this.dialogNode.style.zIndex = 2;

    this.getDateInput();
    this.updateGrid();
    this.setFocusDay();

};

DatePicker.prototype.isOpen = function () {
    return window.getComputedStyle(this.dialogNode).display !== 'none';
};

DatePicker.prototype.hide = function () {
    this.log('hide')

    this.setMessage('');

    this.dialogNode.style.display = 'none';

    this.hasFocusFlag = false;
    this.dateInput.setFocus();
};

DatePicker.prototype.handleBackgroundMouseDown = function (event) {
    this.log('handleBackgroundMouseDown', this.buttonNode, this.dialogNode, event.target, !this.dialogNode.contains(event.target));
    if (!this.dialogNode.contains(event.target)) {

        this.isMouseDownOnBackground = true;

        if (this.isOpen()) {
            this.hide();
            event.stopPropagation();
            event.preventDefault();
        }
    }
};

DatePicker.prototype.handleBackgroundMouseUp = function () {
    this.log('handleBackgroundMouseUp');
    this.isMouseDownOnBackground = false;
};

DatePicker.prototype.handleOkButton = function (event) {
    this.log('handleOkButton');
    var flag = false;

    switch (event.type) {
        case 'keydown':

            switch (event.keyCode) {
                case this.keyCode.ENTER:
                case this.keyCode.SPACE:

                    this.setTextboxDate();

                    this.hide();
                    flag = true;
                    break;

                case this.keyCode.TAB:
                    if (!event.shiftKey) {
                        this.prevMonthNode.focus();
                        flag = true;
                    }
                    break;

                case this.keyCode.ESC:
                    this.hide();
                    flag = true;
                    break;

                default:
                    break;

            }
            break;

        case 'click':
            this.setTextboxDate();
            this.hide();
            flag = true;
            break;

        default:
            break;
    }

    if (flag) {
        event.stopPropagation();
        event.preventDefault();
    }
};

DatePicker.prototype.handleCancelButton = function (event) {
    this.log('handleCancelButton');
    var flag = false;

    switch (event.type) {
        case 'keydown':

            switch (event.keyCode) {
                case this.keyCode.ENTER:
                case this.keyCode.SPACE:
                    this.hide();
                    flag = true;
                    break;

                case this.keyCode.ESC:
                    this.hide();
                    flag = true;
                    break;

                default:
                    break;

            }
            break;

        case 'click':
            this.hide();
            flag = true;
            break;

        default:
            break;
    }

    if (flag) {
        event.stopPropagation();
        event.preventDefault();
    }
};

DatePicker.prototype.handleNextYearButton = function (event) {
    this.log('handleNextYearButton');
    var flag = false;

    switch (event.type) {

        case 'keydown':

            switch (event.keyCode) {
                case this.keyCode.ESC:
                    this.hide();
                    flag = true;
                    break;

                case this.keyCode.ENTER:
                case this.keyCode.SPACE:
                    this.moveToNextYear();
                    this.setFocusDay(false);
                    flag = true;
                    break;
            }

            break;

        case 'click':
            this.moveToNextYear();
            this.setFocusDay(false);
            break;

        default:
            break;
    }

    if (flag) {
        event.stopPropagation();
        event.preventDefault();
    }
};

DatePicker.prototype.handlePreviousYearButton = function (event) {
    this.log('handlePreviousYearButton');
    var flag = false;

    switch (event.type) {

        case 'keydown':

            switch (event.keyCode) {

                case this.keyCode.ENTER:
                case this.keyCode.SPACE:
                    this.moveToPreviousYear();
                    this.setFocusDay(false);
                    flag = true;
                    break;

                case this.keyCode.TAB:
                    if (event.shiftKey) {
                        this.okButtonNode.focus();
                        flag = true;
                    }
                    break;

                case this.keyCode.ESC:
                    this.hide();
                    flag = true;
                    break;

                default:
                    break;
            }

            break;

        case 'click':
            this.moveToPreviousYear();
            this.setFocusDay(false);
            break;

        default:
            break;
    }

    if (flag) {
        event.stopPropagation();
        event.preventDefault();
    }
};

DatePicker.prototype.handleNextMonthButton = function (event) {
    this.log('handleNextMonthButton');
    var flag = false;

    switch (event.type) {

        case 'keydown':

            switch (event.keyCode) {
                case this.keyCode.ESC:
                    this.hide();
                    flag = true;
                    break;

                case this.keyCode.ENTER:
                case this.keyCode.SPACE:
                    this.moveToNextMonth();
                    this.setFocusDay(false);
                    flag = true;
                    break;
            }

            break;

        case 'click':
            this.moveToNextMonth();
            this.setFocusDay(false);
            break;

        default:
            break;
    }

    if (flag) {
        event.stopPropagation();
        event.preventDefault();
    }
};

DatePicker.prototype.handlePreviousMonthButton = function (event) {
    this.log('handlePreviousMonthButton');
    var flag = false;

    switch (event.type) {

        case 'keydown':

            switch (event.keyCode) {
                case this.keyCode.ESC:
                    this.hide();
                    flag = true;
                    break;

                case this.keyCode.ENTER:
                case this.keyCode.SPACE:
                    this.moveToPreviousMonth();
                    this.setFocusDay(false);
                    flag = true;
                    break;
            }

            break;

        case 'click':
            this.moveToPreviousMonth();
            this.setFocusDay(false);
            flag = true;
            break;

        default:
            break;
    }

    if (flag) {
        event.stopPropagation();
        event.preventDefault();
    }
};

DatePicker.prototype.moveToNextYear = function () {
    this.log('moveToNextYear');
    this.focusDay.setFullYear(this.focusDay.getFullYear() + 1);
    this.updateGrid();
};

DatePicker.prototype.moveToPreviousYear = function () {
    this.log('moveToPreviousYear');
    this.focusDay.setFullYear(this.focusDay.getFullYear() - 1);
    this.updateGrid();
};

DatePicker.prototype.moveToNextMonth = function () {
    this.log('moveToPreviousYear');
    this.focusDay.setMonth(this.focusDay.getMonth() + 1);
    this.updateGrid();
};

DatePicker.prototype.moveToPreviousMonth = function () {
    this.focusDay.setMonth(this.focusDay.getMonth() - 1);
    this.updateGrid();
};

DatePicker.prototype.moveFocusToDay = function (day) {
    var d = this.focusDay;

    this.focusDay = day;

    if ((d.getMonth() != this.focusDay.getMonth()) ||
            (d.getYear() != this.focusDay.getYear())) {
        this.updateGrid();
    }
    this.setFocusDay();
};

DatePicker.prototype.moveFocusToNextDay = function () {
    var d = new Date(this.focusDay);
    d.setDate(d.getDate() + 1);
    this.moveFocusToDay(d);
};

DatePicker.prototype.moveFocusToNextWeek = function () {
    var d = new Date(this.focusDay);
    d.setDate(d.getDate() + 7);
    this.moveFocusToDay(d);
};

DatePicker.prototype.moveFocusToPreviousDay = function () {
    var d = new Date(this.focusDay);
    d.setDate(d.getDate() - 1);
    this.moveFocusToDay(d);
};

DatePicker.prototype.moveFocusToPreviousWeek = function () {
    var d = new Date(this.focusDay);
    d.setDate(d.getDate() - 7);
    this.moveFocusToDay(d);
};

DatePicker.prototype.moveFocusToFirstDayOfWeek = function () {
    var d = new Date(this.focusDay);
    d.setDate(d.getDate() - d.getDay());
    this.moveFocusToDay(d);
};

DatePicker.prototype.moveFocusToLastDayOfWeek = function () {
    var d = new Date(this.focusDay);
    d.setDate(d.getDate() + (6 - d.getDay()));
    this.moveFocusToDay(d);
};

DatePicker.prototype.setTextboxDate = function (day) {
    if (day) {
        this.dateInput.setDate(day);
    } else {
        this.dateInput.setDate(this.focusDay);
    }
    this.inputNode.focus()
};

DatePicker.prototype.getDateInput = function () {

    var parts = this.dateInput.getDate().split('/');

    if ((parts.length === 3) &&
            Number.isInteger(parseInt(parts[0])) &&
            Number.isInteger(parseInt(parts[1])) &&
            Number.isInteger(parseInt(parts[2]))) {
        this.focusDay = new Date(parseInt(parts[2]), parseInt(parts[0]) - 1, parseInt(parts[1]));
        this.selectedDay = new Date(this.focusDay);
    } else {
        // If not a valid date (MM/DD/YY) initialize with todays date
        this.focusDay = new Date();
        this.selectedDay = new Date(0, 0, 1);
    }

};

DatePicker.prototype.getDateForButtonLabel = function (year, month, day) {
    if (typeof year !== 'number' || typeof month !== 'number' || typeof day !== 'number') {
        this.selectedDay = this.focusDay;
    } else {
        this.selectedDay = new Date(year, month, day);
    }

    var label = this.dayLabels[this.selectedDay.getDay()];
    label += ' ' + this.monthLabels[this.selectedDay.getMonth()];
    label += ' ' + (this.selectedDay.getDate());
    label += ', ' + this.selectedDay.getFullYear();
    return label;
};

DatePicker.prototype.setMessage = function (str) {

    function setMessageDelayed() {
        this.messageNode.textContent = str;
    }

    if (str !== this.lastMessage) {
        setTimeout(setMessageDelayed.bind(this), 200);
        this.lastMessage = str;
    }
};




/*
 *   This content is licensed according to the W3C Software License at
 *   https://www.w3.org/Consortium/Legal/2015/copyright-software-and-document
 *
 *   File:   datepickerDay.js
 */

var DatePickerDay = function (domNode, datepicker, index, row, column) {

    this.index = index;
    this.row = row;
    this.column = column;

    this.day = new Date();

    this.domNode = domNode;
    this.datepicker = datepicker;

    this.keyCode = Object.freeze({
        'TAB': 9,
        'ENTER': 13,
        'ESC': 27,
        'SPACE': 32,
        'PAGEUP': 33,
        'PAGEDOWN': 34,
        'END': 35,
        'HOME': 36,
        'LEFT': 37,
        'UP': 38,
        'RIGHT': 39,
        'DOWN': 40
    });
};
DatePickerDay.prototype.log = function (value) {
    //return false;
    console.log(value)

}

DatePickerDay.prototype.init = function () {
    this.log('DatePickerDay.prototype.init');
    this.domNode.setAttribute('tabindex', '-1');
    this.domNode.addEventListener('mousedown', this.handleMouseDown.bind(this));
    this.domNode.addEventListener('keydown', this.handleKeyDown.bind(this));
    this.domNode.addEventListener('focus', this.handleFocus.bind(this));

    this.domNode.innerHTML = '-1';

};

DatePickerDay.prototype.isDisabled = function () {
    return this.domNode.classList.contains('disabled');
};

DatePickerDay.prototype.updateDay = function (disable, day) {

    if (disable) {
        this.domNode.classList.add('disabled');
    } else {
        this.domNode.classList.remove('disabled');
    }

    this.day = new Date(day);

    this.domNode.innerHTML = this.day.getDate();
    this.domNode.setAttribute('tabindex', '-1');
    this.domNode.removeAttribute('aria-selected');

    var d = this.day.getDate().toString();
    if (this.day.getDate() < 9) {
        d = '0' + d;
    }

    var m = this.day.getMonth() + 1;
    if (this.day.getMonth() < 9) {
        m = '0' + m;
    }

    this.domNode.setAttribute('data-date', this.day.getFullYear() + '-' + m + '-' + d);

};

DatePickerDay.prototype.handleKeyDown = function (event) {
    this.log('DatePickerDay handleKeyDown');
    var flag = false;

    switch (event.keyCode) {

        case this.keyCode.ESC:
            this.datepicker.hide();
            break;

        case this.keyCode.TAB:
            this.datepicker.cancelButtonNode.focus();
            //console.log(event.shiftKey);
            if (event.shiftKey) {
                this.datepicker.nextMonthNode.focus();
            }
            this.datepicker.setMessage('');
            flag = true;
            break;

        case this.keyCode.ENTER:
        case this.keyCode.SPACE:
            this.datepicker.setTextboxDate(this.day);
            this.datepicker.hide();
            flag = true;
            break;

        case this.keyCode.RIGHT:
            this.datepicker.moveFocusToNextDay();
            flag = true;
            break;

        case this.keyCode.LEFT:
            this.datepicker.moveFocusToPreviousDay();
            flag = true;
            break;

        case this.keyCode.DOWN:
            this.datepicker.moveFocusToNextWeek();
            flag = true;
            break;

        case this.keyCode.UP:
            this.datepicker.moveFocusToPreviousWeek();
            flag = true;
            break;

        case this.keyCode.PAGEUP:
            if (event.shiftKey) {
                this.datepicker.moveToPreviousYear();
            } else {
                this.datepicker.moveToPreviousMonth();
            }
            flag = true;
            break;

        case this.keyCode.PAGEDOWN:
            if (event.shiftKey) {
                this.datepicker.moveToNextYear();
            } else {
                this.datepicker.moveToNextMonth();
            }
            flag = true;
            break;

        case this.keyCode.HOME:
            this.datepicker.moveFocusToFirstDayOfWeek();
            flag = true;
            break;

        case this.keyCode.END:
            this.datepicker.moveFocusToLastDayOfWeek();
            flag = true;
            break;
    }

    if (flag) {
        event.stopPropagation();
        event.preventDefault();
    }

};

DatePickerDay.prototype.handleMouseDown = function (event) {
    this.log('handleMouseDown');

    if (this.isDisabled()) {
        this.datepicker.moveFocusToDay(this.date);
    } else {
        this.datepicker.setTextboxDate(this.day);
        this.datepicker.hide();
    }

    event.stopPropagation();
    event.preventDefault();

};

DatePickerDay.prototype.handleFocus = function () {
    this.log('handleFocus');
    this.datepicker.setMessage(this.datepicker.messageCursorKeys);
};


