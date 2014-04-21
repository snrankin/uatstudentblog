<?php
// ========================================= >>> atw_slider_help_admin <<< ===============================
function atw_slider_help_admin() {
    // admin for help
    $t_dir = atw_slider_plugins_url('/help/help-sliders.html', '');
    $title = ' View Aspen Themeworks ';

?>
<br />
<h2 style="color:blue;text-decoration:underline;">Show Sliders Quick Start</h2>

<p style="color:green;font-weight:bold;font-size:140%;">
    <?php echo $title; ?> <a href="<?php echo $t_dir; ?>" target="_blank" title="ATW Show Sliders Help File">Show Sliders Help Document</a>
    <span style="font-size:80%;margin-left:20px;">Visit the official
    <a href="http://forum.weavertheme.com/categories/atw-show-posts-and-atw-show-sliders" target="_blank">help forum.</a></span>
    </p>

<h3>Create an Image Slide Show using WordPress Media Gallery</h3>
<ol>
  <li>Create the Image Slider content. Add your images to the Media Library. Ideally, the images will be the same or similar sizes.</li>
  <li>Create Slider Post to hold gallery. Open <em>Dashboard : Slider Posts : New Slider Post</em> to create a Slider Post to define gallery. Give that post a meaningful name - for example, <em>Colorado</em>. </li>
  <li>Create [gallery]  for that post using &quot;Add Media : Create Gallery&quot;. See this video <a href="http://www.youtube.com/watch?v=8O0swHbEdVU#t=515" title="Create Gallery Tutorial" target="_blank">tutorial</a> on how to create a gallery. Publish that Slider Post.</li>
  <li>Open the<em> Dashboard : ATW Posts/Slider : Sliders</em> tab. Create a New Slider (e.g., named &quot;Colorado&quot;). In the &quot;Required Options&quot; section, set slider type and paging options  to your choice.  In the <span style="color:green;">&quot;Quick Option:</span> Slider Post Slug" box right under the&quot;Slider Filter:" setting, enter the slug (e.g., &quot;colorado&quot;) of the Slider Post you created in step 1. Save settings.</li>
  <li>Add shortcode <strong>[show_slider name="colorado"]</strong> wherever you want the slider (there is an insert button on the Page/Post Editor).</li>
  <li>View your slide show.</li>
  <li>Click to see the <a href="http://demos.aspenthemeworks.com/plugin-demos/tutorial-create-image-slideshow/" target="_blank">live tutorial</a>
  on how to create an image slide show.</li>
</ol>
<h3>Create an Image or Post Slide Show using a Filter</h3>
<ol>
  <li>Create the content for your slider. Content can be regular posts, or special content created just for the slider using the &quot;Slider Posts&quot; custom post type. Content with images can be used for Image Sliders.</li>
  <li>Select your Slider content by creating a Filter on <em>Filters</em> tab (for example, a filter named &quot;Colorado&quot;). For a &quot;Post&quot; slider, the posts can contain any content. For an &quot;Image&quot; slider, the posts you select in the filter should contain either a [gallery] shortcode, or an image. Image Sliders will use either the [gallery], the post's &quot;Featured Image&quot;, or the first image contained in the post. All posts selected by the filter will be included in the slider.</li>
  <li>Create a Slider on <em>Sliders</em> tab. (for example, named &quot;Colorado&quot;). Set &quot;Slider Type&quot;,  &quot;Slider Paging&quot;, and &quot;Slider Content&quot; to your choice. Set Slider Filter to &quot;Colorado&quot;. Save settings.</li>
  <li>Add shortcode <strong>[show_slider name=&quot;colorado&quot;]</strong> (there is an insert button on the Page/Post Editor).</li>
  <li>See your slide show.</li>
  <li>Click to see the <a href="http://demos.aspenthemeworks.com/plugin-demos/tutorial-create-posts-slideshow/" target="_blank">live tutorial</a>
  on how to create a post slide show.</li>
</ol>
<hr />

<?php
}
?>
