<?php if($_SERVER['SERVER_NAME']=='staging.asipi.org'){ ?>

<?php    
    //date_default_timezone_set('America/Caracas');
    
    //date_default_timezone_set('America/Panama');

    /*$fechaActual = date("d-m-Y");
    $horaActual = date("h:i:s");
    $timezone = date_default_timezone_get();
    
    $fechaActual1 = date_i18n( get_option( 'date_format' ), strtotime( '11/15-1976' ) );
    $horaActual1= date_i18n( 'g:i a' );
    
    
    echo "<br><p style='margin-left:50px;'>Zona Horaria: $timezone. La fecha del <b>servidor</b> es: $fechaActual y la hora es $horaActual</p><br>" ;
    echo "<br><p style='margin-left:50px;'>Zona Horaria: $timezone. La fecha de <b>wordpress</b> es: $fechaActual1 y la hora es $horaActual1</p><br>" ;
    
*/

?>
<iframe id="JotFormIFrame-252154118618152" sandbox="allow-same-origin allow-scripts allow-popups allow-forms allow-top-navigation" title="Seminario ASIPI Asunción 2025" allowtransparency=" true"
    allowfullscreen="true" allow="geolocation; microphone; camera" src="https://form.jotform.com/252154118618152"
    frameborder="0" style="

      min-width: 100%;

      height:3000px;

      border:none;" scrolling="no">

</iframe>



<script type="text/javascript">
var ifr = document.getElementById("JotFormIFrame-252154118618152");

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

<?php }else{ ?>

<iframe id="JotFormIFrame-252023962027148" sandbox="allow-same-origin allow-scripts allow-popups allow-forms allow-top-navigation" title="Congreso ASIPI Asunción 2025" "
    allowtransparency=" true" allowfullscreen="true" allow="geolocation; microphone; camera"
    src="https://form.jotform.com/252023962027148" frameborder="0" style="
      min-width: 100%;
      height:3200px;
      border:none;" scrolling="no">
</iframe>


<script type="text/javascript">
var ifr = document.getElementById("JotFormIFrame-252023962027148");
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
<?php } ?>
<style>
@media (max-width: 480px) {
    iframe {
        height: 3200px !important;
    }
}

@media screen and (min-width: 481px) and (max-width: 800px) {
    iframe {
        height: 3200px !important;
    }
}

@media screen and (min-width: 800px) {
    iframe {
        height: 3200px !important;
    }
}
</style>