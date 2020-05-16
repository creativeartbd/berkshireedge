<?php
/**
 * The header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'everstrap_wp_body_open' ); ?>

<div class="site" id="page">
	<div class="header">		
		<?php                
		// Header top advertisement only for home page, category archive page and single post page        
		if( is_front_page() || is_category() || is_singular( 'post') ) {
			if( is_active_sidebar('header-home-archive-post-page-ad') ) {
				echo '<div class="container">';	
					dynamic_sidebar( 'header-home-archive-post-page-ad' );
				echo '</div>';
			}
		} elseif( is_post_type_archive( 'real-estate' ) || is_singular( 'real-estate') ) {
			if( is_active_sidebar( 'header-real-estate-archive-single-ad' ) ) {
				echo '<div class="container">';	
					dynamic_sidebar( 'header-real-estate-archive-single-ad' );
				echo '</div>';
			}
		} elseif( is_page( 'event') ) {
			if( is_active_sidebar( 'header-event-archive-single-ad' ) ) {
				echo '<div class="container">';	
					dynamic_sidebar( 'header-event-archive-single-ad' );
				echo '</div>';
			}
		} elseif( is_page() ) {
        	if( is_active_sidebar('header-home-archive-post-page-ad') ) {
				echo '<div class="container">';	
					dynamic_sidebar( 'header-home-archive-post-page-ad' );
				echo '</div>';
			}
        }
		?>
		
	<!-- ******************* The Navbar Area ******************* -->
		<div id="wrapper-navbar" itemscope itemtype="http://schema.org/WebSite">
			<a class="skip-link sr-only sr-only-focusable" href="#content"><?php esc_html_e( 'Skip to content', 'everstrap' ); ?></a>
			<nav id="main-nav" class="header-nav">
				<div class="container">
					<div class="row">
						<div class="col-9 col-sm-6 col-md-6">
							<div class="header-site-logo">
								<div class="sticky-logo">
									<?php everstrap_site_logo( 'site_header_sticky_logo' ); ?>
								</div>

								<div class="site-logo">
									<?php everstrap_site_logo( 'site_header_logo' ); ?>
								</div>

							</div>
						</div>
						<div class="col-3 col-sm-6 col-md-6">
							<div class="header-right-side">
								<i class="fa fa-search" aria-hidden="true" data-toggle="modal" data-target="#open_popup_search"></i>
								<?php
								if( everstrap_get_field( 'become_a_member', 'option' ) ) {
									echo do_shortcode( everstrap_get_field( 'become_a_member', 'option' ) );
								};
								?>
								<button type="button" class="hamburger-btn" data-toggle="modal" data-target="#open_nav">
									<span class="hamburger-icon"></span>
								</button>
							</div>
						</div>
					</div>
				</div><!-- .container -->
			</nav><!-- .site-navigation -->
		</div><!-- #wrapper-navbar end -->

		<!-- Popup Menu-->
		<div class="modal fade header-popup-nav-wrapper" id="open_nav" tabindex="-1" role="dialog" aria-hidden="true">
			<button type="button" class="btn btn-secondary close-popup" data-dismiss="modal">&#10005;</button>
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="popup-nav">
						<?php
						// Show category menus
						wp_nav_menu(
							array(
								'theme_location'  => 'category_menu',
								'container_class' => 'categories-menu-container',
								'container_id'    => 'categories-menu',
								'menu_class'      => 'categories-menu',
								'fallback_cb'     => '',
								'menu_id'         => 'main-menu',
								'depth'           => 2,
								'walker'          => new WP_Bootstrap_Navwalker(),
							)
						);

						// Become a member
						if( everstrap_get_field( 'become_a_member', 'option' ) ) {
							echo do_shortcode( everstrap_get_field( 'become_a_member', 'option' ) );
						};


						// Show Page menus
						wp_nav_menu(
							array(
								'theme_location'  => 'page_menu',
								'container_class' => 'pages-menu-container',
								'container_id'    => 'pages-menu',
								'menu_class'      => 'pages-menu',
								'fallback_cb'     => '',
								'menu_id'         => 'main-menu',
								'depth'           => 2,
								'walker'          => new WP_Bootstrap_Navwalker(),
							)
						);

						// Social Media
						if( everstrap_get_field('social_media', 'option' ) ) {
							echo do_shortcode( everstrap_get_field('social_media', 'option' ) );
						}

						// Site small logo
						$site_small_logo = everstrap_get_field('site_footer_logo', 'option');
						if( $site_small_logo ) {
							$site_small_logo = $site_small_logo['sizes']['site-footer-logo'];
							echo "<img src='{$site_small_logo}' />";
						}
						?>
					</div>
				</div>
			</div>
		</div>

		<!-- Popup Search-->
		<div class="modal fade header-popup-nav-wrapper" id="open_popup_search" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-search-dialog" role="document">
				<button type="button" class="btn btn-secondary close-popup" data-dismiss="modal">&#10005;</button>
				<div class="modal-content">
					<div class="popup-nav">
						<div class="popup-search-wrapper">
							<form action="<?php echo site_url( '/' ); ?>" method="get">
								<div class="input-group popup-search-input-group">
									<div class="input-group-append">
										<i class="fa fa-search"></i>
									</div>
									<input type="text" class="form-control" placeholder="Search The Berkshire Edge…" name="s" autocomplete="off">
									<input type="submit" class="search-enter-btn" value="Enter"/>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div><!-- .header end -->

