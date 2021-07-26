<?php
namespace ConnectPolylangElementor;

use \ConnectPolylangElementor\Util\Info;

defined( 'ABSPATH' ) || exit;


class AdminExtras {

	use \ConnectPolylangElementor\Util\Singleton;

	/**
	 * Current template ID.
	 *
	 * @var int|null
	 */
	private $template_id = null;

	/**
	 * __construct
	 *
	 * @return void
	 */
	private function __construct() {

		add_filter( 'plugin_action_links_' . CPEL_BASENAME, array( $this, 'custom_settings_links' ) );
		add_filter( 'network_admin_plugin_action_links_' . CPEL_BASENAME, array( $this, 'custom_settings_links' ) );

		add_filter( 'plugin_row_meta', array( $this, 'plugin_links' ), 10, 2 );

	}

	/**
	 * Add custom settings link to Plugins page.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $cpel_links (Default) Array of plugin action links.
	 * @return strings $cpel_links Settings & Menu Admin links.
	 */
	function custom_settings_links( $cpel_links ) {

		$link_polylang  = '';
		$link_elementor = '';

		/** Add settings link only if user has permission */
		if ( current_user_can( 'edit_theme_options' ) ) {

			/** Polylang settings link */
			if ( cpel_is_polylang_active() ) {

				$link_polylang = sprintf(
					'<a href="%1$s" title="%2$s">%3$s</a>',
					esc_url( admin_url( 'admin.php?page=mlang' ) ),
					/* translators: Title attribute for Polylang settings link */
					esc_html__( 'Polylang Languages Setup', 'connect-polylang-elementor' ),
					esc_attr_x( 'Languages', 'Link title attribute for Polylang settings', 'connect-polylang-elementor' )
				);

			}

			/** Elementor My Templates link */
			if ( cpel_is_elementor_active() ) {

				$link_elementor = sprintf(
					'<a href="%1$s" title="%2$s">%3$s</a>',
					esc_url( admin_url( 'edit.php?post_type=elementor_library' ) ),
					/* translators: Title attribute for Elementor My Templates link */
					esc_html__( 'Elementor My Templates', 'connect-polylang-elementor' ),
					esc_attr_x( 'Templates', 'Link title attribute for Elementor My Templates', 'connect-polylang-elementor' )
				);

			}
		}

		/** Set the order of the links */
		if ( ! empty( $link_polylang ) && ! empty( $link_elementor ) ) {
			array_unshift( $cpel_links, $link_polylang, $link_elementor );
		}

		/** Display plugin settings links */
		return apply_filters(
			'cpel/filter/plugins_page/settings_links',
			$cpel_links,
			$link_polylang,     // additional param
			$link_elementor     // additional param
		);

	}


	/**
	 * Add various support links to Plugins page.
	 *
	 * @since  1.0.0
	 *
	 * @uses   Info::link()
	 *
	 * @param  array  $cpel_links (Default) Array of plugin meta links
	 * @param  string $cpel_file  Path of base plugin file
	 * @return array $cpel_links Array of plugin link strings to build HTML markup.
	 */
	function plugin_links( $cpel_links, $cpel_file ) {

		/** Capability check */
		if ( ! current_user_can( 'install_plugins' ) ) {
			return $cpel_links;
		}

		/** List additional links only for this plugin */
		if ( $cpel_file === CPEL_BASENAME ) {

			?>
				<style type="text/css">
					tr[data-plugin="<?php echo $cpel_file; ?>"] .plugin-version-author-uri a.dashicons-before:before { font-size: 15px; opacity: .85; vertical-align: middle; }
				</style>
			<?php

			// $cpel_links[] = Info::link( 'url_wporg_forum', esc_html_x( 'Support', 'Plugins page listing', 'connect-polylang-elementor' ), 'dashicons-before dashicons-sos' );
			// $cpel_links[] = Info::link( 'url_fb_group', esc_html_x( 'Facebook Group', 'Plugins page listing', 'connect-polylang-elementor' ), 'dashicons-before dashicons-facebook' );
			// $cpel_links[] = Info::link( 'url_translate', esc_html_x( 'Translations', 'Plugins page listing', 'connect-polylang-elementor' ), 'dashicons-before dashicons-translation' );
			// $cpel_links[] = Info::link( 'url_donate', esc_html_x( 'Donate', 'Plugins page listing', 'connect-polylang-elementor' ), 'button-primary dashicons-before dashicons-thumbs-up' );

			$cpel_links[] = '<a href="https://paypal.me/pacotole" title="Support this plugin\'s development">Donate</a>';
			$cpel_links[] = '<a href="mailto:wespeakcomputer@gmail.com" title="Request personal one on one training on using Polylang + Elementor">Personal one-on-one training</a>';

		}

		/** Output the links */
		return apply_filters( 'cpel/filter/plugins_page/more_links', $cpel_links );

	}

}
