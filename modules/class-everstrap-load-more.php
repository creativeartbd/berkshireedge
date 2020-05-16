<?php
/**
 * Load More Class
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/* Check if Class Exists. */
if ( ! class_exists( 'Everstrap_Load_More' ) ) {

	class Everstrap_Load_More {
		/**
		 * The single instance of the class.
		 *
		 * @var Everstrap_Load_More
		 */
		protected static $instance = null;
	

		/**
		 * Main Everstrap_Load_More Instance.
		 *
		 * Ensures only one instance of Everstrap_Load_More is loaded or can be loaded.
		 *
		 * @return Everstrap_Load_More - Main instance.
		 * @since 1.0.0
		 * @static
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Everstrap_Load_More Constructor.
		 */
		public function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_script' ) );
			add_action( 'wp_footer', array( $this, 'load_script' ), 1000 );
			add_filter( 'es_get_template_part', array( $this, 'get_template_part' ), 10, 2 );
			add_filter( 'everstrap_load_more_button', array( $this, 'load_more_button' ), 10, 3 );
			add_action( 'wp_ajax_es_load_more', array( $this, 'load_more' ) );
			add_action( 'wp_ajax_nopriv_es_load_more', array( $this, 'load_more' ) );
		}

		/**
		 * Get the template for html binding with post data
		 *
		 * @param $slug
		 * @param $name
		 */
		public function get_template_part( $slug, $name ) {

			get_template_part( $slug, $name );
		}

		/**
		 * The "Load More" Button
		 *
		 * @param array  $args   Query arguments for a getting the posts
		 * @param string $title Text of the button
		 */
		public function load_more_button( $args = array(), $title = 'Load More', $button_class = '' ) {
			$args = wp_parse_args(
				$args,
				array(
					'posts_per_page' => 4,
					'offset'         => 0,
					'category'       => '',
					'category_name'  => '',
					'order'          => 'ASC',
					'post_type'      => '',
					'post_status'    => 'publish',
				)
			);	

			printf( '<a href="#" class="es-load-more %s" data-args="%s" data-action="rfa_get_more_news">%s </a>', $button_class, esc_js( json_encode( $args ) ), $title );
		}

		/**
		 * The AJAX call back function
		 */
		public function load_more() {
			global $post;

			$posts = get_posts( $_REQUEST );

			$template_name = isset( $_REQUEST['template_name'] ) ? $_REQUEST['template_name'] : '';

			ob_start();

			if ( ! empty( $posts ) ) {
				foreach ( $posts as $post ) {

					setup_postdata( $post );

					//apply_filters( 'es_get_template_part', 'loop-templates/content', get_post_format() );
					apply_filters( 'es_get_template_part', 'loop-templates/content', $template_name );

					wp_reset_postdata();
				}
			}

			$html = ob_get_contents();
			ob_clean();

			$query           = $_REQUEST;
			$query['offset'] = intval( $query['offset'] ) + $query['posts_per_page'];

			wp_send_json_success(
				[
					'query' => $query,
					'posts' => $html,
				]
			);
		}

		/**
		 * Enqueues the dependency script - wp-util.js
		 */
		public function enqueue_script() {
			wp_enqueue_script( 'wp-util' );
		}

		/**
		 * The script with AJAX
		 */
		public function load_script() {
			?>
			<script type="application/javascript">
				window.Project = (function (window, document, $, undefined) {
					'use strict';

					var app = {
						initialize: function () {
							$('.es-load-more').on('click', app.handleLoadMore);
						},

						handleLoadMore: function (e) {
							e.preventDefault();

							var $button = $(this),
								query = $button.data('args');
							var $button_2 = $('.author-load-more-post');

							$button.text('Loading....');

							wp.ajax.send('es_load_more', {
								data: query,

								success: function (res) {
									$button.text('Load More Stories');

									if (res.posts) {
										query.offset = res.query.offset;
										$button_2.before(res.posts);
										$button.attr('data-args', query);
									} else {
										$button.text('No More Story');
										$button.prop('disabled', true);
									}
								},
								error: function (error) {
									$button.text('No More Story');
								}
							});

							return false;
						}

					};
					$(document).ready(app.initialize);

					return app;
				})(window, document, jQuery);
			</script>
			<?php
		}
	}

}


Everstrap_Load_More::instance();
