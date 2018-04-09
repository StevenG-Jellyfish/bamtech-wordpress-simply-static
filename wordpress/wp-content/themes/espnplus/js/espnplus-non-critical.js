/*find current language*/
var language = (window.location.pathname.includes("/es/"))? "es":"en-us"

 /* Configuration Variables */
s_omni.pageName="espnplus:marketing:paywall";
s_omni.server=window.location.hostname;

/* Conversion Variables */
s_omni.products="D2C;8400199910209919951899000";

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
s_omni.contextData["edition"] = language;
s_omni.contextData["paywallvisitcount"] = s_omni.getVisitNum();
s_omni.contextData["lastvisit"] = s_omni.getDaysSinceLastVisit();

var s_code=s_omni.t();if(s_code)document.write(s_code);

 window.jQuery && $(function() {
        /* Clicks on header CTA */
        $("#header_cta").on("click", function(t) {
            t.preventDefault();
            var catDays = ctaDays($(this).html());
           
            try {
                var r = s_gi(s_account);
                r.linkTrackVars = "products,contextData.edition,contextData.site,contextData.linkid,contextData.purchasemethod,contextData.buylocation";
                r.linkTrackEvents = "";
                r.contextData["edition"] = "en-us";
                r.contextData["site"] = "espnplus";
                r.contextData["linkid"] = "buy:espn+monthly:"+catDays+"ft";
                r.contextData["purchasemethod"] = "bamtech";
                r.contextData["buylocation"] = "espn+:paywall:buy";
                r.products="D2C;8400199910209919951899000";

                r.tl(this, "o", "buy:espn+monthly:"+catDays+"ft")
            } catch (t) {}
            var e = $(this).attr("href");
            
            window.location.href = e;
        });
        /* Clicks on spotlight CTA */
        $("#spotlight_cta").on("click", function(t) {
            t.preventDefault();
            var catDays = ctaDays($(this).html());

            try {
                var r = s_gi(s_account);
                r.linkTrackVars = "products,contextData.edition,contextData.site,contextData.linkid,contextData.purchasemethod,contextData.buylocation";
                r.linkTrackEvents = "";
                r.contextData["edition"] = "en-us";
                r.contextData["site"] = "espnplus";
                r.contextData["linkid"] = "buy:espn+monthly:"+catDays+"ft";
                r.contextData["purchasemethod"] = "bamtech";
                r.contextData["buylocation"] = "espn+:paywall:buy";
                r.products="D2C;8400199910209919951899000";

                r.tl(this, "o", "buy:espn+monthly:"+catDays+"ft")
            } catch (t) {}
            var e = $(this).attr("href");
            window.location.href = e;
        })

        function ctaDays(str){
            var s1 = str.split("-");
            var result = s1[0].split(" ");
            return result[result.length-1];
        }
});

