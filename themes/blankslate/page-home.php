<?php get_header(); ?>
<section>
<?php $the_query = new WP_Query( 'showposts=3' ); ?>
<?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>
<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
<?php the_excerpt(__('(more…)')); ?>
<?php endwhile;?>
</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>