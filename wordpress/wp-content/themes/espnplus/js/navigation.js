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
});

// ------------ Header nav ------------ //

// ------------ Lang select ------------ //

document.getElementById("lang-selection").onchange = function() {
    if (this.selectedIndex!==0) {
        window.location.href = this.value;
    }        
};