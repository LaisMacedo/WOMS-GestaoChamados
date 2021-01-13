<?php require_once('before_content.php'); ?>

<?php 
    $chamadosAbertos = mysqli_fetch_assoc(
        mysqli_query($conexao, "SELECT count(cham_id) AS qtdAbertos FROM chamado_tecnico WHERE cham_status != 5 AND cham_status != 6;"));
    $qtdChamadosAbertos = $chamadosAbertos['qtdAbertos'];

    $chamadosConcluidos = mysqli_fetch_assoc(
        mysqli_query($conexao, "SELECT count(cham_id) AS qtdFechados FROM chamado_tecnico WHERE cham_status = 5 OR cham_status = 6;"));
    $qtdChamadosConcluidos = $chamadosConcluidos['qtdFechados'];

    $tecnicos = mysqli_fetch_assoc(
        mysqli_query($conexao, "SELECT count(usu_id) AS qtdTecnicos FROM usuario WHERE usu_cargo = 3;"));
    $tecnicosAtivos = $tecnicos['qtdTecnicos'];

    $finalizados = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT count(cham_id) AS qtd FROM chamado_tecnico WHERE cham_status = 5;"));
    $cancelados = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT count(cham_id) AS qtd FROM chamado_tecnico WHERE cham_status = 6;"));
    $taxaSucesso = ($finalizados['qtd'] / ($finalizados['qtd'] + $cancelados['qtd'])) * 100;

    $tempoMedio = "3:24:11";

    $valMedio = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT AVG(cham_valor_total) AS valorMedio FROM chamado_tecnico WHERE cham_status = 5"));
    $valorMedio = $valMedio['valorMedio'];

    
    //taxasucesso =  finalizados / finalizados + cancelados 
    //     0,5    =        1     /       2  //querys sql//
?>

<div class="row">
    <div class="col-lg-12">
        <div class="card" style="margin-bottom: 15px">
            <div class="gmap_unix card-body" style="padding: 4px;">
                <!--div class="map" id="basic-map"></div-->
                    <div id="map" class="map"></div>
                    <?php 
                    	$latLoja = '-23.186089';
    					$lngLoja = '-50.653893';

                        #consulta no banco e inicia as variaveis e o mapa
                        $getCoordenadas = mysqli_query($conexao,"SELECT * FROM coordenadas_ct ORDER BY cham_status DESC;");
                        $em_andamento = 0; $finalizados = 0;  $cancelados = 0;
                        echo '<script>';
                        echo '  var latitude = '.$latLoja.';';
                        echo '  var longitude = '.$lngLoja.';';
                        echo '  function initMap() {';

                        #mapa 1
                            echo '      var map = new google.maps.Map(document.getElementById(\'map\'), {';
                            echo '          zoom: 14,';
                            echo '          center: {lat: latitude, lng: longitude}';
                            echo '      });';
                            while ($coordenadas = mysqli_fetch_assoc($getCoordenadas)) {
                                if($coordenadas['cham_status']==1 || $coordenadas['cham_status']==2 || $coordenadas['cham_status']==3 || $coordenadas['cham_status']==4) { 
                                									 $coloricon = 'http://maps.gstatic.com/mapfiles/ridefinder-images/mm_20_orange.png'; $em_andamento++; }
                                if($coordenadas['cham_status']==5) { $coloricon = 'http://maps.gstatic.com/mapfiles/ridefinder-images/mm_20_green.png';  $finalizados++; }
                                if($coordenadas['cham_status']==6) { $coloricon = 'http://maps.gstatic.com/mapfiles/ridefinder-images/mm_20_red.png';    $cancelados++; }
                                echo '   var chamado_' . $coordenadas['cham_id'] . ' = {lat: ' . $coordenadas['end_latitude'] . ', lng: ' . $coordenadas['end_longitude'] . '};';
                                echo '   var marker1 = new google.maps.Marker( { position: chamado_' . $coordenadas['cham_id'] . ', map: map, url: \'chamado.php?view='.$coordenadas['cham_id'].'\', icon: \''.$coloricon.'\', title:"'.$coordenadas['est_nome'].'"} );';
                                echo '   google.maps.event.addListener(marker1, \'click\', function() {';
                                echo '        window.location.href = this.url;';
                                echo '   });';
                            }
                            echo '   var local = {lat: latitude, lng: longitude};';
                            echo ' var marcador = new google.maps.Marker( { position: local, map: map, url: \'index.php\', icon: \'http://maps.google.com/mapfiles/kml/pal2/icon10.png\' } );';
                            echo '   google.maps.event.addListener(marcador, \'click\', function() {';
                            echo '        window.location.href = this.url;';
                            echo '   });';
                        echo '  }'; #initMap
                        echo '</script>';
                    ?>
                    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2jlT6C_to6X1mMvR9yRWeRvpIgTXgddM&callback=initMap"></script>
            </div>
            <div class="legenda">
                <div class="col-md-2 col-sm-12 pt-1 pb-1 text-center"><strong>Legenda</strong></div>
                    <div class="col-md-10 col-sm-12">    
                    <?php
                        echo '<div class="col-lg-4 col-sm-12 pl-2 pt-1 pb-1"><img src="http://maps.gstatic.com/mapfiles/ridefinder-images/mm_20_orange.png"/>';
                        echo '    <strong>'.$em_andamento.'</strong> Em Andamento </div>';
                        echo '<div class="col-lg-4 col-sm-12 pl-2 pt-1 pb-1"><img src="http://maps.gstatic.com/mapfiles/ridefinder-images/mm_20_green.png"/>';
                        echo '    <strong>'.$finalizados.'</strong> Finalizados</div>';
                        echo '<div class="col-lg-4 col-sm-12 pl-2 pt-1 pb-1"><img src="http://maps.gstatic.com/mapfiles/ridefinder-images/mm_20_red.png"/>';
                        echo '    <strong>'.$cancelados.'</strong> Cancelados </div>';
                    ?>

                </div>
            </div>
        </div>
        <!-- /# card -->
    </div> <!-- mapa --> <!-- MAPA --> <!--mapa do google-->
</div>    

<div class="row">
    <div class="col-sm-12 md-4" style="margin-bottom: 20px;">
    <div class="card-group">

        <div class="card col-md-6 no-padding ">
            <div class="card-body">
                <div class="h1 text-muted text-right mb-4">
                    <i class="fa fa-users"></i>
                </div>
                <div class="h4 mb-0">
                    <span class="count">
                        <?php echo $tecnicosAtivos; ?>
                    </span>
                </div>
                <small class="text-muted text-uppercase font-weight-bold">Técnicos Ativos</small>
                <div class="progress progress-xs mt-3 mb-0 bg-flat-color-1" style="width: 40%; height: 5px;"></div>
            </div>
        </div>

        <div class="card col-md-6 no-padding ">
            <div class="card-body">
                <div class="h1 text-muted text-right mb-4">
                    <i class="ti-notepad"></i>
                </div>
                <div class="h4 mb-0">
                    <span class="count">
                        <?php echo $qtdChamadosAbertos; ?>
                    </span>
                </div>
                <small class="text-muted text-uppercase font-weight-bold">CT Abertos</small>
                <div class="progress progress-xs mt-3 mb-0 bg-flat-color-3" style="width: 40%; height: 5px;"></div>
            </div>
        </div>

        <div class="card col-md-6 no-padding ">
            <div class="card-body">
                <div class="h1 text-muted text-right mb-4">
                    <i class="fa fa-check-square-o"></i>
                </div>
                <div class="h4 mb-0">
                    <span class="count">
                        <?php echo $qtdChamadosConcluidos; ?>
                    </span>
                </div>
                <small class="text-muted text-uppercase font-weight-bold">CT Finalizados</small>
                <div class="progress progress-xs mt-3 mb-0 bg-flat-color-5" style="width: 40%; height: 5px;"></div>
            </div>
        </div>

        <div class="card col-md-6 no-padding ">
            <div class="card-body">
                <div class="h1 text-muted text-right mb-4">
                    <i class="fa fa-pie-chart"></i>
                </div>
                <div class="h4 mb-0">
                    <span class="count">
                        <?php echo $taxaSucesso; ?>
                    </span>%
                </div>
                <small class="text-muted text-uppercase font-weight-bold">CT Bem-sucedidos</small>
                <div class="progress progress-xs mt-3 mb-0 bg-flat-color-5" style="width: 40%; height: 5px;"></div>
            </div>
        </div>

        <div class="card col-md-6 no-padding ">
            <div class="card-body">
                <div class="h1 text-muted text-right mb-4">
                    <i class="fa fa-clock-o"></i>
                </div>
                <div class="h4 mb-0">
                    <?php echo $tempoMedio; ?>
                </div>
                <small class="text-muted text-uppercase font-weight-bold">Tempo Médio CT</small>
                <div class="progress progress-xs mt-3 mb-0 bg-flat-color-2" style="width: 40%; height: 5px;"></div>
            </div>
        </div>

        <div class="card col-md-6 no-padding ">
            <div class="card-body">
                <div class="h1 text-muted text-right mb-4">
                    <i class="fa fa-usd"></i>
                </div>
                <div class="h4 mb-0">
                    R$<span class="count">
                        <?php echo $valorMedio; ?>
                    </span>
                </div>
                <small class="text-muted text-uppercase font-weight-bold">Valor Médio CT</small>
                <div class="progress progress-xs mt-3 mb-0 bg-flat-color-1" style="width: 40%; height: 5px;"></div>
            </div>
        </div>

    </div> <!-- status cards -->
    </div> <!-- CARDS --> <!--blocos de informações-->
</div>

<?php require_once('after_content.php'); ?>

<!--
CREATE OR REPLACE VIEW coordenadas_ct AS (SELECT ch.cham_id, ch.cham_status, es.est_nome, en.end_latitude, en.end_longitude
            FROM chamado_tecnico AS ch, endereco AS en, cliente AS cl, estatus AS es
            WHERE ch.cham_cliente = cl.cli_id AND cl.cli_endereco = en.end_id AND ch.cham_status = es.est_id);