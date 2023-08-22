<?php if ( ! defined( 'ABSPATH' ) ) exit;

class PBD_MTJ_Shortcode {

    public function __construct() {
        add_shortcode('mtj_quiz_form', array( $this, 'mtj_quiz_function'), 10 );
        add_action( 'wp_enqueue_scripts', array($this, 'enqueue_custom_styles') );
    }
    public function enqueue_custom_styles() {
        wp_enqueue_style( 'mtj-style', PBD_SA_URL. '/includes/assets/css/style.css', array(), '1.0', 'all' );
        wp_enqueue_style( 'rubik-font', 'https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700;800;900&display=swap');
    }
    public function mtj_quiz_function($atts){
        // Extract shortcode attributes
        $attributes = shortcode_atts(
            array(
                'id' => '',
            ),
            $atts
        );
        ob_start();
        ?>
            <div class="mtj_container">
                <div class="mtj_form">
                    <?php echo do_shortcode('[gravityform id="'.$attributes['id'].'" title="true" description="true"]');?>
                </div>
            </div>
        <?php
        return ob_get_clean();
    }

}

new PBD_MTJ_Shortcode;

