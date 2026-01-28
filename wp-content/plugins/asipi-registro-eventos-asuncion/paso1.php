<?php 
global $wpdb;
global $blog_id;
$lang = ($_REQUEST['lang']) ? $_REQUEST['lang'] : 'es' ;
/*if(isset($_REQUEST['curso'])){
    $idcurso = $_REQUEST['curso'];
}*/

//$sql = "SELECT DISTINCT value FROM pwisa_bp_xprofile_data WHERE field_id=12 ORDER BY value asc";
$sql = "SELECT DISTINCT t2.value FROM pwisa_bp_xprofile_data t2 
INNER JOIN pwisa_usermeta t1 ON t1.user_id = t2.user_id
where t1.meta_key = 'pwisa_capabilities' AND t1.meta_value LIKE '%member%'
and t2.field_id=12 ORDER BY value asc";
$queryResult = $wpdb->get_results($sql);
$queryResult = json_decode(json_encode($queryResult), true);
$costo_socio = 375;
$costo_miembro = 375;
$costo_nosocio = 375;
$costo_student = 375;
$nombre_evento = '';


# Datos del evento
    //$sql = "SELECT id, nombre, costo_socio, costo_miembro, costo_nosocio, cant_modulos, cupos FROM pwisa_asipi_cursos WHERE id=$idcurso limit 1";
    $sql = "SELECT * FROM evento_meta where evento_id = '$blog_id'";
    $qryEvento = $wpdb->get_results($sql);
    $qryEvento = json_decode(json_encode($qryEvento), true);
    foreach ($qryEvento as $key => $value) {
        switch ($value['clave']) {
            case "member_full_price":
                $costo_socio = $value['valor'];
                break;
            case "member_of_firm_full_price":
                $costo_miembro = $value['valor'];
                break;
            case "non_member_full_price":
                $costo_nosocio = $value['valor'];
                break;
            case "student_full_price":
                $costo_student = $value['valor'];
                break;
            case "name_es":
                $nombre_evento = $value['valor'];
                break;
        }
    }


$textos = array(
    'es' => array(
        'course' => 'Curso',
        'registry' => 'Registro', 
        'free' => 'Sin Costo',
        'register_with_email_asipi' => 'Debe ingresar con su correo registrado en ASIPI<br><spam style="font-size:10px">Estar al día con la membresía</spam>', 
        'register' => 'Registrarse', 
        'members_firm_tit' => 'Miembros de Firma<br>con Socios en ASIPI', 
        'members_firm_tit_form' => 'Miembros de Firma<br>con Socios en ASIPI', 
        'members_firm_nota' => 'Debe ingresar el correo registrado en ASIPI del Socio', 
        'non_member' => 'No Socios', 
        'student' => 'Estudiantes',
        'member' => 'Socios',
        'enter_email_asipi' => 'Ingrese su correo registrado en ASIPI', 
        'password' => 'Contraseña',
        'enter_password' => 'Ingrese la contraseña',
        'forgot_password' => 'Olvidó Contraseña',
        'continue' => 'Continuar',
        'please_enter_email' => 'Por favor ingrese su correo electrónico',
        'enter_email' => 'Ingrese su correo electrónico',
        'please_enter_email_asipi_nota' => 'Por favor ingresar el correo electrónico del socio de ASIPI miembro en su firma', 
        'please_enter_email_asipi' => 'Ingresar correo del socio de ASIPI', 
        'company' => 'Compañia', 
        'select_company' => 'Seleccione Compañia', 

    ), 
    'en' => array(
        'course' => 'Course',
        'registry' => 'Registry', 
        'free' => 'Free',
        'register_with_email_asipi' => 'Use your email registered in ASIPI',
        'register' => 'Register',
        'members_firm_tit' => 'Non-members with<br>partners in ASIPI',
        'members_firm_tit_form' => 'Non-members with partners in ASIPI', 
        'members_firm_nota' => 'You need the partner´s email registered in ASIPI',
        'non_member' => 'Non Members',
        'student' => 'student',
        'member' => 'Members',
        'enter_email_asipi' => 'Enter your email registered in ASIPI',
        'password' => 'Password',
        'enter_password' => 'Enter password',
        'forgot_password' => 'Forgot Password',
        'continue' => 'next',
        'please_enter_email' => 'Please enter your email',
        'enter_email' => 'Enter your email',
        'please_enter_email_asipi_nota' => 'Please enter a valid email address (ASIPI Members use your email registered with us)',
        'please_enter_email_asipi' => 'Enter email from ASIPI partner',
        'company' => 'Company',
        'select_company' => 'Select Company',
    ), 
);
?>
<br>
<div id="bloque-titulo">
    <?php //echo 'id evento:'.$blog_id.'<br>'; ?>
    <h3 style="text-align: center"><?php echo $textos[$lang]['registry'] ?></h3>
    <h4><?php echo __($nombre_evento) ?></b></h4>
</div>
<div class="container  paso1">
    <div class="three columns" id="">
        <div class="card">
            <div class="card-header">
                <p><?php echo $textos[$lang]['member'] ?></p>
            </div>
            <div class="card-body">
                <h1 class="card-title pricing-card-title">
                    <?php if($costo_socio>0){?>$<?php echo $costo_socio?><?php }else{?><?php echo $textos[$lang]['free'] ?><?php }?>
                    <small class="text-muted"></small></h1>
                <br>
                <a class="btn-comprar" id=""><?php echo $textos[$lang]['register'] ?></a>
                <p class="card-text"><?php echo $textos[$lang]['register_with_email_asipi'] ?></p>
            </div>
        </div>
    </div>
    <div class="three columns" id="">
        <div class="card">
            <div class="card-header">
                <p><?php echo $textos[$lang]['members_firm_tit'] ?></p>
            </div>
            <div class="card-body">
                <h1 class="card-title pricing-card-title">$<?php echo $costo_miembro?> <small
                        class="text-muted"></small></h1>
                <br>
                <a class="btn-comprar" id=""><?php echo $textos[$lang]['register'] ?></a>
                <p class="card-text"><?php echo $textos[$lang]['members_firm_nota'] ?><br></p>
            </div>
        </div>
    </div>
    <div class="three columns" id="">
        <div class="card">
            <div class="card-header">
                <p><?php echo $textos[$lang]['non_member'] ?></p>
            </div>
            <div class="card-body">
                <h1 class="card-title pricing-card-title">$<?php echo $costo_nosocio?> <small
                        class="text-muted"></small></h1>
                <br>
                <a class="btn-comprar" id=""><?php echo $textos[$lang]['register'] ?></a>
                <p class="card-text"><br><br></p>
            </div>
        </div>
    </div>
    <div class="three columns" id="">
        <div class="card">
            <div class="card-header">
                <p><?php echo $textos[$lang]['student'] ?></p>
            </div>
            <div class="card-body">
                <h1 class="card-title pricing-card-title">$<?php echo $costo_student?> <small
                        class="text-muted"></small></h1>
                <br>
                <a class="btn-comprar" id=""><?php echo $textos[$lang]['register'] ?></a>
                <p class="card-text"><br><br></p>
            </div>
        </div>
    </div>
    <div class="nine columns" style="padding-top: 0px" id="bloque-izquierdo">
        <div id="socio" style="display: none;" class="divform">
            <a class="cambiar_plan">
                < Cambiar plan</a>
                    <h1><?php echo $textos[$lang]['member'] ?></h1>
                    <div class="row">
                        <div class="col-md-12">
                            <form id="form-verify-socios" class="form" action="javascript:verifySocio()">
                                <div class="form-group">
                                    <label for="email"><?php echo $textos[$lang]['enter_email_asipi'] ?></label>
                                    <input type="email" class="form-control" name="email" id="email" required
                                        aria-describedby="emailHelp"
                                        placeholder="<?php echo $textos[$lang]['enter_email'] ?>">
                                    <small id="emailHelp" class="form-text text-muted"></small>
                                </div>
                                <div class="form-group">
                                    <label for="password"><?php echo $textos[$lang]['password'] ?></label>
                                    <input type="password" class="form-control" id="password"
                                        placeholder="<?php echo $textos[$lang]['password'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <a href="/ingresar/?action=forgot_password" target="_blank"
                                        style="color: #1f5494 !important;"><?php echo $textos[$lang]['forgot_password'] ?></a>
                                </div>
                                <div id="mensajeErrorLogin" class="alert alert-danger in"
                                    style="font-size: 14px;display:none;"></div>
                                <div class="espacio-boton"><a type="submit" class="btn-comprar"
                                        id="verifySocio"><?php echo $textos[$lang]['continue'] ?></a></div>
                            </form>
                        </div>
                    </div>
        </div>
        <div id="miembro" style="display: none;" class="divform">
            <a class="cambiar_plan">
                < Cambiar plan</a>
                    <h1><?php echo $textos[$lang]['member_firm_tit_form'] ?></h1>
                    <div class="row">
                        <div class="col-md-12">
                            <form id="form-verify-miembros" class="form" action="javascript:veryfyMiembro()">
                                <div class="form-group">
                                    <label
                                        for="email_invitado"><?php echo $textos[$lang]['please_enter_email'] ?></label>
                                    <input type="email" class="form-control" name="email_invitado" id="email_invitado"
                                        required aria-describedby="emailHelp"
                                        placeholder="<?php echo $textos[$lang]['enter_email'] ?>">
                                    <small id="emailHelp" class="form-text text-muted"></small>
                                </div>
                                <div class="form-group">
                                    <label
                                        for="email"><?php echo $textos[$lang]['please_enter_email_asipi_nota'] ?></label>
                                    <input type="email" class="form-control" name="email_fiador" id="email_fiador"
                                        required aria-describedby="emailHelp"
                                        placeholder="<?php echo $textos[$lang]['please_enter_email_asipi'] ?>">
                                    <small id="emailHelp" class="form-text text-muted"></small>
                                </div>
                                <div class="form-group">
                                    <label for="password"><?php echo $textos[$lang]['company'] ?></label>
                                    <select type="select" name="company" id="company" class="form-control">
                                        <option value=""><?php echo $textos[$lang]['select_company'] ?></option>
                                        <?php
                                    foreach ($queryResult as $key => $value) {
                                        ?>
                                        <option value="<?php echo $value['value']?>"><?php echo $value['value']?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                                <div class="form-group" id="olvidoC">
                                </div>
                                <div id="mensajeErrorMiembro" class="alert alert-danger in"
                                    style="font-size: 14px;display:none;"></div>
                                <div class="espacio-boton"><a type="submit" class="btn-comprar"
                                        id="veryfyMiembro"><?php echo $textos[$lang]['continue'] ?></a></div>
                            </form>
                        </div>
                    </div>

        </div>
        <div id="nosocio" style="display: none;" class="divform">
            <a href="" class="cambiar_plan">
                < Cambiar plan</a>
                    <h1><?php echo $textos[$lang]['non_member'] ?></h1>
                    <div class="row">
                        <div class="col-md-12">
                            <form id="form-verify-email-nosocio" class="form" action="javascript:veryfyNoSocio()">
                                <div class="form-group">
                                    <label for="email"><?php echo $textos[$lang]['please_enter_email'] ?></label>
                                    <input type="email" class="form-control" name="email_nosocio" id="email_nosocio"
                                        required aria-describedby="emailHelp"
                                        placeholder="<?php echo $textos[$lang]['enter_email'] ?>">
                                    <small id="emailHelp" class="form-text text-muted"></small>
                                    <input type="hidden" id="typeLoginNosocio" name="typeLoginNosocio" value="verify">
                                </div>
                                <div id="passwordNoSocio" style="display: none;">
                                    <div class="form-group">
                                        <label for="password"><?php echo $textos[$lang]['password'] ?></label>
                                        <input type="password" class="form-control" name="password_nosocio"
                                            id="password_nosocio"
                                            placeholder="<?php echo $textos[$lang]['enter_password'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <a href="/ingresar/?action=forgot_password" target="_blank"
                                            style="color: #1f5494 !important;"><?php echo $textos[$lang]['forgot_password'] ?></a>
                                    </div>
                                </div>
                                <div id="mensajeErrorNoSocio" class="alert alert-danger in"
                                    style="font-size: 14px;display:none;"></div>
                                <div class="espacio-boton"><a type="submit" class="btn-comprar"
                                        id="veryfyNoSocio"><?php echo $textos[$lang]['continue'] ?></a></div>
                            </form>
                        </div>
                    </div>

        </div>
        <div id="student" style="display: none;" class="divform">
            <a href="" class="cambiar_plan">
                < Cambiar plan</a>
                    <h1><?php echo $textos[$lang]['student'] ?></h1>
                    <div class="row">
                        <div class="col-md-12">
                            <form id="form-verify-email-student" class="form" action="javascript:veryfyStudent()">
                                <div class="form-group">
                                    <label for="email"><?php echo $textos[$lang]['please_enter_email'] ?></label>
                                    <input type="email" class="form-control" name="email_student" id="email_student"
                                        required aria-describedby="emailHelp"
                                        placeholder="<?php echo $textos[$lang]['enter_email'] ?>">
                                    <small id="emailHelp" class="form-text text-muted"></small>
                                    <input type="hidden" id="typeLoginStudent" name="typeLoginStudent" value="verify">
                                </div>
                                <div id="passwordStudent" style="display: none;">
                                    <div class="form-group">
                                        <label for="password"><?php echo $textos[$lang]['password'] ?></label>
                                        <input type="password" class="form-control" name="password_student"
                                            id="password_student"
                                            placeholder="<?php echo $textos[$lang]['enter_password'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <a href="/ingresar/?action=forgot_password" target="_blank"
                                            style="color: #1f5494 !important;"><?php echo $textos[$lang]['forgot_password'] ?></a>
                                    </div>
                                </div>
                                <div id="mensajeErrorStudent" class="alert alert-danger in"
                                    style="font-size: 14px;display:none;"></div>
                                <div class="espacio-boton"><a type="submit" class="btn-comprar"
                                        id="veryfyStudent"><?php echo $textos[$lang]['continue'] ?></a></div>
                            </form>
                        </div>
                    </div>

        </div>
    </div>
    <div class="clear"></div>
</div>

<div class="row paso1">
    <div class="col-md-3" id="vacio"></div>

</div>
<div class="container">
    <div class="twelve columns">
        <div id="loadingimage" style="text-align:center;display:none;"><img
                src="https://asipi.org/wp-content/uploads/2016/05/loading.gif">
            <p><?php if ($lang == 'en-US'): ?>Please wait...<?php else: ?>Por favor espere...<?php endif ?></p>
        </div>
    </div>
</div>
<style>
.card-body {
    min-height: 210px !important;
}
</style>


<div class="container">
    <div class="twelve columns" style="text-align: center;">
        <br>
        <p><b>Políticas de cancelación:</b></p>
        <p>Hasta el 15 de Noviembre, devolución del 50%, luego de esa fecha, no habrá devoluciones.</p>
    </div>
</div>

<iframe id="JotFormIFrame-222413772555658"
    title="Seminario EL Salvador 2025" onload="window.parent.scrollTo(0,0)"
    allowtransparency="true" allowfullscreen="true" allow="geolocation; microphone; camera"
    src="https://form.jotform.com/222413772555658" frameborder="0" style="
      min-width: 100%;
      height:539px;
      border:none;
      display:none" scrolling="no">
</iframe>
<script type="text/javascript">
var ifr = document.getElementById("JotFormIFrame-222413772555658");
if (ifr) {
    var src = ifr.src;
    var iframeParams = [];
    if (window.location.href && window.location.href.indexOf("?") > -1) {
        iframeParams = iframeParams.concat(window.location.href.substr(window.location.href.indexOf("?") + 1).split(
            '&'));
    }
    if (src && src.indexOf("?") > -1) {
        iframeParams = iframeParams.concat(src.substr(src.indexOf("?") + 1).split("&"));
        src = src.substr(0, src.indexOf("?"))
    }
    iframeParams.push("isIframeEmbed=1");
    ifr.src = src + "?" + iframeParams.join('&');
}
window.handleIFrameMessage = function(e) {
    if (typeof e.data === 'object') {
        return;
    }
    var args = e.data.split(":");
    if (args.length > 2) {
        iframe = document.getElementById("JotFormIFrame-" + args[(args.length - 1)]);
    } else {
        iframe = document.getElementById("JotFormIFrame");
    }
    if (!iframe) {
        return;
    }
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
            if (!window.isPermitted(e.origin, ['jotform.com', 'jotform.pro'])) {
                break;
            }
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
            if (window.document.exitFullscreen) window.document.exitFullscreen();
            else if (window.document.mozCancelFullScreen) window.document.mozCancelFullScreen();
            else if (window.document.mozCancelFullscreen) window.document.mozCancelFullScreen();
            else if (window.document.webkitExitFullscreen) window.document.webkitExitFullscreen();
            else if (window.document.msExitFullscreen) window.document.msExitFullscreen();
            break;
    }
    var isJotForm = (e.origin.indexOf("jotform") > -1) ? true : false;
    if (isJotForm && "contentWindow" in iframe && "postMessage" in iframe.contentWindow) {
        var urls = {
            "docurl": encodeURIComponent(document.URL),
            "referrer": encodeURIComponent(document.referrer)
        };
        iframe.contentWindow.postMessage(JSON.stringify({
            "type": "urls",
            "value": urls
        }), "*");
    }
};
window.isPermitted = function(originUrl, whitelisted_domains) {
    var url = document.createElement('a');
    url.href = originUrl;
    var hostname = url.hostname;
    var result = false;
    if (typeof hostname !== 'undefined') {
        whitelisted_domains.forEach(function(element) {
            if (hostname.slice((-1 * element.length - 1)) === '.'.concat(element) || hostname === element) {
                result = true;
            }
        });
        return result;
    }
};
if (window.addEventListener) {
    window.addEventListener("message", handleIFrameMessage, false);
} else if (window.attachEvent) {
    window.attachEvent("onmessage", handleIFrameMessage);
}
</script>
<style>
.formFooter {
    display: none;
}

.cambiar_plan {
    display: none;
    text-decoration: none;
    cursor: pointer;
    color: #007bff !important;
}
</style>

<script>
var formJF = '222413772555658';
var id_curso = '<?php echo $idcurso?>';
var tipo_curso = '<?php echo $tipo_curso ?>';
var nombre_curso = '<?php echo $nombre_curso ?>';
var precio_socio = '<?php echo $costo_socio?>';
var precio_miembro = '<?php echo $costo_miembro?>';
var precio_nosocio = '<?php echo $costo_nosocio?>';
var precio_student = '<?php echo $costo_student?>';
</script>