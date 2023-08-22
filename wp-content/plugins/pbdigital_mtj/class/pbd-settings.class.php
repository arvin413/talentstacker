<?php if ( ! defined( 'ABSPATH' ) ) exit;

class PBD_MTJ_Settings {

    public function __construct() {
        add_action('admin_menu', array( $this, 'admin_menus'), 10 );
        add_action('admin_init', array( $this, 'register_settings' ));
        add_action( 'init', array($this, 'wpdocs_personalise_pdf') );
        // add_action('add_meta_boxes', array($this, 'add_custom_metabox'));
        // add_action('save_post', array($this, 'save_custom_metabox_data'));
        add_filter('single_template', array($this, 'load_custom_template'));
    }

    public function register_settings() {
        register_setting( 'pbd_sa_settings', 'pbd_sa_settings', '' );
        register_setting( 'pdat_googleapi_settings', 'pdat_googleapi_settings', '' );
    }

    public function admin_menus(){
        add_submenu_page( 
            'options-general.php', 
            'Personalize PDF', 
            'Personalize PDF', 
            'manage_options',
            'pbd-streaks-settings',
            array( $this , 'pbd_sa_settings_page' ) );
    }

    public function wpdocs_personalise_pdf() {
        $labels = array(
            'name'                  => _x( 'Personalise PDFs', 'Post type general name', 'textdomain' ),
            'singular_name'         => _x( 'Personalise PDF', 'Post type singular name', 'textdomain' ),
            'menu_name'             => _x( 'Personalise PDFs', 'Admin Menu text', 'textdomain' ),
            'name_admin_bar'        => _x( 'Personalise PDF', 'Add New on Toolbar', 'textdomain' ),
            'add_new'               => __( 'Add New', 'textdomain' ),
            'add_new_item'          => __( 'Add New Personalise PDF', 'textdomain' ),
            'new_item'              => __( 'New Personalise PDF', 'textdomain' ),
            'edit_item'             => __( 'Edit Personalise PDF', 'textdomain' ),
            'view_item'             => __( 'View Personalise PDF', 'textdomain' ),
            'all_items'             => __( 'All Personalise PDFs', 'textdomain' ),
            'search_items'          => __( 'Search Personalise PDFs', 'textdomain' ),
            'parent_item_colon'     => __( 'Parent Personalise PDFs:', 'textdomain' ),
            'not_found'             => __( 'No Personalise PDFs found.', 'textdomain' ),
            'not_found_in_trash'    => __( 'No Personalise PDFs found in Trash.', 'textdomain' ),
            'featured_image'        => _x( 'Personalise PDF Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain' ),
            'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
            'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
            'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
            'archives'              => _x( 'Personalise PDF archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain' ),
            'insert_into_item'      => _x( 'Insert into Personalise PDF', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain' ),
            'uploaded_to_this_item' => _x( 'Uploaded to this Personalise PDF', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain' ),
            'filter_items_list'     => _x( 'Filter Personalise PDFs list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain' ),
            'items_list_navigation' => _x( 'Personalise PDFs list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain' ),
            'items_list'            => _x( 'Personalise PDFs list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain' ),
        );
    
        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'personalise_pdf' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title' ),
        );
    
        register_post_type( 'personalise_pdf', $args );
    }

    public function acf_populate_gf_forms_ids( $field ) {
        if ( class_exists( 'GFFormsModel' ) ) {
            $choices = [];
    
            foreach ( \GFFormsModel::get_forms() as $form ) {
                $choices[ $form->id ] = $form->title;
            }
    
            $field['choices'] = $choices;
        }
    
        return $field;
    }

    function pb_metabox_content($post) {
        $selected_form = get_post_meta($post->ID, '_selected_form', true);
    
        // Retrieve list of Gravity Forms forms
        $forms = RGFormsModel::get_forms(null, 'title');
        ?>
        <label for="selected_form">Select a Gravity Form:</label>
        <select name="selected_form" id="selected_form">
            <option value="">Select a form</option>
            <?php foreach ($forms as $form) : ?>
                <option value="<?php echo $form->id; ?>" <?php selected($selected_form, $form->id); ?>>
                    <?php echo esc_html($form->title); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php
    }

    public function add_custom_metabox() {
        add_meta_box(
            'custom_metabox',
            'Select Gravity Form',
            array( $this , 'pb_metabox_content' ) ,
            'personalise_pdf',
            'normal',
            'high'
        );
    }

    public function save_custom_metabox_data($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    
        if (!current_user_can('edit_post', $post_id)) return;
    
        if (isset($_POST['selected_form'])) {
            $selected_form = sanitize_text_field($_POST['selected_form']);
            update_post_meta($post_id, '_selected_form', $selected_form);
        }
    }

    public function load_custom_template($template) {
        if (is_singular('personalise_pdf')) {
            $template = PBD_SA_PATH_INCLUDES . '/templates/single-personalise_pdf.php';
        }
        return $template;
    }
    
    public function pbd_sa_settings_page() {
        include_once(PBD_SA_PATH_INCLUDES . '/settings.php');
    }
}

new PBD_MTJ_Settings;

