<section class="entry-meta">
<span class="author vcard"><?php the_author_posts_link(); ?></span>
<span class="entry-date"><?php the_time( get_option( 'date_format' ) ); ?></span>
<span class="cat-links"><?php _e( 'Categories: ', 'blankslate' ); ?><?php the_category( ', ' ); ?></span>
<span class="tag-links"><?php the_tags(); ?></span>
</section>