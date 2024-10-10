<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div id="myDatepicker" class="datepicker-wai">
    <div class="date">

        <input type="text"
               name="<?php echo $input_name ? $input_name : 'startDate'; ?>"
               placeholder="mm/dd/yyyy"
               id="<?php echo $input_id ? $input_id : 'id-textbox-1'; ?>"
               class="<?php echo isset($date_classes)?$date_classes:''; ?>"
               
               data-el="tableFinderDate"
               aria-autocomplete="none"
               data-currenttime="<?php echo current_time('Hi'); ?>"
               >

    </div>
    <div id="id-datepicker-1"
         class="datepickerDialog"
         role="dialog"
         aria-modal="true"
         aria-labelledby="id-dialog-label">
        <div class="header">
            <!--            <button class="prevYear" aria-label="previous year" type="button" >
                            <span class="fas fa-angle-double-left fa-lg"><<</span>
                        </button>-->
            <button class="prevMonth" aria-label="previous month" type="button" tabindex="0">
                <span class="fas fa-angle-left fa-lg"><</span>
            </button>
            <h2 id="id-dialog-label"
                class="monthYear"
                aria-live="polite">
                Month Year
            </h2>
            <button class="nextMonth" aria-label="next month" type="button" tabindex="0">
                <span class="fas fa-angle-right fa-lg">></span>
            </button>
            <!--            <button class="nextYear" aria-label="next year" type="button" >
                            <span class="fas fa-angle-double-right fa-lg">>></span>
                        </button>-->
        </div>
        <table id="myDatepickerGrid"
               class="dates"
               role="grid"
               aria-labelledby="id-dialog-label">
            <thead>
                <tr>
                    <th scope="col" abbr="Sunday">
                        Su
                    </th>
                    <th scope="col" abbr="Monday">
                        Mo
                    </th>
                    <th scope="col" abbr="Tuesday">
                        Tu
                    </th>
                    <th scope="col" abbr="Wednesday">
                        We
                    </th>
                    <th scope="col" abbr="Thursday">
                        Th
                    </th>
                    <th scope="col" abbr="Friday">
                        Fr
                    </th>
                    <th scope="col" abbr="Saturday">
                        Sa
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="dateCell">
                        <button class="dateButton"
                                tabindex="-1"
                                disabled="">
                            25
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton"
                                tabindex="-1"
                                disabled="">
                            26
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton"
                                tabindex="-1"
                                disabled="">
                            27
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton"
                                tabindex="-1"
                                disabled="">
                            28
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton"
                                tabindex="-1"
                                disabled="">
                            29
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton"
                                tabindex="-1"
                                disabled="">
                            30
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton" tabindex="-1">
                            1
                        </button>
                    </td>
                </tr>
                <tr>
                    <td class="dateCell">
                        <button class="dateButton" tabindex="-1">
                            2
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton" tabindex="-1">
                            3
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton" tabindex="-1">
                            4
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton" tabindex="-1">
                            5
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton" tabindex="-1">
                            6
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton" tabindex="-1">
                            7
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton" tabindex="-1">
                            8
                        </button>
                    </td>
                </tr>
                <tr>
                    <td class="dateCell">
                        <button class="dateButton" tabindex="-1">
                            9
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton" tabindex="-1">
                            10
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton" tabindex="-1">
                            11
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton" tabindex="-1">
                            12
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton" tabindex="-1">
                            13
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton" tabindex="0">
                            14
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton" tabindex="-1">
                            15
                        </button>
                    </td>
                </tr>
                <tr>
                    <td class="dateCell">
                        <button class="dateButton" tabindex="-1">
                            16
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton" tabindex="-1">
                            17
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton" tabindex="-1">
                            18
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton" tabindex="-1">
                            19
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton" tabindex="-1">
                            20
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton" tabindex="-1">
                            21
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton" tabindex="-1">
                            22
                        </button>
                    </td>
                </tr>
                <tr>
                    <td class="dateCell">
                        <button class="dateButton" tabindex="-1">
                            23
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton" tabindex="-1">
                            24
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton" tabindex="-1">
                            25
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton" tabindex="-1">
                            26
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton" tabindex="-1">
                            27
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton" tabindex="-1">
                            28
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton" tabindex="-1">
                            29
                        </button>
                    </td>
                </tr>
                <tr>
                    <td class="dateCell">
                        <button class="dateButton" tabindex="-1">
                            30
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton" tabindex="-1">
                            31
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton"
                                tabindex="-1"
                                disabled="">
                            1
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton"
                                tabindex="-1"
                                disabled="">
                            2
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton"
                                tabindex="-1"
                                disabled="">
                            3
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton"
                                tabindex="-1"
                                disabled="">
                            4
                        </button>
                    </td>
                    <td class="dateCell">
                        <button class="dateButton"
                                tabindex="-1"
                                disabled="">
                            5
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="dialogButtonGroup">
            <button class="dialogButton" value="cancel">
                Cancel
            </button>
            <button class="dialogButton" value="ok">
                OK
            </button>
        </div>
        <div class="message" aria-live="polite">
            Test
        </div>
    </div>
</div>


