function spider_frontend_ajax(form_id, current_view, id, album_gallery_id, cur_album_id, type) {
  var page_number = jQuery("#page_number_" + current_view).val();
  var bwg_previous_album_ids = jQuery('#bwg_previous_album_id_' + current_view).val();
  var bwg_previous_album_page_numbers = jQuery('#bwg_previous_album_page_number_' + current_view).val();
  var post_data = {};
  if (album_gallery_id == 'back') { // Back from album.
    var bwg_previous_album_id = bwg_previous_album_ids.split(",");
    album_gallery_id = bwg_previous_album_id[0];
    jQuery('#bwg_previous_album_id_' + current_view).val(bwg_previous_album_ids.replace(bwg_previous_album_id[0] + ',', ''));
    var bwg_previous_album_page_number = bwg_previous_album_page_numbers.split(",");
    page_number = bwg_previous_album_page_number[0];
    jQuery('#bwg_previous_album_page_number_' + current_view).val(bwg_previous_album_page_numbers.replace(bwg_previous_album_page_number[0] + ',', ''));
  }
  else if (cur_album_id != '') { // Enter album (not change the page).
    jQuery('#bwg_previous_album_id_' + current_view).val(cur_album_id + ',' + bwg_previous_album_ids);
    if (page_number) {
      jQuery('#bwg_previous_album_page_number_' + current_view).val(page_number + ',' + bwg_previous_album_page_numbers);
    }
    page_number = 1;
  }
  post_data["page_number_" + current_view] = page_number;
  post_data["album_gallery_id_" + current_view] = album_gallery_id;
  post_data["bwg_previous_album_id_" + current_view] = jQuery('#bwg_previous_album_id_' + current_view).val();
  post_data["bwg_previous_album_page_number_" + current_view] = jQuery('#bwg_previous_album_page_number_' + current_view).val();
  post_data["type_" + current_view] = type;

  // Loading.
  jQuery("#ajax_loading_" + current_view).css('height', jQuery("#" + id).css('height'));
  jQuery("#opacity_div_" + current_view).css({
    width: jQuery("#" + id).css('width'),
    height: jQuery("#" + id).css('height'),
    display: ''
  });
  jQuery("#loading_div_" + current_view).css({
    width: jQuery("#" + id).css('width'),
    height: jQuery("#" + id).css('height'),
    display: 'table-cell'
  });
  // if (!bwg_current_url) {
    // bwg_current_url = window.location;
  // }
  jQuery.post(
    window.location,
    post_data,
    function (data) {
      var str = jQuery(data).find('#gal_front_form_' + current_view).html();
      jQuery('#gal_front_form_' + current_view).html(str);
    }
  ).success(function(jqXHR, textStatus, errorThrown) {
    jQuery("#opacity_div_" + current_view).css({display: 'none'});
    jQuery("#loading_div_" + current_view).css({display: 'none'});
    // window.scroll(0, spider_get_pos(document.getElementById(form_id)));
    jQuery("html, body").animate({scrollTop: jQuery('#' + form_id).offset().top - 150}, 500);
    // For masonry view.
    jQuery(".bwg_masonry_thumb_spun_" + current_view + " a img").last().on("load", function() {
      window["bwg_masonry_" + current_view]();
    });
  });
  // if (event.preventDefault) {
    // event.preventDefault();
  // }
  // else {
    // event.returnValue = false;
  // }
  return false;
}
