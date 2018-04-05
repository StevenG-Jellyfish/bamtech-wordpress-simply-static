<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package espnplus
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>

    <!-- Page hiding snippet (recommended)  -->
    <style>.async-hide { opacity: 0 !important} </style>
    <script>(function(a,s,y,n,c,h,i,d,e){s.className+=' '+y;h.start=1*new Date;
    h.end=i=function(){s.className=s.className.replace(RegExp(' ?'+y),'')};
    (a[n]=a[n]||[]).hide=h;setTimeout(function(){i();h.end=null},c);h.timeout=c;
    })(window,document.documentElement,'async-hide','dataLayer',4000,
    {'GTM-PLN6GMP':true});</script>

    <!-- Modified Analytics tracking code with Optimize plugin -->
    <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-115899350-1', 'auto');
    ga('require', 'GTM-PLN6GMP');
    </script>

	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-M97M4JF');</script>
	<!-- End Google Tag Manager -->

    <!-- Adobe Tracking -->
    <script language="JavaScript" type="text/javascript" src="<?php echo get_home_url(); ?>/wp-content/adobetracking/adobetrackingcodes.js"></script>
   

    <!-- End Adobe Tracking -->
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <style>
    <?php
        include('css/espnplus-critical.min.css');
    ?>
    </style>
      <noscript>
          <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri().'/style.css'; ?>">
      </noscript>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

     <script language="JavaScript" type="text/javascript"><!--
   
        /* You may give each page an identifying name, server, and channel on
        the next lines. */
        s_omni.pageName="espnplus:marketing:paywall";
        s_omni.server="";
        s_omni.channel="";
        s_omni.pageType="";
        s_omni.prop1="";
        s_omni.prop2="";
        s_omni.prop3="";
        s_omni.prop4="";
        s_omni.prop5="";
        /* Conversion Variables */
        s_omni.campaign="";
        s_omni.state="";
        s_omni.zip="";
        s_omni.events="";
        s_omni.products="";
        s_omni.purchaseID="";
        s_omni.eVar1="";
        s_omni.eVar2="";
        s_omni.eVar3="";
        s_omni.eVar4="";
        s_omni.eVar5="";
        /* Context Variables */
        s_omni.contextData["section"] = "espnplus";
        s_omni.contextData["contenttype"] = "paywall";
        s_omni.contextData["externalmkt"] = s_omni.Util.getQueryParam("ex_cid"); 
        s_omni.contextData["paywallshown"] = "yes";
        s_omni.contextData["site"] = "espnplus";
        s_omni.contextData["registrationtype"] = "unknown";
        s_omni.contextData["lang"] = "en_us";
        s_omni.contextData["visitortype"] = s_omni.getNewRepeat(30, "s_getNewRepeat");
        s_omni.contextData["sport"] = "no sport";
        s_omni.contextData["league"] = "no league";
        s_omni.contextData["edition"] = "en-us";

        var s_code=s_omni.t();if(s_code)document.write(s_code);


        

        //-->


 
    </script>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M97M4JF"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

