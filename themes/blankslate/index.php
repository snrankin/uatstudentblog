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
                	<section class="author">
                		<i class="fa fa-user"></i><?php the_author_posts_link() ?>
                    </section>
                    <section class="categories">
                    	<i class="fa fa-folder"></i><?php the_category(', '); ?>
                    </section>
					<?php if( has_tag() ) {
                        echo ('<section class="tags"><i class="fa fa-tags"></i>'); the_tags(); echo ('</section>');
                        }
                        else {
                        // IF NO TAGS, DO NOTHING
                        }
                    ?>
                </footer>
            </article>
    	<?php endwhile; else: ?>
    	<p>Sorry, no posts matched your criteria.</p>
    <?php endif; ?>
    <?php numeric_posts_nav(); ?>
</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>