<?php
/**
 * Declaring widgets
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Add filter to the parameters passed to a widget's display callback.
 * The filter is evaluated on both the front and the back end!
 *
 * @link https://developer.wordpress.org/reference/hooks/dynamic_sidebar_params/
 */
add_filter( 'dynamic_sidebar_params', 'everstrap_widget_classes' );

if ( ! function_exists( 'everstrap_widget_classes' ) ) {
	/**
	 * Count number of visible widgets in a sidebar and add classes to widgets accordingly,
	 * so widgets can be displayed one, two, three or four per row.
	 *
	 * @global array $sidebars_widgets
	 *
	 * @param array $params {
	 *     @type array $args  {
	 *         An array of widget display arguments.
	 *
	 *         @type string $name          Name of the sidebar the widget is assigned to.
	 *         @type string $id            ID of the sidebar the widget is assigned to.
	 *         @type string $description   The sidebar description.
	 *         @type string $class         CSS class applied to the sidebar container.
	 *         @type string $before_widget HTML markup to prepend to each widget in the sidebar.
	 *         @type string $after_widget  HTML markup to append to each widget in the sidebar.
	 *         @type string $before_title  HTML markup to prepend to the widget title when displayed.
	 *         @type string $after_title   HTML markup to append to the widget title when displayed.
	 *         @type string $widget_id     ID of the widget.
	 *         @type string $widget_name   Name of the widget.
	 *     }
	 *     @type array $widget_args {
	 *         An array of multi-widget arguments.
	 *
	 *         @type int $number Number increment used for multiples of the same widget.
	 *     }
	 * }
	 * @return array $params
	 */
	function everstrap_widget_classes( $params ) {

		global $sidebars_widgets;

		/*
		 * When the corresponding filter is evaluated on the front end
		 * this takes into account that there might have been made other changes.
		 */
		$sidebars_widgets_count = apply_filters( 'sidebars_widgets', $sidebars_widgets ); //phpcs:ignore

		// Only apply changes if sidebar ID is set and the widget's classes depend on the number of widgets in the sidebar.
		if ( isset( $params[0]['id'] ) && strpos( $params[0]['before_widget'], 'dynamic-classes' ) ) {
			$sidebar_id   = $params[0]['id'];
			$widget_count = count( $sidebars_widgets_count[ $sidebar_id ] );

			$widget_classes = 'widget-count-' . $widget_count;
			if ( 0 === $widget_count % 4 || $widget_count > 6 ) {
				// Four widgets per row if there are exactly four or more than six.
				$widget_classes .= ' col-md-3';
			} elseif ( 6 === $widget_count ) {
				// If two widgets are published.
				$widget_classes .= ' col-md-2';
			} elseif ( $widget_count >= 3 ) {
				// Three widgets per row if there's three or more widgets.
				$widget_classes .= ' col-md-4';
			} elseif ( 2 === $widget_count ) {
				// If two widgets are published.
				$widget_classes .= ' col-md-6';
			} elseif ( 1 === $widget_count ) {
				// If just on widget is active.
				$widget_classes .= ' col-md-12';
			}

			// Replace the placeholder class 'dynamic-classes' with the classes stored in $widget_classes.
			$params[0]['before_widget'] = str_replace( 'dynamic-classes', $widget_classes, $params[0]['before_widget'] );
		}

		return $params;

	}
}

add_action( 'widgets_init', 'everstrap_widgets_init' );

if ( ! function_exists( 'everstrap_widgets_init' ) ) {
	/**
	 * Initializes themes widgets.
	 */
	function everstrap_widgets_init() {

		// ================================= 
		// Header advertisement start here
		// =================================
		register_sidebar(
			array(
				'name'          => __( 'Ad for header home, archive, post & page', 'everstrap' ),
				'id'            => 'header-home-archive-post-page-ad',
				'description'   => 'Add header home, archive, single post and page ad',
				'before_widget' => '<div class="header-ad">',
				'after_widget'  => '</div>',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Ad for header real estate archive & single page', 'everstrap' ),
				'id'            => 'header-real-estate-archive-single-ad',
				'description'   => 'Add header real estate archive and single page ad',
				'before_widget' => '<div class="header-ad">',
				'after_widget'  => '</div>',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Ad for header event archive & singel page', 'everstrap' ),
				'id'            => 'header-event-archive-single-ad',
				'description'   => 'Add footer event archive & single page add',
				'before_widget' => '<div class="header-ad">',
				'after_widget'  => '</div>',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		// ================================= 
		// Header advertisement end here
		// =================================
	
		// =========================================== 
		// Home right top & bottom  sidebar start here
		// ===========================================

		register_sidebar(
			array(
				'name'          => __( 'Home Right Top Sidebar', 'everstrap' ),
				'id'            => 'home-right-top-sidebar',
				'description'   => __( 'Home top right sidebarr widget area', 'everstrap' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Home Right Bottom Sidebar', 'everstrap' ),
				'id'            => 'home-right-bottom-sidebar',
				'description'   => __( 'Home bottom right sidebare widget area', 'everstrap' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);

		// ======================================== 
		// Home right top & bottom sidebar end here
		// ========================================

		// ===============================
		// Real Estate sidebar start here
		// ===============================

		register_sidebar(
			array(
				'name'          => __( 'Real Estate Sidebar', 'everstrap' ),
				'id'            => 'real-estate-sidebar',
				'description'   => __( 'Real Esate sidebar widget area', 'everstrap' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);

		// ===============================
		// Real Estate sidebar end here
		// ===============================

		// ===============================
		// Event page sidebar start here
		// ===============================

		register_sidebar(
			array(
				'name'          => __( 'Event page Sidebar', 'everstrap' ),
				'id'            => 'event-sidebar',
				'description'   => __( 'Event page sidebar widget area', 'everstrap' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);

		// ===============================
		// Event page  sidebar end here
		// ===============================

		// ===============================
		// Wedding page sidebar start here
		// ===============================

		register_sidebar(
			array(
				'name'          => __( 'Wedding page Sidebar', 'everstrap' ),
				'id'            => 'wedding-sidebar',
				'description'   => __( 'Wedding page sidebar widget area', 'everstrap' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);

		// ===============================
		// Wedding page  sidebar end here
		// ===============================

		// ===============================
		// Wedding page header start here
		// ===============================

		register_sidebar(
			array(
				'name'          => __( 'Ad for wedding header archive & page', 'everstrap' ),
				'id'            => 'wedding-header-archive-single',
				'description'   => 'Add wedding header archive & single page ad',
				'before_widget' => '<div class="header-ad">',
				'after_widget'  => '</div>',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		// ===============================
		// Wedding page header end here
		// ===============================


		// ===============================
		// Media kit wdiget start here
		// ===============================

		register_sidebar(
			array(
				'name'          => __( 'Media kit widget', 'everstrap' ),
				'id'            => 'media-kit-widget',
				'description'   => 'Add media kit widget shortocde',
				'before_widget' => '<div class="media-kit">',
				'after_widget'  => '</div>',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		// ===============================
		// Media kit wdiget end here
		// ===============================


		register_sidebar(
			array(
				'name'          => __( 'Home page subscribe now', 'everstrap' ),
				'id'            => 'home-page-subscribe-now',
				'description'   => 'Add subscribe now shortcode to the middle of the home page',
				'before_widget' => '<div class="home-page-subscribe-now">',
				'after_widget'  => '</div>',
				'before_title'  => '',
				'after_title'   => '',
			)
		);


		register_sidebar(
			array(
				'name'          => __( 'Right Top Sidebar', 'everstrap' ),
				'id'            => 'right-top-sidebar',
				'description'   => __( 'Top Right Sidebar widget area', 'everstrap' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Right Bottom Sidebar', 'everstrap' ),
				'id'            => 'right-bottom-sidebar',
				'description'   => __( 'Top Right Sidebar widget area', 'everstrap' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Single Post Right Sidebar', 'everstrap' ),
				'id'            => 'single-right-sidebar',
				'description'   => __( 'Single Post Right Sidebar widget area', 'everstrap' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Author Right Sidebar', 'everstrap' ),
				'id'            => 'author-right-sidebar',
				'description'   => __( 'Author Right Sidebar widget area', 'everstrap' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Advertisement author page', 'everstrap' ),
				'id'            => 'author-page-ad',
				'description'   => 'Add author page advertisement here',
				'before_widget' => '<div class="author-page-ad">',
				'after_widget'  => '</div>',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Advertisement event page', 'everstrap' ),
				'id'            => 'event-page-ad',
				'description'   => 'Add event page advertisement here',
				'before_widget' => '<div class="event-page-ad">',
				'after_widget'  => '</div>',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Advertisement real estate single page', 'everstrap' ),
				'id'            => 're-archive-single-ad-single',
				'description'   => 'Add real estate archive and single page advertisement',
				'before_widget' => '<div class="re-archive-single-ad-single">',
				'after_widget'  => '</div>',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		
	

		register_sidebar(
			array(
				'name'          => __( 'Advertisement directory page', 'everstrap' ),
				'id'            => 'directory-page-ad',
				'description'   => 'Add directory page advertisement here',
				'before_widget' => '<div class="directory-page-ad">',
				'after_widget'  => '</div>',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Advertisement single post bottom', 'everstrap' ),
				'id'            => 'single-post-ad',
				'description'   => 'Add single post advertisement here',
				'before_widget' => '<div class="single-post-ad">',
				'after_widget'  => '</div>',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Advertisement Real Estate Archive', 'everstrap' ),
				'id'            => 'real-estate-archive-ad',
				'description'   => 'Add real estate archive advertisement here',
				'before_widget' => '<div class="real-estate-archive-ad">',
				'after_widget'  => '</div>',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Advertisement Category Archive', 'everstrap' ),
				'id'            => 'category-archive-ad',
				'description'   => 'Add category archive advertisement here',
				'before_widget' => '<div class="category-archive-ad">',
				'after_widget'  => '</div>',
				'before_title'  => '',
				'after_title'   => '',
			)
		);
		

		register_sidebar(
			array(
				'name'          => __( 'Advertisement Top Latest Stories', 'everstrap' ),
				'id'            => 'top-latest-stories-advertisement',
				'description'   => 'Add top latest news advertisement',
				'before_widget' => '<div class="top-latest-stories-advertisement">',
				'after_widget'  => '</div>',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Advertisement loop Latest Stories', 'everstrap' ),
				'id'            => 'loop-latest-stories-advertisement',
				'description'   => 'Add advertisement between the latest stories loop',
				'before_widget' => '<div class="loop-latest-stories-advertisement">',
				'after_widget'  => '</div>',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Advertisement Bottom Sidebar One', 'everstrap' ),
				'id'            => 'ad-bottom-sidebar-1',
				'description'   => 'Add bottom right sidebar advertisement',
				'before_widget' => '<div class="bottom-sidebar">',
				'after_widget'  => '</div>',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Advertisement Bottom Sidebar Two', 'everstrap' ),
				'id'            => 'ad-bottom-sidebar-2',
				'description'   => 'Add bottom right sidebar advertisement',
				'before_widget' => '<div class="bottom-sidebar">',
				'after_widget'  => '</div>',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Advertisement Bottom Sidebar Three', 'everstrap' ),
				'id'            => 'ad-bottom-sidebar-3',
				'description'   => 'Add bottom right sidebar advertisement',
				'before_widget' => '<div class="bottom-sidebar">',
				'after_widget'  => '</div>',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Advertisement Bottom Sidebar Four', 'everstrap' ),
				'id'            => 'ad-bottom-sidebar-4',
				'description'   => 'Add bottom right sidebar advertisement',
				'before_widget' => '<div class="bottom-sidebar">',
				'after_widget'  => '</div>',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Advertisement Bottom Sidebar Five', 'everstrap' ),
				'id'            => 'ad-bottom-sidebar-5',
				'description'   => 'Add bottom right sidebar advertisement',
				'before_widget' => '<div class="bottom-sidebar">',
				'after_widget'  => '</div>',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Footer Copyright', 'everstrap' ),
				'id'            => 'everstrap_footer_copyright',
				'description'   => 'Add footer copyright text here',
				'before_widget' => '<div class="footer-copyright">',
				'after_widget'  => '</div>',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		// ================================= 
		// Footer advertisement start here
		// =================================
		register_sidebar(
			array(
				'name'          => __( 'Ad for footer home, archive, post & page', 'everstrap' ),
				'id'            => 'footer-home-archive-post-page-ad',
				'description'   => 'Add footer home, archive, single post and page ad',
				'before_widget' => '',
				'after_widget'  => '',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Ad for footer real estate archive & single page', 'everstrap' ),
				'id'            => 'footer-real-estate-archive-single-ad',
				'description'   => 'Add footer real estate archive and single page ad',
				'before_widget' => '',
				'after_widget'  => '',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Ad for footer event archive & singel page', 'everstrap' ),
				'id'            => 'footer-event-archive-single-ad',
				'description'   => 'Add footer event archive & single page add',
				'before_widget' => '',
				'after_widget'  => '',
				'before_title'  => '',
				'after_title'   => '',
			)
		);
		// ================================= 
		// Footer advertisement end here
		// =================================

		register_sidebar( array(
			'name'          => 'Calendar Header',
			'id'            => 'cal_header',
			'before_widget' => '<div>',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="rounded">',
			'after_title'   => '</h2>',
		) );
		register_sidebar( array(
			'name'          => 'Calendar Center',
			'id'            => 'cal_center',
			'before_widget' => '<div>',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="rounded">',
			'after_title'   => '</h2>',
		) );
		register_sidebar( array(
			'name'          => 'Calendar Sidebar',
			'id'            => 'cal_side_top',
			'before_widget' => '<div>',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="rounded">',
			'after_title'   => '</h2>',
		) );
		
	}
}

/**
 * Adds ECP_Extended_Widget widget.
 */
if( !class_exists( 'ECP_Extended_Widget' ) ) {
	class ECP_Extended_Widget extends WP_Widget
	{

		/**
		 * Register widget with WordPress.
		 */

		function __construct()
		{
			add_action('widgets_init', array($this, 'register_ecp_widget'));
			parent::__construct(
				'ecp_widget', // Base ID
				esc_html__('Event Calendar Pro', 'event-calendar-pro'),
				array('description' => esc_html__('Show and Filters Events', 'event-calendar-pro'))
			);
		}

		/**
		 * Front-end display of widget.
		 *
		 * @param array $args Widget arguments.
		 * @param array $instance Saved values from database.
		 * @see WP_Widget::widget()
		 *
		 */
		public function widget($widget_args, $instance)
		{

			echo $widget_args['before_widget'];

			if (!empty($instance['title'])) {
				echo '<h2>' . apply_filters('widget_title', $instance['title']) . '</h2>';
			}

			$events_page = ecp_get_settings('events_page', 'calendar', 'event_calendar_pro_page_settings');

			$date = get_query_var('date');

			if (empty($date)) {
				$date = date('Y-m-d', current_time('timestamp'));
			}

			$args = array(
				'order_by' => 'event_start_date',
				'order' => 'DESC',
			);

			if (!empty($date)) {
				$args['start_date'] = $date;
			}

			$args = apply_filters('ecp_widget_events_query_args', $args);

			$events = everstrap_get_event_list($args);

			ob_start();
			ecp_get_template('widget/main.php', ['events' => $events, 'events_page' => $events_page]);
			$html = ob_get_clean();

			echo $html;

			echo $widget_args['after_widget'];
		}

		/**
		 * Back-end widget form.
		 *
		 * @param array $instance Previously saved values from database.
		 * @see WP_Widget::form()
		 *
		 */
		public function form($instance)
		{
			$title = !empty($instance['title']) ? $instance['title'] : esc_html__('Calendar', 'event-calendar-pro');
			?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
					<?php esc_attr_e('Title:', 'event-calendar-pro'); ?>
				</label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
					   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
					   value="<?php echo esc_attr($title); ?>">
			</p>
			<?php
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 * @see WP_Widget::update()
		 *
		 */
		public function update($new_instance, $old_instance)
		{
			$instance = array();
			$instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';

			return $instance;
		}

		// register ECP_Widget widget
		public function register_ecp_widget()
		{
			register_widget('ECP_Extended_Widget');
		}

	}

	new ECP_Extended_Widget();
}
