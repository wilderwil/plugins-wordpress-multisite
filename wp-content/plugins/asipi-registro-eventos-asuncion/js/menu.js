(function($){
    $( document ).ready(function() {	
        console.log('no esta logueado');
        jQuery(".menu-item-1931").hide();
        //jQuery(".menu-item-1932").hide();
        //jQuery(".menu-item-1934").hide();	
        if ( jQuery('body').hasClass('logged-in') ){
            console.log('esta logueado');
            jQuery(".menu-item-1931").show();
            //jQuery(".menu-item-583").hide();
        }
    });
});