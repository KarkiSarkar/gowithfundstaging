<?php
class Gavias_Themer_Header{
  public static $post_type = 'gva_header';
  
  public static $instance;

  public static function getInstance() {
    if (!isset(self::$instance) && !(self::$instance instanceof Gavias_Themer_Header)) {
      self::$instance = new Gavias_Themer_Header();
    }
    return self::$instance;
  }

  public function __construct(){ 
    
  }

  public function register_post_type_header(){
    add_action('init', array($this, 'args_post_type_header'), 10);
  }

  public function args_post_type_header(){
    $labels = array(
      'name' => __( 'Header Builder', 'krowd-themer' ),
      'singular_name' => __( 'Header Builder', 'krowd-themer' ),
      'add_new' => __( 'Add Header Builder', 'krowd-themer' ),
      'add_new_item' => __( 'Add Header Builder', 'krowd-themer' ),
      'edit_item' => __( 'Edit Header', 'krowd-themer' ),
      'new_item' => __( 'New Header Builder', 'krowd-themer' ),
      'view_item' => __( 'View Header Builder', 'krowd-themer' ),
      'search_items' => __( 'Search Header Profiles', 'krowd-themer' ),
      'not_found' => __( 'No Header Profiles found', 'krowd-themer' ),
      'not_found_in_trash' => __( 'No Header Profiles found in Trash', 'krowd-themer' ),
      'parent_item_colon' => __( 'Parent Header:', 'krowd-themer' ),
      'menu_name' => __( 'Header Builder', 'krowd-themer' ),
    );

    $args = array(
        'labels'              => $labels,
        'hierarchical'        => true,
        'description'         => __('List Header', "gaviasthemer"),
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 5,
        'show_in_nav_menus'   => false,
        'publicly_queryable'  => true,
        'exclude_from_search' => true,
        'has_archive'         => true,
        'query_var'           => true,
        'can_export'          => true,
        'rewrite'             => true,
        'capability_type'     => 'post'
    );
    register_post_type( self::$post_type, $args );
  }


  public function get_headers( $default = true ){
    $args = array(
      'post_type'        => 'gva_header',
      'posts_per_page'   => 100,
      'numberposts'      => 100,
      'post_status'     => 'publish'
    );
    $post_list = get_posts($args);
    $headers = array();
    if($default){
      $headers['__default_option_theme'] = esc_html__('Default Option Theme', 'krowd');
    }
    foreach ( $post_list as $post ) {
      $headers[$post->post_name] = $post->post_title;
    }
    wp_reset_postdata();
    return apply_filters('gaviasthemes_list_header', $headers );
  }

  public function render_header_builder($header_slug) {
    $header = get_page_by_path($header_slug, OBJECT, 'gva_header');
    if ($header && $header instanceof WP_Post) {
      if(class_exists('\Elementor\Plugin')){
        return \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $header->ID );
      }
    }
    return '';
  }
}

Gavias_Themer_Header::getInstance()->register_post_type_header();