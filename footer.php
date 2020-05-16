<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ); ?>


<?php
// ===================================
// Footer Advertisement
// ===================================
if( is_front_page() || is_category() || is_singular( 'post') ) {
	if( is_active_sidebar('footer-home-archive-post-page-ad') ) {
		echo '<div class="container">';	
			dynamic_sidebar( 'footer-home-archive-post-page-ad' );
		echo '</div>';
	}
} elseif( is_post_type_archive( 'real-estate' ) || is_singular( 'real-estate') ) {
	if( is_active_sidebar( 'footer-real-estate-archive-single-ad' ) ) {
		echo '<div class="container">';	
			dynamic_sidebar( 'footer-real-estate-archive-single-ad' );
		echo '</div>';
	}
} elseif( is_page( 'event') ) {
	if( is_active_sidebar( 'footer-event-archive-single-ad' ) ) {
		echo '<div class="container">';	
			dynamic_sidebar( 'footer-event-archive-single-ad' );
		echo '</div>';
	}
} elseif( is_page() ) {
	if( is_active_sidebar('footer-home-archive-post-page-ad') ) {
		echo '<div class="container">';	
			dynamic_sidebar( 'footer-home-archive-post-page-ad' );
		echo '</div>';
	}
}
?>

<div class="wrapper footer-area" id="wrapper-footer">
	<div class="container">
		<div class="row">
			
			
			
			<div class="col-12 col-sm-12 col-md-6">
				<?php
				// Footer pages menu
				if( has_nav_menu( 'page_menu') ) {
					echo '<div class="footer-nav-wrapper">';
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
					echo '</div>';
				}
				?>
			</div>
			<div class="col-12 col-sm-12 col-md-6">
				<div class="footer-search-wrapper">
					<i class="fa fa-search" aria-hidden="true" data-toggle="modal" data-target="#open_popup_search"></i>
					<?php
					// Become a member
					if( everstrap_get_field( 'become_a_member', 'option' ) ) {
						echo do_shortcode( everstrap_get_field( 'become_a_member', 'option' ) );
					};
					?>
				</div>
			</div>
		</div><!-- row end -->
		<div class="row">
			<div class="col-md-4">
				<div class="social-wrapper">
					<?php
					// Social Media
					if( everstrap_get_field('social_media', 'option' ) ) {
						echo do_shortcode( everstrap_get_field('social_media', 'option' ) );
					}
					?>
				</div>
			</div>
			<div class="col-md-8">
				<div class="footer-logo-wrapper">
					<?php everstrap_footer_logo(); ?>
				</div>
			</div>
		</div><!-- row end -->
		<div class="footer-bottom">
			<div class="row">
				<div class="col-12 col-sm-12 col-md-12 text-center">
					<?php
					if( is_active_sidebar( 'everstrap_footer_copyright' ) ) {
						dynamic_sidebar( 'everstrap_footer_copyright' );
					}
					?>
				</div>
			</div><!-- row end -->
		</div><!-- footer bottom end -->
	</div><!-- container end -->
</div><!-- wrapper end -->

</div><!-- #page we need this extra closing tag here -->

<?php wp_footer(); ?>


<?php
// Disable subscription box from theme options
$disable_subscripton_box = everstrap_get_field( 'disable_subscripton_box', 'option' );
if( !$disable_subscripton_box ) {
	if( !current_user_can('editor') && !current_user_can('administrator') ) {
		if( !edge_have_any_plan() ) { // Check that user has any plan
			if( !is_page_template( 'page-templates/membership.php' ) ) {
			?>
			<!-- Popup message box 2 -->
			<div class="modal fade subscription-box-two" id="subscription-box-two" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<span class="close" data-dismiss="modal">&#10005</span>
						<h1><?php _e( 'Coronavirus Alert!', 'everstrap' ); ?></h1>
						<h2><?php _e( 'The Edge delivers the news you need NOW', 'everstrap' ); ?></h2>
						<ul>
							<li> In this crisis, we need each other.</li>
							<li> If we're helping you,please help sustain us.</li>
							<li> JOIN THE EDGE AS A MEMBER.</li>
						</ul>
						<div class="signup-wrapper">
							<?php
							$become_a_member_page = everstrap_get_field( 'become_a_member_page', 'option' );
							if( $become_a_member_page ) {
								$become_a_member_page = $become_a_member_page;
							} else {
								$become_a_member_page = '';
							}
							?>
							<a href="<?php echo $become_a_member_page; ?>"><?php _e( 'Sign Up Now', 'everstrap' ); ?></a>
						</div>
					</div>
				</div>
			</div>
			<!-- Popup message box 2 -->
		<?php
			}
		}
	}
}

?>


<div class="modal fade subscription-box-one" id="subscription-box-one" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<span class="close" data-dismiss="modal">&#10005</span>
			<h1><?php _e( 'Support a lively and independent voice for the Berkshires.', 'everstrap' ); ?></h1>
			<h2><?php _e( 'Become an Edge Member and get:', 'everstrap' ); ?></h2>
			<ul>
				<li> > Continued Berkshire Edge coverage.</li>
				<li> > Daily email updates of latest stories.</li>
				<li> > Recognition on our Membership Page.*</li>
			</ul>
			<?php
			$become_a_member_page = everstrap_get_field( 'become_a_member_page', 'option' );
			if( $become_a_member_page ) {
				$become_a_member_page = $become_a_member_page;
			} else {
				$become_a_member_page = '';
			}
			?>
			<div class="signup-wrapper">
				<a href="<?php echo $become_a_member_page; ?>"><?php _e( 'Sign Up Now', 'everstrap' ); ?></a>
			</div>
		</div>
	</div>
</div>



</body>
</html>
