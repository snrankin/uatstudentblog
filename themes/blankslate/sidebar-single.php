<aside id="sidebar" role="complementary" class="column">
      <?php
      if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('single-post-sidebar') ) :
      endif; ?>   
      <?php get_template_part( 'entry', 'meta' ); ?>
</aside>