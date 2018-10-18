<?php get_header(); 
	$reviews = new WP_Query(array(
		'post_type' => 'review',
		'posts_per_page' => 10,
		'post_status' => 'publish',
		'paged' => ( ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1 )
	));
	wp_reset_postdata();
?>
<div class="sp-md-1"></div>
<?php if (function_exists('kama_breadcrumbs')) kama_breadcrumbs(' » '); ?>
<div class="sp-md-1"></div>
<h1 class="text-center archive-header">
	<?php _e('Отзывы', 'brainworks'); ?>
</h1>
<div class="sp-md-2"></div>

	<div class="container-fluid">
		<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">

          		<?php foreach ($reviews->posts as $post): ?>
		          	<div class="review-row">
		          		<div class="review-image-container">
		          			<?php echo get_the_post_thumbnail($post->ID, 'full'); ?>
		          		</div>
		          		<div class="review-content-container">
		          			<h5><?php echo $post->post_title; ?></h5>
		          			<p>
		          				<b><?php echo get_post_meta($post->ID, 'bw-position', true); ?></b>
		          				<br/>
		          				<?php echo $post->post_content; ?>	
		          				<br>
		          				<?php
		          					if ($socials = get_post_meta($post->ID, 'bw-socials', true))
		          						the_review_socials($socials);
		          				?>
		          			</p>
		          		</div>
		          	</div>
							<?php endforeach; ?>
					<div class="pagination">
						<?php 
						echo paginate_links( array(
	            'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
	            'total'        => $reviews->max_num_pages,
	            'current'      => max( 1, get_query_var( 'paged' ) ),
	            'format'       => '?paged=%#%',
	            'show_all'     => false,
	            'type'         => 'plain',
	            'end_size'     => 2,
	            'mid_size'     => 1,
	            'prev_next'    => true,
	            'prev_text'    => sprintf( '<i></i> %1$s', __( 'Назад', 'brainworks' ) ),
	            'next_text'    => sprintf( '%1$s <i></i>', __( 'Далее', 'brainworks' ) ),
	            'add_args'     => false,
	            'add_fragment' => '',
	        ) ); ?>
					</div>
        </div>
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
          <?php get_sidebar(); ?>
        </div>
		</div>
	</div>

<?php get_footer(); ?>