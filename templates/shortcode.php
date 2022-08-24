<figure class="wp-block-gallery columns-3">
	<ul class="blocks-gallery-grid">
		<?php while ( $query->have_posts() ) : $query->the_post(); ?>
		<li class="blocks-gallery-item">
			<figure>
				<a href="<?php echo esc_url( get_attachment_link() ); ?>">
					<?php echo wp_kses_post( wp_get_attachment_image( get_the_ID(), 'large' ) ); ?>
				</a>
			</figure>
		</li>
		<?php endwhile; ?>
	</ul>
</figure>