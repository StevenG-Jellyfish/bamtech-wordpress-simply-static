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
				<div class="site-info"></div>
			</footer>

		</div>
	</div>

	<script>
		loadCSS('<?php echo get_stylesheet_directory_uri().'/css/espnplus-non-critical.min.css?ver='.VERSION; ?>');
	</script>	
	<noscript>
		<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri().'/css/espnplus-non-critical.min.css?ver='.VERSION; ?>">
	</noscript>
	<script src="//cdn.unid.go.com/js/unid.min.js" data-client="ESPN-ONESITE.WEB-PROD"></script>
    <script>
    	var LangCode = '<?php echo apply_filters( 'wpml_current_language', NULL );  ?>';
		<?php $context_vars = explode('-',$wp_query->post->post_title); ?>
		var ALeague = '<?php echo array_key_exists(1,$context_vars)? strtolower(trim($context_vars[0])) : 'no league';?>';
		var ASport = '<?php echo array_key_exists(1,$context_vars)? strtolower(trim($context_vars[1])) : 'no sport';?>';
    
   /*find current language*/
var ALanguage = (LangCode=='es')? "es":"en-us";
var Ex_cid = s_omni.Util.getQueryParam("ex_cid");

 /* Configuration Variables */
s_omni.pageName="espnplus:marketing:paywall";
s_omni.server=window.location.hostname;

/* Conversion Variables */
s_omni.products="D2C;8400199910209919951899000";

/* Context Variables */
s_omni.contextData["section"] = "espnplus";
s_omni.contextData["contenttype"] = "paywall";
s_omni.contextData["externalmkt"] = Ex_cid; 
s_omni.contextData["paywallshown"] = "yes";
s_omni.contextData["site"] = "espnplus";
s_omni.contextData["registrationtype"] = "unknown";
s_omni.contextData["lang"] = ALanguage;
s_omni.contextData["visitortype"] = s_omni.getNewRepeat(30, "s_getNewRepeat");
s_omni.contextData["sport"] = ASport;
s_omni.contextData["league"] = ALeague;
s_omni.contextData["edition"] = ALanguage;
s_omni.contextData["paywallvisitcount"] = s_omni.getVisitNum();
s_omni.contextData["lastvisit"] = s_omni.getDaysSinceLastVisit("s_last");
s_omni.contextData["navmethod"] = "external marketing";

var s_code=s_omni.t();if(s_code)document.write(s_code);

window.jQuery && $(function() {
        /* Clicks on header CTA */
        $("#header_cta").on("click", function(t) {
            
            t.preventDefault();
            var catDays = ctaDays($(this).html(),ALanguage);
             
            try {
                var r = s_gi(s_account);
                r.linkTrackVars = "products,contextData.edition,contextData.site,contextData.linkid,contextData.purchasemethod,contextData.buylocation";
                r.linkTrackEvents = "";
                r.contextData["edition"] = ALanguage;
                r.contextData["site"] = "espnplus";
                r.contextData["linkid"] = "buy:espn+monthly:"+catDays+"ft";
                r.contextData["purchasemethod"] = "bamtech";
                r.contextData["buylocation"] = "espn+:paywall:buy";
                r.products="D2C;8400199910209919951899000";

                r.tl(this, "o", "buy:espn+monthly:"+catDays+"ft");
            } catch (t) {}
            var e = $(this).attr("href");
            
            window.location.href = e+'?ex_cid='+Ex_cid;
        });
        /* Clicks on spotlight CTA */
        $("#spotlight_cta").on("click", function(t) {
            
            t.preventDefault();
            var catDays = ctaDays($(this).html(),ALanguage);

            try {
                var r = s_gi(s_account);
                r.linkTrackVars = "products,contextData.edition,contextData.site,contextData.linkid,contextData.purchasemethod,contextData.buylocation";
                r.linkTrackEvents = "";
                r.contextData["edition"] = ALanguage;
                r.contextData["site"] = "espnplus";
                r.contextData["linkid"] = "buy:espn+monthly:"+catDays+"ft";
                r.contextData["purchasemethod"] = "bamtech";
                r.contextData["buylocation"] = "espn+:paywall:buy";
                r.products="D2C;8400199910209919951899000";

                r.tl(this, "o", "buy:espn+monthly:"+catDays+"ft");
            } catch (t) {}
            var e = $(this).attr("href");
            window.location.href = e+'?ex_cid='+Ex_cid;
        })

        function ctaDays(str,l){
            switch(l){
                case "es": 
                    var s1 = str.split(" de ");
                    var result = s1[1].split(" ");
                    return result[0];
                    break;

                default:
                    var s1 = str.split("-");
                    var result = s1[0].split(" ");
                    return result[result.length-1];
                    break;
            }
            
            
        }

        function getParameterByName(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }
});




    </script>
<!-- added to functions.php	
	<script async src="<?php echo get_stylesheet_directory_uri(); ?>/js/espnplus-non-critical.js"></script> 
	<script async src="<?php echo get_stylesheet_directory_uri(); ?>/js/espnplus-bottom.min.js"></script>
-->

	<?php wp_footer(); ?>

</body>
</html>
