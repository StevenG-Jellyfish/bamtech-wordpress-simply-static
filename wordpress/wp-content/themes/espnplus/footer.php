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
	 window.jQuery && $(function() {
        /* Clicks on header CTA */
        $(document).on("click", "#header_cta", function(t) {
            t.preventDefault();
           
            try {
                var r = s_gi(s_account);
                r.linkTrackVars = "products,contextData.edition,contextData.site,contextData.linkid,contextData.purchasemethod,contextData.buylocation";
                r.linkTrackEvents = "";
                r.contextData["edition"] = "en-us";
                r.contextData["site"] = "espnplus";
                r.contextData["linkid"] = "buy:espn+monthly:7ft";
                r.contextData["purchasemethod"] = "bamtech";
                r.contextData["buylocation"] = "espn+:paywall:buy";
                r.products="D2C;8400199910209919951899000";

                r.tl(this, "o", "buy:espn+monthly:7ft")
            } catch (t) {}
            var e = $(this).attr("href");
            
            window.location.href = e;
        });
        /* Clicks on spotlight CTA */
        $("#spotlight_cta").on("click", function(t) {
            t.preventDefault();
            try {
                var r = s_gi(s_account);
                r.linkTrackVars = "products,contextData.edition,contextData.site,contextData.linkid,contextData.purchasemethod,contextData.buylocation";
                r.linkTrackEvents = "";
                r.contextData["edition"] = "en-us";
                r.contextData["site"] = "espnplus";
                r.contextData["linkid"] = "buy:espn+monthly:7ft";
                r.contextData["purchasemethod"] = "bamtech";
                r.contextData["buylocation"] = "espn+:paywall:buy";
                r.products="D2C;8400199910209919951899000";

                r.tl(this, "o", "buy:espn+monthly:7ft")
            } catch (t) {}
            var e = $(this).attr("href");
            window.location.href = e;
        })
    });
	
</script>

<script>
!function(e){"use strict";
var n=function(n,t,o){function i(e){return f.body?e():void setTimeout(function(){i(e)})}var d,r,a,l,f=e.document,s=f.createElement("link"),u=o||"all";
return t?d=t:(r=(f.body||f.getElementsByTagName("head")[0]).childNodes,d=r[r.length-1]),a=f.styleSheets,s.rel="stylesheet",s.href=n,s.media="only x",i(function(){d.parentNode.insertBefore(s,t?d:d.nextSibling)}),l=function(e){for(var n=s.href,t=a.length;t--;)if(a[t].href===n)return e();
setTimeout(function(){l(e)})},s.addEventListener&&s.addEventListener("load",function(){this.media=u}),s.onloadcssdefined=l,l(function(){s.media!==u&&(s.media=u)}),s};
"undefined"!=typeof exports?exports.loadCSS=n:e.loadCSS=n}("undefined"!=typeof global?global:this)

loadCSS('<?php echo get_stylesheet_directory_uri().'/css/espnplus-non-critical.min.css'; ?>'); 
</script>	

<noscript>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri().'/css/espnplus-non-critical.min.css'; ?>">
</noscript>
<?php wp_footer(); ?>
</body>

</html>