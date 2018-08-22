<?php

// Register and load the widget
function dapi_load_widget() {
    register_widget( 'dapi_widget' );
}
add_action( 'widgets_init', 'dapi_load_widget' );

// Creating the widget
class dapi_widget extends WP_Widget {

    function __construct() {
        parent::__construct(

            //ID of our widget
            'dapi_widget',

            //UI widget name
            __('Dejean API', 'woocommerce-dejean-api'),

            // Widget description
            array( 'description' => __( 'A simple widget that returns a list of items from a REST API', 'woocommerce-dejean-api' ), )
        );
    }

    /**
     * Creating widget front-end
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );

        //before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];

        //Widget content
        $api = new \Dejean\Api\Dapi_Api();
        $preferences = new \Dejean\Api\Dapi_Preferences();
        $api_response = $api->getContent($preferences->load()['dapi_elements_list']);
        require(DAPI_PLUGIN_DIR.'templates/elements_list.php');
        echo $args['after_widget'];
    }

    /**
     * Widget Backend
     * @param array $instance
     * @return string|void
     */
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'Dejean API', 'woocommerce-dejean-api' );
        }
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <?php
    }

    /**
     * Updating widget replacing old instances with new
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
} // Class dapi_widget ends here