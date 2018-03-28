define(function(){

    function loadPlugins(s) {
        /************************* PLUGINS FUNCTIONS ************************/
        /*
         * Plugin Utility
         * apl (appendList) v1.1
         * - append a value to any delimited lists
         */
        s.apl = (Function("return (function(l,v,d,u) { var s=this,m=0;if(!l)l='';if(u){var i,n,a=s.split(l,d);for(i=0;i<a.length;i++){n=a[i];m=m||(u==1?(n==v):(n.toLowerCase()==v.toLowerCase()));}}if(!m)l=l?l+d+v:v;return l; });"))();
        /*
         * Plugin Utility
         * split v1.5
         * - splite a string (JS 1.0 compatible)
         */
        s.split = (Function('return (function(l,d) { var i,x=0,a=new Array;while(l){i=l.indexOf(d);i=i>-1?i:l.length;a[x++]=l.substring(0,i);l=l.substring(i+d.length);}return a; });'))();
        /*
         * Plugin
         * getDaysSinceLastVisit v1.1.H
         * - capture time from last visit
         */
        s.getDaysSinceLastVisit = (Function("return (function(c) { var s=this,e=new Date(),es=new Date(),cval,cval_s,cval_ss,ct=e.getTime(),day=24*60*60*1000,f1,f2,f3,f4,f5;e.setTime(ct+3*365*day);es.setTime(ct+30*60*1000);f0='Cookies Not Supported';f1='First Visit';f2='More than 30 days';f3='More than 7 days';f4='Less than 7 days';f5='Less than 1 day';cval=s.c_r(c);if(cval.length==0){s.c_w(c,ct,e);s.c_w(c+'_s',f1,es);}else{var d=ct-cval;if(d>30*60*1000){if(d>30*day){s.c_w(c,ct,e);s.c_w(c+'_s',f2,es);}else if(d<30*day+1 && d>7*day){s.c_w(c,ct,e);s.c_w(c+'_s',f3,es);}else if(d<7*day+1 && d>day){s.c_w(c,ct,e);s.c_w(c+'_s',f4,es);}else if(d<day+1){s.c_w(c,ct,e);s.c_w(c+'_s',f5,es);}}else{s.c_w(c,ct,e);cval_ss=s.c_r(c+'_s');s.c_w(c+'_s',cval_ss,es);}}cval_s=s.c_r(c+'_s');if(cval_s.length==0) return f0;else if(cval_s!=f1&&cval_s!=f2&&cval_s!=f3&&cval_s!=f4&&cval_s!=f5) return '';else return cval_s; });"))();
        /*
         * Plugin
         * getValOnce v1.11
         * - get a value once per session or number of days
         */
        s.getValOnce = (Function("return (function(v,c,e,t) { var s=this,a=new Date,v=v?v:'',c=c?c:'s_gvo',e=e?e:0,i=t=='m'?60000:86400000,k=s.c_r(c);if(v){a.setTime(a.getTime()+e*i);s.c_w(c,v,e==0?0:a);}return v==k?'':v; });"))();
        /*
         * Plugin
         * getPreviousValue v1.0
         * - return previous value of designated variable
         */
        s.getPreviousValue = (Function("return (function(v,c,el) { var s=this,t=new Date,i,j,r='';t.setTime(t.getTime()+1800000);if(el){if(s.events){i=s.split(el,',');j=s.split(s.events,',');for(x in i){for(y in j){if(i[x]==j[y]){if(s.c_r(c)) r=s.c_r(c);v?s.c_w(c,v,t):s.c_w(c,'no value',t);return r}}}}}else{if(s.c_r(c)) r=s.c_r(c);v?s.c_w(c,v,t):s.c_w(c,'no value',t);return r}; });"))();
        /*
         * Plugin
         * getNewRepeat 1.2
         * - Returns whether user is new or repeat
         */
        s.getNewRepeat = (Function("return (function(d,cn) { var s=this,e=new Date(),cval,sval,ct=e.getTime();d=d?d:30;cn=cn?cn:'s_nr';e.setTime(ct+d*24*60*60*1000);cval=s.c_r(cn);if(cval.length==0){s.c_w(cn,ct+'-New',e);return'New';}sval=s.split(cval,'-');if(ct-sval[0]<30*60*1000&&sval[1]=='New'){s.c_w(cn,ct+'-New',e);return'New';}else{s.c_w(cn,ct+'-Repeat',e);return'Repeat';}; });"))();
        /*
         *  Plugin: ESPN getLinkParams beta v1
         */
        s.getLinkParams = (Function("return (function(p,qp,m,q,ev) { var s=this,a='',t=0,l,ll,l2,r,e,la,ap,ev=ev?';;;'+ev+'=1':'';if(s.d.links){for(i=0;i<s.d.links.length;i++){l=s.d.links[i];r=l.href;e=l.name;e=!e?'':e.indexOf('&')!=0?'&'+e:e;la=r.indexOf('?')>-1?r.substring(r.indexOf('?'))+e:e?'?'+e:'';ll=la.toLowerCase();if(qp&&ll.indexOf(qp.toLowerCase())>0)l2=qp?s.Util.getQueryParam(qp,ll,''):'';else l2='';if(l2&&l2.indexOf(p.toLowerCase())>0){ap=s.Util.getQueryParam(p,l2+'','');if(ap!=''&&ap.indexOf('#')<0){a=s.apl(a,q+ap+ev,',',2);t=t+1}}else if(ll.indexOf(p.toLowerCase())>0){ap=s.Util.getQueryParam(p,la+'','');if(ap!=''&&ap.indexOf('#')<0){a=s.apl(a,q+ap+ev,',',2);t=t+1}}if(t==m)return a}return a}; });"))();
        /*
         * Plugin: getNewRepeat 1.2 - Returns whether user is new or repeat
         */
        s.getNewRepeat = (Function("return (function(d,cn) { var s=this,e=new Date(),cval,sval,ct=e.getTime();d=d?d:30;cn=cn?cn:'s_nr';e.setTime(ct+d*24*60*60*1000);cval=s.c_r(cn);if(cval.length==0){s.c_w(cn,ct+'-New',e);return'New';}sval=s.split(cval,'-');if(ct-sval[0]<30*60*1000&&sval[1]=='New'){s.c_w(cn,ct+'-New',e);return'New';}else{s.c_w(cn,ct+'-Repeat',e);return'Repeat';}; });"))();

        // Load Media Module
        //s = _loadMediaModule(s);

        return s;
    }
    return {
        loadPlugins: loadPlugins
    };
});
