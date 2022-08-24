<?php namespace WSUWP\Theme\WDS; 

/* The page template is used both for the front-page (home) template
* and and individual page. Therefore we need to check our context
*/
$context = ( is_front_page() ) ? 'home' : 'page';
$show_breadcrumbs = ( 'home' === $context ) ? false : true;
?>
<?php get_header(); ?>
<?php get_template_part( 'template-component/component-global-header', $context ); ?>
<?php get_template_part( 'template-component/component-site-navigation-vertical', $context ); ?>
<!-- SITE WRAPPER:START -->
<div class="wsu-wrapper-site">
	<!-- SITE CONTAINER:START -->
	<?php Template_Part::get( 'site-header', 'page' ); ?>
	<div class="wsu-wrapper-content <?php echo esc_attr( WDS_Options::get_option_class( 'template', 'width', 'wsu-wrapper-content--' ) ); ?>">
		<?php do_action('wsu_wds_theme_before_main', $context); ?>
		<main role="main" id="wsu-content" class="wsu-wrapper-main" tabindex="-1">
			<?php do_action('wsu_wds_theme_main', $context); ?>
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
				<?php 
					$image_full_src = wp_get_attachment_image_src( get_the_ID(), 'full' );
					$image_web_src  = wp_get_attachment_image_src( get_the_ID(), 'web' );
					$image_html     = wp_get_attachment_image( get_the_ID(), 'large' );
				?>
				<?php if ( get_theme_mod( 'wsu_wds_template_' . $context . '_show_breadcrumbs', $show_breadcrumbs ) && apply_filters( 'wsu_wds_template_show_title', true ) ) : ?>
					<?php get_template_part( 'template-component/component-breadcrumb', $context ); ?>
				<?php endif; ?>
				<?php do_action('wsu_wds_theme_after_breadcrumbs', $context); ?>
				<article class="wsu-article">
					<?php if ( get_theme_mod( 'wsu_wds_template_' . $context . '_show_title', true ) && apply_filters( 'wsu_wds_template_show_title', true ) ) : ?>
						<header class="wsu-article-header">
							<h1  class="wsu-article-header__title">File: <?php the_title(); ?></h1>
							<?php if ( get_theme_mod( 'wsu_wds_template_' . $context . '_show_publish_date', false ) ) : ?><?php get_template_part( 'template-component/component-post-published-date', $context ); ?><?php endif; ?>
						</header>
					<?php endif; ?>
					<?php do_action( 'wsu_wds_theme_after_header', $context); ?>
					<div class="wsu-row wsu-row--sidebar-right">
						<div class="wsu-column">
							<?php echo wp_kses_post( $image_html ); ?>
							<p><?php echo wp_kses_post( wp_get_attachment_caption( get_the_ID() ) ); ?></p>
						</div>
						<div class="wsu-column">
							<h2>Image Sizes</h2>
							<div class="wsu-cta ">
								<a class="wsu-button wsu-button--style-action" href="<?php echo esc_url( $image_full_src[0] ); ?>" download="" >Download Full Size</a>
							</div>
							<div class="wsu-cta ">
								<a class="wsu-button wsu-button--style-action" href="<?php echo esc_url( $image_web_src[0] ); ?>" download="">Download Web Size (1900px)</a>
							</div>
							<hr />

							<div class="wsu-meta-categories">
								<?php 
									$terms = get_the_terms( get_the_ID() , 'category' );
									if ( ! empty( $terms ) ) {

										echo 'Categories: ';

										foreach ( $terms as $term ) {
											echo '<a href="' . get_bloginfo( 'url' ) . '/gallery/?photo-term=' . $term->slug . '&photo-taxonomy=category">' . $term->name . '</a>';
										}
									}
								?>
							</div>
							<div class="wsu-meta-categories">
								<?php 
									$terms = get_the_terms( get_the_ID() , 'wsuwp_university_location' );
									if ( ! empty( $terms ) ) {

										echo 'Locations: ';

										foreach ( $terms as $term ) {
											echo '<a href="' . get_bloginfo( 'url' ) . '/gallery/?photo-term=' . $term->slug . '&photo-taxonomy=wsuwp_university_location">' . $term->name . '</a>';
										} 
									} 
								?>
							</div>
							<?php get_template_part( 'template-component/component-post-tags', $context ); ?>
						</div>
					</div>
					<footer class="wsu-article-footer">
						
					</footer>
				</article>
				<?php endwhile; ?>
			<?php endif; ?>
			<?php do_action('wsu_wds_theme_after_content', $context); ?>
		</main>
		<?php do_action('wsu_wds_theme_after_main', $context); ?>
	</div>
	<?php do_action('wsu_wds_theme_before_footer', $context); ?>
	<?php get_template_part( 'template-component/component-site-footer', $context ); ?>
	<!-- SITE CONTAINER:END -->
</div>
<!-- SITE WRAPPER:END -->
<?php get_template_part( 'template-component/component-global-footer', $context ); ?>
<?php get_footer(); ?>