<?php
/**
 * Infinite Scroll Class
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/* Check if Class Exists. */
if ( ! class_exists( 'Everstrap_Infinite_Scroll' ) ) {

	class Everstrap_Infinite_Scroll {
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
			add_filter( 'es_get_infinite_scroll_template', array( $this, 'get_template_part' ), 10, 2 );
			add_filter( 'everstrap_infinite_scroll_nav', array( $this, 'infinite_scroll_nav' ), 10 );
			add_action( 'wp_ajax_es_get_next_post', array( $this, 'get_next_post' ) );
			add_action( 'wp_ajax_nopriv_es_get_next_post', array( $this, 'get_next_post' ) );
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
		 * Get linked to posts
		 */
		public function get_linked_to_posts() {
			$posts = get_posts(
				array(
					'posts_per_page' => - 1,
					'meta_query'     => array(
						array(
							'key'     => '_links_to',
							'value'   => '',
							'compare' => '!=',
						),
					),
				)
			);

			return wp_list_pluck( $posts, 'ID' );
		}

		/**
		 * Get the next post ID
		 *
		 * @return int|string $next_post_id
		 */
		public function get_next_post_id() {
			$next_post    = get_previous_post();
			$next_post_id = ! empty( $next_post ) && isset( $next_post->ID ) ? $next_post->ID : '';

			$excludes = $this->get_linked_to_posts();

			$max_ex = 50;
			$ex     = 0;

			while ( in_array( $next_post_id, $excludes ) ) {
				if ( $ex > $max_ex ) {
					break;
				}

				$GLOBALS['post'] = $next_post;

				$next_post    = get_previous_post();
				$next_post_id = ! empty( $next_post ) && isset( $next_post->ID ) ? $next_post->ID : '';

				$ex ++;
			}

			return $next_post_id;
		}

		/**
		 * The "Infinite Scroll" Nav
		 */
		public function infinite_scroll_nav() {
			$next_post_id = $this->get_next_post_id();
			printf( '<div class="everstrap-next-post-nav" data-id="%d"></div>', esc_attr( $next_post_id ) );
		}

		/**
		 * The AJAX call back function
		 */
		public function get_next_post() {
			$post_id = ! empty( $_POST['id'] ) ? $_POST['id'] : false;

			if ( false === $post_id ) {
				wp_send_json_error( 'Post ID required!' );
			}

			$query = new WP_Query(
				array(
					'p'         => $post_id,
					'tax_query' => array(
						array(
							'taxonomy' => 'post_format',
							'field'    => 'slug',
							'terms'    => array( 'post-format-link' ),
							'operator' => 'NOT IN',
						),
					),
				)
			);

			$GLOBALS['wp_query'] = $query;

			$next_post_id = '';
			$next_url     = '';
			$next_title   = '';

			ob_start();
			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();
					?>

					<div class="fadeInUp">
						<?php apply_filters( 'es_get_infinite_scroll_template', 'loop-templates/content', 'single' ); ?>
					</div>

					<?php
					$next_url   = get_the_permalink();
					$next_title = wp_get_document_title();

					$next_post_id = $this->get_next_post_id();
				}
			}

			$post_view = ob_get_clean();

			wp_send_json_success(
				array(
					'next_id'    => $next_post_id,
					'next_url'   => $next_url,
					'next_title' => $next_title,
					'post_view'  => $post_view,
				)
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

					var everstrapAjaxUrl='<?php echo admin_url( 'admin-ajax.php' ); ?>';

					var app = {
						initialize: function () {
							app.nextPostForSingle();	
							app.openCommentForm();						
						},

						openCommentForm: function() {
							$('.single-post-comment').on('click', function() {								
								var that = $(this);
								that.parent().next('.post-comments').toggle();
							});		
						},

						nextPostForSingle: function() {
							if ( $( 'body' ).hasClass( 'single-post' ) ) {
								$( window ).on( 'scroll', function( ) {									
									var target_pos = $('.everstrap-next-post-nav').position();
									if( ( target_pos.top - window.scrollY - window.outerHeight ) < 100 && ! app.postCalled ) {
										app.postCalled = true;
										app.getSinglePostByAjax();
										app.openCommentForm();
									}
								} );
							}
						},

						getSinglePostByAjax: function() {
							var postId = $('.everstrap-next-post-nav').data( 'id' );
							console.log(postId);

							// I want to stop it here because I want tos how only 5 posts on scroll
							var fadeInUp = $(".fadeInUp").length;
							if( fadeInUp == 5 ) {
								return;
							}
							// I want to stop it here because I want tos how only 5 posts on scroll
							
							if ( postId === '' || postId === 0 ) {
								return;
							}

							$.ajax( {
								method: 'POST',
								url: everstrapAjaxUrl,
								data: {
									action: 'es_get_next_post',
									id: postId
								}
							} ).done( function( res ) {
								$( res.data.post_view ).insertBefore('.everstrap-next-post-nav');
								$('.everstrap-next-post-nav').data( 'id', res.data.next_id );

								var theTitle = $( '<div />' ).html( res.data.next_title ).text();

								window.history.pushState( { pageTitle: theTitle }, '', res.data.next_url );
								document.title = theTitle;								
							} ).always( function() {
								app.postCalled = false;
							} );
						},

					};
					$(document).ready(app.initialize);

					return app;
				})(window, document, jQuery);
			</script>
			<?php
		}
	}

}


Everstrap_Infinite_Scroll::instance();
