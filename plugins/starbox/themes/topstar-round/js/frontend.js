
var abh_loadbox_loaded=false;function abh_loadbox(){abh_loadbox_loaded=true;jQuery(".abh_tab_content").mouseenter(function(){jQuery(this).find(".abh_social").stop().fadeIn('slow');}).mouseleave(function(){jQuery(this).find(".abh_social").stop().fadeOut('fast');});}
jQuery(document).ready(function(){if(abh_loadbox_loaded===false)
abh_loadbox();});var abh_timeout_loadbox=setTimeout(function(){if(abh_loadbox_loaded===false)
abh_loadbox();else
clearTimeout(abh_timeout_loadbox);},1000);