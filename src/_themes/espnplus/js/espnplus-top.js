function appendQueryString($) {
  $('#spotlight_cta, #header_cta, a.wpml-ls-link').each(function() {
    trgtURL = $(this).attr('href');

    var currQueryString = "";
    if(window.location.href.indexOf('?') > -1) {
      currQueryString = window.location.href.slice(window.location.href.indexOf('?') + 1);
    }
    if( currQueryString!=="" ) {
      if( trgtURL.indexOf('?') > -1 ) {
          trgtURL += ("&"+currQueryString);
      }
      else {
          trgtURL += ("?"+currQueryString);
      }
    }
    $(this).attr('href', trgtURL);
  });
} // appendQueryString  

jQuery(function($) {
  //console.log('espnplus-top.js loaded:: 2');
  // execute the following functions when the DOM returns the 'DOMContentLoaded' status (render tree built)
  appendQueryString($);
/* --- lazyload ---  */
function registerListener(event, func) {
  if (window.addEventListener) {
      window.addEventListener(event, func)
  } else {
      window.attachEvent('on' + event, func)
  }
}

// registerListener('load', lazyLoad);

function isInViewport(el){
  var rect = el.getBoundingClientRect();

return (
  rect.bottom >= 0 && 
  rect.right >= 0 && 

  rect.top <= (
  window.innerHeight || 
  document.documentElement.clientHeight) && 

  rect.left <= (
  window.innerWidth || 
  document.documentElement.clientWidth)
);
}

function lazyLoad(){
  var lazy = document.getElementsByClassName('lazy');

  for(var i=0; i<lazy.length; i++) {
      if(isInViewport(lazy[i])){
         lazy[i].src =
          lazy[i].getAttribute('data-src');
          console.log("ok view: " + i)
      }
  }
}

registerListener('scroll', lazyLoad);
/* temp turn off lazy loading
  $(function() {

    //console.log('ok Lazy');
    $('img.lazy').Lazy({
        // your configuration goes here
        bind: "event",
        delay: 2000,
        scrollDirection: 'vertical',
        visibleOnly: true,
    
    // show_while_loading: true, //best for progressive JPEG
        afterLoad: function(element) {
            // console.log('ok');
        },
        onError: function(element) {
            console.log('error loading ' + element.data('src'));
        }
    });
  });
*/
  document.addEventListener('contextmenu', function(e){
    e.preventDefault();
  }, false);
});

//

       