<?php
namespace ElementorApollo\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class Apollo extends Widget_Base {

  /**
   * Retrieve the widget name.
   *
   * @since 1.1.0
   *
   * @access public
   *
   * @return string Widget name.
   */
  public function get_name() {
    return 'Apollo - Audio Player';
  }

  /**
   * Retrieve the widget title.
   *
   * @since 1.1.0
   *
   * @access public
   *
   * @return string Widget title.
   */
  public function get_title() {
    return esc_html__( 'Apollo - Audio Player', 'elementor-apollo' );
  }

  /**
   * Retrieve the widget icon.
   *
   * @since 1.1.0
   *
   * @access public
   *
   * @return string Widget icon.
   */
  public function get_icon() {
    return 'far fa-calendar-alt';
  }

  /**
   * Retrieve the list of categories the widget belongs to.
   *
   * Used to determine where to display the widget in the editor.
   *
   * Note that currently Elementor supports only one category.
   * When multiple categories passed, Elementor uses the first one.
   *
   * @since 1.1.0
   *
   * @access public
   *
   * @return array Widget categories.
   */
  public function get_categories() {
    return [ 'lambert-widgets' ];
  }

  /**
   * Register the widget controls.
   *
   * Adds different input fields to allow the user to change and customize the widget settings.
   *
   * @since 1.1.0
   *
   * @access protected
   */
  protected function _register_controls() {
    //general controls (ex content)
    $this->start_controls_section(
      'general_content',
      [
        'label' => esc_html__( 'General Settings', 'elementor-apollo' ),
      ]
    );
    $this->add_control(
			'skin',
			[
				'label' => __( 'Skin Name', 'elementor-apollo' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'whiteControllers'  => __( 'White Controllers', 'elementor-apollo' ),
					'blackControllers' => __( 'Black Controllers', 'elementor-apollo' ),
				],
        'default' => 'whiteControllers',
			]
		);
    $this->add_control(
			'loop',
			[
				'label' => esc_html__( 'Loop Playlist', 'elementor-apollo' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'elementor-apollo' ),
				'label_off' => esc_html__( 'No', 'elementor-apollo' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
    $this->add_control(
			'autoPlay',
			[
				'label' => esc_html__( 'Auto Play', 'elementor-apollo' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'elementor-apollo' ),
				'label_off' => esc_html__( 'No', 'elementor-apollo' ),
				'return_value' => 'true',
				'default' => 'false',
			]
		);
    $this->add_control(
			'shuffle',
			[
				'label' => esc_html__( 'Shuffle', 'elementor-apollo' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'elementor-apollo' ),
				'label_off' => esc_html__( 'No', 'elementor-apollo' ),
				'return_value' => 'true',
				'default' => 'false',
			]
		);
    $this->add_control(
			'sticky',
			[
				'label' => esc_html__( 'Sticky', 'elementor-apollo' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'elementor-apollo' ),
				'label_off' => esc_html__( 'No', 'elementor-apollo' ),
				'return_value' => 'true',
				'default' => 'false',
			]
		);
    $this->add_control(
      'initialVolume',
      [
        'label' => esc_html__( 'Initial Volume Value', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'min' => 0,
        'max' => 1,
        'step' => 0.1,
        'default' => 1,
      ]
    );
    $this->add_control(
      'playerBgHexa',
      [
        'label' => esc_html__( 'Player Background (HEXA)', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'default' => '#000000',
      ]
    );
    $this->add_control(
    'playerBg',
    [
      'label' => esc_html__( 'Player Background - Image', 'elementor-apollo' ),
      'type' => \Elementor\Controls_Manager::MEDIA,
      'default' => [
        'url' => \Elementor\Utils::get_placeholder_image_src(),
      ],
      'description' => esc_html__( 'if defined, it will be used instead of the HEXA value', 'elementor-apollo' ),
    ]
    );
    $this->add_control(
      'bufferEmptyColor',
      [
        'label' => esc_html__( 'Empty Buffer Color', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'default' => '#929292',
      ]
    );
    $this->add_control(
      'bufferFullColor',
      [
        'label' => esc_html__( 'Full Buffer Color', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'default' => '#454545',
      ]
    );
    $this->add_control(
      'seekbarColor',
      [
        'label' => esc_html__( 'SeekBar Color', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'default' => '#FFFFFF',
      ]
    );
    $this->add_control(
      'volumeOffColor',
      [
        'label' => esc_html__( 'Volume Off State Color', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'default' => '#454545',
      ]
    );
    $this->add_control(
      'volumeOnColor',
      [
        'label' => esc_html__( 'Volume On State Color', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'default' => '#FFFFFF',
      ]
    );
    $this->add_control(
      'timerColor',
      [
        'label' => esc_html__( 'Timer Color', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'default' => '#FFFFFF',
      ]
    );
    $this->add_control(
      'songTitleColor',
      [
        'label' => esc_html__( 'Song Title - Text Color', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'default' => '#a6a6a6',
      ]
    );
    $this->add_control(
      'songAuthorColor',
      [
        'label' => esc_html__( 'Song Author -Text Color', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'default' => '#FFFFFF',
      ]
    );
    $this->add_control(
			'showVinylRecord',
			[
				'label' => esc_html__( 'Show Vinyl Record', 'elementor-apollo' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'elementor-apollo' ),
				'label_off' => esc_html__( 'No', 'elementor-apollo' ),
				'return_value' => 'true',
				'default' => 'true',
        'description' => esc_html__( 'if disabled, the image defined in the playlist will appear', 'elementor-apollo' ),
			]
		);
    $this->add_control(
      'barsColor',
      [
        'label' => esc_html__( 'Bars Color', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'default' => '#FFFFFF',
      ]
    );
    $this->add_control(
			'showRewindBut',
			[
				'label' => esc_html__( 'Show Rewind Button', 'elementor-apollo' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'elementor-apollo' ),
				'label_off' => esc_html__( 'No', 'elementor-apollo' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
    $this->add_control(
			'showNextPrevBut',
			[
				'label' => esc_html__( 'Show Next & Previous Buttons', 'elementor-apollo' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'elementor-apollo' ),
				'label_off' => esc_html__( 'No', 'elementor-apollo' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
    $this->add_control(
			'showShuffleBut',
			[
				'label' => esc_html__( 'Show Shuffle Button', 'elementor-apollo' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'elementor-apollo' ),
				'label_off' => esc_html__( 'No', 'elementor-apollo' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
    $this->add_control(
			'showDownloadBut',
			[
				'label' => esc_html__( 'Show Download Button', 'elementor-apollo' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'elementor-apollo' ),
				'label_off' => esc_html__( 'No', 'elementor-apollo' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
    $this->add_control(
			'showBuyBut',
			[
				'label' => esc_html__( 'Show Buy Button', 'elementor-apollo' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'elementor-apollo' ),
				'label_off' => esc_html__( 'No', 'elementor-apollo' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
    $this->add_control(
      'buyButTitle',
      [
        'label' => esc_html__( 'Buy Button Title', 'elementor-apollo' ),
        'type' => Controls_Manager::TEXT,
        'label_block' => false,
        'default' => 'Buy Now',
      ]
    );
    $this->add_control(
			'buyButTarget',
			[
				'label' => __( 'Buy Button Target Window', 'elementor-apollo' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'_blank'  => __( 'New Window', 'elementor-apollo' ),
					'_self' => __( 'Same Window', 'elementor-apollo' ),
				],
        'default' => '_blank',
			]
		);
    $this->add_control(
			'showLyricsBut',
			[
				'label' => esc_html__( 'Show Lyrics Button', 'elementor-apollo' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'elementor-apollo' ),
				'label_off' => esc_html__( 'No', 'elementor-apollo' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
    $this->add_control(
      'lyricsButTitle',
      [
        'label' => esc_html__( 'Lyrics Button Title', 'elementor-apollo' ),
        'type' => Controls_Manager::TEXT,
        'label_block' => false,
        'default' => 'Lyrics',
      ]
    );
    $this->add_control(
			'lyricsButTarget',
			[
				'label' => __( 'Buy Lyrics Target Window', 'elementor-apollo' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'_blank'  => __( 'New Window', 'elementor-apollo' ),
					'_self' => __( 'Same Window', 'elementor-apollo' ),
				],
        'default' => '_blank',
			]
		);
    $this->add_control(
			'showTwitterBut',
			[
				'label' => esc_html__( 'Show Twitter Button', 'elementor-apollo' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'elementor-apollo' ),
				'label_off' => esc_html__( 'No', 'elementor-apollo' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
    $this->add_control(
			'showPopupBut',
			[
				'label' => esc_html__( 'Show Popup Button', 'elementor-apollo' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'elementor-apollo' ),
				'label_off' => esc_html__( 'No', 'elementor-apollo' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
    $this->add_control(
			'showAuthor',
			[
				'label' => esc_html__( 'Show Author', 'elementor-apollo' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'elementor-apollo' ),
				'label_off' => esc_html__( 'No', 'elementor-apollo' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
    $this->add_control(
			'showTitle',
			[
				'label' => esc_html__( 'Show Title', 'elementor-apollo' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'elementor-apollo' ),
				'label_off' => esc_html__( 'No', 'elementor-apollo' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
    $this->add_control(
			'showFacebookBut',
			[
				'label' => esc_html__( 'Show FaceBook Button', 'elementor-apollo' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'elementor-apollo' ),
				'label_off' => esc_html__( 'No', 'elementor-apollo' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
    $this->add_control(
      'facebookAppID',
      [
        'label' => esc_html__( 'FaceBook AppID', 'elementor-apollo' ),
        'type' => Controls_Manager::TEXT,
        'label_block' => false,
        'default' => '',
      ]
    );
    $this->add_control(
      'preload',
      [
        'label' => __( 'Preload', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'options' => [
          'auto'  => __( 'auto', 'elementor-apollo' ),
          'metadata' => __( 'metadata', 'elementor-apollo' ),
          'none' => __( 'none', 'elementor-apollo' ),
        ],
        'default' => 'metadata',
      ]
    );
    $this->add_control(
      'popupWidth',
      [
        'label' => esc_html__( 'Popup Width', 'elementor-apollo' ),
        'type' => Controls_Manager::NUMBER,
        'label_block' => false,
        'default' => '1100',
      ]
    );
    $this->add_control(
      'popupHeight',
      [
        'label' => esc_html__( 'Popup Height', 'elementor-apollo' ),
        'type' => Controls_Manager::NUMBER,
        'label_block' => false,
        'default' => '500',
      ]
    );
    $this->add_control(
			'googleTrakingOn',
			[
				'label' => esc_html__( 'Activate Google Analytics Traking', 'elementor-apollo' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'elementor-apollo' ),
				'label_off' => esc_html__( 'No', 'elementor-apollo' ),
				'return_value' => 'true',
				'default' => 'false',
			]
		);
    $this->add_control(
      'googleTrakingCode',
      [
        'label' => esc_html__( 'Your Google Analytics Traking Code', 'elementor-apollo' ),
        'type' => Controls_Manager::TEXT,
        'label_block' => false,
        'default' => '',
        'description' => esc_html__( 'Example of code: UA-3245593-1', 'elementor-apollo' ),
      ]
    );
    $this->add_control(
			'showSearchArea',
			[
				'label' => esc_html__( 'Show Search Area', 'elementor-apollo' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'elementor-apollo' ),
				'label_off' => esc_html__( 'No', 'elementor-apollo' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
    $this->add_control(
      'searchAreaBg',
      [
        'label' => esc_html__( 'Search Area Background Color', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'default' => '#333333',
      ]
    );
    $this->add_control(
      'searchInputText',
      [
        'label' => esc_html__( 'Search Input Text', 'elementor-apollo' ),
        'type' => Controls_Manager::TEXT,
        'label_block' => false,
        'default' => 'search...',
      ]
    );
    $this->add_control(
      'searchInputBg',
      [
        'label' => esc_html__( 'Search Input Background Color', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'default' => '#ffffff',
      ]
    );
    $this->add_control(
      'searchInputBorderColor',
      [
        'label' => esc_html__( 'Search Input Border Color', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'default' => '#333333',
      ]
    );
    $this->add_control(
      'searchInputTextColor',
      [
        'label' => esc_html__( 'Search Input Text Color', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'default' => '#333333',
      ]
    );
    $this->add_control(
			'searchAuthor',
			[
				'label' => esc_html__( 'Search Inside Author Field', 'elementor-apollo' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'elementor-apollo' ),
				'label_off' => esc_html__( 'No', 'elementor-apollo' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);

    $this->end_controls_section();




    $this->start_controls_section(
      'left_side_top_content',
      [
        'label' => esc_html__( 'Playlist Settings', 'elementor-apollo' ),
      ]
    );
    $this->add_control(
      'showPlaylistOnInit',
      [
        'label' => esc_html__( 'Show Playlist On Init', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__( 'Yes', 'elementor-apollo' ),
        'label_off' => esc_html__( 'No', 'elementor-apollo' ),
        'return_value' => 'true',
        'default' => 'false',
      ]
    );
    $this->add_control(
      'showPlaylistBut',
      [
        'label' => esc_html__( 'Show Playlist Button', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__( 'Yes', 'elementor-apollo' ),
        'label_off' => esc_html__( 'No', 'elementor-apollo' ),
        'return_value' => 'true',
        'default' => 'true',
      ]
    );
    $this->add_control(
      'showPlaylist',
      [
        'label' => esc_html__( 'Show Playlist', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__( 'Yes', 'elementor-apollo' ),
        'label_off' => esc_html__( 'No', 'elementor-apollo' ),
        'return_value' => 'true',
        'default' => 'true',
      ]
    );
    $this->add_control(
      'playlistTopPos',
      [
        'label' => esc_html__( 'Playlist Top Position', 'elementor-apollo' ),
        'type' => Controls_Manager::NUMBER,
        'label_block' => false,
        'default' => '2',
      ]
    );
    $this->add_control(
      'playlistBgColor',
      [
        'label' => esc_html__( 'Playlist Background Color', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'label_block' => false,
        'default' => '#000000',
      ]
    );
    $this->add_control(
      'playlistRecordBgOffColor',
      [
        'label' => esc_html__( 'Playlist Record Background Off Color', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'label_block' => false,
        'default' => '#000000',
      ]
    );
    $this->add_control(
      'playlistRecordBgOnColor',
      [
        'label' => esc_html__( 'Playlist Record Background On Color', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'label_block' => false,
        'default' => '#333333',
      ]
    );
    $this->add_control(
      'playlistRecordBottomBorderOffColor',
      [
        'label' => esc_html__( 'Playlist Record Bottom Border Off Color', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'label_block' => false,
        'default' => '#333333',
      ]
    );
    $this->add_control(
      'playlistRecordBottomBorderOnColor',
      [
        'label' => esc_html__( 'Playlist Record Bottom Border On Color', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'label_block' => false,
        'default' => '#FFFFFF',
      ]
    );
    $this->add_control(
      'playlistRecordTextOffColor',
      [
        'label' => esc_html__( 'Playlist Record Text Off Color', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'label_block' => false,
        'default' => '#777777',
      ]
    );
    $this->add_control(
      'playlistRecordTextOnColor',
      [
        'label' => esc_html__( 'Playlist Record Text On Color', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'label_block' => false,
        'default' => '#FFFFFF',
      ]
    );
    $this->add_control(
      'numberOfThumbsPerScreen',
      [
        'label' => esc_html__( 'Number Of Items Per Screen', 'elementor-apollo' ),
        'type' => Controls_Manager::NUMBER,
        'label_block' => false,
        'default' => '5',
      ]
    );
    $this->add_control(
      'playlistPadding',
      [
        'label' => esc_html__( 'Playlist Padding', 'elementor-apollo' ),
        'type' => Controls_Manager::NUMBER,
        'label_block' => false,
        'default' => '18',
      ]
    );
    $this->add_control(
      'showPlaylistNumber',
      [
        'label' => esc_html__( 'Show Playlist Number', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__( 'Yes', 'elementor-apollo' ),
        'label_off' => esc_html__( 'No', 'elementor-apollo' ),
        'return_value' => 'true',
        'default' => 'true',
      ]
    );

    $this->end_controls_section();


    $this->start_controls_section(
      'details_area_content',
      [
        'label' => esc_html__( 'Categories Settings', 'elementor-apollo' ),
      ]
    );
    $this->add_control(
      'categoryRecordBgOffColor',
      [
        'label' => esc_html__( 'Category Record Background Off Color', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'label_block' => false,
        'default' => '#191919',
      ]
    );
    $this->add_control(
      'categoryRecordBgOnColor',
      [
        'label' => esc_html__( 'Category Record Background On Color', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'label_block' => false,
        'default' => '#252525',
      ]
    );
    $this->add_control(
      'categoryRecordBottomBorderOffColor',
      [
        'label' => esc_html__( 'Category Record Bottom Border Off Color', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'label_block' => false,
        'default' => '#2f2f2f',
      ]
    );
    $this->add_control(
      'categoryRecordBottomBorderOnColor',
      [
        'label' => esc_html__( 'Category Record Bottom Border On Color', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'label_block' => false,
        'default' => '#2f2f2f',
      ]
    );
    $this->add_control(
      'categoryRecordTextOffColor',
      [
        'label' => esc_html__( 'Category Record Text Off Color', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'label_block' => false,
        'default' => '#4c4c4c',
      ]
    );
    $this->add_control(
      'categoryRecordTextOnColor',
      [
        'label' => esc_html__( 'Category Record Text On Color', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'label_block' => false,
        'default' => '#00b4f9',
      ]
    );
    $this->add_control(
      'showCategories',
      [
        'label' => esc_html__( 'Show Categories', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__( 'Yes', 'elementor-apollo' ),
        'label_off' => esc_html__( 'No', 'elementor-apollo' ),
        'return_value' => 'true',
        'default' => 'true',
      ]
    );
    $this->add_control(
			'firstCateg',
      [
				'label' => __( 'First Selected Category', 'elementor-apollo' ),
				'type' => \Elementor\Controls_Manager::TEXT,
        'label_block' => true,
        'default' => '',
        'description' => esc_html__( 'it must be one of the defined categories or you can leave it blank', 'elementor-apollo' ),
			]
		);
    $this->add_control(
      'selectedCategBg',
      [
        'label' => esc_html__( 'Selected Categ Background Color', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'label_block' => false,
        'default' => '#333333',
      ]
    );
    $this->add_control(
      'selectedCategOffColor',
      [
        'label' => esc_html__( 'Selected Categ Off Color', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'label_block' => false,
        'default' => '#FFFFFF',
      ]
    );
    $this->add_control(
      'selectedCategOnColor',
      [
        'label' => esc_html__( 'Selected Categ On Color', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'alpha' => false,
        'label_block' => false,
        'default' => '#00b4f9',
      ]
    );
    $this->add_control(
      'selectedCategMarginBottom',
      [
        'label' => esc_html__( 'Selected Category Bottom Margin', 'elementor-apollo' ),
        'type' => Controls_Manager::NUMBER,
        'label_block' => false,
        'default' => '12',
      ]
    );
    $this->end_controls_section();



    /*playlist controls*/
    $this->start_controls_section(
      'playlist_content',
      [
        'label' => esc_html__( 'Playlist Items', 'elementor-apollo' ),
      ]
    );


    $repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title', [
				'label' => __( 'Title', 'elementor-apollo' ),
				'type' => \Elementor\Controls_Manager::TEXT,
        'label_block' => true,
        'default' => '',
			]
		);
    $repeater->add_control(
			'author', [
				'label' => __( 'Author', 'elementor-apollo' ),
				'type' => \Elementor\Controls_Manager::TEXT,
        'label_block' => true,
        'default' => '',
			]
		);
    $repeater->add_control(
			'authorlink', [
				'label' => __( 'Author Link (Optional)', 'elementor-apollo' ),
				'type' => \Elementor\Controls_Manager::TEXT,
        'label_block' => true,
        'default' => '',
			]
		);
    $repeater->add_control(
			'authorlinktarget',
			[
				'label' => __( 'Author Link Target (Optional)', 'elementor-apollo' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'_blank'  => __( 'New Window', 'elementor-apollo' ),
					'_self' => __( 'Same Window', 'elementor-apollo' ),
				],
        'default' => '_blank',
			]
		);
    $repeater->add_control(
			'category', [
				'label' => __( 'Category', 'elementor-apollo' ),
				'type' => \Elementor\Controls_Manager::TEXT,
        'label_block' => true,
        'default' => '',
        'description' => esc_html__( "If you'll define multiple categories for each song, you'll separate them by a semicolomn. Example: Category 1; Category 2", 'elementor-apollo' ),
			]
		);
    $repeater->add_control(
		'imgplaylist',
		[
			'label' => esc_html__( 'Playlist Image', 'elementor-apollo' ),
			'type' => \Elementor\Controls_Manager::MEDIA,
			'default' => [
				'url' => \Elementor\Utils::get_placeholder_image_src(),
			]
		]
	  );
    $repeater->add_control(
      'buylink', [
        'label' => __( 'Buy Link', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::TEXT,
        'label_block' => true,
        'default' => '',
      ]
    );
    $repeater->add_control(
      'lyricslink', [
        'label' => __( 'Lyrics Link', 'elementor-apollo' ),
        'type' => \Elementor\Controls_Manager::TEXT,
        'label_block' => true,
        'default' => '',
      ]
    );
    $repeater->add_control(
			'mp3',
			[
				'label' => esc_html__( 'MP3 file (Chrome, IE, Safari)', 'elementor-apollo' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
					'categories' => [
						TagsModule::MEDIA_CATEGORY,
					],
				],
				'media_type' => 'audio'
			]
		);
    $repeater->add_control(
		'ogg',
		[
			'label' => esc_html__( 'Optional OGG file (Mozzila, Opera)', 'elementor-apollo' ),
			'type' => \Elementor\Controls_Manager::MEDIA,
      'dynamic' => [
        'active' => true,
        'categories' => [
          TagsModule::MEDIA_CATEGORY,
        ],
      ],
      'media_type' => 'audio'
		]
	  );



    $this->add_control(
			'list',
			[
				'label' => __( 'Here you can add/edit/delete/clone the player playlist items', 'elementor-apollo' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => __( 'Song Title', 'elementor-apollo' ),
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

    $this->end_controls_section();
  }

  /**
   * Render the widget output on the frontend.
   *
   * Written in PHP and used to generate the final HTML.
   *
   * @since 1.1.0
   *
   * @access protected
   */
  protected function render() {
    $rand_id=rand(10,999999);
    $settings = $this->get_settings_for_display();

    $playerBgColor='';
    if ($settings['playerBgHexa'])
        $playerBgColor.=$settings['playerBgHexa'];
      if ($settings['playerBg']['url']!='' && strpos($settings['playerBg']['url'],'placeholder.png')===FALSE)
        $playerBgColor.=' url('.$settings['playerBg']['url'].')';

    $pathToDownloadFile_aux=plugin_dir_url(__FILE__).'audio7_html5/';
    ?>
    <script>
  		jQuery(function() {
          setTimeout(function(){
                jQuery("#lbg_audio7_html5_<?php echo strip_tags($rand_id); ?>").audio7_html5({
                  skin:"<?php echo strip_tags($settings['skin']); ?>",
          				initialVolume:<?php echo strip_tags($settings['initialVolume']); ?>,
          				autoPlay:<?php echo (($settings['autoPlay']==='true')?'true':'false'); ?>,
          				loop:<?php echo (($settings['loop']==='true')?'true':'false'); ?>,
          				shuffle:<?php echo (($settings['shuffle']==='true')?'true':'false'); ?>,
          				sticky:<?php echo (($settings['sticky']==='true')?'true':'false'); ?>,
          				playerBg:"<?php echo strip_tags($playerBgColor); ?>",
          				bufferEmptyColor:"<?php echo strip_tags($settings['bufferEmptyColor']); ?>",
          				bufferFullColor:"<?php echo strip_tags($settings['bufferFullColor']); ?>",
          				seekbarColor:"<?php echo strip_tags($settings['seekbarColor']); ?>",
          				volumeOffColor:"<?php echo strip_tags($settings['volumeOffColor']); ?>",
          				volumeOnColor:"<?php echo strip_tags($settings['volumeOnColor']); ?>",
          				timerColor:"<?php echo strip_tags($settings['timerColor']); ?>",
          				songTitleColor:"<?php echo strip_tags($settings['songTitleColor']); ?>",
          				songAuthorColor:"<?php echo strip_tags($settings['songAuthorColor']); ?>",
          				googleTrakingOn:<?php echo strip_tags($settings['googleTrakingOn']); ?>,
          				googleTrakingCode:"<?php echo strip_tags($settings['googleTrakingCode']); ?>",
          				showVinylRecord:<?php echo (($settings['showVinylRecord']==='true')?'true':'false'); ?>,
          				showRewindBut:<?php echo (($settings['showVinylRecord']==='true')?'true':'false'); ?>,
          				showNextPrevBut:<?php echo (($settings['showNextPrevBut']==='true')?'true':'false'); ?>,
          				showShuffleBut:<?php echo (($settings['showShuffleBut']==='true')?'true':'false'); ?>,
          				showDownloadBut:<?php echo (($settings['showDownloadBut']==='true')?'true':'false'); ?>,
          				showBuyBut:<?php echo (($settings['showBuyBut']==='true')?'true':'false'); ?>,
          				showLyricsBut:<?php echo (($settings['showBuyBut']==='true')?'true':'false'); ?>,
          				buyButTitle:"<?php echo strip_tags($settings['buyButTitle']); ?>",
          				lyricsButTitle:"<?php echo strip_tags($settings['lyricsButTitle']); ?>",
          				buyButTarget:"<?php echo strip_tags($settings['buyButTarget']); ?>",
          				lyricsButTarget:"<?php echo strip_tags($settings['lyricsButTarget']); ?>",
          				showFacebookBut:<?php echo (($settings['showFacebookBut']==='true')?'true':'false'); ?>,
          				facebookAppID:"<?php echo strip_tags($settings['facebookAppID']); ?>",
          				showTwitterBut:<?php echo (($settings['showTwitterBut']==='true')?'true':'false'); ?>,
          				showPopupBut:<?php echo (($settings['showPopupBut']==='true')?'true':'false'); ?>,
          				showAuthor:<?php echo (($settings['showAuthor']==='true')?'true':'false'); ?>,
          				showTitle:<?php echo (($settings['showTitle']==='true')?'true':'false'); ?>,
          				showPlaylistBut:<?php echo (($settings['showPlaylistBut']==='true')?'true':'false'); ?>,
          				showPlaylist:<?php echo (($settings['showPlaylist']==='true')?'true':'false'); ?>,
          				showPlaylistOnInit:<?php echo (($settings['showPlaylistOnInit']==='true')?'true':'false'); ?>,
          				playlistTopPos:<?php echo strip_tags($settings['playlistTopPos']); ?>,
          				playlistBgColor:"<?php echo strip_tags($settings['playlistBgColor']); ?>",
          				playlistRecordBgOffColor:"<?php echo strip_tags($settings['playlistRecordBgOffColor']); ?>",
          				playlistRecordBgOnColor:"<?php echo strip_tags($settings['playlistRecordBgOnColor']); ?>",
          				playlistRecordBottomBorderOffColor:"<?php echo strip_tags($settings['playlistRecordBottomBorderOffColor']); ?>",
          				playlistRecordBottomBorderOnColor:"<?php echo strip_tags($settings['playlistRecordBottomBorderOnColor']); ?>",
          				playlistRecordTextOffColor:"<?php echo strip_tags($settings['playlistRecordTextOffColor']); ?>",
          				playlistRecordTextOnColor:"<?php echo strip_tags($settings['playlistRecordTextOnColor']); ?>",
          				categoryRecordBgOffColor:"<?php echo strip_tags($settings['categoryRecordBgOffColor']); ?>",
          				categoryRecordBgOnColor:"<?php echo strip_tags($settings['categoryRecordBgOnColor']); ?>",
          				categoryRecordBottomBorderOffColor:"<?php echo strip_tags($settings['categoryRecordBottomBorderOffColor']); ?>",
          				categoryRecordBottomBorderOnColor:"<?php echo strip_tags($settings['categoryRecordBottomBorderOnColor']); ?>",
          				categoryRecordTextOffColor:"<?php echo strip_tags($settings['categoryRecordTextOffColor']); ?>",
          				categoryRecordTextOnColor:"<?php echo strip_tags($settings['categoryRecordTextOnColor']); ?>",
          				numberOfThumbsPerScreen:<?php echo strip_tags($settings['numberOfThumbsPerScreen']); ?>,
          				playlistPadding:<?php echo strip_tags($settings['playlistPadding']); ?>,
          				showCategories:<?php echo (($settings['showCategories']==='true')?'true':'false'); ?>,
          				firstCateg:"<?php echo strip_tags($settings['firstCateg']); ?>",
          				selectedCategBg:"<?php echo strip_tags($settings['selectedCategBg']); ?>",
          				selectedCategOffColor:"<?php echo strip_tags($settings['selectedCategOffColor']); ?>",
          				selectedCategOnColor:"<?php echo strip_tags($settings['selectedCategOnColor']); ?>",
          				selectedCategMarginBottom:<?php echo strip_tags($settings['selectedCategMarginBottom']); ?>,
          				showSearchArea:<?php echo (($settings['showSearchArea']==='true')?'true':'false'); ?>,
          				searchAreaBg:"<?php echo strip_tags($settings['searchAreaBg']); ?>",
          				searchInputText:"<?php echo strip_tags($settings['searchInputText']); ?>",
          				searchInputBg:"<?php echo strip_tags($settings['searchInputBg']); ?>",
          				searchInputBorderColor:"<?php echo strip_tags($settings['searchInputBorderColor']); ?>",
          			    searchInputTextColor:"<?php echo strip_tags($settings['searchInputTextColor']); ?>",
          				searchAuthor:<?php echo (($settings['searchAuthor']==='true')?'true':'false'); ?>,
          				showPlaylistNumber:<?php echo (($settings['showPlaylistNumber']==='true')?'true':'false'); ?>,
          				pathToDownloadFile:"<?php echo strip_tags($pathToDownloadFile_aux); ?>",
          				popupWidth:<?php echo strip_tags($settings['popupWidth']); ?>,
          				popupHeight:<?php echo strip_tags($settings['popupHeight']); ?>,
          				barsColor:"<?php echo strip_tags($settings['barsColor']); ?>"
                });
          },100);
  		});
  	</script>
    <div class="audio7_html5">
          <audio id="lbg_audio7_html5_<?php echo strip_tags($rand_id); ?>" preload="metadata">
          				<div class="xaudioplaylist">
                  <?php
                  if ( $settings['list'] ) {
                      foreach (  $settings['list'] as $item ) {
                          echo '<ul>';
                              echo '<li class="xtitle">'.strip_tags($item['title']).'</li>';
                              echo '<li class="xauthor">'.strip_tags($item['author']).'</li>';
                              echo '<li class="ximage">'.strip_tags($item['imgplaylist']['url']).'</li>';
                              echo '<li class="xauthorlink">'.strip_tags($item['authorlink']).'</li>';
                              echo '<li class="xauthorlinktarget">'.strip_tags($item['authorlinktarget']).'</li>';
                              echo '<li class="xcategory">'.(($item['category']!='')?strip_tags($item['category']):"ALL CATEGORIES").'</li>';
                              echo '<li class="xbuy">'.strip_tags($item['buylink']).'</li>';
                              echo '<li class="xlyrics">'.strip_tags($item['lyricslink']).'</li>';
                              echo '<li class="xsources_mp3">'.strip_tags($item['mp3']['url']).'</li>';
                              echo '<li class="xsources_ogg">'.strip_tags($item['ogg']['url']).'</li>';
                          echo '</ul>';
                      }
                  }
                  ?>
                  </div>
          No HTML5 audio playback capabilities for this browser. Use <a href="https://www.google.com/intl/en/chrome/browser/">Chrome Browser!</a>
        </audio>
    </div>
    <?php
  }

  /**
   * Render the widget output in the editor.
   *
   * Written as a Backbone JavaScript template and used to generate the live preview.
   *
   * @since 1.1.0
   *
   * @access protected
   */
  protected function _content_template() {

  }
}
