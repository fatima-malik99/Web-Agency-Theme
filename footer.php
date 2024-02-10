<!-- info section footer -->
<section class="info_section ">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <div class="info_contact">
            <h5>
              About Shop
            </h5>
            <div style="
                font-size: <?php echo esc_attr(get_theme_mod('footer_text_font_size', '16px')); ?>;
                color: <?php echo esc_attr(get_theme_mod('footer_text_color', '#ffffff')); ?>;
                text-align: <?php echo esc_attr(get_theme_mod('footer_text_alignment', 'left')); ?>;
            ">
              <div class="img-box">
                <img src="<?php echo get_theme_file_uri('images/location-white.png'); ?>" width="18px" alt="">
              </div>
              
              <p>
                <!-- Address -->
                <p style=""><?php echo get_theme_mod('footer_address_text', ''); ?></p>

              </p>
            </div>
            <div>
              <div class="img-box">
                <img src="<?php echo get_theme_file_uri('images/telephone-white.png'); ?>" width="12px" alt="">
              </div>
              <p style=""><?php echo get_theme_mod('footer_phone_number', ''); ?></p>
            </div>
            <div>
              <div class="img-box">
                <img src="<?php echo get_theme_file_uri('images/envelope-white.png'); ?>" width="18px" alt="">
              </div>
              <p>
                <?php
                $email_address = get_theme_mod('footer_email_address', ''); // Retrieve the email address from the customizer
                if (!empty($email_address)) {
                    echo '<a href="mailto:' . esc_attr($email_address) . '">' . esc_html($email_address) . '</a>'; //esc_attr() is used to escape the email address for safe inclusion in the HTML attribute.
                }                                                                                                  //esc_html() is used to escape the email address for safe HTML display. This helps prevent potential security issues like cross-site scripting (XSS).
                ?>
                </p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="info_info" style="
              font-size: <?php echo esc_attr(get_theme_mod('footer_information_font_size', '16px')); ?>;
              color: <?php echo esc_attr(get_theme_mod('footer_information_text_color', '#ffffff')); ?>;
              text-align: <?php echo esc_attr(get_theme_mod('footer_information_alignment', 'left')); ?>;
          ">
            <h5>
              Informations
            </h5>
            <p style=""><?php echo get_theme_mod('footer_information_text', ''); ?></p>
          </div>
        </div>

        <div class="col-md-3">
          <div class="info_insta">
            <h5>
              Instagram
            </h5>
            <div class="insta_container">
              <div>
              <?php
                  $image_url = get_theme_mod('insta_icon1_upload', get_template_directory_uri() . '/images/insta.png' ); // Retrieve the image URL from the Customizer
                  $image_link = get_theme_mod('insta_icon1_link', ''); // Retrieve the image link from the Customizer
                  ?>

                  <a href="<?php echo esc_url($image_link); ?>">
                    <div class="insta-box b-1">
                      <img src="<?php echo esc_url($image_url); ?>" alt="">
                    </div>
                  </a>
                  <?php
                  $image_url = get_theme_mod('insta_icon2_upload', get_template_directory_uri() . '/images/insta.png'); // Retrieve the image URL from the Customizer
                  $image_link = get_theme_mod('insta_icon2_link', ''); // Retrieve the image link from the Customizer
                  ?>

                  <a href="<?php echo esc_url($image_link); ?>">
                    <div class="insta-box b-2">
                      <img src="<?php echo esc_url($image_url); ?>" alt="">
                    </div>
                  </a>
              </div>

              <div>
              <?php
                  $image_url = get_theme_mod('insta_icon3_upload', get_template_directory_uri() . '/images/insta.png'); // Retrieve the image URL from the Customizer
                  $image_link = get_theme_mod('insta_icon3_link', ''); // Retrieve the image link from the Customizer
                  ?>

                  <a href="<?php echo esc_url($image_link); ?>">
                    <div class="insta-box b-3">
                      <img src="<?php echo esc_url($image_url); ?>" alt="">
                    </div>
                  </a>
                  <?php
                  $image_url = get_theme_mod('insta_icon4_upload', get_template_directory_uri() . '/images/insta.png'); // Retrieve the image URL from the Customizer
                  $image_link = get_theme_mod('insta_icon4_link', ''); // Retrieve the image link from the Customizer
                  ?>

                  <a href="<?php echo esc_url($image_link); ?>">
                    <div class="insta-box b-4">
                      <img src="<?php echo esc_url($image_url); ?>" alt="">
                    </div>
                  </a>
              </div>


              <div>
              <?php
                  $image_url = get_theme_mod('insta_icon5_upload', get_template_directory_uri() . '/images/insta.png'); // Retrieve the image URL from the Customizer
                  $image_link = get_theme_mod('insta_icon5_link', ''); // Retrieve the image link from the Customizer
                  ?>

                  <a href="<?php echo esc_url($image_link); ?>">
                    <div class="insta-box b-5">
                      <img src="<?php echo esc_url($image_url); ?>" alt="">
                    </div>
                  </a>
                  <?php
                  $image_url = get_theme_mod('insta_icon6_upload', get_template_directory_uri() . '/images/insta.png'); // Retrieve the image URL from the Customizer
                  $image_link = get_theme_mod('insta_icon6_link', ''); // Retrieve the image link from the Customizer
                  ?>

                  <a href="<?php echo esc_url($image_link); ?>">
                    <div class="insta-box b-6">
                      <img src="<?php echo esc_url($image_url); ?>" alt="">
                    </div>
                  </a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="info_form ">
            <h5>
              Newsletter
            </h5>
            <form action="">
                <?php
                // Retrieve settings from the Customizer
                $email_placeholder = get_theme_mod('newsletter_email_placeholder', '');
                $button_text = get_theme_mod('newsletter_button_text', 'Subscribe');
                $button_link = get_theme_mod('newsletter_button_link', '#');
                $button_text_color = get_theme_mod('newsletter_button_text_color', '#ffffff');
                $button_bg_color = get_theme_mod('newsletter_button_bg_color', '#fbca47');
                $button_font_size = get_theme_mod('newsletter_button_font_size', '15px');
                $button_hover_text_color = get_theme_mod('newsletter_button_hover_text_color', '#fbca47');
                $button_hover_bg_color = get_theme_mod('newsletter_button_hover_bg_color', 'transparent');
                $button_border_radius = get_theme_mod('newsletter_button_border_radius', '');
                ?>

                <input type="email" placeholder="<?php echo esc_attr($email_placeholder); ?>">
                <button style="
                    color: <?php echo esc_attr($button_text_color); ?>;
                    background-color: <?php echo esc_attr($button_bg_color); ?>;
                    font-size: <?php echo esc_attr($button_font_size); ?>;
                    border-radius: <?php echo esc_attr($button_border_radius); ?>;
                " onmouseover="this.style.backgroundColor='<?php echo esc_attr($button_hover_bg_color); ?>'; this.style.color='<?php echo esc_attr($button_hover_text_color); ?>';"  
                onmouseout="this.style.backgroundColor='<?php echo esc_attr($button_bg_color); ?>'; this.style.color='<?php echo esc_attr($button_text_color); ?>';">
                <!--onmouseout= event handler that specifies JavaScript code to be executed when the mouse pointer is moved over the button -->
                    <?php echo esc_html($button_text); ?>
                </button>
            </form>

            <div class="social_box">
              <?php
              // Retrieve settings from the Customizer for each social icon
              $social_icon1_link = get_theme_mod('social_icon1_link', '');
              $social_icon2_link = get_theme_mod('social_icon2_link', '');
              $social_icon3_link = get_theme_mod('social_icon3_link', '');
              $social_icon4_link = get_theme_mod('social_icon4_link', '');

              // Display social icons with links
              ?>
              <a href="<?php echo esc_url($social_icon1_link); ?>">
                  <img src="<?php echo esc_url(get_theme_mod('social_icon1_upload', get_template_directory_uri() . '/images/fb.png')); ?>" alt="">
              </a>
              <a href="<?php echo esc_url($social_icon2_link); ?>">
                  <img src="<?php echo esc_url(get_theme_mod('social_icon2_upload', get_template_directory_uri() . '/images/linkedin.png')); ?>" alt="">
              </a>
              <a href="<?php echo esc_url($social_icon3_link); ?>">
                  <img src="<?php echo esc_url(get_theme_mod('social_icon3_upload', get_template_directory_uri() . '/images/twitter.png')); ?>" alt="">
              </a>
              <a href="<?php echo esc_url($social_icon4_link); ?>">
                  <img src="<?php echo esc_url(get_theme_mod('social_icon4_upload', get_template_directory_uri() . '/images/youtube.png')); ?>" alt="">
              </a>
          </div>

          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end info_section -->
<!-- footer section -->
<section class="container-fluid footer_section">
    <p>
      &copy; 2020 All Rights Reserved By
      <a href="https://html.design/">Free Html Templates</a>
    </p>
  </section>
  
  <!-- footer section -->

  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"> 
  </script>
  <!-- <script type="text/javascript" src="js/my-contact-form.js"></script> -->
  <!-- owl carousel script 
    -->
  <script type="text/javascript">
    $(".owl-carousel").owlCarousel({
      loop: true,
      margin: 0,
      navText: [],
      center: true,
      autoplay: true,
      autoplayHoverPause: true,
      responsive: {
        0: {
          items: 1
        },
        1000: {
          items: 3
        }
      }
    });
  </script>
  <!-- end owl carousel script -->