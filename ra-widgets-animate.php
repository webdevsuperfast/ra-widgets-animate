<?php
/*
Plugin Name: Widgets Animate
Plugin URI:  https://github.com/webdevsuperfast/ra-widgets-animate
Description: Animate widgets using USAL.js library.
Version:     1.1.9.1
Author:      Rotsen Mark Acob
Author URI:  https://www.rotsenacob.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: ra-widgets-animate
Domain Path: /languages
*/

defined( 'ABSPATH' ) or die( esc_html_e( 'With great power comes great responsibility.', 'ra-widgets-animate' ) );

class RA_Widgets_Animate {
    public function __construct() {
        // Add settings page
        add_action( 'admin_menu', array( $this, 'rawa_create_settings_page' ) );

        // Add settings and fields
        add_action( 'admin_init', array( $this, 'rawa_setup_sections' ) );
        add_action( 'admin_init', array( $this, 'rawa_setup_fields' ) );

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

        //* Add settings link in plugins directory
        add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'rawa_plugin_action_links' ) );

        // Migrate old settings
        $this->rawa_migrate_settings();
    }

    public function rawa_migrate_settings() {
        // Migrate AOS settings to USAL
        $old_options = array(
            'rawa_aos_offset' => 'rawa_usal_threshold',
            'rawa_aos_duration' => 'rawa_usal_duration',
            'rawa_aos_easing' => 'rawa_usal_easing',
            'rawa_aos_delay' => 'rawa_usal_delay',
            'rawa_aos_disable' => 'rawa_usal_disable',
            'rawa_aos_custom' => 'rawa_usal_custom',
            'rawa_aos_once' => 'rawa_usal_once',
            'rawa_aos_js' => 'rawa_usal_js',
        );

        foreach ( $old_options as $old => $new ) {
            $old_value = get_option( $old );
            if ( $old_value !== false && get_option( $new ) === false ) {
                // Handle array values
                if ( is_array( $old_value ) ) {
                    $old_value = $old_value[0] ?? '';
                }
                // Migrate value
                if ( $old === 'rawa_aos_offset' ) {
                    // Convert offset to threshold, roughly
                    $threshold = min( 100, max( 0, (int) $old_value / 10 ) ); // rough conversion
                    update_option( $new, $threshold );
                } elseif ( $old === 'rawa_aos_easing' ) {
                    // Map AOS easings to CSS
                    $easing_map = array(
                        'linear' => 'linear',
                        'ease' => 'ease',
                        'ease-in' => 'ease-in',
                        'ease-out' => 'ease-out',
                        'ease-in-out' => 'ease-in-out',
                        'ease-in-back' => 'cubic-bezier(0.6, -0.28, 0.735, 0.045)',
                        'ease-out-back' => 'cubic-bezier(0.175, 0.885, 0.32, 1.275)',
                        'ease-in-out-back' => 'cubic-bezier(0.68, -0.55, 0.265, 1.55)',
                        'ease-in-sine' => 'cubic-bezier(0.47, 0, 0.745, 0.715)',
                        'ease-out-sine' => 'cubic-bezier(0.39, 0.575, 0.565, 1)',
                        'ease-in-out-sine' => 'cubic-bezier(0.445, 0.05, 0.55, 0.95)',
                        'ease-in-quad' => 'cubic-bezier(0.55, 0.085, 0.68, 0.53)',
                        'ease-out-quad' => 'cubic-bezier(0.25, 0.46, 0.45, 0.94)',
                        'ease-in-out-quad' => 'cubic-bezier(0.455, 0.03, 0.515, 0.955)',
                        'ease-in-cubic' => 'cubic-bezier(0.55, 0.055, 0.675, 0.19)',
                        'ease-out-cubic' => 'cubic-bezier(0.215, 0.61, 0.355, 1)',
                        'ease-in-out-cubic' => 'cubic-bezier(0.645, 0.045, 0.355, 1)',
                        'ease-in-quart' => 'cubic-bezier(0.895, 0.03, 0.685, 0.22)',
                        'ease-out-quart' => 'cubic-bezier(0.165, 0.84, 0.44, 1)',
                        'ease-in-out-quart' => 'cubic-bezier(0.77, 0, 0.175, 1)',
                    );
                    $new_value = isset( $easing_map[$old_value] ) ? $easing_map[$old_value] : 'ease-out';
                    update_option( $new, $new_value );
                } else {
                    update_option( $new, $old_value );
                }
                // Optionally delete old option
                // delete_option( $old );
            }
        }
    }

    public function rawa_plugin_action_links( $links ) {
        $links = array_merge( array(
            '<a href="'.esc_url( admin_url( '/options-general.php?page=rawa_settings' ) ).'">'.__( 'Settings', 'ra-widgets-animate' ).'</a>'
        ), $links );

        return $links;
    }

    public function rawa_create_settings_page() {
        $page_title = __( 'RA Widgets Animate', 'ra-widgets-animate' );
        $menu_title = __( 'RA Widgets Animate', 'ra-widgets-animate' );
        $capability = 'manage_options';
        $slug = 'rawa_settings';
        $callback = array(
            $this, 
            'rawa_settings_content'
        );
        $icon = 'dashicons-admin-plugins';
        $position = 100;

        add_submenu_page( 'options-general.php', $page_title, $menu_title, $capability, $slug, $callback );
    }

    public function rawa_setup_sections() {
        // Global Settings
        add_settings_section( 
            'usal_settings', 
            __( 'Global Settings', 'ra-widgets-animate' ),
            array( $this, 'rawa_section_callback' ),
            'rawa_settings' 
        );

        // Script Settings
        add_settings_section(
            'usal_scripts',
            __( 'Script Settings', 'ra-widgets-animate' ),
            array( $this, 'rawa_section_callback' ),
            'rawa_settings'
        );
    }

    public function rawa_section_callback( $arguments ) {
        switch( $arguments['id'] ) {
            case 'usal_settings':
                break;
            case 'usal_scripts':
                break;
        }
    }

    public function rawa_setup_fields() {
        $fields = array(
            // Global Settings
            array(
                'uid' => 'rawa_usal_threshold',
                'section' => 'usal_settings',
                'label' => __( 'Threshold', 'ra-widgets-animate' ),
                'type' => 'number',
                'supplimental' => __( 'Percentage of element visible to trigger animation (0-100)', 'ra-widgets-animate' ),
                'default' => 10,
            ),
            array(
                'uid' => 'rawa_usal_duration',
                'section' => 'usal_settings',
                'label' => __( 'Duration', 'ra-widgets-animate' ),
                'type' => 'number',
                'supplimental' => __( 'Duration of animation (ms)', 'ra-widgets-animate' ),
                'default' => 1000,
            ),
            array(
                'uid' => 'rawa_usal_easing',
                'section' => 'usal_settings',
                'label' => __( 'Easing', 'ra-widgets-animate' ),
                'type' => 'select',
                'supplimental' => __( 'Choose timing function to ease elements in different ways', 'ra-widgets-animate' ),
                'default' => array( 'ease-out' ),
                'options' => array(
                    'ease' => 'ease',
                    'ease-in' => 'ease-in',
                    'ease-out' => 'ease-out',
                    'ease-in-out' => 'ease-in-out',
                    'linear' => 'linear',
                    'cubic-bezier(0.4, 0, 0.2, 1)' => 'ease-in-out-sine',
                    'cubic-bezier(0.25, 0.46, 0.45, 0.94)' => 'ease-out-back',
                    'cubic-bezier(0.55, 0.055, 0.675, 0.19)' => 'ease-in-cubic',
                    'cubic-bezier(0.895, 0.03, 0.685, 0.22)' => 'ease-out-circ',
                )
            ),
            array(
                'uid' => 'rawa_usal_delay',
                'section' => 'usal_settings',
                'label' => __( 'Delay', 'ra-widgets-animate' ),
                'type' => 'number',
                'supplimental' => __( 'Delay animation (ms)', 'ra-widgets-animate' ),
                'default' => 0,
            ),
            array(
                'uid' => 'rawa_usal_disable',
                'section' => 'usal_settings',
                'label' => __( 'Disable', 'ra-widgets-animate' ),
                'type' => 'select',
                'supplimental' => __( 'Disable USAL on certain devices.', 'ra-widgets-animate' ),
                'options' => array(
                    '' => __( 'None' ),
                    'mobile' => __( 'Mobile(Phones/Tablets)', 'ra-widgets-animate' ),
                    'phone' => __( 'Phone', 'ra-widgets-animate' ),
                    'tablet' => __( 'Tablet', 'ra-widgets-animate' ),
                    'custom' => __( 'Custom', 'ra-widgets-animate' )
                ),
                'default' => array()
            ),
            array(
                'uid' => 'rawa_usal_custom',
                'section' => 'usal_settings',
                'label' => __( 'Custom Width', 'ra-widgets-animate' ),
                'type' => 'number',
                'supplimental' => __( 'Enter the viewport width to which USAL will be disabled', 'ra-widgets-animate' ),
                'default' => 768
            ),
            array(
                'uid' => 'rawa_usal_once',
                'section' => 'usal_settings',
                'label' => __( 'Once', 'ra-widgets-animate' ),
                'type' => 'checkbox',
                'supplimental' => __( 'Choose whether animation should fire once, or every time you scroll up/down to element', 'ra-widgets-animate' ),
                'default' => array(),
                'options' => array(
                    'enabled' => __( 'Yes' )
                )
            ),

            // USAL scripts
            array(
                'uid' => 'rawa_usal_js',
                'label' => __( 'Disable script', 'ra-widgets-animate' ),
                'section' => 'usal_scripts',
                'type' => 'checkbox',
                'supplimental' => __( 'Disable USAL script, e.g. already present on your theme or plugin', 'ra-widgets-animate' ),
                'options' => array(
                    'enabled' => __( 'Yes', 'ra-widgets-animate' )
                ),
                'default' => array()
            ),
        );

        foreach( $fields as $field ) {
            add_settings_field( 
                $field['uid'], 
                $field['label'], 
                array( 
                    $this, 
                    'rawa_fields_callback' 
                ), 
                'rawa_settings', 
                $field['section'], 
                $field 
            );
            register_setting( 
                'rawa_settings', 
                $field['uid'] 
            );
        }
    }

    public function rawa_fields_callback( $arguments ) {
        $value = get_option( $arguments['uid'] );
        
        if( ! $value ) {
            $value = $arguments['default'];
        }
        
        switch( $arguments['type'] ){
            case 'text':
            case 'password':
            case 'number':
                printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />', esc_attr( $arguments['uid'] ), esc_attr( $arguments['type'] ), esc_attr( isset($arguments['placeholder']) ? $arguments['placeholder'] : '' ), esc_attr( $value ) );
                break;
            case 'textarea':
                printf( '<textarea name="%1$s" id="%1$s" placeholder="%2$s" rows="5" cols="50">%3$s</textarea>', esc_attr( $arguments['uid'] ), esc_attr( isset($arguments['placeholder']) ? $arguments['placeholder'] : '' ), esc_textarea( $value ) );
                break;
            case 'select':
            case 'multiselect':
                if( ! empty ( $arguments['options'] ) && is_array( $arguments['options'] ) ){
                    $attributes = '';
                    $options_markup = '';
                    foreach( $arguments['options'] as $key => $label ){
                        $selected = in_array( $key, (array) $value ) ? 'selected' : '';
                        $options_markup .= sprintf( '<option value="%s" %s>%s</option>', esc_attr( $key ), $selected, esc_html( $label ) );
                    }
                    if( $arguments['type'] === 'multiselect' ){
                        $attributes = ' multiple="multiple" ';
                    }
                    printf( '<select name="%1$s[]" id="%1$s" %2$s>%3$s</select>', esc_attr( $arguments['uid'] ), $attributes, $options_markup );
                }
                break;
            case 'radio':
            case 'checkbox':
                if( ! empty ( $arguments['options'] ) && is_array( $arguments['options'] ) ){
                    $options_markup = '';
                    $iterator = 0;
                    foreach( $arguments['options'] as $key => $label ){
                        $iterator++;
                        $checked = in_array( $key, (array) $value ) ? 'checked' : '';
                        $options_markup .= sprintf( '<label for="%1$s_%6$s"><input id="%1$s_%6$s" name="%1$s[]" type="%2$s" value="%3$s" %4$s /> %5$s</label><br/>', esc_attr( $arguments['uid'] ), esc_attr( $arguments['type'] ), esc_attr( $key ), $checked, esc_html( $label ), $iterator );
                    }
                    printf( '<fieldset>%s</fieldset>', $options_markup );
                }
                break;
        }
        $helper = isset($arguments['helper']) ? $arguments['helper'] : '';
        if( $helper ){
            printf( '<span class="helper"> %s</span>', esc_html( $helper ) );
        }
        $supplimental = isset($arguments['supplimental']) ? $arguments['supplimental'] : '';
        if( $supplimental ){
            printf( '<p class="description">%s</p>', esc_html( $supplimental ) );
        }
    }

    public function rawa_settings_content() { ?>
        <?php 
        if ( ! current_user_can( 'manage_options' ) ) return; 
        ?>

        <div class="wrap">
            <h2><?php _e( 'RA Widgets Animate Settings', 'ra-widgets-animate' ); ?></h2>
            <hr>
            <form action="options.php" method="post">
                <?php 
                settings_fields( 'rawa_settings' ); 
                do_settings_sections( 'rawa_settings' );
                submit_button();
                ?>
            </form>
        </div>
        
    <?php }

    public function rawa_in_widget_form( $t, $return, $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '', 'animation' => '', 'anchor' => '', 'anchor-placement' => '', 'easing' => '', 'offset' => '', 'duration' => '', 'delay' => '', 'once' => '' ) );

        // Animation
        $animations = $this->rawa_animations();

        // Placement
        $placements = $this->rawa_placements();

        // Easing
        $easing = $this->rawa_easing();

        if ( !isset( $instance['animation'] ) ) $instance['animation'] = null;
        if ( !isset( $instance['anchor'] ) ) $instance['anchor'] = null;
        if ( !isset( $instance['anchor-placement'] ) ) $instance['anchor-placement'] = null;
        if ( !isset( $instance['easing'] ) ) $instance['easing'] = null;
        if ( !isset( $instance['offset'] ) ) $instance['offset'] = null;
        if ( !isset( $instance['duration'] ) ) $instance['duration'] = null;
        if ( !isset( $instance['delay'] ) ) $instance['delay'] = null;
        if ( !isset( $instance['once'] ) ) $instance['once'] = 0;
        ?>
        <div class="rawa-clearfix"></div>
        <div class="rawa-fields">
            <h3 class="rawa-toggle"><?php _e( 'Animation Settings', 'ra-widgets-animate' ); ?></h3>
            <div class="rawa-field" style="display: none;">
                <p>
                    <label for="<?php echo $t->get_field_id('animation'); ?>"><?php _e( 'Animation:', 'ra-widgets-animate' ); ?></label>
                    <select class="widefat" id="<?php echo $t->get_field_id('animation'); ?>" name="<?php echo $t->get_field_name('animation'); ?>">
                        <?php foreach( $animations as $key => $value ) { ?>
                            <option <?php selected( $instance['animation'], $key ); ?>value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    </select>
                    <span><em><?php _e( 'Choose from several predefined animations.', 'ra-widgets-animate' ); ?></em></span>
                </p>
                <p>
                    <label for="<?php echo $t->get_field_id('anchor'); ?>"><?php _e( 'Anchor:', 'ra-widgets-animate' ); ?></label>
                    <input class="widefat" id="<?php echo $t->get_field_id('anchor'); ?>" name="<?php echo $t->get_field_name('anchor'); ?>" value="<?php echo esc_attr($instance['anchor']); ?>" type="text" />
                    <span><em><?php _e( 'Anchor element, whose offset will be counted to trigger animation instead of actual elements offset.', 'ra-widgets-animate' ); ?></em></span>
                </p>
                <p>
                    <label for="<?php echo $t->get_field_id('anchor-placement'); ?>"><?php _e( 'Anchor Placement:', 'ra-widgets-animate' ); ?></label>
                    <select class="widefat" id="<?php echo $t->get_field_id('anchor-placement'); ?>" name="<?php echo $t->get_field_name('anchor-placement'); ?>">
                        <?php foreach( $placements as $key => $value ) { ?>
                            <option <?php selected( $instance['anchor-placement'], $key ); ?>value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    </select>
                    <span><em><?php _e( 'Select which position of element on the screen should trigger animation.', 'ra-widgets-animate' ); ?></em></span>
                </p>
                <p>
                    <label for="<?php echo $t->get_field_id('easing'); ?>"><?php _e( 'Easing:', 'ra-widgets-animate' ); ?></label>
                    <select class="widefat" id="<?php echo $t->get_field_id('easing'); ?>" name="<?php echo $t->get_field_name('easing'); ?>">
                        <?php foreach( $easing as $key => $value ) { ?>
                            <option <?php selected( $instance['easing'], $key ); ?>value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    </select>
                    <span><em><?php _e( 'Choose timing function to ease elements in different ways.', 'ra-widgets-animate' ); ?></em></span>
                </p>
                <p>
                    <label for="<?php echo $t->get_field_id('offset'); ?>"><?php _e( 'Offset:', 'ra-widgets-animate' ); ?></label>
                    <input class="widefat" id="<?php echo $t->get_field_id('offset'); ?>" name="<?php echo $t->get_field_name('offset'); ?>" value="<?php echo esc_attr($instance['offset']); ?>" type="number" />
                    <span><em><?php _e( 'Change offset to trigger animations sooner or later (px).', 'ra-widgets-animate' ); ?></em></span>
                </p>
                <p>
                    <label for="<?php echo $t->get_field_id('duration'); ?>"><?php _e( 'Duration:', 'ra-widgets-animate' ); ?></label>
                    <input class="widefat" id="<?php echo $t->get_field_id('duration'); ?>" name="<?php echo $t->get_field_name('duration'); ?>" value="<?php echo esc_attr($instance['duration']); ?>" type="number" />
                    <span><em><?php _e( 'Duration of animation (ms).', 'ra-widgets-animate' ); ?></em></span>
                </p>
                <p>
                    <label for="<?php echo $t->get_field_id('delay'); ?>"><?php _e( 'Delay:', 'ra-widgets-animate' ); ?></label>
                    <input class="widefat" id="<?php echo $t->get_field_id('delay'); ?>" name="<?php echo $t->get_field_name('delay'); ?>" value="<?php echo esc_attr($instance['delay']); ?>" type="number" />
                    <span><em><?php _e( 'Delay animation (ms).', 'ra-widgets-animate' ); ?></em></span>
                </p>
                <p>
                    <label for="<?php echo $t->get_field_id('once'); ?>"><?php _e( 'Once:', 'ra-widgets-animate' ); ?>
                    <input id="<?php echo $t->get_field_id('once'); ?>" name="<?php echo $t->get_field_name('once'); ?>" type="checkbox"<?php checked($instance['once']); ?> />
                    <span><em><?php _e( 'Choose whether animation should fire once, or every time you scroll up/down to element.', 'ra-widgets-animate' ); ?></em></span>
                    </label>
                </p>
            </div>

        </div>
        <?php

        $return = null;

        return array( $t, $return, $instance );
    }

    public function rawa_in_widget_form_update( $instance, $new_instance, $old_instance ) {
        $instance['animation'] = sanitize_text_field( $new_instance['animation'] );
        $instance['anchor'] = sanitize_text_field( $new_instance['anchor'] );
        $instance['anchor-placement'] = sanitize_text_field( $new_instance['anchor-placement'] );
        $instance['easing'] = sanitize_text_field( $new_instance['easing'] );
        $instance['offset'] = (int) $new_instance['offset'];
        $instance['duration'] = (int) $new_instance['duration'];
        $instance['delay'] = (int) $new_instance['delay'];
        $instance['once'] = isset($new_instance['once']) && $new_instance['once'] ? 1 : 0;

        return $instance;
    }

    public function rawa_dynamic_sidebar_params( $params ) {
        global $wp_registered_widgets;

        $widget_id = $params[0]['widget_id'];
        $widget_obj = $wp_registered_widgets[$widget_id];
        $widget_opt = get_option( $widget_obj['callback'][0]->option_name );
        $widget_num = $widget_obj['params'][0]['number'];

        $usal_parts = array();

        if ( isset( $widget_opt[$widget_num]['animation'] ) && !empty( $widget_opt[$widget_num]['animation'] ) ) {
            $animation = $widget_opt[$widget_num]['animation'];
            $usal_animation = $this->rawa_map_animation( $animation );
            $usal_parts[] = $usal_animation;
        }

        if ( isset( $widget_opt[$widget_num]['duration'] ) && !empty( $widget_opt[$widget_num]['duration'] ) ) {
            $usal_parts[] = 'duration-' . (int) $widget_opt[$widget_num]['duration'];
        }

        if ( isset( $widget_opt[$widget_num]['delay'] ) && !empty( $widget_opt[$widget_num]['delay'] ) ) {
            $usal_parts[] = 'delay-' . (int) $widget_opt[$widget_num]['delay'];
        }

        if ( isset( $widget_opt[$widget_num]['easing'] ) && !empty( $widget_opt[$widget_num]['easing'] ) ) {
            $usal_parts[] = 'easing-' . esc_attr( $widget_opt[$widget_num]['easing'] );
        }

        if ( isset( $widget_opt[$widget_num]['once'] ) && $widget_opt[$widget_num]['once'] == 'true' ) {
            $usal_parts[] = 'once';
        }

        if ( !empty( $usal_parts ) ) {
            $usal_value = implode( ' ', $usal_parts );
            $attr_string = ' data-usal="' . esc_attr( $usal_value ) . '">';

            $params[0]['before_widget'] = preg_replace( '/>$/', $attr_string, $params[0]['before_widget'], 1 );
        }

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
        // Animation
        $animations = $this->rawa_animations();

        // Placement
        $placements = $this->rawa_placements();

        // Easing
        $easing = $this->rawa_easing();

        $duration = array();

        foreach( range(0, 2000, 100) as $number ) {
            $duration[$number] = $number;
        }

        $fields['animation_type'] =  array(
            'name' => __( 'Type', 'ra-widgets-animate' ),
            'type' => 'select',
            'options' => (array) $animations,
            'group' => 'animation',
            'description' => __( 'Choose from several predefined animations.', 'ra-widgets-animate' ),
            'priority' => 5
        );

        $fields['animation_anchor'] = array(
            'name' => __( 'Anchor', 'ra-widgets-animate' ),
            'type' => 'text',
            'group' => 'animation',
            'description' => __( 'Anchor element, whose offset will be counted to trigger animation instead of actual elements offset.', 'ra-widgets-animate' ),
            'priority' => 10
        );

        $fields['anchor_placement'] = array(
            'name' => __( 'Anchor Placement', 'ra-widgets-animate' ),
            'type' => 'select',
            'options' => (array) $placements,
            'group' => 'animation',
            'description' => __( 'Select which position of element on the screen should trigger animation.', 'ra-widgets-animate' ),
            'priority' => 15
        );

        $fields['animation_easing'] = array(
            'name' => __( 'Easing', 'ra-widgets-animate' ),
            'type' => 'select',
            'options' => (array) $easing,
            'group' => 'animation',
            'description' => __( 'Choose timing function to ease elements in different ways.', 'ra-widgets-animate' ),
            'priority' => 15
        );

        $fields['animation_offset'] = array(
            'name' => __( 'Threshold', 'ra-widgets-animate' ),
            'type' => 'text',
            'group' => 'animation',
            'description' => __( 'Percentage of element visible to trigger animation (0-100).', 'ra-widgets-animate' ),
            'priority' => 20
        );

        $fields['animation_duration'] = array(
            'name' => __( 'Duration', 'ra-widgets-animate' ),
            'type' => 'text',
            'group' => 'animation',
            'description' => __( 'Duration of animation (ms).', 'ra-widgets-animate' ),
            'priority' => 25
        );

        $fields['animation_delay'] = array(
            'name' => __( 'Delay', 'ra-widgets-animate' ),
            'type' => 'text',
            'group' => 'animation',
            'description' => __( 'Delay animation (ms).', 'ra-widgets-animate' ),
            'priority' => 30
        );

        $fields['animation_once'] = array(
            'name' => __( 'Once', 'ra-widgets-animate' ),
            'type' => 'checkbox',
            'group' => 'animation',
            'description' => __( 'Choose whether animation should fire once, or every time you scroll up/down to element.', 'ra-widgets-animate' ),
            'priority' => 35
        );

        return $fields;
    }

    public function rawa_siteorigin_style_attributes( $atts, $value ) {
        if ( empty( $value['animation_type'] ) ) {
            return $atts;
        }

        $usal_parts = array();

        if ( !empty( $value['animation_type'] ) ) {
            $usal_animation = $this->rawa_map_animation( $value['animation_type'] );
            $usal_parts[] = $usal_animation;
        }

        if ( !empty( $value['animation_duration'] ) && '0' != $value['animation_duration'] ) {
            $usal_parts[] = 'duration-' . (int) $value['animation_duration'];
        }

        if ( !empty( $value['animation_delay'] ) ) {
            $usal_parts[] = 'delay-' . (int) $value['animation_delay'];
        }

        if ( !empty( $value['animation_easing'] ) ) {
            $usal_parts[] = 'easing-' . esc_attr( $value['animation_easing'] );
        }

        if ( !empty( $value['animation_once'] ) ) {
            $usal_parts[] = 'once';
        }

        if ( !empty( $usal_parts ) ) {
            $atts['data-usal'] = implode( ' ', $usal_parts );
        }

        return $atts;
    }

    public function rawa_enqueue_scripts() {
        $scripts = get_option( 'rawa_usal_js' );

        if (!is_array($scripts)) $scripts = array();

        if ( !is_admin() ) {
            // USAL JS
            wp_register_script( 'rawa-usal-js', 'https://cdn.usal.dev/latest', array(), null, true );
            if ( !isset($scripts[0]) || $scripts[0] != 'enabled' ) {
                wp_enqueue_script( 'rawa-usal-js' );
            }

            // Initialize USAL
            wp_register_script( 'rawa-app-js', plugin_dir_url( __FILE__ ) . 'public/js/rawa.min.js', array( 'jquery' ), null, true );
            wp_enqueue_script( 'rawa-app-js' );

            $threshold = get_option( 'rawa_usal_threshold', '10' );
            $duration = get_option( 'rawa_usal_duration', '1000' );
            $easing = get_option( 'rawa_usal_easing', 'ease-out' );
            $delay = get_option( 'rawa_usal_delay', 0 );
            $disable = get_option( 'rawa_usal_disable', false );
            $custom = get_option( 'rawa_usal_custom', '768' );
            $once = get_option( 'rawa_usal_once' );

            if (!is_array($disable)) $disable = array();
            if (!is_array($once)) $once = array();

            wp_localize_script( 'rawa-app-js', 'rawa_usal', array(
                'threshold' => (int) $threshold,
                'duration' => (int) $duration,
                'easing' => $easing,
                'delay' => (int) $delay,
                'disable' => isset($disable[0]) && $disable[0] ? $disable[0] : "false",
                'custom' => (int) $custom,
                'once' => isset($once[0]) && $once[0] == 'enabled' ? true : false
            ) );
        }
    }

    public function rawa_admin_enqueue_scripts() {
        //Get current page
        $current_page = get_current_screen();

        //Only load if we are not on the widget page - where some of our scripts seem to be conflicting
        if ( $current_page->id === 'widgets' || is_customize_preview() ){
            wp_enqueue_style( 'rawa-admin-css', plugin_dir_url( __FILE__ ) . 'admin/css/rawa-admin.css' );

            wp_register_script( 'rawa-admin-js', plugin_dir_url( __FILE__ ) . 'admin/js/rawa-admin.min.js', array( 'jquery' ), null, true );
            wp_enqueue_script( 'rawa-admin-js' );
        }

        if ( $current_page->id === 'settings_page_rawa_settings' ) {
            wp_register_script( 'rawa-settings-js', plugin_dir_url( __FILE__ ) . 'admin/js/rawa-settings.min.js', array( 'jquery' ), null, true );
            wp_enqueue_script( 'rawa-settings-js' );
        }
    }

    public function rawa_siteorigin_panels_admin_scripts() {
        wp_register_script( 'rawa-siteorigin-panels-js', plugin_dir_url( __FILE__ ) . 'admin/js/siteorigin-admin.min.js', array( 'jquery' ), null, true );
        wp_enqueue_script( 'rawa-siteorigin-panels-js' );
    }

    function rawa_animations() {
        // Animations
        $animations = array(
            '' => __( 'No Animation' ),
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

        return apply_filters( 'rawa_animations', $animations );
    }

    function rawa_map_animation( $aos_animation ) {
        $map = array(
            'fade' => 'fade',
            'fade-up' => 'fade-u',
            'fade-down' => 'fade-d',
            'fade-left' => 'fade-l',
            'fade-right' => 'fade-r',
            'fade-up-right' => 'fade-ur',
            'fade-up-left' => 'fade-ul',
            'fade-down-right' => 'fade-dr',
            'fade-down-left' => 'fade-dl',
            'flip-up' => 'flip-u',
            'flip-down' => 'flip-d',
            'flip-left' => 'flip-l',
            'flip-right' => 'flip-r',
            'slide-up' => 'slide-u',
            'slide-down' => 'slide-d',
            'slide-left' => 'slide-l',
            'slide-right' => 'slide-r',
            'zoom-in' => 'zoomin',
            'zoom-in-up' => 'zoomin-u',
            'zoom-in-down' => 'zoomin-d',
            'zoom-in-left' => 'zoomin-l',
            'zoom-in-right' => 'zoomin-r',
            'zoom-out' => 'zoomout',
            'zoom-out-up' => 'zoomout-u',
            'zoom-out-down' => 'zoomout-d',
            'zoom-out-left' => 'zoomout-l',
            'zoom-out-right' => 'zoomout-r',
        );
        return isset( $map[$aos_animation] ) ? $map[$aos_animation] : $aos_animation;
    }

    function rawa_placements() {
        // Anchor Placements
        $placements = array(
            '' => __( 'Default' ),
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

        return $placements;
    }

    function rawa_easing() {
        // Easing
        $easing = array(
            '' => __( 'Default' ),
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

        return $easing;
    }
}

new RA_Widgets_Animate();