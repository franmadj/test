<?php

foreach (range(11, 12) as $i):?>
        <option 
            value="<?php echo $i;?>:00 <?php if ($i == 12) echo 'PM';else echo 'AM';?>" 
            data-hour="<?php echo $i;?>00" 
            class="table-finder__option">
                <?php echo $i;?>:00<?php if ($i == 12) echo 'PM';else echo 'AM';?>
        </option>
	<option 
            value="<?php echo $i;?>:30 <?php if ($i == 12) echo 'PM';else echo 'AM';?>" 
            data-hour="<?php echo $i;?>00" 
            class="table-finder__option">
                <?php echo $i;?>:30<?php if ($i == 12) echo 'PM';else echo 'AM';?>
        </option>
<?php endforeach;?>
        
        
<?php foreach (range(1, 10) as $i):?>
	<option 
            value="<?php echo $i;?>:00 PM" 
            data-hour="<?php echo $i+12;?>00" 
            class="table-finder__option"><?php echo $i;?>:00 PM
        </option>
        <?php if($i<10){ ?>
	<option 
            value="<?php echo $i;?>:30 PM" 
            data-hour="<?php echo $i+12;?>30" 
            class="table-finder__option">
                <?php echo $i;?>:30 PM
        </option>
        <?php } ?>
<?php endforeach;?>