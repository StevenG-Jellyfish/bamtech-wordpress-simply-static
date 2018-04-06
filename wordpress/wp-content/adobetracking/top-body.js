/* Configuration Variables */
s_omni.pageName="espnplus:marketing:paywall";
s_omni.server=window.location.hostname;

/* Conversion Variables */
//s_omni.events="prodView";
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
s_omni.contextData["edition"] = "en-us";
s_omni.contextData["paywallvisitcount"] = s_omni.getVisitNum();

var s_code=s_omni.t();
if(s_code)document.write(s_code);
 