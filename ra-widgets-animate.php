<?php
/*
Plugin Name: RA Widgets Animate
Plugin URI:  https://github.com/webdevsuperfast/ra-widgets-animate
Description: Animate widgets using Animate on Scroll library.
Version:     1.0.2
Author:      Rotsen Mark Acob
Author URI:  https://rotsenacob.com/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: ra-widgets-animate
Domain Path: /languages
*/

defined( 'ABSPATH' ) or die( esc_html_e( 'With great power comes great responsibility.', 'ra-widgets-animate' ) );

class RA_Widgets_Animate {
    public function __construct() {
        // Add input fields
        add_action( 'in_widget_form', array( $this, 'rawa_in_widget_form' ), 5, 3 );

        // Callback function for options update
        add_filter( 'widget_update_callback', array( $this, 'rawa_in_widget_form_update' ), 5, 3 );

        // Add data attributes
        add_filter( 'dynamic_sidebar_params', array( $this, 'rawa_dynamic_sidebar_params' ) );

        // Enqueue scripts
        add_action( 'wp_enqueue_scripts', array( $this, 'rawa_enqueue_scripts' ) );

        // Filter SiteOrigin Panels Widget Style Groups
        add_filter( 'siteorigin_panels_widget_style_groups', array( $this, 'rawa_siteorigin_style_groups' ), 2, 3 );

        // Filter SiteOrigin Panels Widget Style Fields
        add_filter( 'siteorigin_panels_widget_style_fields', array( $this, 'rawa_siteorigin_style_fields' ), 1, 3 );

        // Filter SiteOrigin Panels Widget Style Attributes
        add_filter( 'siteorigin_panels_widget_style_attributes', array( $this, 'rawa_siteorigin_style_attributes' ), 1, 2 );

        // Enqueue Admin scripts
        add_action( 'admin_enqueue_scripts', array( $this, 'rawa_admin_enqueue_scripts' ) );

        // Enqueue SiteOrigin Panels Admin scripts
        add_action( 'siteorigin_panel_enqueue_admin_scripts', array( $this, 'rawa_siteorigin_panels_admin_scripts' ) );
    }

    public function rawa_in_widget_form( $t, $return, $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '', 'animation' => '', 'anchor' => '', 'easing' => '', 'duration' => '' ) );

        // Animations
        $animations = array(
            // Fade Animations
            'fade' => __( 'Fade' ),
            'fade-up' => __( 'Fade Up' ),
            'fade-down' => __( 'Fade Down' ),
            'fade-left' => __( 'Fade Left' ),
            'fade-right' => __( 'Fade Right' ),
            'fade-up-right' => __( 'Fade Up Right' ),
            'fade-up-left' => __( 'Fade Up Left' ),
            'fade-down-right' => __( 'Fade Down Right' ),
            'fade-down-left' => __( 'Fade Down Left' ),
            // Flip Animations
            'flip-up' => __( 'Flip Up' ),
            'flip-down' => __( 'Flip Down' ),
            'flip-left' => __( 'Flip Left' ),
            'flip-right' => __( 'Flip Right' ),
            //Slide Animations
            'slide-up' => __( 'Slide Up' ),
            'slide-down' => __( 'Slide Down' ),
            'slide-left' => __( 'Slide Left' ),
            'slide-right' => __( 'Slide Right' ),
            // Zoom Animations
            'zoom-in' => __( 'Zoom In' ),
            'zoom-in-up' => __( 'Zoom In Up' ),
            'zoom-in-down' => __( 'Zoom In Down' ),
            'zoom-in-left' => __( 'Zoom In Left' ),
            'zoom-in-right' => __( 'Zoom In Right' ),
            'zoom-out' => __( 'Zoom In' ),
            'zoom-out-up' => __( 'Zoom In Up' ),
            'zoom-out-down' => __( 'Zoom In Down' ),
            'zoom-out-left' => __( 'Zoom In Left' ),
            'zoom-out-right' => __( 'Zoom In Right' ),
        );

        // Anchor Placements
        $placements = array(
            'top-bottom' => __( 'Top Bottom' ),
            'top-center' => __( 'Top Center' ),
            'top-top' => __( 'Top Top' ),
            'center-bottom' => __( 'Center Bottom' ),
            'center-center' => __( 'Center Center' ),
            'center-top' => __( 'Center Top' ),
            'bottom-bottom' => __( 'Bottom Bottom' ),
            'bottom-center' => __( 'Bottom Center' ),
            'bottom-top' => __( 'Bottom Top' )
        );

        // Easing
        $easing = array(
            'linear' => __( 'Linear' ),
            'ease' => __( 'Ease' ),
            'ease-in' => __( 'Ease In' ),
            'ease-out' => __( 'Ease Out' ),
            'ease-in-out' => __( 'Ease In Out' ),
            'ease-in-back' => __( 'Ease In Back' ),
            'ease-out-back' => __( 'Ease Out Back' ),
            'ease-in-out-back' => __( 'Ease In Out Back' ),
            'ease-in-sine' => __( 'Ease In Sine' ),
            'ease-out-sine' => __( 'Ease Out Sine' ),
            'ease-in-out-sine' => __( 'Ease In Out Sine' ),
            'ease-in-quad' => __( 'Ease In Quad' ),
            'ease-out-quad' => __( 'Ease Out Quad' ),
            'ease-in-out-quad' => __( 'Ease In Out Quad' ),
            'ease-in-cubic' => __( 'Ease In Cubic' ),
            'ease-out-cubic' => __( 'Ease Out Cubic' ),
            'ease-in-out-cubic' => __( 'Ease In Out Cubic' ),
            'ease-in-quart' => __( 'Ease In Quart' ),
            'ease-out-quart' => __( 'Ease Out Quart' ),
            'ease-in-out-quart' => __( 'Ease In Out Quart' )
        );
        
        if ( !isset( $instance['animation'] ) ) $instance['animation'] = null; 
        if ( !isset( $instance['anchor'] ) ) $instance['anchor'] = null;
        if ( !isset( $instance['easing'] ) ) $instance['easing'] = null;
        if ( !isset( $instance['duration'] ) ) $instance['duration'] = null;
        ?>
        <div class="rawa-clearfix"></div>
        <div class="rawa-fields">
            <p><strong>Animation Settings</strong></p>
            <hr>
            <p>
                <label for="<?php echo $t->get_field_id('animation'); ?>">Animation:</label>
                <select id="<?php echo $t->get_field_id('animation'); ?>" name="<?php echo $t->get_field_name('animation'); ?>">
                    <option <?php selected($instance['animation'], '');?> value="">None</option>
                    <?php foreach( $animations as $key => $value ) { ?>
                        <option <?php selected( $instance['animation'], $key ); ?>value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php } ?>
                </select>
            </p>
            <p>
                <label for="<?php echo $t->get_field_id('anchor'); ?>">Anchor Placement:</label>
                <select id="<?php echo $t->get_field_id('anchor'); ?>" name="<?php echo $t->get_field_name('anchor'); ?>">
                    <option <?php selected($instance['anchor'], '');?> value="">None</option>
                    <?php foreach( $placements as $key => $value ) { ?>
                        <option <?php selected( $instance['anchor'], $key ); ?>value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php } ?>
                </select>
            </p>
            <p>
                <label for="<?php echo $t->get_field_id('easing'); ?>">Easing:</label>
                <select id="<?php echo $t->get_field_id('easing'); ?>" name="<?php echo $t->get_field_name('easing'); ?>">
                    <option <?php selected($instance['easing'], '');?> value="">None</option>
                    <?php foreach( $easing as $key => $value ) { ?>
                        <option <?php selected( $instance['easing'], $key ); ?>value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php } ?>
                </select>
            </p>
            <p>
                <label for="<?php echo $t->get_field_id('duration'); ?>">Duration:</label>
                <select id="<?php echo $t->get_field_id('duration'); ?>" name="<?php echo $t->get_field_name('duration'); ?>">
                    <option <?php selected($instance['duration'], '');?> value="">None</option>
                    <?php foreach( range(0, 2000, 100) as $number ) { ?>
                        <option <?php selected( $instance['duration'], $number ); ?>value="<?php echo $number; ?>"><?php echo $number; ?></option>
                    <?php } ?>
                </select>
            </p>
        </div>
        <?php
        
        $return = null;
        
        return array( $t, $return, $instance );
    }

    public function rawa_in_widget_form_update( $instance, $new_instance, $old_instance ) {
        $instance['animation'] = $new_instance['animation'];
        $instance['anchor'] = $new_instance['anchor'];
        $instance['easing'] = $new_instance['easing'];
        $instance['duration'] = $new_instance['duration'];
        
        return $instance;
    }

    public function rawa_dynamic_sidebar_params( $params ) {
        global $wp_registered_widgets;

        $widget_id = $params[0]['widget_id'];
        $widget_obj = $wp_registered_widgets[$widget_id];
        $widget_opt = get_option( $widget_obj['callback'][0]->option_name );
        $widget_num = $widget_obj['params'][0]['number'];

        $attrs = array();
        
        if ( isset( $widget_opt[$widget_num]['anchor'] ) && !empty( $widget_opt[$widget_num]['anchor'] ) ) $attrs['data-aos-anchor-placement'] = $widget_opt[$widget_num]['anchor'];
        
        if ( isset( $widget_opt[$widget_num]['animation'] ) && !empty( $widget_opt[$widget_num]['animation'] ) ) $attrs['data-aos'] = $widget_opt[$widget_num]['animation'];
        
        if ( isset( $widget_opt[$widget_num]['easing'] ) && !empty( $widget_opt[$widget_num]['easing'] ) ) $attrs['data-aos-easing'] = $widget_opt[$widget_num]['easing'];

        if ( isset( $widget_opt[$widget_num]['duration'] ) && !empty( $widget_opt[$widget_num]['duration'] ) ) $attrs['data-aos-duration'] = $widget_opt[$widget_num]['duration'];

        $attr = '';
        foreach( $attrs as $key => $value ) {
            $attr .= $key . '="' . $value .'" ';
        }
        $attr .= '>';

        $params[0]['before_widget'] = preg_replace( '/>/', $attr,  $params[0]['before_widget'], 1 );
        
        return $params;
    }

    public function rawa_siteorigin_style_groups( $groups ) {
        $groups['animation'] = array(
            'name' => __( 'Animation', 'ra-widgets-animate' ),
            'priority' => 30
        );

        return $groups;
    }

    public function rawa_siteorigin_style_fields( $fields ) {
        // Animations
        $animations = array(
            '' => __( 'No animation' ),
            // Fade Animations
            'fade' => __( 'Fade' ),
            'fade-up' => __( 'Fade Up' ),
            'fade-down' => __( 'Fade Down' ),
            'fade-left' => __( 'Fade Left' ),
            'fade-right' => __( 'Fade Right' ),
            'fade-up-right' => __( 'Fade Up Right' ),
            'fade-up-left' => __( 'Fade Up Left' ),
            'fade-down-right' => __( 'Fade Down Right' ),
            'fade-down-left' => __( 'Fade Down Left' ),
            // Flip Animations
            'flip-up' => __( 'Flip Up' ),
            'flip-down' => __( 'Flip Down' ),
            'flip-left' => __( 'Flip Left' ),
            'flip-right' => __( 'Flip Right' ),
            //Slide Animations
            'slide-up' => __( 'Slide Up' ),
            'slide-down' => __( 'Slide Down' ),
            'slide-left' => __( 'Slide Left' ),
            'slide-right' => __( 'Slide Right' ),
            // Zoom Animations
            'zoom-in' => __( 'Zoom In' ),
            'zoom-in-up' => __( 'Zoom In Up' ),
            'zoom-in-down' => __( 'Zoom In Down' ),
            'zoom-in-left' => __( 'Zoom In Left' ),
            'zoom-in-right' => __( 'Zoom In Right' ),
            'zoom-out' => __( 'Zoom In' ),
            'zoom-out-up' => __( 'Zoom In Up' ),
            'zoom-out-down' => __( 'Zoom In Down' ),
            'zoom-out-left' => __( 'Zoom In Left' ),
            'zoom-out-right' => __( 'Zoom In Right' ),
        );

        // Anchor Placements
        $placements = array(
            '' => __( 'No Placement' ),
            'top-bottom' => __( 'Top Bottom' ),
            'top-center' => __( 'Top Center' ),
            'top-top' => __( 'Top Top' ),
            'center-bottom' => __( 'Center Bottom' ),
            'center-center' => __( 'Center Center' ),
            'center-top' => __( 'Center Top' ),
            'bottom-bottom' => __( 'Bottom Bottom' ),
            'bottom-center' => __( 'Bottom Center' ),
            'bottom-top' => __( 'Bottom Top' )
        );

        // Easing
        $easing = array(
            '' => __( 'No Easing' ),
            'linear' => __( 'Linear' ),
            'ease' => __( 'Ease' ),
            'ease-in' => __( 'Ease In' ),
            'ease-out' => __( 'Ease Out' ),
            'ease-in-out' => __( 'Ease In Out' ),
            'ease-in-back' => __( 'Ease In Back' ),
            'ease-out-back' => __( 'Ease Out Back' ),
            'ease-in-out-back' => __( 'Ease In Out Back' ),
            'ease-in-sine' => __( 'Ease In Sine' ),
            'ease-out-sine' => __( 'Ease Out Sine' ),
            'ease-in-out-sine' => __( 'Ease In Out Sine' ),
            'ease-in-quad' => __( 'Ease In Quad' ),
            'ease-out-quad' => __( 'Ease Out Quad' ),
            'ease-in-out-quad' => __( 'Ease In Out Quad' ),
            'ease-in-cubic' => __( 'Ease In Cubic' ),
            'ease-out-cubic' => __( 'Ease Out Cubic' ),
            'ease-in-out-cubic' => __( 'Ease In Out Cubic' ),
            'ease-in-quart' => __( 'Ease In Quart' ),
            'ease-out-quart' => __( 'Ease Out Quart' ),
            'ease-in-out-quart' => __( 'Ease In Out Quart' )
        );

        $duration = array();

        foreach( range(0, 2000, 100) as $number ) {
            $duration[$number] = $number;
        }

        $fields['animation_type'] =  array(
            'name' => __( 'Type', 'ra-widgets-animate' ),
            'type' => 'select',
            'options' => (array) $animations,
            'group' => 'animation',
            'description' => __( '', 'ra-widgets-animate' ),
            'priority' => 5
        );

        $fields['anchor_placement'] = array(
            'name' => __( 'Anchor Placement', 'ra-widgets-animate' ),
            'type' => 'select',
            'options' => (array) $placements,
            'group' => 'animation',
            'description' => __( '', 'ra-widgets-animate' ),
            'priority' => 10
        );

        $fields['animation_easing'] = array(
            'name' => __( 'Easing', 'ra-widgets-animate' ),
            'type' => 'select',
            'options' => (array) $easing,
            'group' => 'animation',
            'description' => __( '', 'ra-widgets-animate' ),
            'priority' => 15
        );

        $fields['animation_duration'] = array(
            'name' => __( 'Duration', 'ra-widgets-animate' ),
            'type' => 'select',
            'options' => (array) $duration,
            'group' => 'animation',
            'description' => __( '', 'ra-widgets-animate' ),
            'priority' => 15
        );

        return $fields;
    }

    public function rawa_siteorigin_style_attributes( $atts, $value ) {
        if ( empty( $value['animation_type'] ) ) {
            return $atts;
        }

        if ( !empty( $value['animation_type'] ) ) {
            $atts['data-aos'] = $value['animation_type'];
        }

        if ( !empty( $value['anchor_placement'] ) ) {
            $atts['data-aos-anchor-placement'] = $value['anchor_placement'];
        }

        if ( !empty( $value['animation_easing'] ) ) {
            $atts['data-aos-easing'] = $value['animation_easing'];
        }

        if ( !empty( $value['animation_duration'] ) && '0' != $value['animation_duration'] ) {
            $atts['data-aos-duration'] = $value['animation_duration'];
        }

        return $atts;
    }

    public function rawa_enqueue_scripts() {
        if ( !is_admin() ) {
            // AOS CSS
            wp_enqueue_style( 'rawa-aos-css', plugin_dir_url( __FILE__ ) . 'public/css/app.css' );

            // AOS JS
            wp_register_script( 'rawa-aos-js', plugin_dir_url( __FILE__ ) . 'public/js/aos.min.js', array(), null, true );
            wp_enqueue_script( 'rawa-aos-js' );
            
            // Initialize AOS
            wp_add_inline_script( 'rawa-aos-js', 'AOS.init()' );
        }
    }

    public function rawa_admin_enqueue_scripts() {
        //Get current page
        $current_page = get_current_screen();

        //Only load if we are not on the widget page - where some of our scripts seem to be conflicting
        if ( $current_page->id === 'widgets' ){
            wp_enqueue_style( 'rawa-admin-css', plugin_dir_url( __FILE__ ) . 'admin/css/admin.css' );
        }
    }

    public function rawa_siteorigin_panels_admin_scripts() {
        wp_register_script( 'rawa-siteorigin-panels-js', plugin_dir_url( __FILE__ ) . 'admin/js/admin.js', array( 'jquery' ), null, true );
        wp_enqueue_script( 'rawa-siteorigin-panels-js' );
    }
}

new RA_Widgets_Animate();