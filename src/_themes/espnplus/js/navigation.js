/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu sticky
 * 
 */

// ------------ Header nav ------------ //

$(document).ready(function() {
    var jumbotron = $('.jumbotron').height();
    var jumbotronsize = jumbotron + 77;
    //
   // console.log('jumbotron start height ' + jumbotron);
    //
    $( window ).resize(function() {
        jumbotron = $('.jumbotron').height();
        jumbotronsize = jumbotron + 77;
      });

    var header = $("header").clone().attr('id', 'masthead-stick').attr('class', 'd-none').insertAfter("#masthead");
    // var header = $("#masthead-stick");
    header.find("#primary-menu").attr("id","primary-menu"+"-stick");
    header.find('li').each(function(){
        if(this.id){
          this.id = this.id+"-stick";
        }
      });

    $(window).scroll(function() {
       // console.log('window' + $(window).scrollTop());
        if ($(window).scrollTop() > 140){
            header.removeClass("d-none");
        }
        //if ($(window).scrollTop() > $(window).height()) {
            if ($(window).scrollTop() > jumbotronsize) {
        // if ($(window).scrollTop() > elementOffset {
            header.addClass("sticky");
            header.slideDown();
        } else {
            // header.removeClass("sticky");
            header.slideUp(400, function() {
                header.removeClass("sticky");
            });
        }
    });
        // var langsector = $('#lang_sel_click');
        // console.log("lang selector = ");
         //
});

// ------------ Header nav ------------ //
/*jshint browser:true, devel:true */
/*global document */

var WPMLLanguageSwitcherDropdownClick = (function() {
    "use strict";

    var wrapperSelector = '.js-wpml-ls-legacy-dropdown-click';
    var submenuSelector = '.js-wpml-ls-sub-menu';
    var isOpen = false;

    var toggle = function(event) {
        var subMenu = this.querySelectorAll(submenuSelector)[0];

        if(subMenu.style.visibility === 'visible'){
            subMenu.style.visibility = 'hidden';
            $("#lang_sel_click .wpml-ls-item-legacy-dropdown-click").removeClass("open");
            document.removeEventListener('click', close);
        }else{
            $("#lang_sel_click .wpml-ls-item-legacy-dropdown-click").addClass("open");
            subMenu.style.visibility = 'visible';
            document.addEventListener('click', close);
            isOpen = true;
        }

        return false;
    };

    var close = function(){

        if(!isOpen){
            var switchers = document.querySelectorAll(wrapperSelector);

            for(var i=0;i<switchers.length;i++){
                var altLangs = switchers[i].querySelectorAll(submenuSelector)[0];
                $("#lang_sel_click .wpml-ls-item-legacy-dropdown-click").removeClass("open");
                altLangs.style.visibility = 'hidden';
            }
        }

        isOpen = false;
    };

    var preventDefault = function(e) {
        var evt = e ? e : window.event;

        if (evt.preventDefault) {
            evt.preventDefault();
        }

        evt.returnValue = false;
    };

    var init = function() {
        var wrappers = document.querySelectorAll(wrapperSelector);
        for(var i=0; i < wrappers.length; i++ ) {
            wrappers[i].addEventListener('click', toggle );
        }

        var links = document.querySelectorAll(wrapperSelector + ' a.js-wpml-ls-item-toggle');
        for(var j=0; j < links.length; j++) {
            links[j].addEventListener('click', preventDefault );
        }
    };

    return {
        'init': init
    };

})();

document.addEventListener('DOMContentLoaded', function(){
    "use strict";
    WPMLLanguageSwitcherDropdownClick.init();
});