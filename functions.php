<?php
function esigned_files(){
wp_enqueue_style('css_linking', get_stylesheet_uri());
wp_enqueue_style('link css 1', get_theme_file_uri('./css/style.css'));
wp_enqueue_style('link css 2', get_theme_file_uri('./css/bootstrap.css'));
wp_enqueue_style('link css 3', get_theme_file_uri('./css/style.scss'));
wp_enqueue_style('link css 4', get_theme_file_uri('./css/responsive.css'));
wp_enqueue_style('link css 5', get_theme_file_uri('./css/style.css.map'));
wp_enqueue_script('link-js-file1', get_theme_file_uri('/js/bootstrap.js')); 
wp_enqueue_script('link-js-file2', get_theme_file_uri('/js/jquery-3.4.1.min.js'));
wp_enqueue_script('link-js-file3', get_theme_file_uri('/js/custom-scripts.js'));
}

add_action('wp_enqueue_scripts', 'esigned_files');



function register_my_menus() {
    register_nav_menus(
      array(
        'header-menu' => __( 'Header Menu' ),
        'footer-menu' => __( 'Footer Menu' )
      )
    );
  }
  add_action( 'init', 'register_my_menus' );


function custom_theme_setup() {
    add_theme_support('custom-logo', array(
        'height'      => 150, // Set the height of the logo in pixels
        'width'       => 250, // Set the width of the logo in pixels
        'flex-height' => true,
        'flex-width'  => true,
        'header-text'          => array( 'site-title', 'site-description' ),
        'unlink-homepage-logo' => true,
    ));
}

add_action('after_setup_theme', 'custom_theme_setup');

function custom_slider_post_type() { //will be responsible for registering the custom post type.
  $labels = array(                       //defines the labels used for the custom post type in the WordPress admin interface.
      'name'               => 'Slider Items',
      'singular_name'      => 'Slider Item',
      'menu_name'          => 'Slider Items',
      'add_new'            => 'Add New',
      'add_new_item'       => 'Add New Slider Item',
      'edit_item'          => 'Edit Slider Item',
      'new_item'           => 'New Slider Item',
      'view_item'          => 'View Slider Item',
      'search_items'       => 'Search Slider Items',
      'not_found'          => 'No Slider Items found',
      'not_found_in_trash' => 'No Slider Items found in Trash',
  );

  $args = array(
      'labels'              => $labels,
      'public'              => true,
      'has_archive'         => false,
      'menu_icon'           => 'dashicons-images-alt2', 
      'supports'            => array('title', 'editor', 'thumbnail','excerpt', 'author', 'post-formats', 'page-attributes'),
      'rewrite'             => array('slug' => 'slider-item'),
      'taxonomies'          => array('category')
  );
  add_theme_support('post-thumbnails');
  register_post_type('slider_item', $args);
}


function load_next_slide() {
    $slides = new WP_Query(array(
        'post_type' => 'slider_item',
        'posts_per_page' => 1,
        'offset' => 1, // Offset by 1 to get the next post
    ));

    while ($slides->have_posts()) {
        $slides->the_post();
        ?>
        <h1><?php the_title(); ?></h1>
        <?php the_post_thumbnail('full');
    }

    wp_reset_postdata();
    die(); // Important: always include die() at the end to terminate the script
}

add_action('init', 'custom_slider_post_type');  //Hooks the custom_slider_post_type function into the init action in WordPress. The init action is fired when WordPress is initializing. This hook is used to register the custom post type during the initialization process.

// Step 1: Register custom fields for the 'slider_item' post type
function register_slider_item_fields() {
  // Add a custom field for subtitle
  add_meta_box('slider_item_subtitle', 'Subtitle', 'render_subtitle_field', 'slider_item', 'normal', 'default');

  // Add custom fields for button settings
  add_meta_box('slider_item_button_settings', 'Button Settings', 'render_button_settings_field', 'slider_item', 'normal', 'default');

  // Add custom fields for slider image settings
  add_meta_box('slider_item_image_settings', 'Image Settings', 'render_image_settings_field', 'slider_item', 'normal', 'default');
}

add_action('add_meta_boxes', 'register_slider_item_fields');

// Step 2: Render the custom fields in the editor
function render_subtitle_field($post) {
  $subtitle = get_post_meta($post->ID, 'subtitle', true);
  ?>
  <label for="subtitle">Subtitle:</label>
  <input type="text" id="subtitle" name="subtitle" value="<?php echo esc_attr($subtitle); ?>" style="width: 100%;">
  <?php
}

function render_button_settings_field($post) {
  $button_text = get_post_meta($post->ID, 'button_text', true);
  $button_position = get_post_meta($post->ID, 'button_position', true);
  $button_font_size = get_post_meta($post->ID, 'button_font_size', true);
  $button_font_style = get_post_meta($post->ID, 'button_font_style', true);
  $button_font_color = get_post_meta($post->ID, 'button_font_color', true);
  ?>
  <label for="button_text">Button Text:</label>
  <input type="text" id="button_text" name="button_text" value="<?php echo esc_attr($button_text); ?>" style="width: 100%;">

  <label for="button_position">Button Position:</label>
  <select id="button_position" name="button_position">
      <option value="left" <?php selected($button_position, 'left'); ?>>Left</option>
      <option value="center" <?php selected($button_position, 'center'); ?>>Center</option>
      <option value="right" <?php selected($button_position, 'right'); ?>>Right</option>
  </select>

  <label for="button_font_size">Button Font Size:</label>
  <input type="text" id="button_font_size" name="button_font_size" value="<?php echo esc_attr($button_font_size); ?>" style="width: 100%;">

  <label for="button_font_style">Button Font Style:</label>
  <input type="text" id="button_font_style" name="button_font_style" value="<?php echo esc_attr($button_font_style); ?>" style="width: 100%;">

  <label for="button_font_color">Button Font Color:</label>
  <input type="text" id="button_font_color" name="button_font_color" value="<?php echo esc_attr($button_font_color); ?>" style="width: 100%;">
  <?php
}

function render_image_settings_field($post) {
  $image_position = get_post_meta($post->ID, 'image_position', true);
  $image_size = get_post_meta($post->ID, 'image_size', true);
  ?>
  <label for="image_position">Image Position:</label>
  <select id="image_position" name="image_position">
      <option value="left" <?php selected($image_position, 'left'); ?>>Left</option>
      <option value="center" <?php selected($image_position, 'center'); ?>>Center</option>
      <option value="right" <?php selected($image_position, 'right'); ?>>Right</option>
  </select>

  <label for="image_size">Image Size:</label>
  <input type="text" id="image_size" name="image_size" value="<?php echo esc_attr($image_size); ?>" style="width: 100%;">
  <?php
}

// Step 3: Save the custom fields when the post is saved
function save_slider_item_fields($post_id) {
  // Save subtitle
  if (isset($_POST['subtitle'])) {
      update_post_meta($post_id, 'subtitle', sanitize_text_field($_POST['subtitle']));
  }

  // Save button settings
  if (isset($_POST['button_text'])) {
      update_post_meta($post_id, 'button_text', sanitize_text_field($_POST['button_text']));
  }
  if (isset($_POST['button_position'])) {
      update_post_meta($post_id, 'button_position', sanitize_text_field($_POST['button_position']));
  }
  if (isset($_POST['button_font_size'])) {
      update_post_meta($post_id, 'button_font_size', sanitize_text_field($_POST['button_font_size']));
  }
  if (isset($_POST['button_font_style'])) {
      update_post_meta($post_id, 'button_font_style', sanitize_text_field($_POST['button_font_style']));
  }
  if (isset($_POST['button_font_color'])) {
      update_post_meta($post_id, 'button_font_color', sanitize_text_field($_POST['button_font_color']));
  }

  // Save slider image settings
  if (isset($_POST['image_position'])) {
      update_post_meta($post_id, 'image_position', sanitize_text_field($_POST['image_position']));
  }
  if (isset($_POST['image_size'])) {
      update_post_meta($post_id, 'image_size', sanitize_text_field($_POST['image_size']));
  }
}

add_action('save_post_slider_item', 'save_slider_item_fields');

  

function add_custom_menu_section() {
  add_menu_page(
      'Theme Customization', // Home Services
      'Theme Customization', // Menu title
      'manage_options', // Capability (who can access)
      'theme-customization', // Menu slug
      'theme_customization_page', // Callback function to display content
      'dashicons-admin-generic', // Icon (optional)
      35 // Menu position (optional)
  );
};

add_action('admin_menu', 'add_custom_menu_section');

function theme_customization_page() {

  // Section-1 (What we do?)
  if (isset($_POST['update_section1'])) {
      // Save and update settings
      update_option('section1_title', sanitize_text_field($_POST['section1_title']));
      update_option('section1_description', sanitize_text_field($_POST['section1_description']));
      update_option('service1_title', sanitize_text_field($_POST['service1_title']));
      update_option('service1_image', esc_url_raw($_POST['service1_image'])); 
      update_option('service2_title', sanitize_text_field($_POST['service2_title']));
      update_option('service2_image', esc_url_raw($_POST['service2_image'])); 
      update_option('service3_title', sanitize_text_field($_POST['service3_title']));
      update_option('service3_image', esc_url_raw($_POST['service3_image'])); 
      update_option('service4_title', sanitize_text_field($_POST['service4_title']));
      update_option('service4_image', esc_url_raw($_POST['service4_image'])); 
      update_option('service5_title', sanitize_text_field($_POST['service5_title']));
      update_option('service5_image', esc_url_raw($_POST['service5_image'])); 
      echo '<div class="updated1"><p>Settings saved.</p></div>';
  }

  echo '<div class="MySection"> ';
  echo '<h1>Section 1</h1>';
  echo '<form method="post" action="">';

  // Display current values
  $section1_title = get_option('section1_title');
  $section1_description = get_option('section1_description');
  $service1_title = get_option('service1_title');
  $service1_image = get_option('service1_image');
  $service2_title = get_option('service2_title');
  $service2_image = get_option('service2_image');
  $service3_title = get_option('service3_title');
  $service3_image = get_option('service3_image');
  $service4_title = get_option('service4_title');
  $service4_image = get_option('service4_image');
  $service5_title = get_option('service5_title');
  $service5_image = get_option('service5_image');

  echo '<label class="custom_label" for="section1_title">Title:</label>';
  echo '<input class="custom_input" type="text" name="section1_title" value="' . esc_attr($section1_title) . '" /> <br>';

  echo '<label class="custom_label">Description:</label>';
  echo '<textarea class="custom_input" name="section1_description" rows="1">' . esc_textarea($section1_description) . '</textarea> <br>';

  echo '<label class="custom_label" for="service1_title">Service-1 Title:</label>';
  echo '<input class="custom_input" type="text" name="service1_title" value="' . esc_attr($service1_title) . '" /> <br>';

  echo '<label class="custom_label" for="service1_image">Service 1 Image:</label>';
  echo '<input type="text" name="service1_image" class="meta-image1 custom_input" value="' . esc_url($service1_image) . '"  />';
  echo '<input type="button" class="button image-upload1" value="Browse Files" /> <br>';

  echo '<label class="custom_label" for="service2_title">Service-2 Title:</label>';
  echo '<input class="custom_input" type="text" name="service2_title" value="' . esc_attr($service2_title) . '" /> <br>';

  echo '<label class="custom_label" for="service2_image">Service 2 Image:</label>';
  echo '<input  type="text" name="service2_image" class="meta-image2 custom_input" value="' . esc_url($service2_image) . '"  />';
  echo '<input type="button" class="button image-upload2" value="Browse Files" /> <br>';

  echo '<label class="custom_label" for="service4_title">Service-3 Title:</label>';
  echo '<input class="custom_input" type="text" name="service3_title" value="' . esc_attr($service3_title) . '" /> <br>';

  echo '<label class="custom_label" for="service3_image">Service 3 Image:</label>';
  echo '<input type="text" name="service3_image" class="meta-image3 custom_input" value="' . esc_url($service3_image) . '"  />';
  echo '<input type="button" class="button image-upload3" value="Browse Files" /> <br>';

  echo '<label class="custom_label" for="service4_title">Service-4 Title:</label>';
  echo '<input class="custom_input" type="text" name="service4_title" value="' . esc_attr($service4_title) . '" /> <br>';

  echo '<label class="custom_label" for="service4_image">Service 4 Image:</label>';
  echo '<input type="text" name="service4_image" class="meta-image4 custom_input" value="' . esc_url($service4_image) . '"  />';
  echo '<input type="button" class="button image-upload4" value="Browse Files" /> <br>';

  echo '<label class="custom_label" for="service5_title">Service-5 Title:</label>';
  echo '<input class="custom_input" type="text" name="service5_title" value="' . esc_attr($service5_title) . '" /> <br>';

  echo '<label class="custom_label" for="service5_image">Service 5 Image:</label>';
  echo '<input type="text" name="service5_image" class="meta-image5 custom_input" value="' . esc_url($service5_image) . '"  />';
  echo '<input type="button" class="button image-upload5" value="Browse Files" /> <br>';

  
  echo '<input type="submit" name="update_section1" class="button-primary custom_label_1" value="Update Settings" />';
  echo '</form>';
  echo '</div>';
  // Section-2 (Who we are)
  if (isset($_POST['update_section2'])) {
    // Save and update settings
    update_option('section2_title', sanitize_text_field($_POST['section2_title']));
    update_option('section2_description', sanitize_text_field($_POST['section2_description']));
    update_option('section2_button', sanitize_text_field($_POST['section2_button']));
    update_option('section2_image', esc_url_raw($_POST['section2_image'])); 
    echo '<div class="updated2"><p>Settings saved.</p></div>';
}

echo '<div class="MySection"> ';
echo '<h1>Section 2</h1>';
echo '<form method="post" action="">';

// Display current values
$section2_title = get_option('section2_title');
$section2_description = get_option('section2_description');
$section2_button = get_option('section2_button');
$section2_image = get_option('section2_image');


echo '<label class="custom_label" for="section2_title">Title:</label>';
echo '<input class="custom_input" type="text" name="section2_title" value="' . esc_attr($section2_title) . '" /> <br>';

echo '<label class="custom_label">Description:</label>';
echo '<textarea class="custom_input" name="section2_description" rows="1">' . esc_textarea($section2_description) . '</textarea> <br>';

echo '<label class="custom_label" for="section2_button">Button Text:</label>';
echo '<input class="custom_input" type="text" name="section2_button" value="' . esc_attr($section2_button) . '" /> <br>';

echo '<label class="custom_label" for="section2_image">Image:</label>';
echo '<input type="text" name="section2_image" class="meta-image6 custom_input" value="' . esc_url($section2_image) . '"  />';
echo '<input type="button" class="button image-upload6" value="Browse Files" /> <br>';



echo '<input type="submit" name="update_section2" class="button-primary custom_label_1" value="Update Settings" />';
echo '</form>';
echo '</div>';

 // Section-3 (Creative Works)
 if (isset($_POST['update_section3'])) {
  // Save and update settings
  update_option('section3_title', sanitize_text_field($_POST['section3_title']));
  update_option('section3_description', sanitize_text_field($_POST['section3_description']));
  update_option('section3_image1', esc_url_raw($_POST['section3_image1'])); 
  update_option('section3_image2', esc_url_raw($_POST['section3_image2'])); 
  update_option('section3_image3', esc_url_raw($_POST['section3_image3'])); 
  update_option('section3_image4', esc_url_raw($_POST['section3_image4'])); 
  echo '<div class="updated3"><p>Settings saved.</p></div>';
}

echo '<div class="MySection"> ';
echo '<h1>Section 3</h1>';
echo '<form method="post" action="">';

// Display current values
$section3_title = get_option('section3_title');
$section3_description = get_option('section3_description');
$section3_image1 = get_option('section3_image1');
$section3_image2 = get_option('section3_image2');
$section3_image3 = get_option('section3_image3');
$section3_image4 = get_option('section3_image4');


echo '<label class="custom_label" for="section3_title">Title:</label>';
echo '<input class="custom_input" type="text" name="section3_title" value="' . esc_attr($section3_title) . '" /> <br>';

echo '<label class="custom_label">Description:</label>';
echo '<textarea class="custom_input" name="section3_description" rows="1">' . esc_textarea($section3_description) . '</textarea> <br>';

echo '<label class="custom_label" for="section3_image1">Image 1:</label>';
echo '<input type="text" name="section3_image1" class="meta-image7 custom_input" value="' . esc_url($section3_image1) . '"  />';
echo '<input type="button" class="button image-upload7" value="Browse Files" /> <br>';

echo '<label class="custom_label" for="section3_image2">Image 2:</label>';
echo '<input type="text" name="section3_image2" class="meta-image8 custom_input" value="' . esc_url($section3_image2) . '"  />';
echo '<input type="button" class="button image-upload8" value="Browse Files" /> <br>';

echo '<label class="custom_label" for="section3_image3">Image 3:</label>';
echo '<input type="text" name="section3_image3" class="meta-image9 custom_input" value="' . esc_url($section3_image3) . '"  />';
echo '<input type="button" class="button image-upload9" value="Browse Files" /> <br>';

echo '<label class="custom_label" for="section3_image4">Image 4:</label>';
echo '<input type="text" name="section3_image4" class="meta-image10 custom_input" value="' . esc_url($section3_image4) . '"  />';
echo '<input type="button" class="button image-upload10" value="Browse Files" /> <br>';



echo '<input type="submit" name="update_section3" class="button-primary custom_label_1" value="Update Settings" />';
echo '</form>';
echo '</div>';

// Section-4 (What customers say about us)
if (isset($_POST['update_section4'])) {
  // Save and update settings
  update_option('section4_title', sanitize_text_field($_POST['section4_title']));
  update_option('section4_image1', esc_url_raw($_POST['section4_image1']));
  update_option('section4_name1', sanitize_text_field($_POST['section4_name1']));
  update_option('section4_job1', sanitize_text_field($_POST['section4_job1']));
  update_option('section4_review1', sanitize_text_field($_POST['section4_review1']));
  update_option('section4_image2', esc_url_raw($_POST['section4_image2']));
  update_option('section4_name2', sanitize_text_field($_POST['section4_name2']));
  update_option('section4_job2', sanitize_text_field($_POST['section4_job2']));
  update_option('section4_review2', sanitize_text_field($_POST['section4_review2']));
  update_option('section4_image3', esc_url_raw($_POST['section4_image3']));
  update_option('section4_name3', sanitize_text_field($_POST['section4_name3']));
  update_option('section4_job3', sanitize_text_field($_POST['section4_job3']));
  update_option('section4_review3', sanitize_text_field($_POST['section4_review3']));
  echo '<div class="updated4"><p>Settings saved.</p></div>';
}

echo '<div class="MySection"> ';
echo '<h1>Section 4</h1>';
echo '<form method="post" action="">';

// Display current values
$section4_title = get_option('section4_title');
$section4_image1 = get_option('section4_image1');
$section4_name1 = get_option('section4_name1');
$section4_job1 = get_option('section4_job1');
$section4_review1 = get_option('section4_review1');
$section4_image2 = get_option('section4_image2');
$section4_name2 = get_option('section4_name2');
$section4_job2 = get_option('section4_job2');
$section4_review2 = get_option('section4_review2');
$section4_image3 = get_option('section4_image3');
$section4_name3 = get_option('section4_name3');
$section4_job3 = get_option('section4_job3');
$section4_review3 = get_option('section4_review3');


echo '<label class="custom_label" for="section4_title">Title:</label>';
echo '<input class="custom_input" type="text" name="section4_title" value="' . esc_attr($section4_title) . '" /> <br>';

echo '<label class="custom_label" for="section4_image1">Image 1:</label>';
echo '<input type="text" name="section4_image1" class="meta-image11 custom_input" value="' . esc_url($section4_image1) . '"  />';
echo '<input type="button" class="button image-upload11" value="Browse Files" /> <br>';

echo '<label class="custom_label" for="section4_name1">Name:</label>';
echo '<input class="custom_input" type="text" name="section4_name1" value="' . esc_attr($section4_name1) . '" /> <br>';

echo '<label class="custom_label" for="section4_job1">Job Type:</label>';
echo '<input type="text" class="custom_input" name="section4_job1" value="' . esc_attr($section4_job1) . '" /> <br>';

echo '<label class="custom_label" for="section4_review1">Review:</label>';
echo '<input type="text" class="custom_input" name="section4_review1" value="' . esc_attr($section4_review1) . '" /> <br>';

echo '<label class="custom_label" for="section4_image2">Image 2:</label>';
echo '<input type="text" name="section4_image2" class="meta-image12 custom_input" value="' . esc_url($section4_image2) . '"  />';
echo '<input type="button" class="button image-upload12" value="Browse Files" /> <br>';

echo '<label class="custom_label" for="section4_name2">Name:</label>';
echo '<input class="custom_input" type="text" name="section4_name2" value="' . esc_attr($section4_name2) . '" /> <br>';

echo '<label class="custom_label" for="section4_job2">Job Type:</label>';
echo '<input type="text" class="custom_input" name="section4_job2" value="' . esc_attr($section4_job2) . '" /> <br>';

echo '<label class="custom_label" for="section4_review2">Review:</label>';
echo '<input type="text" class="custom_input" name="section4_review2" value="' . esc_attr($section4_review2) . '" /> <br>';

echo '<label class="custom_label" for="section4_image3">Image 3:</label>';
echo '<input type="text" name="section4_image3" class="meta-image13 custom_input" value="' . esc_url($section4_image3) . '"  />';
echo '<input type="button" class="button image-upload13" value="Browse Files" /> <br>';

echo '<label class="custom_label" for="section4_name3">Name:</label>';
echo '<input class="custom_input" type="text" name="section4_name3" value="' . esc_attr($section4_name3) . '" /> <br>';

echo '<label class="custom_label" for="section4_job3">Job Type:</label>';
echo '<input type="text" class="custom_input" name="section4_job3" value="' . esc_attr($section4_job3) . '" /> <br>';

echo '<label class="custom_label" for="section4_review3">Review:</label>';
echo '<input type="text" class="custom_input" name="section4_review3" value="' . esc_attr($section4_review3) . '" /> <br>';

echo '<input type="submit" name="update_section4" class="button-primary custom_label_1" value="Update Settings" />';
echo '</form>';
echo '</div>';

// Section-5 (Target Section)
if (isset($_POST['update_section5'])) {
  // Save and update settings
  update_option('section5_number1', sanitize_text_field($_POST['section5_number1']));
  update_option('section5_text1', sanitize_text_field($_POST['section5_text1']));
  update_option('section5_number2', sanitize_text_field($_POST['section5_number2']));
  update_option('section5_text2', sanitize_text_field($_POST['section5_text2']));
  update_option('section5_number3', sanitize_text_field($_POST['section5_number3']));
  update_option('section5_text3', sanitize_text_field($_POST['section5_text3']));
  update_option('section5_number4', sanitize_text_field($_POST['section5_number4']));
  update_option('section5_text4', sanitize_text_field($_POST['section5_text4']));
  echo '<div class="updated5"><p>Settings saved.</p></div>';
}

echo '<div class="MySection"> ';
echo '<h1>Section 5</h1>';
echo '<form method="post" action="">';

// Display current values
$section5_number1 = get_option('section5_number1');
$section5_text1 = get_option('section5_text1');
$section5_number2 = get_option('section5_number2');
$section5_text2 = get_option('section5_text2');
$section5_number3 = get_option('section5_number3');
$section5_text3 = get_option('section5_text3');
$section5_number4 = get_option('section5_number4');
$section5_text4 = get_option('section5_text4');

echo '<label class="custom_label" for="section5_number1">Number1:</label>';
echo '<input class="custom_input" type="text" name="section5_number1" value="' . esc_attr($section5_number1) . '" /> <br>';

echo '<label class="custom_label" for="section5_text1">Title:</label>';
echo '<input class="custom_input" type="text" name="section5_text1" value="' . esc_attr($section5_text1) . '" /> <br>';

echo '<label class="custom_label" for="section5_number2">Number2:</label>';
echo '<input class="custom_input" type="text" name="section5_number2" value="' . esc_attr($section5_number2) . '" /> <br>';

echo '<label class="custom_label" for="section5_text2">Title:</label>';
echo '<input class="custom_input" type="text" name="section5_text2" value="' . esc_attr($section5_text2) . '" /> <br>';

echo '<label class="custom_label" for="section5_number3">Number3:</label>';
echo '<input class="custom_input" type="text" name="section5_number3" value="' . esc_attr($section5_number3) . '" /> <br>';

echo '<label class="custom_label" for="section5_text3">Title:</label>';
echo '<input class="custom_input" type="text" name="section5_text3" value="' . esc_attr($section5_text3) . '" /> <br>';

echo '<label class="custom_label" for="section5_number4">Number4:</label>';
echo '<input class="custom_input" type="text" name="section5_number4" value="' . esc_attr($section5_number4) . '" /> <br>';

echo '<label class="custom_label" for="section5_text4">Title:</label>';
echo '<input class="custom_input" type="text" name="section5_text4" value="' . esc_attr($section5_text4) . '" /> <br>';

echo '<input class="button-primary custom_label_1" type="submit" name="update_section5" value="Update Settings" />';
echo '</form>';
echo '</div>';


}

function enqueue_custom_scripts() {
  if (isset($_GET['page']) && $_GET['page'] === 'theme-customization') {
      wp_enqueue_media();
      wp_enqueue_script('custom-dashboard-section-script', get_template_directory_uri() . '/js/custom-dashboard-section.js', array('jquery'), null, true);
  }
}
add_action('admin_enqueue_scripts', 'enqueue_custom_scripts');

// functions.php or your custom plugin file
function enqueue_custom_styles() {
  wp_enqueue_style('custom-styles', get_stylesheet_uri()); 
}
add_action('admin_enqueue_scripts', 'enqueue_custom_styles');




















// Add a custom section for header settings
function custom_header_settings($wp_customize) {
  $wp_customize->add_section('heassder_section', array(
      'title' => __('Header Section', 'your-theme-textdomain'),
      'priority' => 30,
  ));

  // Add a setting for header background image
  $wp_customize->add_setting('header_background_image', array(
      'default' => '',
      'sanitize_callback' => 'esc_url_raw',
  ));

  // Add a control for header background image
  $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'header_background_image', array(
      'label' => __('Header Background Image', 'your-theme-textdomain'),
      'section' => 'header_section',
      'settings' => 'header_background_image',
  )));
}

add_action('customize_register', 'custom_header_settings');







// enqueue-scripts.php

// function theme_enqueue_scripts() {
//   wp_enqueue_script('jquery');
//   wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.js', array('jquery'), '1.0', true);
//   wp_enqueue_script('owl-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array('jquery'), '2.3.4', true);

//   // Add your other scripts here
// }
// add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');













// Include the customizer section for the footer
function custom_footer_customize_register($wp_customize) {
  
//Footer Section (Main Section)
$wp_customize->add_panel('footer_section', array(
  'title'=> __('Footer Section'),
  'priority' => 40, // Adjust the priority as needed
  'description'=> ('Footer Section'),
));

  //About Us Section (1st inner Section)
  $wp_customize->add_section('custom_footer_section_aboutus_section', array(
      'panel'    => 'footer_section',
      'title'    => __('About Us', 'esigned'),
      'priority' => 10,
  ));
     
    // Add settings, controls, and options as needed
    $wp_customize->add_setting('footer_address_text', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('footer_address_text', array(
        'label'    => __('Address', 'esigned'),
        'section'  => 'custom_footer_section_aboutus_section',
        'settings' => 'footer_address_text',
        'type'     => 'text',
    ));
    // Add additional controls for options like font size, color, text alignment, etc.
    $wp_customize->add_setting('footer_text_font_size', array(
      'default' => '16px',
      'transport' => 'refresh',
  ));

    $wp_customize->add_control('footer_text_font_size', array(
        'label' => __('Font Size', 'esigned'),
        'section' => 'custom_footer_section_aboutus_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('footer_text_color', array(
        'default' => '#ffffff',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_text_color', array(
        'label' => __('Text Color', 'esigned'),
        'section' => 'custom_footer_section_aboutus_section',
    )));

    $wp_customize->add_setting('footer_text_alignment', array(
        'default' => 'left',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('footer_text_alignment', array(
        'label' => __('Text Alignment', 'esigned'),
        'section' => 'custom_footer_section_aboutus_section',
        'type' => 'select',
        'choices' => array(
            'left' => __('Left', 'esigned'),
            'center' => __('Center', 'esigned'),
            'right' => __('Right', 'esigned'),
        ),
    ));
    $wp_customize->add_setting('footer_phone_number', array(
      'default'   => '',
      'transport' => 'refresh',
    ));

    $wp_customize->add_control('footer_phone_number', array(
        'label'    => __('Phone Number', 'esigned'),
        'section'  => 'custom_footer_section_aboutus_section',
        'settings' => 'footer_phone_number',
        'type'     => 'tel', // Use 'tel' type for phone numbers
    ));
    $wp_customize->add_setting('footer_email_address', array(
      'default'   => 'info@gmail.com',
      'transport' => 'refresh',
    ));

    $wp_customize->add_control('footer_email_address', array(
        'label'    => __('Email', 'esigned'),
        'section'  => 'custom_footer_section_aboutus_section',
        'settings' => 'footer_email_address',
        'type'     => 'email', // Use 'tel' type for phone numbers
    ));

  //Information Section (2nd inner Section)
  $wp_customize->add_section('custom_footer_section_information_section', array(
    'panel'    => 'footer_section',
    'title'    => __('Information', 'esigned'),
    'priority' => 20,
  ));
    // Add settings, controls, and options as needed
    $wp_customize->add_setting('footer_information_text', array(
      'default'   => '',
      'transport' => 'refresh',
    ));

    $wp_customize->add_control('footer_information_text', array(
      'label'    => __('Information', 'esigned'),
      'section'  => 'custom_footer_section_information_section',
      'settings' => 'footer_information_text',
      'type'     => 'text',
    ));
    // Add additional controls for options like font size, color, text alignment, etc.
    $wp_customize->add_setting('footer_information_text_font_size', array(
      'default' => '16px',
      'transport' => 'refresh',
    ));

    $wp_customize->add_control('footer_information_text_font_size', array(
      'label' => __('Font Size', 'esigned'),
      'section' => 'custom_footer_section_information_section',
      'type' => 'text',
    ));

    $wp_customize->add_setting('footer_information_text_color', array(
      'default' => '#ffffff',
      'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_information_text_color', array(
      'label' => __('Text Color', 'esigned'),
      'section' => 'custom_footer_section_information_section',
    )));

    $wp_customize->add_setting('footer_information_text_alignment', array(
      'default' => 'left',
      'transport' => 'refresh',
    ));

    $wp_customize->add_control('footer_information_text_alignment', array(
      'label' => __('Text Alignment', 'esigned'),
      'section' => 'custom_footer_section_information_section',
      'type' => 'select',
      'choices' => array(
          'left' => __('Left', 'esigned'),
          'center' => __('Center', 'esigned'),
          'right' => __('Right', 'esigned'),
      ),
    ));
  //Instagram Section (3rd inner Section)
  $wp_customize->add_section('custom_footer_section_instagram_section', array(
    'panel'    => 'footer_section',
    'title'    => __('Instagram', 'esigned'),
    'priority' => 30,
    ));
    //Icon 1
    $wp_customize->add_setting('insta_icon1_upload', array(
      'default'   => '',
      'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'insta_icon1_upload', array(
        'label'    => __('Upload Icon1 Image', 'esigned'),
        'section'  => 'custom_footer_section_instagram_section',
        'settings' => 'insta_icon1_upload',
    )));
    $wp_customize->add_setting('insta_icon1_link', array(
      'default'   => '',
      'transport' => 'refresh',
    ));

    $wp_customize->add_control('insta_icon1_link', array(
        'label'    => __('Icon1 Image Link', 'esigned'),
        'section'  => 'custom_footer_section_instagram_section',
        'settings' => 'insta_icon1_link',
        'type'     => 'text',
    ));
    //Icon 2
    $wp_customize->add_setting('insta_icon2_upload', array(
      'default'   => '',
      'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'insta_icon2_upload', array(
        'label'    => __('Upload Icon2 Image', 'esigned'),
        'section'  => 'custom_footer_section_instagram_section',
        'settings' => 'insta_icon2_upload',
    )));
    $wp_customize->add_setting('insta_icon2_link', array(
      'default'   => '',
      'transport' => 'refresh',
    ));

    $wp_customize->add_control('insta_icon2_link', array(
        'label'    => __('Icon2 Image Link', 'esigned'),
        'section'  => 'custom_footer_section_instagram_section',
        'settings' => 'insta_icon2_link',
        'type'     => 'text',
    ));
    //Icon 3
    $wp_customize->add_setting('insta_icon3_upload', array(
      'default'   => '',
      'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'insta_icon3_upload', array(
        'label'    => __('Upload Icon3 Image', 'esigned'),
        'section'  => 'custom_footer_section_instagram_section',
        'settings' => 'insta_icon3_upload',
    )));
    $wp_customize->add_setting('insta_icon3_link', array(
      'default'   => '',
      'transport' => 'refresh',
    ));

    $wp_customize->add_control('insta_icon3_link', array(
        'label'    => __('Icon3 Image Link', 'esigned'),
        'section'  => 'custom_footer_section_instagram_section',
        'settings' => 'insta_icon3_link',
        'type'     => 'text',
    ));
    //Icon 4
    $wp_customize->add_setting('insta_icon4_upload', array(
      'default'   => '',
      'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'insta_icon4_upload', array(
        'label'    => __('Upload Icon4 Image', 'esigned'),
        'section'  => 'custom_footer_section_instagram_section',
        'settings' => 'insta_icon4_upload',
    )));
    $wp_customize->add_setting('insta_icon4_link', array(
      'default'   => '',
      'transport' => 'refresh',
    ));

    $wp_customize->add_control('insta_icon4_link', array(
        'label'    => __('Icon4 Image Link', 'esigned'),
        'section'  => 'custom_footer_section_instagram_section',
        'settings' => 'insta_icon4_link',
        'type'     => 'text',
    ));
    //Icon 5
    $wp_customize->add_setting('insta_icon5_upload', array(
      'default'   => '',
      'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'insta_icon5_upload', array(
        'label'    => __('Upload Icon5 Image', 'esigned'),
        'section'  => 'custom_footer_section_instagram_section',
        'settings' => 'insta_icon5_upload',
    )));
    $wp_customize->add_setting('insta_icon5_link', array(
      'default'   => '',
      'transport' => 'refresh',
    ));

    $wp_customize->add_control('insta_icon5_link', array(
        'label'    => __('Icon5 Image Link', 'esigned'),
        'section'  => 'custom_footer_section_instagram_section',
        'settings' => 'insta_icon5_link',
        'type'     => 'text',
    ));
    //Icon 6
    $wp_customize->add_setting('insta_icon6_upload', array(
      'default'   => '',
      'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'insta_icon6_upload', array(
        'label'    => __('Upload Icon6 Image', 'esigned'),
        'section'  => 'custom_footer_section_instagram_section',
        'settings' => 'insta_icon6_upload',
    )));
    $wp_customize->add_setting('insta_icon6_link', array(
      'default'   => '',
      'transport' => 'refresh',
    ));

    $wp_customize->add_control('insta_icon6_link', array(
        'label'    => __('Icon6 Image Link', 'esigned'),
        'section'  => 'custom_footer_section_instagram_section',
        'settings' => 'insta_icon6_link',
        'type'     => 'text',
    ));

  //Newsletter Section (4th inner Section)
  $wp_customize->add_section('custom_footer_section_newsletter_section', array(
    'panel'    => 'footer_section',
    'title'    => __('Newsletter', 'esigned'),
    'priority' => 40,
    ));
    // Add setting for the button text
    $wp_customize->add_setting('newsletter_button_text', array(
      'default'   => __('Subscribe', 'esigned'),
      'transport' => 'refresh',
    ));

    // Add control for the button text
    $wp_customize->add_control('newsletter_button_text', array(
      'label'    => __('Button Text', 'esigned'),
      'section'  => 'custom_footer_section_newsletter_section',
      'settings' => 'newsletter_button_text',
      'type'     => 'text',
    ));

    // Add setting for the button link
    $wp_customize->add_setting('newsletter_button_link', array(
      'default'   => '#', // You can set a default link
      'transport' => 'refresh',
    ));

    // Add control for the button link
    $wp_customize->add_control('newsletter_button_link', array(
      'label'    => __('Button Link', 'esigned'),
      'section'  => 'custom_footer_section_newsletter_section',
      'settings' => 'newsletter_button_link',
      'type'     => 'url', // Use 'url' type for a URL field
    ));
    //Additional controls for button.
      // setting for button text color
      $wp_customize->add_setting('newsletter_button_text_color', array(
        'default'   => '#ffffff',
        'transport' => 'refresh',
      ));

      // Add control for button text color
      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'newsletter_button_text_color', array(
        'label'    => __('Button Text Color', 'esigned'),
        'section'  => 'custom_footer_section_newsletter_section',
        'settings' => 'newsletter_button_text_color',
      )));

      // Add setting for button background color
      $wp_customize->add_setting('newsletter_button_bg_color', array(
        'default'   => '#fbca47',
        'transport' => 'refresh',
      ));

      // Add control for button background color
      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'newsletter_button_bg_color', array(
        'label'    => __('Button Background Color', 'esigned'),
        'section'  => 'custom_footer_section_newsletter_section',
        'settings' => 'newsletter_button_bg_color',
      )));

      // Add setting for button font size
      $wp_customize->add_setting('newsletter_button_font_size', array(
        'default'   => '15px',
        'transport' => 'refresh',
      ));

      // Add control for button font size
      $wp_customize->add_control('newsletter_button_font_size', array(
        'label'    => __('Button Font Size', 'esigned'),
        'section'  => 'custom_footer_section_newsletter_section',
        'type'     => 'text',
      ));
      // Add setting for button hover text color
      $wp_customize->add_setting('newsletter_button_hover_text_color', array(
        'default'   => '#fbca47',
        'transport' => 'refresh',
      ));

      // Add control for button hover text color
      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'newsletter_button_hover_text_color', array(
        'label'    => __('Button Hover Text Color', 'esigned'),
        'section'  => 'custom_footer_section_newsletter_section',
        'settings' => 'newsletter_button_hover_text_color',
      )));

      // Add setting for button hover background color
      $wp_customize->add_setting('newsletter_button_hover_bg_color', array(
        'default'   => 'transparent',
        'transport' => 'refresh',
      ));

      // Add control for button hover background color
      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'newsletter_button_hover_bg_color', array(
        'label'    => __('Button Hover Background Color', 'esigned'),
        'section'  => 'custom_footer_section_newsletter_section',
        'settings' => 'newsletter_button_hover_bg_color',
      )));

      // Add setting for button border radius
      $wp_customize->add_setting('newsletter_button_border_radius', array(
        'default'   => '',
        'transport' => 'refresh',
      ));

      // Add control for button border radius
      $wp_customize->add_control('newsletter_button_border_radius', array(
        'label'    => __('Button Border Radius', 'esigned'),
        'section'  => 'custom_footer_section_newsletter_section',
        'type'     => 'text',
      ));
  //Social media Section (5th inner Section)
  $wp_customize->add_section('custom_footer_section_socialmedia_section', array(
    'panel'    => 'footer_section',
    'title'    => __('Social Media', 'esigned'),
    'priority' => 50,
    ));
     //Social media Icon 1
     $wp_customize->add_setting('social_icon1_upload', array(
      'default'   => '',
      'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'social_icon1_upload', array(
        'label'    => __('Upload Icon1 Image', 'esigned'),
        'section'  => 'custom_footer_section_socialmedia_section',
        'settings' => 'social_icon1_upload',
    )));
    $wp_customize->add_setting('social_icon1_link', array(
      'default'   => '',
      'transport' => 'refresh',
    ));

    $wp_customize->add_control('social_icon1_link', array(
        'label'    => __('Icon1 Image Link', 'esigned'),
        'section'  => 'custom_footer_section_socialmedia_section',
        'settings' => 'social_icon1_link',
        'type'     => 'text',
    ));
    //Social media Icon 2
    $wp_customize->add_setting('social_icon2_upload', array(
      'default'   => '',
      'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'social_icon2_upload', array(
        'label'    => __('Upload Icon2 Image', 'esigned'),
        'section'  => 'custom_footer_section_socialmedia_section',
        'settings' => 'social_icon2_upload',
    )));
    $wp_customize->add_setting('social_icon2_link', array(
      'default'   => '',
      'transport' => 'refresh',
    ));

    $wp_customize->add_control('social_icon2_link', array(
        'label'    => __('Icon2 Image Link', 'esigned'),
        'section'  => 'custom_footer_section_socialmedia_section',
        'settings' => 'social_icon2_link',
        'type'     => 'text',
    ));
    //Social media Icon 3
    $wp_customize->add_setting('social_icon3_upload', array(
      'default'   => '',
      'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'social_icon3_upload', array(
        'label'    => __('Upload Icon3 Image', 'esigned'),
        'section'  => 'custom_footer_section_socialmedia_section',
        'settings' => 'social_icon3_upload',
    )));
    $wp_customize->add_setting('social_icon3_link', array(
      'default'   => '',
      'transport' => 'refresh',
    ));

    $wp_customize->add_control('social_icon3_link', array(
        'label'    => __('Icon3 Image Link', 'esigned'),
        'section'  => 'custom_footer_section_socialmedia_section',
        'settings' => 'social_icon3_link',
        'type'     => 'text',
    ));
    //Social media Icon 4
    $wp_customize->add_setting('social_icon4_upload', array(
      'default'   => '',
      'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'social_icon4_upload', array(
        'label'    => __('Upload Icon4 Image', 'esigned'),
        'section'  => 'custom_footer_section_socialmedia_section',
        'settings' => 'social_icon4_upload',
    )));
    $wp_customize->add_setting('social_icon4_link', array(
      'default'   => '',
      'transport' => 'refresh',
    ));

    $wp_customize->add_control('social_icon4_link', array(
        'label'    => __('Icon4 Image Link', 'esigned'),
        'section'  => 'custom_footer_section_socialmedia_section',
        'settings' => 'social_icon4_link',
        'type'     => 'text',
    ));
  }

add_action('customize_register', 'custom_footer_customize_register');




