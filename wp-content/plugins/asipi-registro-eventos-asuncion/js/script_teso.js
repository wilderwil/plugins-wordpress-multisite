(function($){
    $( document ).ready(function() {
        
        $(document).on('click','#verifyEmailNew',function(e){
            e.preventDefault();
            jQuery.ajax({
                url : arc_teso_vars.ajaxurl,
                type: 'post',
                data: {
                    action : 'arc_ajax_verifyEmailNew',
                    "email" : jQuery("#email").val() , 
                    "lang" : '<?php echo $lang ?>',
                    "tipo_curso" : 'C',
                    "id_curso" : jQuery("#curso").val(),
                },
                beforeSend: function () {
                    jQuery("#loadingimage").show();
                },
                success: function (response) {
                    response = response.replace('}0','}')
                    //jQuery("#loadingimage").hide();
                    var obj = jQuery.parseJSON(response);
                    if (obj.status == "success") {
                        /*jQuery(".paso1").hide(300);
                        var tipo_usuario='socio';
                        var email=obj.email;
                        var nombre=obj.name;
                        var apellido=obj.last;
                        var id_usuario=obj.id_user;*/
                    }else{
                        jQuery("#mensajeErrorLogin").html(obj.mensaje);
                        jQuery("#mensajeErrorLogin").show();
                    }
                }
            });
        });
    });
})(jQuery);