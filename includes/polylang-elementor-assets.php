<?php
/*
 * Non-MU plugin. Need to be used together with MU plugin.
 *
 * Based on code from @nicmare: https://github.com/polylang/polylang/issues/590#issuecomment-721782112
 *
 * Plugin Name: Polylang Elementor Cross Domain Assets
 * Description: Fixes cross origin domain issues with Elementor and Polylang
 * Version: 1.0
 * Author: Jory Hogeveen
 * Author URI: http://www.keraweb.nl/
*/

namespace ConnectPolylangElementor;

defined( 'ABSPATH' ) || exit;


class PolylangElementorAssets {

	use \ConnectPolylangElementor\Util\Singleton;

	protected $current_domain   = '';
	protected $default_domain   = '';
	protected $current_language = '';
	protected $default_language = '';
	protected $all_domains      = array();

	protected function __construct() {
		add_action( 'init', array( $this, 'init' ) );
	}

	public function init() {

		$return           = OBJECT;
		$current_language = pll_current_language( $return );
		$default_language = pll_default_language( $return );

		if ( ! $current_language || ! $default_language ) {
			return;
		}

		$is_preview = isset( $_GET['elementor_preview'] );
		$is_editor  = ( isset( $_GET['action'] ) && 'elementor' === $_GET['action'] );

		if ( ! $is_editor && ! $is_preview ) {
			return;
		}

		$languages = pll_the_languages( array( 'raw' => true ) );

		foreach ( $languages as $language ) {
			$this->all_domains[] = $language['url'];
			if ( false !== stripos( $language['url'], $_SERVER['SERVER_NAME'] ) ) {
				$current_language = PLL()->model->get_language( $language['slug'] );
				break;
			}
		}

		$this->current_domain   = $current_language->home_url;
		$this->default_domain   = $default_language->home_url;
		$this->current_language = $current_language->slug;
		$this->default_language = $default_language->slug;

		add_filter( 'script_loader_src', array( $this, 'translate_url' ) );
		add_filter( 'style_loader_src', array( $this, 'translate_url' ) );

		add_filter( 'allowed_http_origins', array( $this, 'add_allowed_origins' ) );

		add_filter( 'wp_get_attachment_image_attributes', array( $this, 'check_for_src' ), 10, 2 );
		add_filter( 'admin_url', array( $this, 'modify_adminy_url_for_ajax' ), 10, 3 );

		add_filter( 'post_row_actions', array( $this, 'elementor_links_fix' ), 12, 2 );
		add_filter( 'page_row_actions', array( $this, 'elementor_links_fix' ), 12, 2 );

		add_filter( 'elementor/editor/localize_settings', array( $this, 'translate_url_recursive' ) );
	}

	public function translate_url( $url ) {
		return str_replace( $this->default_domain, $this->current_domain, $url );
	}

	public function translate_url_recursive( $data ) {
		if ( is_string( $data ) ) {
			$data = $this->translate_url( $data );
		} elseif ( is_array( $data ) ) {
			$data = array_map( array( $this, 'translate_url_recursive' ), $data );
		}
		return $data;
	}

	public function add_allowed_origins( $origins ) {
		$origins[] = $this->current_domain;
		$origins   = array_merge( $origins, $this->all_domains );
		return $origins;
	}

	public function modify_adminy_url_for_ajax( $url, $path, $blog_id ) {
		if ( 'admin-ajax.php' == $path ) {
			return $this->translate_url( $url );
		}
		return $url;
	}

	public function check_for_src( $attr, $attachment ) {
		$attr['src']    = $this->translate_url( $attr['src'] );
		$attr['srcset'] = $this->translate_url( $attr['srcset'] );
		return $attr;
	}

	// change the edit and elementor-edit links in post table
	public function elementor_links_fix( $actions, $post ) {
		if ( empty( $actions['edit_with_elementor'] ) ) {
			return $actions;
		}
		if ( ! function_exists( 'pll_get_post_language' ) ) {
			return $actions;
		}

		if ( pll_get_post_language( $post->ID ) != pll_default_language() ) {
			$actions['edit']                = $this->translate_url( $actions['edit'] );
			$actions['edit_with_elementor'] = $this->translate_url( $actions['edit_with_elementor'] );
		}

		return $actions;
	}
}
