<aside id="sidebar" role="complementary" class="column">
	<div id="post-info">
		<?php get_template_part( 'entry', 'meta' ); ?>
        <?php
        if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('single-post-sidebar') ) :
        endif; ?>   
    </div>
    <?php display_related_posts_via_taxonomies(); ?>
</aside>