jQuery(function($) {
    //console.log('espnplus bottom.js loaded');

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
    s_omni.contextData["lastvisit"] = s_omni.getDaysSinceLastVisit();
    s_omni.contextData["navmethod"] = "external marketing";

    var s_code=s_omni.t();if(s_code)document.write(s_code);

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

}); //jquery()