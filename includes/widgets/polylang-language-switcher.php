<?php
namespace ConnectPolylangElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use function function_exists;

defined( 'ABSPATH' ) || exit;


/**
 * Polylang Switcher
 *
 * Elementor widget for Polylang Language Switcher.
 *
 * Note: Code based on Widget class of plugin "Language Switcher for Elementor",
 *       licensed under GPLv2 or later.
 *
 * @author Solitweb
 * @link https://solitweb.be/
 *
 * @since 1.0.0
 */
class PolylangLanguageSwitcher extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {

		return 'polylang-language-switcher';

	}


	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {

		return _x( 'Polylang Switcher', 'Elementor widget title', 'connect-polylang-elementor' );

	}


	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {

		return 'fa fa-language';

	}


	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {

		return array( 'general', 'theme-elements' );

	}


	/**
	 * Set keywords for widgets search.
	 *
	 * @since 1.0.0
	 */
	public function get_keywords() {

		$keywords = _x(
			'languages, switcher, polylang, multilingual, flags, countries, country',
			'Comma separated keywords',
			'connect-polylang-elementor'
		);

		return explode( ', ', $keywords );

	}


	/**
	 * Retrieve the list of styles the widget depended on.
	 *
	 * Used to set styles dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget styles dependencies.
	 */
	public function get_style_depends() {

		return array( 'cpel-language-switcher' );

	}


	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {

		return array();

	}


	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the
	 *   widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 *
	 * @uses pll_the_languages()
	 */
	protected function _register_controls() {

		/** Content: Layout etc. */
		$this->start_controls_section(
			'section_content',
			array(
				'label' => __( 'Content', 'elementor' ),
			)
		);

		$this->add_responsive_control(
			'layout',
			array(
				'label'        => __( 'Layout', 'elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'horizontal',
				'options'      => array(
					'horizontal' => __( 'Horizontal', 'elementor' ),
					'vertical'   => __( 'Vertical', 'elementor' ),
				),
				'prefix_class' => 'cpel-switcher-%s-layout-',
			)
		);

		$this->add_responsive_control(
			'align_items',
			array(
				'label'        => __( 'Alignment', 'elementor' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => array(
					'left'    => array(
						'title' => __( 'Left', 'elementor' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center'  => array(
						'title' => __( 'Center', 'elementor' ),
						'icon'  => 'eicon-h-align-center',
					),
					'right'   => array(
						'title' => __( 'Right', 'elementor' ),
						'icon'  => 'eicon-h-align-right',
					),
					'justify' => array(
						'title' => __( 'Stretch', 'elementor' ),
						'icon'  => 'eicon-h-align-stretch',
					),
				),
				'prefix_class' => 'cpel-switcher-%s-align-',
			)
		);

		$this->add_control(
			'hide_current',
			array(
				'label'        => __( 'Hides the current language', 'polylang' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => '',
				'separator'    => 'before',
			)
		);

		$this->add_control(
			'hide_missing',
			array(
				'label'        => __( 'Hides languages with no translation', 'polylang' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->add_control(
			'show_country_flag',
			array(
				'label'        => __( 'Displays flags', 'polylang' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'show_language_name',
			array(
				'label'        => __( 'Displays language names', 'polylang' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'show_language_code',
			array(
				'label'        => __( 'Displays language codes', 'connect-polylang-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->end_controls_section();

		/** Style: Main menu */
		$this->start_controls_section(
			'main_section',
			array(
				'label' => __( 'Main Menu', 'connect-polylang-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs( 'tabs_menu_item_style' );

		$this->start_controls_tab(
			'tab_menu_item_normal',
			array(
				'label' => __( 'Normal', 'elementor' ),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'typography_menu_item',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
				'selector' => '{{WRAPPER}} .cpel-switcher__lang a',
			)
		);

		$this->add_control(
			'color_menu_item',
			array(
				'label'     => __( 'Text Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_TEXT,
				),
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .cpel-switcher__lang a' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_menu_item_hover',
			array(
				'label' => __( 'Hover', '__elementor' ),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'typography_menu_item_hover',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .cpel-switcher__lang a:hover, {{WRAPPER}} .cpel-switcher__lang a:focus',
			)
		);

		$this->add_control(
			'color_menu_item_hover',
			array(
				'label'     => __( 'Text Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_ACCENT,
				),
				'selectors' => array(
					'{{WRAPPER}} .cpel-switcher__lang a:hover, {{WRAPPER}} .cpel-switcher__lang a:focus' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_menu_item_active',
			array(
				'label'     => __( 'Active', 'elementor' ),
				'condition' => array(
					'hide_current!' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'typography_menu_item_active',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .cpel-switcher__lang.cpel-switcher__lang--active a',
			)
		);

		$this->add_control(
			'color_menu_item_active',
			array(
				'label'     => __( 'Text Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .cpel-switcher__lang.cpel-switcher__lang--active a' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'padding_horizontal_menu_item',
			array(
				'label'     => __( 'Horizontal Padding', 'connect-polylang-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array( 'max' => 50 ),
				),
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .cpel-switcher__lang a' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'padding_vertical_menu_item',
			array(
				'label'     => __( 'Vertical Padding', 'connect-polylang-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array( 'max' => 50 ),
				),
				'selectors' => array(
					'{{WRAPPER}} .cpel-switcher__lang a' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'menu_space_between',
			array(
				'label'     => __( 'Space Between', 'elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array( 'max' => 100 ),
				),
				'selectors' => array(
					'{{WRAPPER}} .cpel-switcher__switcher' => '--cpel-switcher-espace: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Style: Language flag
		 */

		$this->start_controls_section(
			'country_flag_section',
			array(
				'label'     => __( 'Flag', 'polylang' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_country_flag' => array( 'yes' ),
				),
			)
		);

		$this->add_control(
			'svg_flag',
			array(
				'label'        => __( 'Scalable Image', 'connect-polylang-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'aspect_ratio_flag',
			array(
				'label'        => __( 'Aspect Ratio', 'elementor' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => array(
					'43' => '4:3',
					'11' => '1:1',
				),
				'default'      => '43',
				'prefix_class' => 'cpel-switcher--aspect-ratio-',
				'condition'    => array( 'svg_flag' => 'yes' ),
			)
		);

		$this->add_responsive_control(
			'size_flag',
			array(
				'label'     => __( 'Size', 'elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array( 'size' => 20 ),
				'range'     => array(
					'px' => array( 'min' => 16 ),
				),
				'selectors' => array(
					'{{WRAPPER}} .cpel-switcher__switcher .cpel-switcher__flag' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition' => array( 'svg_flag' => 'yes' ),
			)
		);

		$this->add_responsive_control(
			'border_radius_flag',
			array(
				'label'      => __( 'Border Radius', 'elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'%' => array( 'max' => 50 ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .cpel-switcher__switcher .cpel-switcher__flag img' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array( 'svg_flag' => 'yes' ),
			)
		);

		$this->end_controls_section();

		/**
		 * Style: Language name
		 */

		$this->start_controls_section(
			'language_name_section',
			array(
				'label'     => __( 'Language Name', 'connect-polylang-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_language_name' => array( 'yes' ),
				),
			)
		);

		$this->add_control(
			'text_indent_language_name',
			array(
				'label'     => __( 'Text Indent', 'elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array( 'max' => 50 ),
				),
				'selectors' => array(
					'{{WRAPPER}} .cpel-switcher__name' => is_rtl() ? 'padding-right: {{SIZE}}{{UNIT}};' : 'padding-left: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Style: Language code
		 */

		$this->start_controls_section(
			'language_code_section',
			array(
				'label'     => __( 'Language Code', 'connect-polylang-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_language_code' => array( 'yes' ),
				),
			)
		);

		$this->add_control(
			'uppercase_language_code',
			array(
				'label'        => _x( 'Uppercase', 'Typography Control', 'elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'text_indent_language_code',
			array(
				'label'     => __( 'Text Indent', 'elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 50,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .cpel-switcher__code' => is_rtl() ? 'padding-right: {{SIZE}}{{UNIT}};' : 'padding-left: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'before_language_code',
			array(
				'label' => __( 'Before', 'elementor' ),
				'type'  => Controls_Manager::TEXT,
			)
		);

		$this->add_control(
			'after_language_code',
			array(
				'label' => __( 'After', 'elementor' ),
				'type'  => Controls_Manager::TEXT,
			)
		);

		$this->end_controls_section();

	}


	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 *
	 * @uses pll_the_languages() Holds Polylang languages for switcher.
	 */
	protected function render() {

		// Get the widget settings.
		$settings = $this->get_active_settings();

		// Add render attributes for Elementor.
		$this->add_render_attribute( 'main-menu', 'class', array( 'cpel-switcher__switcher' ) );

		// Get the available languages for switcher.
		$languages = pll_the_languages( array( 'raw' => 1 ) );

		if ( ! empty( $languages ) ) {

			$output = '<nav ' . $this->get_render_attribute_string( 'main-menu' ) . '><ul class="cpel-switcher__list">';

			foreach ( $languages as $language ) {

				// Hide the current language.
				if ( 'yes' === $settings['hide_current'] && $language['current_lang'] ) {
					continue;
				}

				// Hide language without translation.
				if ( 'yes' === $settings['hide_missing'] && $language['no_translation'] ) {
					continue;
				}

				$language_code = sprintf(
					'%s%s%s',
					$settings['before_language_code'] ?: '',
					'yes' === $settings['uppercase_language_code'] ? strtoupper( $language['slug'] ) : strtolower( $language['slug'] ),
					$settings['after_language_code'] ?: ''
				);

				// Flag image.
				$language_flag = '';
				if ( $settings['show_country_flag'] ) {
					$flag_code = cpel_flag_code( $language['flag'] );
					$flag_svg  = $flag_code ? cpel_flag_svg( $flag_code ) : false;

					if ( 'yes' === $settings['svg_flag'] && $flag_svg ) {

						// If base64 encoded flags are preferred.
						if ( ! defined( 'PLL_ENCODED_FLAGS' ) || PLL_ENCODED_FLAGS ) {
							$file_contents   = file_get_contents( CPEL_DIR . $flag_svg['path'] ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
							$flag_svg['src'] = 'data:image/svg+xml;base64,' . base64_encode( $file_contents ); // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode
						}

						$language_flag = \PLL_Language::get_flag_html( $flag_svg, '', $language['name'] );
					} elseif ( $flag_code ) {
						$language_flag = \PLL_Language::get_flag_html( \PLL_Language::get_flag_informations( $flag_code ), '', $language['name'] );
					} else {
						$language_flag = '<img src="' . esc_url( $language['flag'] ) . '" alt="' . esc_attr( $language['name'] ) . '" />';
					}

					if ( $flag_code ) {
						$language_flag = '<span class="cpel-switcher__flag cpel-switcher__flag--' . $flag_code . '">' . $language_flag . '</span>';
					} else {
						$language_flag = '<span class="cpel-switcher__flag">' . $language_flag . '</span>';
					}
				}

				// Build the language switcher menu item.
				$output .= sprintf(
					'<li class="%1$s"><a lang="%2$s" hreflang="%2$s" href="%3$s">%4$s%5$s%6$s</a></li>',
					$language['current_lang'] ? 'cpel-switcher__lang cpel-switcher__lang--active' : 'cpel-switcher__lang',
					esc_attr( $language['locale'] ),
					esc_url( $language['url'] ),
					$language_flag,
					$settings['show_language_name'] ? '<span class="cpel-switcher__name">' . esc_html( $language['name'] ) . '</span>' : '',
					$settings['show_language_code'] ? '<span class="cpel-switcher__code">' . esc_html( $language_code ) . '</span>' : ''
				);
			}

			$output .= '</ul></nav>';

			echo $output;

		}

	}


	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live
	 *   preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _content_template() { }

}
