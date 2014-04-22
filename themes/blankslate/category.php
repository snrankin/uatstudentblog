<?php get_header(); ?>
<section id="content" role="main" class="col-2">
<header class="header">
<h1 class="entry-title"><?php _e( 'Category Archives: ', 'blankslate' ); ?><?php single_cat_title(); ?></h1>
<?php if ( '' != category_description() ) echo apply_filters( 'archive_meta', '<div class="archive-meta">' . category_description() . '</div>' ); ?>
</header>
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
        <?php if( has_tag() ) {
            echo ('<section class="tags"><i class="fa fa-tags"></i>'); the_tags(); echo ('</section>');
            }
            else {
            // IF NO TAGS, DO NOTHING
            }
        ?>
    </footer>
</article>
<?php endwhile; endif; ?>
<?php numeric_posts_nav(); ?>
</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>