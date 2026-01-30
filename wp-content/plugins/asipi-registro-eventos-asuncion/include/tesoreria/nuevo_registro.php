<?php 
$sql = "SELECT id, nombre FROM pwisa_asipi_cursos";
$queryResult = $wpdb->get_results($sql);
$queryResult = json_decode(json_encode($queryResult), true);
?>
<div id="page-content">   
        <br>
        <h1>Nuevo Registro</h1>
        <div class="row" id="verifyF">
            <form action="" method="post">
            <table class="form-table">
                <tr>
                    <td>Curso</td>
                    <td>
                            <select type="select" name="curso_id" id="curso_id" class="form-control">
                                <option value="">Seleccione Curso</option>
                                <?php
                                foreach ($queryResult as $key => $value) {
                                    ?>
                                    <option value="<?php echo $value['id']?>"><?php echo $value['nombre']?></option>
                                    <?php
                                }
                                ?>
                            </select>
                    </td>
                </tr> 
                <tr>
                    <td>Email</td>
                    <td>
                            <input type="email" class="form-control" name="email_verificar" id="email_verificar" required aria-describedby="emailHelp" placeholder="Ingresar correo">
                            <small id="emailHelp" class="form-text text-muted"></small>
                    </td>
                </tr> 
                <tr>
                    <td></td>
                    <td>
                        <div id="mensajeErrorLogin" class="alert alert-danger in" style="font-size: 14px;display:none;"></div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <button class="btn-form" id="verifyEmailNew">Consultar</button>
                    </td>
                </tr>
            </table>
            </form>
        </div>
        <style>
            .btn-form{
                padding: 8px;
                width: 100px;
            }
            .form_registro_nuevo{
                border-spacing: 10px;
            }
            .form_registro_nuevo input, #verifyF input{
                width: 220px;
            }
        </style>
        <div class="row" id="newF" style="display: none;">
            <form action="/wp-admin/admin.php?page=teso-settings&tab=7" method="post">
                <input type="hidden" name="id_usuario" id="id_usuario" value="">
                <input type="hidden" name="tipo_usuario" id="tipo_usuario" value="">
                <input type="hidden" name="id_curso" id="id_curso" value="">
                <input type="hidden" name="tipo_curso" id="tipo_curso" value="">
                <input type="hidden" name="nombre_curso" id="nombre_curso" value="">
                <input type="hidden" name="id_fiador" id="id_fiador" value="">
                <input type="hidden" name="email_fiador" id="email_fiador" value="">
                <input type="hidden" name="company_fiador" id="company_fiador" value="">
                <input type="hidden" name="email" id="email" value="">
                <table class="form_registro_nuevo">
                    <tr>
                        <td>Curso</td>
                        <td>
                            <b><span id='label_curso'></span></b>
                        </td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>
                            <b><span id='label_email'></span></b>
                        </td>
                    </tr>
                    <tr>
                        <td>Nombre y Apellido</td>
                        <td><input type="text" name="nombre[]" id="nombre" value=""> <input type="text" name="nombre[]" id="apellido" value=""></tr>
                    </tr>
                    <tr class="campos_ocultos">
                        <td>Razón Social</td>
                        <td><input type="text" name="razonsocial" class="campos_ocultos" id="razonsocial" value=""></td>
                    </tr>
                    <tr class="campos_ocultos">
                        <td>NIT</td>
                        <td><input type="text" name="nit" class="campos_ocultos" id="nit" value=""></td>
                    </tr>
                    <tr class="campos_ocultos">
                        <td>Dirección</td>
                        <td>
                            <label for="" class="lbl_campos">Dirección</label><br>
                            <input type="text" name="direccion[]" class="campos_ocultos" id="direccion" value="" style="width: 450px;"><input type="hidden" name="direccion[]" id="direccion2" value="">
                        </td>
                    </tr>

                    <tr class="campos_ocultos">
                        <td></td>
                        <td><table>
                            <tr>
                                <td style="padding: 0px;">
                                    <label for="" class="lbl_campos">Ciudad</label><br>
                                    <input type="text" class="campos_ocultos" name="direccion[]" id="ciudad" value="">
                                </td>
                                <td>
                                    <label for="" class="lbl_campos">Estado</label><br>
                                    <input type="text" class="campos_ocultos" name="direccion[]" id="estado" value="">
                                </td>
                            </tr>
                        </table></td>
                    </tr>

                    <tr class="campos_ocultos">
                        <td></td>
                        <td><table>
                            <tr>
                                <td style="padding: 0px;">
                                    <label for="" class="lbl_campos">Código Postal</label><br>
                                    <input type="text" class="campos_ocultos" name="direccion[]" id="codigo_postal" value="">
                                    <br>
                                </td>
                                <td>
                                    <label for="" class="lbl_campos">País</label><br>
                                    <select name="direccion[]" id="pais">
                                        <option value=""></option>
                                        <?php 
                                        $sqlCountries = 'SELECT id, name_es as name FROM country_names ORDER BY name_es ASC';
                                        $queryResult = $wpdb->get_results($sqlCountries);
                                        if(count($queryResult)>0 ){
                                            foreach ($queryResult as $data) {
                                                echo '<option value="'.$data->name.'">'.$data->name.'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                        </table></td>
                    </tr>

                    <tr>
                        <td>Precio</td>
                        <td><input type="text" name="precio" id="precio" value="0"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <button class="btn-form">Registrar</button>  
                        </td>
                    </tr>
                </table>
                
            </form>
        </div>
</div>
<?php /*/ ?>
<iframe
    id="JotFormIFrame-202313588748664"
    title="Registro"
    onload="window.parent.scrollTo(0,0)"
    allowtransparency="true"
    allowfullscreen="true"
    allow="geolocation; microphone; camera"
    frameborder="0"
    src="https://form.jotform.com/202313588748664"
    style="
    min-width: 100%;
    height:539px;
    border:none;
    display:none"
    scrolling="no"
>
</iframe>

<style>
    .formFooter{
        display: none;
    }
</style>
<?php /*/ ?>
<script>
    /*
    var formJF = '202313588748664';
    var id_curso='<?php echo $idcurso?>';
    var tipo_curso='<?php echo $tipo_curso ?>';
    var nombre_curso='<?php echo $nombre_curso ?>';
    var precio_socio='<?php echo $costo_socio?>';
    var precio_miembro='<?php echo $costo_miembro?>';
    var precio_nosocio='<?php echo $costo_nosocio?>';
*/
</script>

<script>
(function($){
    $( document ).ready(function() {
        
        $(document).on('click','#verifyEmailNew',function(e){
            e.preventDefault();
            jQuery.ajax({
                url : '/asipi-helper/teso_cursos/verificarEmailNew.php',
                type: 'post',
                data: {
                    action : 'arc_ajax_verifyEmailNew',
                    "email" : jQuery("#email_verificar").val() , 
                    "lang" : 'ES',
                    "tipo_curso" : 'C',
                    "id_curso" : jQuery("#curso_id").val(),
                },
                beforeSend: function () {
                    jQuery("#loadingimage").show();
                },
                success: function (response) {
                    response = response.replace('}0','}');

                    //jQuery("#loadingimage").hide();
                    var obj = jQuery.parseJSON(response);
                    console.log(obj);
                    if (obj.status == "success") {
                        jQuery("#tipo_usuario").val(obj.userType);
                        jQuery("#email").val(obj.email);
                        jQuery("#nombre").val(obj.name);
                        jQuery("#apellido").val(obj.last);
                        jQuery("#nombre_curso").val(obj.nombre_curso);
                        jQuery("#id_curso").val(jQuery("#curso_id").val());
                        jQuery("#tipo_curso").val('C');
                        jQuery("#label_curso").html(obj.nombre_curso);
                        jQuery("#label_email").html(obj.email);
                        jQuery("#label_tipoUsuario").html(obj.email);
                        var email=obj.email;
                        if (obj.user_id) {
                            var id_usuario=obj.user_id;
                            jQuery(".campos_ocultos").hide();
                        }else{
                            var id_usuario='';
                        }
                        jQuery("#id_usuario").val(id_usuario);
                        
                        /*
                        var url = 'https://form.jotform.com/202313588748664?precio='+precio+'&tipo_usuario='+tipo_usuario+'&id_curso='+id_curso+'&nombre_curso='+nombre_curso+'&email='+email+'&nombre[first]='+nombre+'&nombre[last]='+apellido+'&id_usuario='+id_usuario+'&tipo_curso='+tipo_curso+bill;
                        
                        jQuery("#JotFormIFrame-202313588748664").attr('src',url);
                        jQuery("#JotFormIFrame-202313588748664").show(300);
                        */
                        //jQuery("#verifyF").hide(300);
                        jQuery("#newF").show(300);

                    }else{
                        jQuery("#mensajeErrorLogin").html(obj.mensaje);
                        jQuery("#mensajeErrorLogin").show();
                    }
                }
            });
        });
    });
})(jQuery);
</script>

<?php /*/ ?>
<script type="text/javascript">
      var ifr = document.getElementById("JotFormIFrame-202313588748664");
      if(window.location.href && window.location.href.indexOf("?") > -1) {
        var get = window.location.href.substr(window.location.href.indexOf("?") + 1);
        if(ifr && get.length > 0) {
          var src = ifr.src;
          src = src.indexOf("?") > -1 ? src + "&" + get : src  + "?" + get;
          ifr.src = src;
        }
      }
      window.handleIFrameMessage = function(e) {
        if (typeof e.data === 'object') { return; }
        var args = e.data.split(":");
        if (args.length > 2) { iframe = document.getElementById("JotFormIFrame-" + args[(args.length - 1)]); } else { iframe = document.getElementById("JotFormIFrame"); }
        if (!iframe) { return; }
        switch (args[0]) {
          case "scrollIntoView":
            iframe.scrollIntoView();
            break;
          case "setHeight":
            iframe.style.height = args[1] + "px";
            break;
          case "collapseErrorPage":
            if (iframe.clientHeight > window.innerHeight) {
              iframe.style.height = window.innerHeight + "px";
            }
            break;
          case "reloadPage":
            window.location.reload();
            break;
          case "loadScript":
            var src = args[1];
            if (args.length > 3) {
                src = args[1] + ':' + args[2];
            }
            var script = document.createElement('script');
            script.src = src;
            script.type = 'text/javascript';
            document.body.appendChild(script);
            break;
          case "exitFullscreen":
            if      (window.document.exitFullscreen)        window.document.exitFullscreen();
            else if (window.document.mozCancelFullScreen)   window.document.mozCancelFullScreen();
            else if (window.document.mozCancelFullscreen)   window.document.mozCancelFullScreen();
            else if (window.document.webkitExitFullscreen)  window.document.webkitExitFullscreen();
            else if (window.document.msExitFullscreen)      window.document.msExitFullscreen();
            break;
        }
        var isJotForm = (e.origin.indexOf("jotform") > -1) ? true : false;
        if(isJotForm && "contentWindow" in iframe && "postMessage" in iframe.contentWindow) {
          var urls = {"docurl":encodeURIComponent(document.URL),"referrer":encodeURIComponent(document.referrer)};
          iframe.contentWindow.postMessage(JSON.stringify({"type":"urls","value":urls}), "*");
        }
      };
      if (window.addEventListener) {
        window.addEventListener("message", handleIFrameMessage, false);
      } else if (window.attachEvent) {
        window.attachEvent("onmessage", handleIFrameMessage);
      }
</script>
<?php /*/ ?>