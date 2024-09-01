<?php 
class TpHeaderPost 
{

	private $type = 'tp-header';
    private $slug;
    private $name;
    private $plural_name;

	public function __construct() {
		$this->name = __('Header', 'tpcore');
        $this->slug = 'tp-header';
        $this->plural_name = __('Header', 'tpcore');

		add_action( 'init', array( $this, 'register_custom_post_type' ) );
		//add_action( 'init', array( $this, 'create_cat' ) );
		add_filter( 'single_template', array( $this, 'get_custom_pt_single_template' ) );
		
	}
	
	
	public function register_custom_post_type() {
		// $medidove_mem_slug = get_theme_mod('medidove_mem_slug','member'); 
		$labels = array(
			'name' => $this->name,
            'singular_name' => $this->name,
            'add_new' => sprintf( __('Add New Template', 'tpcore'), $this->name ),
            'add_new_item' => sprintf( __('Add New %s', 'tpcore'), $this->name ),
            'edit_item' => sprintf( __('Edit %s', 'tpcore'), $this->name ),
            'new_item' => sprintf( __('New %s', 'tpcore'), $this->name ),
            'all_items' => sprintf( __('All Templates', 'tpcore'), $this->plural_name ),
            'view_item' => sprintf( __('View %s', 'tpcore'), $this->name ),
            'search_items' => sprintf( __('Search %s', 'tpcore'), $this->name ),
            'not_found' => sprintf( __('No %s found' , 'tpcore'), strtolower($this->name) ),
            'not_found_in_trash' => sprintf( __('No %s found in Trash', 'tpcore'), strtolower($this->name) ),
            'parent_item_colon' => '',
            'menu_name' => $this->name,
		);

		$args   = array(
			'labels' => $labels,
            'public' => true,
            'exclude_from_search' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'rewrite' => [ 'slug' => $this->slug ],
            'menu_position' => 10,
            'supports' => ['title', 'editor', 'thumbnail', 'page-attributes','elementor'],
            'menu_icon' => 'dashicons-admin-page'
		);

		register_post_type( $this->type, $args );

        $cpt_support = get_option('elementor_cpt_support');
        if (!$cpt_support) {
            $cpt_support = ['page', 'post','tp-header', 'tp-footer', 'elementor_disable_color_schemes']; //create array of our default supported post types
            update_option('elementor_cpt_support', $cpt_support); //write it to the database
        }
	}

	public function wrapper_header_open()
    {
        global $post;

        if ($post->post_type == $this->type) {
            //echo "<header class='tpc-theme-header'>";
                //echo "<div class='tpc-site-header'>";
                    //echo "<div class='container-wrapper'>";
        }
    }

    public function wrapper_header_close()
    {
        global $post;

        if ($post->post_type == $this->type) {
                    //echo '</div>';
                //echo '</div>';
            //echo '</header>';
        }
    }


	public function get_custom_pt_single_template($single_template)
    {
        global $post;

        if ($post->post_type == $this->type) {

            if (defined('ELEMENTOR_PATH')) {
                $elementor_template = ELEMENTOR_PATH . '/modules/page-templates/templates/canvas.php';

                if ( file_exists( $elementor_template ) ) {
                    add_action( 'elementor/page_templates/canvas/before_content', [$this, 'wrapper_header_open']);
                    add_action( 'elementor/page_templates/canvas/after_content', [$this, 'wrapper_header_close']);
                    return $elementor_template;
                }
            }

            if (file_exists(get_template_directory().'/single-header.php')) return $single_template;

            $single_template = plugin_dir_path( dirname( __FILE__ ) ) . 'include/template/single-header.php';
        }
        return $single_template;
    }
}

new TpHeaderPost();