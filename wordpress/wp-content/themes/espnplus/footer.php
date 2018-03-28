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
<script>
    !function(e){"use strict";
    var n=function(n,t,o){function i(e){return f.body?e():void setTimeout(function(){i(e)})}var d,r,a,l,f=e.document,s=f.createElement("link"),u=o||"all";
    return t?d=t:(r=(f.body||f.getElementsByTagName("head")[0]).childNodes,d=r[r.length-1]),a=f.styleSheets,s.rel="stylesheet",s.href=n,s.media="only x",i(function(){d.parentNode.insertBefore(s,t?d:d.nextSibling)}),l=function(e){for(var n=s.href,t=a.length;t--;)if(a[t].href===n)return e();
    setTimeout(function(){l(e)})},s.addEventListener&&s.addEventListener("load",function(){this.media=u}),s.onloadcssdefined=l,l(function(){s.media!==u&&(s.media=u)}),s};
    "undefined"!=typeof exports?exports.loadCSS=n:e.loadCSS=n}("undefined"!=typeof global?global:this)
</script>
<script>
loadCSS('<?php echo get_stylesheet_directory_uri().'/css/espnplus-non-critical.min.css'; ?>'); // load non-critical with javascript
</script> 
<noscript>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri().'/css/espnplus-non-critical.min.css'; ?>">
</noscript>
<?php wp_footer(); ?>


</body>


<!-- Adobe Tracking -->
<script language="JavaScript" type="text/javascript" 
src="<?php echo get_home_url(); ?>/adobetracking/AppMeasurement.js"></script>
		
		<script language="JavaScript" type="text/javascript">
		
		s.pageName="JellyfishTest" ;
        s.trackingServer = trackingConfig.trackingServer;

        s.trackingServerSecure = trackingConfig.trackingServerSecure ;
		var s=s_gi("somethingsomething");
        omniturePlugins.loadPlugins(s);

        s.linkInternalFilters = 'javascript:,espn.go.com,espn.com,jayski.com,cricinfo.com,scrum.com,nasn.com,espnclassicsport.com,espnshop.com,espn360.com,horseracing.com,expn.go.com,expn.com,espntv.com,myespn.go.com,starwave.com,x.go.com,soccernet.com,soccernet.fr,soccernet.es,soccernet.it,soccernet.de,espndeportes.com,espndeportes.fr,espndeportes.es,espndeportes.it,espndeportes.de,spanishflytv.com,redfishcup.com,espnclassic.com,racing-live.com,quiznosmadfin.com,collegebass.com,espnamerica.com,espnstar.com,espndb.go.com,espn.co.uk,shop.expn.com,grantland.com,espnpub01,espnmast01,vwtsbar02,b.espncdn.com,espncdn.com,a.espncdn.com,fantasybeta.espn.go.com,espn-ffl-2013-stage.sportsr.us,espn-ffl-2013.sportsr.us,espnsync.com,espnfivethirtyeight.wordpress.com,fivethirtyeight.com,projects.fivethirtyeight.com,espn.com.mx,espn.com.ar,espn.com.ve,espn.com.co,espnfc.com,espnfc.us,espnfc.co.uk,espnfc.mx,espnfc.com.ar,espnfc.com.ve,espnfc.com.co,espnfc.com.br,espnfc.com.ng,espnfc.com.sg,espnfc.com.au,espnfc.com.my,espnfc.co.id,secsports.go.com,secsports.com,secsports.com,espn.uol.com.br,espnplayer.com,footytips.com.au,espn.com.au,espnview.com.au,espn.cl,espnfcasia.com,sonyespn.com,espn.in,kwese.espn.com,espn-development.com';
		
		</script>
<!-- End Adobe Tracking -->

</html>
