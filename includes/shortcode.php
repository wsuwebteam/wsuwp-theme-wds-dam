<?php namespace WSUWP\Theme\WDSDAM;

class Shortcode {

	public static function init() {

		add_action( 'init', array( __CLASS__, 'add_shortcode' ) );

	}


	public static function add_shortcode() {

		add_shortcode( 'photo_library', array( __CLASS__, 'render_shortcode' ) );

	}


	public static function render_shortcode( $atts, $content ) {

		$atts = shortcode_atts(
			array(
				'count'         => 100,
				'paginate'      => 0,
				'title'         => 'Recently Added',
				'heading_level' => 'h2',
			),
			$atts,
			'photo_library'
		);

		$taxonomy   = ( ! empty( $_REQUEST['photo-taxonomy'] ) ) ? sanitize_text_field( $_REQUEST['photo-taxonomy'] ) : '';
		$term_slug  = ( ! empty( $_REQUEST['photo-term'] ) ) ? sanitize_text_field( $_REQUEST['photo-term'] ) : '';
		$paged      = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		$count      = $atts['count'];
		$query_args = array(
			'posts_per_page' => $count,
			'paged'          => $paged,
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
		);
		$term = ( ! empty( $taxonomy ) && ! empty( $term_slug ) ) ? get_term_by( 'slug', $term_slug, $taxonomy ) : false;

		if ( $term ) {

			$query_args['tax_query'] = array(
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'slug',
					'terms'    => $term_slug,
				),
			);

			$atts['title'] = 'Photo Library: ' . $term->name;

		}

		$query = new \WP_Query( $query_args );

		ob_start();

		if ( ! empty( $atts['title'] ) ) {

			echo '<' . esc_attr( $atts['heading_level'] ) . '>' . wp_kses_post( $atts['title'] ) . '</' . esc_attr( $atts['heading_level'] ) . '>';

		}

		if ( $query->have_posts() ) {

			include get_stylesheet_directory() . '/templates/shortcode.php';

		} else {
			// no posts found
		}
		/* Restore original Post Data */
		wp_reset_postdata();

		return ob_get_clean();

	}

}

Shortcode::init();