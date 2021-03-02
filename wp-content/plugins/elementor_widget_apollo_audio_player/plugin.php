<?php
namespace ElementorApollo;

/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.0.0
 */
class Plugin {

  /**
   * Instance
   *
   * @since 1.0.0
   * @access private
   * @static
   *
   * @var Plugin The single instance of the class.
   */
  private static $_instance = null;

  /**
   * Instance
   *
   * Ensures only one instance of the class is loaded or can be loaded.
   *
   * @since 1.2.0
   * @access public
   *
   * @return Plugin An instance of the class.
   */
  public static function instance() {
    if ( is_null( self::$_instance ) ) {
      self::$_instance = new self();
    }

    return self::$_instance;
  }

  /**
   * widget_scripts
   *
   * Load required plugin core files.
   *
   * @since 1.2.0
   * @access public
   */
  public function widget_scripts() {
    // the player css
    wp_enqueue_style('audio7-html5_site_css', plugins_url('audio7_html5/audio7_html5.css', __FILE__));

    // the player js
    wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-slider');
		wp_enqueue_script('jquery-ui-progressbar');
    wp_enqueue_script('jquery-effects-core');

    wp_register_script('mousewheel', plugins_url('audio7_html5/js/jquery.mousewheel.min.js', __FILE__));
		wp_enqueue_script('mousewheel');

		wp_register_script('touchSwipe', plugins_url('audio7_html5/js/jquery.touchSwipe.min.js', __FILE__));
		wp_enqueue_script('touchSwipe');

		wp_register_script('lbg-audio7_html5', plugins_url('audio7_html5/js/audio7_html5.js', __FILE__));
		wp_enqueue_script('lbg-audio7_html5');

    wp_register_script('google_a', plugins_url('audio7_html5/js/google_a.js', __FILE__));
		wp_enqueue_script('google_a');
  }

  /**
   * Include Widgets files
   *
   * Load widgets files
   *
   * @since 1.2.0
   * @access private
   */
  private function include_widgets_files() {
    require_once( __DIR__ . '/widgets/apollo.php' );
  }

  /**
   * Register Widgets
   *
   * Register new Elementor widgets.
   *
   * @since 1.2.0
   * @access public
   */
  public function register_widgets() {
    // Its is now safe to include Widgets files
    $this->include_widgets_files();

    // Register Widgets
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Apollo() );
  }


  /**
   * lbg register_categories
   */
   public function register_categories( $elements_manager ) {
       $elements_manager->add_category(
         'lambert-widgets',
         [
           'title' => esc_html__( 'Lambert Widgets', 'elementor-apollo' ),
           'icon' => 'far fa-play-circle',
         ]
       );
     }


  /**
   *  Plugin class constructor
   *
   * Register plugin action hooks and filters
   *
   * @since 1.2.0
   * @access public
   */
  public function __construct() {
    // Register widget scripts
    add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );

    // Register widgets
    add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );


    //lbg - new categ
    add_action( 'elementor/elements/categories_registered', [ $this, 'register_categories' ] );

  }
}

// Instantiate Plugin Class
Plugin::instance();
