<body>
<div class="hero_area"  style="background-image: url('<?php echo get_theme_mod('header_background_image'); ?>');">
<!-- To call the header from header from header.php -->
<?php get_header();  ?>
<!-- slider section -->
<section class="Custom-slider-section">
  
 <?php
    $slides = new WP_Query(array(
        'post_type' => 'slider_item',
        'posts_per_page' => -1, // Display all posts
    ));

    while ($slides->have_posts()) {
        $slides->the_post();
        $subtitle = get_post_meta(get_the_ID(), 'subtitle', true);
        $button_text = get_post_meta(get_the_ID(), 'button_text', true);
        $button_position = get_post_meta(get_the_ID(), 'button_position', true);
        $button_font_size = get_post_meta(get_the_ID(), 'button_font_size', true);
        $button_font_style = get_post_meta(get_the_ID(), 'button_font_style', true);
        $button_font_color = get_post_meta(get_the_ID(), 'button_font_color', true);
        ?>
        <div class="slide">
          <div class="slide-content" >
            <h2><?php the_title(); ?></h2>
            <?php
                // Output subtitle
                echo '<h1>' . esc_html($subtitle) . '</h1>';
                // Output additional content
                echo '<p>' . the_content() . '</p>';
            ?>
            <div class="button-box" style="text-align: <?php echo esc_attr($button_position); ?>;">
                <a href="#" style="
                    font-size: <?php echo esc_attr($button_font_size); ?>;
                    font-style: <?php echo esc_attr($button_font_style); ?>;
                    color: <?php echo esc_attr($button_font_color); ?>;
                "><?php echo esc_html($button_text); ?></a>
            </div>
          </div>
          <div id="slider_div" style="z-index:-9999;">
            <?php the_post_thumbnail('full'); ?>
          </div>
        </div>
        <?php
    }

    wp_reset_postdata();
    ?>

    <!-- Place the pagination container outside the loop -->
    <div class="slider-pagination"></div>
   

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var paginationContainer = document.querySelector('.slider-pagination');
        var slides = document.querySelectorAll('.slide');
        var currentIndex = 0;

        slides.forEach(function (_, i) {
            var button = document.createElement('div');
            button.classList.add('pagination-button');
            button.dataset.index = i;
            paginationContainer.appendChild(button);

            button.addEventListener('click', function () {
                currentIndex = parseInt(button.dataset.index);
                showSlide(currentIndex);
            });
        });

        function showSlide(index) {
            slides.forEach(function (slide, i) {
                slide.style.display = i === index ? 'block' : 'none';
            });
        }

        function switchToNextSlide() {
            currentIndex = (currentIndex + 1) % slides.length;
            showSlide(currentIndex);
        }

        setInterval(switchToNextSlide, 5000);

        showSlide(currentIndex);
    });
</script>

</section> 

<!-- end slider section -->
</div>

    
<!-- do section -->

<section class="do_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>
              <?php
                $section1_title = get_option('section1_title');
                echo esc_html($section1_title);
                ?>
        </h2>
        <p>
        <?php
                $section1_description = get_option('section1_description');
                echo esc_html($section1_description);
                ?>  
        </p>
      </div>
      <div class="do_container">
        <div class="box arrow-start arrow_bg">
        <div class="img-box">
            <img src="<?php 
                $service1_image = get_option('service1_image');
                echo esc_url($service1_image);
            ?>" alt="service1 image">
        </div>
          <div class="detail-box">
            <h6>
            <?php
                $service1_title = get_option('service1_title');
                echo esc_html($service1_title);
                ?>
            </h6>
          </div>
        </div>
        <div class="box arrow-middle arrow_bg">
          <div class="img-box">
          <img src="<?php 
                $service2_image = get_option('service2_image');
                echo esc_url($service2_image);
            ?>" alt="service2 image">
          </div>
          <div class="detail-box">
            <h6>
            <?php
                $service2_title = get_option('service2_title');
                echo esc_html($service2_title);
                ?>
            </h6>
          </div>
        </div>
        <div class="box arrow-middle arrow_bg">
          <div class="img-box">
          <img src="<?php 
                $service3_image = get_option('service3_image');
                echo esc_url($service3_image);
            ?>" alt="service3 image">
          </div>
          <div class="detail-box">
            <h6>
            <?php
                $service3_title = get_option('service3_title');
                echo esc_html($service3_title);
                ?>
            </h6>
          </div>
        </div>
        <div class="box arrow-end arrow_bg">
          <div class="img-box">
          <img src="<?php 
                $service4_image = get_option('service4_image');
                echo esc_url($service4_image);
            ?>" alt="service4 image">
          </div>
          <div class="detail-box">
            <h6>
            <?php
                $service4_title = get_option('service4_title');
                echo esc_html($service4_title);
                ?>
            </h6>
          </div>
        </div>
        <div class="box ">
          <div class="img-box">
          <img src="<?php 
                $service5_image = get_option('service5_image');
                echo esc_url($service5_image);
            ?>" alt="service5 image">
          </div>
          <div class="detail-box">
            <h6>
            <?php
                $service5_title = get_option('service5_title');
                echo esc_html($service5_title);
                ?>
            </h6>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end do section -->


  <!-- who section -->

  <section class="who_section ">
    <div class="container">
      <div class="row">
        <div class="col-md-5">
          <div class="img-box">
          <img src="<?php 
                $section2_image = get_option('section2_image');
                echo esc_url($section2_image);
            ?>" alt="section2 image">
          </div>
        </div>
        <div class="col-md-7">
          <div class="detail-box">
            <div class="heading_container">
              <h2>
              <?php
                $section2_title = get_option('section2_title');
                echo esc_html($section2_title);
                ?>
              </h2>
            </div>
            <p>
            <?php
                $section2_description = get_option('section2_description');
                echo esc_html($section2_description);
                ?> 
            </p>
            <div>
              <a href="">
              <?php
                $section2_button = get_option('section2_button');
                echo esc_html($section2_button);
                ?> 

              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end who section -->


  <!-- work section -->
  <section class="work_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>
        <?php
                $section3_title = get_option('section3_title');
                echo esc_html($section3_title);
                ?>
        </h2>
        <p>
        <?php
                $section3_description = get_option('section3_description');
                echo esc_html($section3_description);
                ?> 
        </p>
      </div>
      <div class="work_container layout_padding2">
        <div class="box b-1">
        <img src="<?php 
                $section3_image1 = get_option('section3_image1');
                echo esc_url($section3_image1);
            ?>" alt="section3 image1">
        </div>
        <div class="box b-2">
        <img src="<?php 
                $section3_image2 = get_option('section3_image2');
                echo esc_url($section3_image2);
            ?>" alt="section3 image2">

        </div>
        <div class="box b-3">
        <img src="<?php 
                $section3_image3 = get_option('section3_image3');
                echo esc_url($section3_image3);
            ?>" alt="section3 image3">

        </div>
        <div class="box b-4">
        <img src="<?php 
                $section3_image4 = get_option('section3_image4');
                echo esc_url($section3_image4);
            ?>" alt="section3 image4">

        </div>
      </div>
    </div>
  </section>

  <!-- end work section -->

  <!-- client section -->
  <section class="client_section">
    <div class="container">
      <div class="heading_container">
        <h2>
        <?php
                $section4_title = get_option('section4_title');
                echo esc_html($section4_title);
                ?>
        </h2>
      </div>
      <div class="carousel-wrap ">
        <div class="owl-carousel">
          <div class="item">
            <div class="box">
              <div class="img-box">
              <img src="<?php 
                $section4_image1 = get_option('section4_image1');
                echo esc_url($section4_image1);
            ?>" alt="$section4_image1">
              </div>
              <div class="detail-box">
                <h5>
                <?php
                $section4_name1 = get_option('section4_name1');
                echo esc_html($section4_name1);
                ?> <br>
                  <span>
                  <?php
                  $section4_job1 = get_option('section4_job1');
                echo esc_html($section4_job1);
                ?>
                  </span>
                  
                </h5>
                <img src="<?php echo get_theme_file_uri('images/quote.png'); ?>" alt="">
                <p>
                <?php
                $section4_review1 = get_option('section4_review1');
                echo esc_html($section4_review1);
                ?>
                </p>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="box">
              <div class="img-box">
              <img src="<?php 
                $section4_image2 = get_option('section4_image2');
                echo esc_url($section4_image2);
            ?>" alt="$section4_image2">
              </div>
              <div class="detail-box">
                <h5>
                <?php
                $section4_name2 = get_option('section4_name2');
                echo esc_html($section4_name2);
                ?> <br>
                  <span>
                  <?php
                  $section4_job2 = get_option('section4_job2');
                echo esc_html($section4_job2);
                ?>
                  </span>
                </h5>
                <img src="<?php echo get_theme_file_uri('images/quote.png'); ?>" alt="">
                <p>
                <?php
                $section4_review2 = get_option('section4_review2');
                echo esc_html($section4_review2);
                ?>
                </p>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="box">
              <div class="img-box">
              <img src="<?php 
                $section4_image3 = get_option('section4_image3');
                echo esc_url($section4_image3);
            ?>" alt="$section4_image3">
              </div>
              <div class="detail-box">
                <h5>
                <?php
                $section4_name3 = get_option('section4_name3');
                echo esc_html($section4_name3);
                ?> <br>
                  <span>
                  <?php
                  $section4_job3 = get_option('section4_job3');
                echo esc_html($section4_job3);
                ?>
                  </span>
                </h5>
                <img src="<?php echo get_theme_file_uri('images/quote.png'); ?>" alt="">
                <p>
                <?php
                $section4_review3 = get_option('section4_review3');
                echo esc_html($section4_review3);
                ?>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end client section -->

  <!-- target section -->
  <section class="target_section layout_padding2">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-6">
          <div class="detail-box">
            <h2>
            <?php
                $section5_number1 = get_option('section5_number1');
                echo esc_html($section5_number1);
                ?>
            </h2>
            <h5>
            <?php
                $section5_text1 = get_option('section5_text1');
                echo esc_html($section5_text1);
                ?>
            </h5>
          </div>
        </div>
        <div class="col-md-3 col-sm-6">
          <div class="detail-box">
            <h2>
            <?php
                $section5_number2 = get_option('section5_number2');
                echo esc_html($section5_number2);
                ?>
            </h2>
            <h5>
            <?php
                $section5_text2 = get_option('section5_text2');
                echo esc_html($section5_text2);
                ?>
            </h5>
          </div>
        </div>
        <div class="col-md-3 col-sm-6">
          <div class="detail-box">
            <h2>
            <?php
                $section5_number3 = get_option('section5_number3');
                echo esc_html($section5_number3);
                ?>
            </h2>
            <h5>
            <?php
                $section5_text3 = get_option('section5_text3');
                echo esc_html($section5_text3);
                ?>
            </h5>
          </div>
        </div>
        <div class="col-md-3 col-sm-6">
          <div class="detail-box">
            <h2>
            <?php
                $section5_number4 = get_option('section5_number4');
                echo esc_html($section5_number4);
                ?>
            </h2>
            <h5>
            <?php
            $section5_text4 = get_option('section5_text4');
                echo esc_html($section5_text4);
                ?>
            </h5>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end target section -->


  <!-- contact section -->

  <?php
$shortcode_output = do_shortcode('[custom_contact_form]');
echo $shortcode_output;
  ?>

  <!-- end contact section -->
  <?php get_footer();  ?>

  


</body>

</html>