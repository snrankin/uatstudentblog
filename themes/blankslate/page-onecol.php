<?php
/*
Template Name: Why UAT
*/
get_header(); ?>
<div id="why-uat">
    <section id="content" role="main" class="col-1">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </header>
            <section class="entry-content">
                <?php if ( has_post_thumbnail() ) { the_post_thumbnail(); } ?>
                <?php the_content(); ?>
                <div class="entry-links"><?php wp_link_pages(); ?> <?php edit_post_link(); ?></div>
            </section>
        </article>
        <?php if ( ! post_password_required() ) comments_template( '', true ); ?>
        <?php endwhile; endif; ?>
        <?php $args = array( 'post_type' => 'why-uat' );
        $loop = new WP_Query( $args );
        while ( $loop->have_posts() ) : $loop->the_post();
            echo '<div class="entry">';
                echo '<div class="entry-photo">';
                    userphoto_the_author_photo ();
                echo '</div>';
                echo '<div class="entry-content">';
                    the_content();
                    echo '<div class="entry-author"> &mdash; ';
                        the_author();
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        endwhile; ?>
    
    </section>
</div>
<?php get_footer(); ?>