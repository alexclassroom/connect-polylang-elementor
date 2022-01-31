<?php
namespace ConnectPolylangElementor\Util;

defined( 'ABSPATH' ) || exit;


class Info {

	public static function val( $key ) {

		$values = array(
			'url_translate'     => 'https://translate.wordpress.org/projects/wp-plugins/connect-polylang-elementor',
			'url_wporg_faq'     => 'https://wordpress.org/plugins/connect-polylang-elementor/#faq',
			'url_wporg_forum'   => 'https://wordpress.org/support/plugin/connect-polylang-elementor',
			'url_wporg_review'  => 'https://wordpress.org/support/plugin/connect-polylang-elementor/reviews/?filter=5/#new-post',
			'url_wporg_profile' => 'https://profiles.wordpress.org/daveshine/',
			'url_fb_group'      => 'https://www.facebook.com/groups/deckerweb.wordpress.plugins/',
			// 'url_snippets'      => 'https://github.com/deckerweb/connect-polylang-elementor/wiki/Code-Snippets',
			'author'            => __( 'David Decker - DECKERWEB', 'connect-polylang-elementor' ),
			'author_uri'        => 'https://deckerweb.de/',
			'license'           => 'GPL-2.0-or-later',
			'url_license'       => 'https://opensource.org/licenses/GPL-2.0',
			'first_code'        => '2018',
			'url_donate'        => 'https://www.paypal.me/deckerweb',
			'url_plugin'        => 'https://github.com/deckerweb/connect-polylang-elementor',
			// 'url_plugin_docs'   => 'https://github.com/deckerweb/connect-polylang-elementor/wiki',
			// 'url_plugin_faq'    => 'https://wordpress.org/plugins/connect-polylang-elementor/#faq',
			'url_github'        => 'https://github.com/deckerweb/connect-polylang-elementor',
			'url_github_issues' => 'https://github.com/deckerweb/connect-polylang-elementor/issues',
			'url_twitter'       => 'https://twitter.com/deckerweb',
			'url_github_follow' => 'https://github.com/deckerweb',
		);

		return isset( $values[ $key ] ) ? $values[ $key ] : false;

	}

	/**
	 * Get URL of specific BTC info value.
	 *
	 * @since  1.0.0
	 *
	 * @uses   cpel_info_values()
	 *
	 * @param  string $url_key String of value key from array of cpel_info_values()
	 * @param  bool   $raw     If raw escaping or regular escaping of URL gets used
	 * @return string URL for info value.
	 */
	public static function url( $url_key = '', $raw = false ) {

		$output = self::val( sanitize_key( $url_key ) );

		if ( ! empty( $output ) ) {
			return $raw ? esc_url_raw( $output ) : esc_url( $output );
		}

		return '';

	}

	/**
	 * Get link with complete markup for a specific BTC info value.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $url_key String of value key
	 * @param  string $text    String of text and link attribute
	 * @param  string $class   String of CSS class
	 * @return string HTML markup for linked URL.
	 */
	public static function link( $url_key = '', $text = '', $class = '' ) {

		$link = sprintf(
			'<a class="%1$s" href="%2$s" target="_blank" rel="nofollow noopener noreferrer" title="%3$s">%3$s</a>',
			strtolower( esc_attr( $class ) ),   // sanitize_html_class( $class ),
			self::url( $url_key ),
			esc_html( $text )
		);

		return $link;

	}

}
