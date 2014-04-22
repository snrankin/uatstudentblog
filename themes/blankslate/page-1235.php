<?php get_header(); ?>
<section id="content" role="main" class="column archive">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <article class="post">
                <header>
                    <div class="postdate"><?php the_time('M j, Y') ?></div>
                    <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                </header>
                <div class="entry">
                    <?php the_excerpt(); ?>
                </div>
                <footer class="postmetadata">
                	<i class="fa fa-user"></i><?php the_author_posts_link() ?>
                    <i class="fa fa-folder"></i><?php the_category(', '); ?>
					<?php if( has_tag() ) {
                        echo ('<i class="fa fa-tags"></i>'); the_tags();
                    }
                    else {
                    // IF NO TAGS
                    }
                    ?>
                </footer>
            </article>
    	<?php endwhile; else: ?>
    	<p>Sorry, no posts matched your criteria.</p>
    <?php endif; ?>
</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>