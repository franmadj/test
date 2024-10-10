<?php
$action = 'https://www.opentable.com/restref/client/';
$dateFormat = 'MM/dd/yyyy';
?>
<form method="GET" action="<?php echo $action; ?>" class="table-finder" data-ref="tableForm" id="reserveTable">
    <input type="hidden" name="restref" id="restref" value="">
    <input type="hidden" name="rid" id="rid" value="">
    <input type="hidden" name="covers" id="covers" value="2">
    <input type="hidden" name="datetime" id="datetime" value="">
    <input type="hidden" name="searchdatetime" id="searchdatetime" value="">
    
    
    
    
    
    <div class="table-finder__field -location">
        <label for="resturant-select" class="table-finder__label" aria-label="Choose location">Choose location</label>
        <div class="table-finder__dropdown table-finder__dropdown-main-book" >
            <select id="resturant-select" aria-label="Choose location" data-label="Choose location" 
                    label="Choose location" class="table-finder__select" data-ref="selectedLocationPopup"  
                    data-ignore="1"  
                    required>
                <!--<option value="" disabled selected>Select a Location</option>-->
            </select>
        </div>
    </div>
    
    

    <div class="table-finder__field -date">
        <label for="id-textbox-1" aria-label="Pick a date" class="table-finder__label pick-a-date">Pick a date</label>
        <div class="table-finder__dropdownn" style="position: relative;">
            <?php if (isMobileDevice()) { ?> 
                <input id="select-date" class="date-input" type="date" value="<?php echo current_time('Y-m-d'); ?>" min="<?php echo current_time('Y-m-d'); ?>" max="2030-12-31" />
            <?php } else { ?>
                <script>
                    var date_picker_only_future_dates = true;
                    //var format_date = 'Y/m/d';

                </script>                                   <!--                <input type="text" name="startDate" class="datepicker tableFinderDate find-date-selector" data-el="tableFinderDate" placeholder="Pick a Date" value="" aria-label="Date" readonly>-->
                <?php
                //$input_name = 'startDate';
                $date_classes = 'date-input';
                $input_id = 'id-textbox-1';
                require_once('datepicker.php');
                ?>
                <script src="<?php echo get_template_directory_uri() . '/assets/js/datePickerAda.js?a=2' ?>"></script>
                <link href="<?php echo get_template_directory_uri() . '/assets/css/datePickerAda.css?v=3' ?>" rel="stylesheet">
            <?php } ?>
        </div>
    </div>
    
    
    

    <div class="table-finder__field -time">
        <label for="resTime" aria-label="Pick a Time" class="table-finder__label">Pick a time <?php //var_dump(current_time('h:i'));               ?></label>
        <div class="table-finder__dropdown time-picker-dropdown">
            <select id="resTime" data-currenttime="<?php echo current_time('Hi'); ?>" label="Pick a time" class="table-finder__select tableFinderTime" data-el="tableFinderTime" 
                    data-label="Pick a time" 
                    <?php if (isMobileDevice()) { ?> 
                        data-ignore="1" <?php }
                    ?>>

                <?php get_template_part('template-parts/time', 'option'); ?>
            </select>
        </div>
    </div>
    
    
    

    <div class="table-finder__field -guests">
        <label for="partysize" aria-label="Guests" class="table-finder__label">Guests</label>
        <div class="table-finder__dropdown">
            <select name="partysize" id="partysize" label="Guests" <?php if (isMobileDevice()) { ?> data-ignore="1" <?php } ?> 
                    class="table-finder__select">
                <?php if (isMobileDevice()) { ?> <option value="" class="table-finder__option">Number of Guests</option> <?php } ?>
                <?php foreach (range(1, 14) as $i): ?>
                    <option <?php if ($i == 2) { ?> selected="" <?php } ?> class="table-finder__option"><?php echo $i; ?></option>
                <?php endforeach; ?>
                <option value="15+" class="table-finder__option">15+</option>
            </select>
        </div>
    </div>
    
    
    

    <button class="table-finder__submit open-table custom-border-bottom" <?php if (!isMobileDevice()) { ?> type="button" <?php } else { ?> type="button" <?php } ?>  role="button">
        Find a table
    </button>

    <a href="#"  onclick="window.open('https://order.texasdebrazil.com', '_blank');return false;" class="table-finder__submit table-finder__link custom-border-bottom">
        Order Pickup / Delivery

    </a>
</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script>
                    jQuery(document).ready(function ($) {
                        setTimeout(function () {
                            $('#resturant-select').parent().parent().attr('aria-label', 'Choose Location')

                        }, 2000)



<?php if (isMobileDevice()) { ?>
                            $('.open-table_').click(function (e) {
                                e.preventDefault()

                                window.open('<?php echo $action; ?>?' + $('#reserveTable').serialize(), '_blank');
                                return false;
                            });


                            $('.trigger-date').click(function () {
                                console.log($('#select-date'));
                                $('#select-date').trigger('click');
                                $('.pick-a-date').css('margin-bottom', 0);
                                console.log(document.getElementById('select-date'));
                                document.getElementById('select-date').click();

                                var cal = document.getElementById('select-date');
                                cal.focus();
                                openPicker(cal);


                            });
                            $('#select-date_').click(function () {
                                $('.pick-a-date').css('margin-bottom', 0);
                            });
                            $('#select-date_').change(function () {
                                let date_parts = $(this).val().split('-');
                                var $date = new Date(Date.UTC(date_parts[0], date_parts[1], date_parts[2], 8, 0, 0))
                                let month = $date.getMonth();
                                let day = $date.getDate();
                                var format_date = $date.getFullYear() + '-' + (month < 10 ? '0' + month : month) + '-' + (day < 10 ? '0' + day : day);
                                $('#startDate').val(format_date);
                                $('.trigger-date').text(format_date);
                                //$('#select-date').val(format_date);

                            });

                            function openPicker(inputDateElem) {
                                var ev = document.createEvent('KeyboardEvent');
                                ev.initKeyboardEvent('keydown', true, true, document.defaultView, 'F4', 0);
                                inputDateElem.dispatchEvent(ev);
                            }
<?php } ?>

                        $('.table-finder__submit').click(function () {
<?php if (isMobileDevice()) { ?>
                                let date_parts = $('.date-input').val().split('-');
                                const year = date_parts[0];
                                let month = date_parts[1];
                                let day = date_parts[2];
<?php } else { ?>
                                let date_parts = $('.date-input').val().split('/');
                                const year = date_parts[2];
                                let month = date_parts[0];
                                let day = date_parts[1];
<?php } ?>

                            var pm = $('#resTime').val().includes('PM');
                            var rest_time = $('#resTime').val().replace(/AM|PM/g, "").trim()
                            var parts = rest_time.split(':');

                            console.log('parts', parts);

                            if (pm) {
                                var pms = {'1': '13', '2': '14', '3': '15', '4': '16', '5': '17', '6': '18', '7': '19', '8': '20', '9': '21', '10': '22', '11': '23', '12': '12'};
                                rest_time = pms[parts[0]] + ':' + parts[1];
                            } else if (parts[0].length < 2) {
                                rest_time = '0' + parts[0] + ':' + parts[1];
                            }



                            if (month.length < 2) {
                                month = '0' + month;
                            }
                            if (day.length < 2) {
                                day = '0' + day;
                            }

                            var format_date = year + '-' + month + '-' + day + 'T' + rest_time;



                            $('#datetime, #searchdatetime').val(format_date);

                            $('#covers').val($('#partysize').val())

                            const location_parts=$('#resturant-select').val().split('-');
                          
                            const locationId= (typeof location_parts[1]!='undefined')?location_parts[1]:location_parts[0];
                            console.log(locationId);

                                            $('#restref, #rid').val(locationId)
                            $('.table-finder').submit();

                        })








                    });
</script>
<style>
    body.mobile-view .table-finder__dropdown{
        position: relative;

    }

    body.mobile-view .table-finder__dropdown:before {
        background-image: url(https://texasdebrazil.com/assets/img/dropdown.svg);
        background-repeat: no-repeat;
        content: "";
        height: 1.4rem;
        position: absolute;
        right: 1.2rem;
        top: 50%;
        transform: translateY(-60%);
        width: 0.9rem;
    }
    #resturant-select{
        text-transform: capitalize !important;
    }
    .table-finder select {
        font-size: 16px;
        font-weight: 600;
    }
</style>
