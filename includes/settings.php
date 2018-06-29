<?php
/**
 * Class for Widget Admin Settings
 */
if ( !class_exists( 'RA_Widgets_Animation' ) ) {
    include_once( plugin_dir_path( __FILE__ ) . 'aos.php' );
}

class RA_Widgets_Animate_Settings {
    public function __construct() {
        // Add settings page
        add_action( 'admin_menu', array( $this, 'rawa_create_settings_page' ) );

        // Add settings and fields
        add_action( 'admin_init', array( $this, 'rawa_setup_sections' ) );
        add_action( 'admin_init', array( $this, 'rawa_setup_fields' ) );

        //* Add settings link in plugins directory
        add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'rawa_plugin_action_links' ) );
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
            'aos_settings', 
            __( 'Global Settings', 'ra-widgets-animate' ),
            array( $this, 'rawa_section_callback' ),
            'rawa_settings' 
        );

        // Script Settings
        add_settings_section(
            'aos_scripts',
            __( 'Script Settings', 'ra-widgets-animate' ),
            array( $this, 'rawa_section_callback' ),
            'rawa_settings'
        );
    }

    public function rawa_section_callback( $arguments ) {
        switch( $arguments['id'] ) {
            case 'aos_settings':
                break;
            case 'aos_scripts':
                break;
        }
    }

    public function rawa_setup_fields() {
        $aos = new RA_Widgets_Animation();

        $fields = array(
            // Global Settings
            array(
                'uid' => 'rawa_aos_offset',
                'section' => 'aos_settings',
                'label' => __( 'Offset', 'ra-widgets-animate' ),
                'type' => 'number',
                'supplimental' => __( 'Change offset to trigger animations sooner or later (px)', 'ra-widgets-animate' ),
                'default' => 120,
            ),
            array(
                'uid' => 'rawa_aos_duration',
                'section' => 'aos_settings',
                'label' => __( 'Duration', 'ra-widgets-animate' ),
                'type' => 'number',
                'supplimental' => __( 'Duration of animation (ms)', 'ra-widgets-animate' ),
                'default' => 400,
            ),
            array(
                'uid' => 'rawa_aos_easing',
                'section' => 'aos_settings',
                'label' => __( 'Easing', 'ra-widgets-animate' ),
                'type' => 'select',
                'supplimental' => __( 'Choose timing function to ease elements in different ways', 'ra-widgets-animate' ),
                'default' => array( 'ease' ),
                'options' => $aos->rawa_easing()
            ),
            array(
                'uid' => 'rawa_aos_delay',
                'section' => 'aos_settings',
                'label' => __( 'Delay', 'ra-widgets-animate' ),
                'type' => 'number',
                'supplimental' => __( 'Delay animation (ms)', 'ra-widgets-animate' ),
                'default' => 0,
            ),
            array(
                'uid' => 'rawa_aos_disable',
                'section' => 'aos_settings',
                'label' => __( 'Disable', 'ra-widgets-animate' ),
                'type' => 'select',
                'supplimental' => __( 'Disable AOS on certain devices.', 'ra-widgets-animate' ),
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
                'uid' => 'rawa_aos_custom',
                'section' => 'aos_settings',
                'label' => __( 'Custom Width', 'ra-widgets-animate' ),
                'type' => 'number',
                'supplimental' => __( 'Enter the viewport width to which AOS will be disabled', 'ra-widgets-animate' ),
                'default' => 768
            ),
            array(
                'uid' => 'rawa_aos_once',
                'section' => 'aos_settings',
                'label' => __( 'Once', 'ra-widgets-animate' ),
                'type' => 'checkbox',
                'supplimental' => __( 'Choose whether animation should fire once, or every time you scroll up/down to element', 'ra-widgets-animate' ),
                'default' => array(),
                'options' => array(
                    'enabled' => __( 'Yes' )
                )
            ),

            // AoS scripts
            array(
                'uid' => 'rawa_aos_css',
                'label' => __( 'Disable style', 'ra-widgets-animate' ),
                'section' => 'aos_scripts',
                'type' => 'checkbox',
                'supplimental' => __( 'Disable Animate on Scroll stylesheet, e.g. already present on your theme or plugin', 'ra-widgets-animate' ),
                'options' => array(
                    'enabled' => __( 'Yes', 'ra-widgets-animate' )
                ),
                'default' => array()
            ),
            array(
                'uid' => 'rawa_aos_js',
                'label' => __( 'Disable script', 'ra-widgets-animate' ),
                'section' => 'aos_scripts',
                'type' => 'checkbox',
                'supplimental' => __( 'Disable Animate on Scroll script, e.g. already present on your theme or plugin', 'ra-widgets-animate' ),
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
                printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />', $arguments['uid'], $arguments['type'], $arguments['placeholder'], $value );
                break;
            case 'textarea':
                printf( '<textarea name="%1$s" id="%1$s" placeholder="%2$s" rows="5" cols="50">%3$s</textarea>', $arguments['uid'], $arguments['placeholder'], $value );
                break;
            case 'select':
            case 'multiselect':
                if( ! empty ( $arguments['options'] ) && is_array( $arguments['options'] ) ){
                    $attributes = '';
                    $options_markup = '';
                    foreach( $arguments['options'] as $key => $label ){
                        $options_markup .= sprintf( '<option value="%s" %s>%s</option>', $key, selected( $value[ array_search( $key, $value, true ) ], $key, false ), $label );
                    }
                    if( $arguments['type'] === 'multiselect' ){
                        $attributes = ' multiple="multiple" ';
                    }
                    printf( '<select name="%1$s[]" id="%1$s" %2$s>%3$s</select>', $arguments['uid'], $attributes, $options_markup );
                }
                break;
            case 'radio':
            case 'checkbox':
                if( ! empty ( $arguments['options'] ) && is_array( $arguments['options'] ) ){
                    $options_markup = '';
                    $iterator = 0;
                    foreach( $arguments['options'] as $key => $label ){
                        $iterator++;
                        $options_markup .= sprintf( '<label for="%1$s_%6$s"><input id="%1$s_%6$s" name="%1$s[]" type="%2$s" value="%3$s" %4$s /> %5$s</label><br/>', $arguments['uid'], $arguments['type'], $key, checked( $value[ array_search( $key, $value, true ) ], $key, false ), $label, $iterator );
                    }
                    printf( '<fieldset>%s</fieldset>', $options_markup );
                }
                break;
        }
        if( $helper = $arguments['helper'] ){
            printf( '<span class="helper"> %s</span>', $helper );
        }
        if( $supplimental = $arguments['supplimental'] ){
            printf( '<p class="description">%s</p>', $supplimental );
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
}

$rawas = new RA_Widgets_Animate_Settings();