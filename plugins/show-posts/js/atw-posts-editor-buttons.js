jQuery(document).ready(function($){
    //selector functions
   window.atwSelectShowPosts = function() {
    return fnatwSelectShowPosts();
   }

   function fnatwSelectShowPosts(){
    var atwShowPostsIDSelected = $('#atw-slider-post-select').val();

    window.send_to_editor( '[show_posts filter="' + atwShowPostsIDSelected + '"]' );
    $('#select-show-posts-dialog').fadeOut();
   }

   window.atwCancelSelectShowPosts = function() {
    return fnatwCancelSelectShowPosts();
   }

   function fnatwCancelSelectShowPosts() {
    window.send_to_editor( '' ); $('#select-show-posts-dialog').fadeOut();
   }

   //------------------------------ sliders -------------

   window.atwSelectSliders = function() {
    return fnatwSelectSliders();
   }

   function fnatwSelectSliders(){
    var atwShowSliderIDSelected = $('#atw-slider-slider-select').val();

    window.send_to_editor( '[show_slider name="' + atwShowSliderIDSelected + '"]' );
    $('#select-show-posts-dialog').fadeOut();
   }

   window.atwCancelSelectSliders = function() {
    return fnatwCancelSelectSliders();
   }

   function fnatwCancelSelectSliders() {
    window.send_to_editor( '' ); $('#select-show-posts-dialog').fadeOut();
   }


});
