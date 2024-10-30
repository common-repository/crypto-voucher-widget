<?php
function trim_and_lowercase($arg) {
    return trim(strtolower($arg));
}

class CV_Widget_Text_Button extends WP_Widget {

  /**
   * Register widget with WordPress.
   */
  public function __construct() {
      parent::__construct(
          'cv_widget_text_button', // Base ID
          'Crypto Voucher Widget Text Button', // Name
          array( 'description' => __( 'Inserts a button to open Crypto Voucher Widget as a button with customizable text.', 'text_domain' ), ) // Args
      );
  }

  /**
   * Front-end display of widget.
   *
   * @see CV_Widget_Text_Button::widget()
   *
   * @param array $args     Widget arguments.
   * @param array $instance Saved values from database.
   */
  public function widget( $args, $instance ) {
      extract( $args );
      $title = $instance['title'];
      $referenceId = apply_filters( 'trim_and_lowercase', $instance['referenceId'] or null );

      echo $before_widget;
      ?>

      <div class="buy-cryptocurrency-directly">
          <?php
            if ( isset( $instance[ 'label' ] ) ) {
              echo '<h4
                      style="margin-bottom: 10px;"
                    >' . $instance['label'] . '</h4>';
            }
          ?>
          <button
            onclick="startTransaction({
                referenceId: '<?php echo esc_attr($instance['referenceId']); ?>',
                primaryColor: '<?php echo esc_attr($instance['primaryColor']); ?>',
                <?php echo (is_null($instance['logo'])) ? "logo: '".esc_attr($instance['logo'])."'" : ''; ?>
            })"
            class="cv-widget-text-button"><?php echo $instance['title']; ?>
          </button>
      </div>

      <?php
      echo $after_widget;
  }

  /**
   * Back-end widget form.
   *
   * @see CV_Widget_Text_Button::form()
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
      if ( isset( $instance[ 'title' ] ) ) {
        $title = $instance[ 'title' ];
      }
      else {
        $title = __( 'Buy Now', 'text_domain' );
      }
      ?>
      <p>
        <h3>Crypto Voucher Widget (Text Button)</h3>

        <label for="<?php echo esc_attr($this->get_field_name( 'label' )); ?>"><?php _e( 'Enter title:' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'label' )); ?>" name="<?php echo $this->get_field_name( 'label' ); ?>" type="text" value="<?php echo esc_attr( $label ); ?>" />

        <label for="<?php echo esc_attr($this->get_field_name( 'title' )); ?>"><?php _e( 'Text to display inside button:' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />

        <label for="<?php echo esc_attr($this->get_field_name( 'referenceId' )); ?>"><?php _e( 'Enter your reference identificator (required):' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'referenceId' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'referenceId' )); ?>" type="text" value="<?php echo esc_attr( $referenceId ); ?>" />

        <label for="<?php echo esc_attr($this->get_field_name( 'primaryColor' )); ?>"><?php _e( 'Enter primary color of widget (optional):' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'primaryColor' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'primaryColor' )); ?>" type="text" value="<?php echo esc_attr( $primaryColor ); ?>" />

        <label for="<?php echo esc_attr($this->get_field_name( 'logo' )); ?>"><?php _e( 'Enter URL to your logo (optional):' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'logo' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'logo' )); ?>" type="text" value="<?php echo esc_attr( $logo ); ?>" />
     </p>
  <?php
  }

  /**
   * Sanitize widget form values as they are saved.
   *
   * @see CV_Widget_Text_Button::update()
   *
   * @param array $new_instance Values just sent to be saved.
   * @param array $old_instance Previously saved values from database.
   *
   * @return array Updated safe values to be saved.
   */
  public function update( $new_instance, $old_instance ) {
      $instance = array();
      $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : 'Buy Cryptocurrency Directly';
      $instance['label'] = ( !empty( $new_instance['label'] ) ) ? strip_tags( $new_instance['label'] ) : '';
      $instance['referenceId'] = ( !empty( $new_instance['referenceId'] ) ) ? strip_tags( $new_instance['referenceId'] ) : NULL;
      $instance['primaryColor'] = ( !empty( $new_instance['primaryColor'] ) ) ? strip_tags( $new_instance['primaryColor'] ) : NULL;
      $instance['logo'] = ( !empty( $new_instance['logo'] ) ) ? strip_tags( $new_instance['logo'] ) : NULL;

      return $instance;
  }
}
 ?>
