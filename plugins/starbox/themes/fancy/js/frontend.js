
var abh_loadbox_loaded=false;(function($){$._getCookie=function(nombre){var dcookie=document.cookie;var cname=nombre+"=";var longitud=dcookie.length;var inicio=0;while(inicio<longitud)
{var vbegin=inicio+cname.length;if(dcookie.substring(inicio,vbegin)===cname)
{var vend=dcookie.indexOf(";",vbegin);if(vend===-1)
vend=longitud;return unescape(dcookie.substring(vbegin,vend));}
inicio=dcookie.indexOf(" ",inicio)+1;if(inicio===0)
break;}
return null;};$._setCookie=function(name,value){document.cookie=name+"="+value+"; expires="+(60*24)+"; path=/";};})(jQuery);function abh_loadbox(){abh_loadbox_loaded=true;jQuery(".abh_tabs li").click(function(event){event.preventDefault();jQuery(this).parents('.abh_box').find(".abh_tabs li").removeClass('abh_active');jQuery(this).addClass("abh_active");jQuery(this).parents('.abh_box').find(".abh_tab").hide();var selected_tab=jQuery(this).find("a").attr("href");jQuery(this).parents('.abh_box').find(selected_tab.replace('#','.')+'_tab').fadeIn();jQuery(this).parents('.abh_box').find(selected_tab.replace('#','.')+'_tab').parents('.abh_box').find(selected_tab.replace('#','.')).addClass("abh_active");jQuery._setCookie('abh_tab',selected_tab);return false;});if(jQuery._getCookie('abh_tab')!==null){jQuery(".abh_tab").hide();jQuery(".abh_tabs li").removeClass('abh_active');var selected_tab=jQuery._getCookie('abh_tab');jQuery(selected_tab.replace('#','.')+'_tab').fadeIn();jQuery(selected_tab.replace('#','.')).addClass("abh_active");}}
jQuery(document).ready(function(){if(abh_loadbox_loaded===false)
abh_loadbox();});var abh_timeout_loadbox=setTimeout(function(){if(abh_loadbox_loaded===false)
abh_loadbox();else
clearTimeout(abh_timeout_loadbox);},1000);