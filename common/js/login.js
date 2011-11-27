$(document).ready(function() {

    $(".signin").click(function(e) {          
        e.preventDefault();
        $("fieldset#login-signin_menu").toggle();
        $(".signin").toggleClass("menu-open");
    });
    
    $("fieldset#login-signin_menu").mouseup(function() {
        return false
    });
    $(document).mouseup(function(e) {
        if($(e.target).parent("a.signin").length==0) {
            $(".signin").removeClass("menu-open");
            $("fieldset#login-signin_menu").hide();
        }
    });			
    
});

$(function() {
  $('#forgot_username_link').tipsy({gravity: 'w'});   
});
