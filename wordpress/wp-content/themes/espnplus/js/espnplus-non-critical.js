// analytics events
    window.jQuery && $(function() {
        /* Clicks on header CTA */
        $("#header_cta").on("click", function(t) {
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
            window.location.href = e
        }),
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
            window.location.href = e
        })
    });

