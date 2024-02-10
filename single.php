<?php get_header(); ?>
<div class="page-format">
   <h1><?php  the_title();  ?> </h1> 
   <p><?php  the_content();  ?> </p> 
<?php
if (function_exists('do_shortcode')) {
    // Call the shortcode and echo its output
    echo do_shortcode('[simple-calculator]');
}
?>
</div>
<?php get_footer(); ?>