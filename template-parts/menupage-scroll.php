<div class="menu-listing ">
    <div class="menu-categories__inner">
        <ul class="menu-categories__listing">


            <?php
            if (have_rows('menu_content_block')):
                // loop through the rows of data
                while (have_rows('menu_content_block')) : the_row();
                    ?>
                    <li><a href="#<?php the_sub_field('scroll_section_id'); ?>" class="menu-categories__button">
                            <span class="menu-categories__button-label"><?php the_sub_field('menu_heading'); ?></span>
                        </a></li>
                <?php endwhile; ?>
            <?php endif; ?>
        </ul>
    </div>
</div>
<style>
    ul.menu-categories__listing{
        justify-content: center;
        margin: auto;
        display: flex;
        flex-wrap: wrap;
    }
    ul.menu-categories__listing li{
        list-style: none;
    }
</style>