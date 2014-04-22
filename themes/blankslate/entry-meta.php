<section class="entry-meta">
<div class="entry-date"><h3><i class="fa fa-calendar"></i> Posted On:</h3> <?php the_time( get_option( 'date_format' ) ); ?></div>
<div class="cat-links"><h3><i class="fa fa-folder"></i> Categories</h3><?php the_category( ', ' ); ?></div>
<div class="tag-links"><h3><i class="fa fa-tags"></i> Tags:</h3> <?php the_tags(' '); ?></div>
</section>