<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package espnplus
 */
?>
	</div>
	<footer id="colophon" class="site-footer">
		<div class="site-info">
		</div>
	</footer>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
window.jQuery&&$(function(){$("#header_cta").on("click",function(t){t.preventDefault();try{var r=s_gi("wdgespncomdev");r.linkTrackVars="",r.tl(this,"o","Header - CTA Free Trial")}catch(t){}var e=$(this).attr("href");window.location.href=e}),$("#header_login").on("click",function(t){t.preventDefault();try{var r=s_gi("wdgespncomdev");r.linkTrackVars="",r.tl(this,"o","Header - Login")}catch(t){}var e=$(this).attr("href");window.location.href=e}),$("#spotlight_cta").on("click",function(t){t.preventDefault();try{var r=s_gi("wdgespncomdev");r.linkTrackVars="",r.tl(this,"o","Body - CTA Free Trial")}catch(t){}var e=$(this).attr("href");window.location.href=e}),$("#spotlight_terms").on("click",function(t){t.preventDefault();try{var r=s_gi("wdgespncomdev");r.linkTrackVars="",r.tl(this,"o","Body - Terms & Conditions")}catch(t){}var e=$(this).attr("href");window.location.href=e})});

    !function(e){"use strict";
    var n=function(n,t,o){function i(e){return f.body?e():void setTimeout(function(){i(e)})}var d,r,a,l,f=e.document,s=f.createElement("link"),u=o||"all";
    return t?d=t:(r=(f.body||f.getElementsByTagName("head")[0]).childNodes,d=r[r.length-1]),a=f.styleSheets,s.rel="stylesheet",s.href=n,s.media="only x",i(function(){d.parentNode.insertBefore(s,t?d:d.nextSibling)}),l=function(e){for(var n=s.href,t=a.length;t--;)if(a[t].href===n)return e();
    setTimeout(function(){l(e)})},s.addEventListener&&s.addEventListener("load",function(){this.media=u}),s.onloadcssdefined=l,l(function(){s.media!==u&&(s.media=u)}),s};
    "undefined"!=typeof exports?exports.loadCSS=n:e.loadCSS=n}("undefined"!=typeof global?global:this)

	loadCSS('<?php echo get_stylesheet_directory_uri().'/css/espnplus-non-critical.min.css'; ?>'); // load non-critical with javascript
</script>
<noscript>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri().'/css/espnplus-non-critical.min.css'; ?>">
</noscript>
<?php wp_footer(); ?>
</body>

</html>