<?php
/**
 * Class for Animate on Scroll options
 */
if ( !class_exists( 'RA_Widgets_Animation' ) ) {
    class RA_Widgets_Animation {
        public function __construct() {}
            
        public function rawa_animations() {
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
    
        public function rawa_placements() {
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
    
        public function rawa_easing() {
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
}