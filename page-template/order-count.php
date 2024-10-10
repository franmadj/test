<?php
/*
  Template Name:Order Count
 */
get_header();
while (have_posts()) :the_post();
//$test=['2019-December'=>2000,'2020-January'=>1500,'2020-February'=>2000];
//update_option('tx_count_orders', []);

    $data = get_option('tx_count_orders', []);
    ?>
    <div class="">
        <div class="o-grid">
            <div class="o-col">
                <h1><?php the_title(); ?></h1>
                <table id="orders-count">
                    <tr> 
                        <?php
                        foreach ($data as $key => $val) {
                            echo '<th>' . end(explode('-', $key)) . '</th> ';
                        }
                        ?>
                    </tr>
                    <tr> 
                        <?php
                        foreach ($data as $key => $val) {
                            echo '<th>' . $val . '</th> ';
                        }
                        ?>
                    </tr>





                </table>
            </div>
        </div>
    </div>
<?php endwhile; ?>

<?php get_footer(); ?>
<script type="text/javascript">
    jQuery('.u-contact-submit').click(function () {

    })
</script>
<style>
    #orders-count{
        margin: 50px auto;
        max-width: 100%;
        overflow-x: auto;
    }
    #orders-count th, #orders-count td{
        padding: 5px 10px;
    }
    
    
    
</style>

