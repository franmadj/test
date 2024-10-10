<?php
$themes = get_field('themes');
$i = 1;
foreach ($themes as $theme):
$image = wp_get_attachment_image_src( get_post_thumbnail_id($theme), 'full' );
?>

<span class="c-option__thumb<?php if($i==1):?> c-option__thumb--selected<?php endif ?>" style="background-image: url('<?php echo $image[0];?>');"
data-image="<?php echo $image[0];?>'" data-ref="theme" data-id="<?php echo $theme;?>"
></span>
<?php $i++;endforeach;?>                      
