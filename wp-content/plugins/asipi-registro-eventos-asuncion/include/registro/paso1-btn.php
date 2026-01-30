<br>panama

<div id="bloque-titulo">

    <h3 style="text-align: center"><?php echo $textos[$lang]['registry'] ?></h3>

    <h4 style="font-size: x-large;"><?php echo __($nombre_evento[$lang]) ?></b></h4>

    <p style="font-size: 20px;"><b><a href="/quito2023/planes-y-costos/" target="_blank"><?php echo __("<!--:es-->Planes y Costos<!--:--><!--:en-->Plans and Costs<!--:-->") ?></a></b></p>

</div>

<div class="container  paso1">

    <div class="two columns">

        

    </div>

    <div class="four columns">

        <div class="card">

            <div class="card-header">

                <p><?php echo __("<!--:es-->Registro Presencial<!--:--><!--:en-->Face-to-face Registration<!--:-->") ?></p>

            </div>

            <div class="card-body">

                <h1 class="card-title pricing-card-title">

                    <!-- US$ <?php echo $costos['member_simple_'.$tipo_precio.'_price']?> <small style="font-size: medium;">(<?php echo __("<!--:es-->Presencial<!--:--><!--:en-->Face to face<!--:-->") ?>)</small> <small class="text-muted"></small><br> -->

                </h1>

                <br>

                <a class="btn-comprar" href="?t=presencial"><?php echo $textos[$lang]['register'] ?></a>

                <p class="card-text"><?php /* if($tipo_precio=='early_bird'){ ?><?php echo __("<!--:es-->Early bird hasta el 15/09<!--:--><!--:en-->Early bird until 09/15<!--:-->") ?><?php } */ ?></p>

            </div>

        </div>

    </div>

    <div class="four columns">

        <div class="card">

            <div class="card-header">

                <p><?php echo __("<!--:es-->Registro Virtual<!--:--><!--:en-->Virtual Registration<!--:-->") ?></p>

            </div>

            <div class="card-body">

                <h1 class="card-title pricing-card-title">

                    <!-- US$ <?php echo $costos['member_simple_'.$tipo_precio.'_price']?> <small style="font-size: medium;">(<?php echo __("<!--:es-->Presencial<!--:--><!--:en-->Face to face<!--:-->") ?>)</small> <small class="text-muted"></small><br> -->

                </h1>

                <br>

                <a class="btn-comprar" href="?t=virtual"><?php echo $textos[$lang]['register'] ?></a>

                <p class="card-text"><?php /* if($tipo_precio=='early_bird'){ ?><?php echo __("<!--:es-->Early bird hasta el 15/09<!--:--><!--:en-->Early bird until 09/15<!--:-->") ?><?php } */ ?></p>

            </div>

        </div>

    </div>

    <div class="two columns">

        

    </div>

</div>

<style>

    .card-body {

        min-height: auto !important;

    }

</style>

<br>

<br>

<br>

<br>

<br>

<br>

<br>

<br>