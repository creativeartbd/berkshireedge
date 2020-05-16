<?php
/**
 * Custom functions that affect the /wp-admin/ area
 *
 * @package everstrap
 */

/* EverStrap news dashboard widget */

add_action( 'wp_dashboard_setup', 'everstrap_dashboard_news_meta_box' );

function everstrap_dashboard_news_meta_box() {
	add_meta_box( 'everstrap-news', 'EverStrap News', 'everstrap_news_widget_render', 'dashboard', 'side', 'high' );
}

function everstrap_news_widget_render() {
	include_once ABSPATH . WPINC . '/feed.php';
	$everstrap_news_last_checked = get_option( 'everstrap_news_last_checked' );
	$everstrap_news_url          = 'https://webpublisherpro.com/';
	$this_site_parsed            = wp_parse_url( get_site_url() );
	if ( ! $everstrap_news_last_checked ) {
		$everstrap_news_url .= '?fi_ti=' . $this_site_parsed['host'];
		update_option( 'everstrap_news_last_checked', time() );
	}
	$rss       = fetch_feed( $everstrap_news_url );
		
	if( !is_wp_error( $rss ) ) {

		$maxitems  = $rss->get_item_quantity( 5 );
		$rss_items = $rss->get_items( 0, $maxitems );
		?>
		<style>
			.everstrap_news_feed li {
				border-top: 1px solid #eee;
				padding-top: 14px;
			}

			.everstrap_news_feed li:last-child {
				border-bottom: 1px solid #eee;
			}

			.everstrap_news_feed li .wordpress-feed__post-link {
				font-size: 16px;
			}

			.everstrap_news_feed li p {
				margin-top: 0.65rem;
			}

			.everstrap_news_feed .feed_item_0 a {
				color: #2c9600;
				font-weight: 600;
			}
		</style>
		<div class="wordpress-feed everstrap_news_feed">
			<h3 class="wordpress-feed__header"><em>Latest blog posts on webpublisherpro.com</em></h3>
			<ul class="wordpress-feed__posts" role="list">
				<?php
				if ( 0 === $maxitems ) {
					echo '<li>No items</li>';
				} else {
					foreach ( $rss_items as $feed_count => $item ) {
						$the_description = wp_strip_all_tags( $item->get_description() );
						?>
						<li class="wordpress-feed__post feed_item_<?php echo $feed_count; ?>">
							<a class="wordpress-feed__post-link" href="<?php echo esc_url( $item->get_permalink() ); ?>?swpdb=27" target="_blank"><span class="dashicons dashicons-admin-post"></span> <?php echo esc_html( $item->get_title() ); ?></a>
							<?php
							if ( 0 === $feed_count ) {
								echo '<small>NEW</small>';
							}
							?>
							<p class="wordpress-feed__post-description">
								<?php echo trim( substr( $the_description, 0, 140 ) ) . '... <a href="' . esc_url( $item->get_permalink() ) . '"><small>Read More</small></a>'; ?>
							</p>
						</li>
						<?php
					}
				}
				?>
			</ul>
			<div class="wordpress-feed__footer">
				<a class="wordpress-feed__footer-link" href="https://webpublisherpro.com/" target="_blank">Read more like this On webpublisherpro.com</a></div>
		</div>
	<?php
    }
}
