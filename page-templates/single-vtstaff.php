<?php get_header(); ?>
	<div class="small-12 large-8 columns" id="content" role="main">
	
	<?php /* Start loop */ ?>
	<?php while (have_posts()) : the_post(); ?>
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<header>
				<h1 class="entry-title"><?php the_title(); ?></h1>
				<i><?php echo get_post_meta( get_the_ID(), 'vt_designation', true ); ?></i>
			</header>
			<div class="entry-content">
				<figure>
					<?php if ( has_post_thumbnail() ) {
						the_post_thumbnail(array(320, 9999));
					} ?>
				</figure>
				<?php the_content(); ?>
			</div>
			<footer>
				<?php edit_post_link('Edit this Post'); ?>
			</footer>
		</article>
	<?php endwhile; // End the loop ?>

	</div>
	<?php get_sidebar(); ?>
		
<?php get_footer(); ?>
