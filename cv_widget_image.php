<?php
class CV_Widget_Image extends WP_Widget {

  /**
   * Register widget with WordPress.
   */
  public function __construct() {
      parent::__construct(
          'cv_widget_image_button', // Base ID
          'Crypto Voucher Widget Image Button', // Name
          array( 'description' => __( 'Inserts a button to open Crypto Voucher Widget as a button with pre-made image.', 'text_domain' ), ) // Args
      );
  }

  /**
   * Front-end display of widget.
   *
   * @see WP_Widget::widget()
   *
   * @param array $args     Widget arguments.
   * @param array $instance Saved values from database.
   */
  public function widget( $args, $instance ) {
      extract( $args );
      $label = apply_filters( 'widget_title', $instance['label'] );
      $options = get_option('cv_widget_plugin_options');

      echo $before_widget;
      ?>

      <div class="buy-cryptocurrency-directly">
          <?php
            if ( isset( $instance[ 'label' ] ) ) {
              echo "<h4
                      style='margin-bottom: 10px;'
                    >" . esc_attr($instance['label'])."</h4>";
            }
          ?>
          <?php
            echo "<img
              src='".esc_attr(plugin_dir_url( __FILE__ )."images/buy_cv.svg")."'
              alt='Buy Cryptocurrency Directly'
              onclick=\"window.startTransaction_hertlkj345h34({
                  token: '".esc_attr($options['widget_token'])."'
              })\"
              class='cv-widget-image-button'
              style='cursor: pointer;'
            />";
          ?>
      </div>

      <?php
      echo $after_widget;
  }

  /**
   * Back-end widget form.
   *
   * @see WP_Widget::form()
   *
   * @param array $instance Previously saved values from database.
   */
  public function form( $instance ) {
      if ( isset( $instance[ 'label' ] ) ) {
        $label = $instance[ 'label' ];
      }
      else {
        $label = __( 'Buy Cryptocurrency Directly', 'text_domain' );
      }
      ?>
      <p>
        <h3>Crypto Voucher Widget (Text Button)</h3>

        <label for="<?php echo esc_attr($this->get_field_name( 'label' )); ?>"><?php _e( 'Enter title:' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'label' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'label' )); ?>" type="text" value="<?php echo esc_attr( $label ); ?>" />
     </p>
  <?php
  }

  /**
   * Sanitize widget form values as they are saved.
   *
   * @see WP_Widget::update()
   *
   * @param array $new_instance Values just sent to be saved.
   * @param array $old_instance Previously saved values from database.
   *
   * @return array Updated safe values to be saved.
   */
  public function update( $new_instance, $old_instance ) {
      $instance = array();
      $instance['label'] = ( !empty( $new_instance['label'] ) ) ? strip_tags( $new_instance['label'] ) : 'Buy Cryptocurrency Directly';

      return $instance;
  }
}
 ?>
