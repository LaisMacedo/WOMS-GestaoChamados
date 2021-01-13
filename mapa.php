<?php require_once('before_content.php'); ?>

<?php #Define LAT e LNG da Empresa (aleterar para consultar do banco)
    $latLoja = '-23.186089';
    $lngLoja = '-50.653893';
?> 

<style type="text/css">
    .map {
      display: flex;
      border: 1px solid #dee2e6;
      height: 600px;
      width: 100%;
      z-index: 4;
    }    
    @media only screen and (max-height: 800px) {
        #map {
            height: 500px;
        }
    }
    @media only screen and (max-width: 1250px) {
        .legenda div {
            font-size: 14px;
        }
    }
    .legenda img {
        width: 22px;
    }
</style>

<?php #handle GET requisition
    $map = 1; #by default
    if($_SERVER['REQUEST_METHOD'] == "GET") {
        if(isset($_GET['lat'])&&isset($_GET['lng'])){ //valores passados por parametros get latude e longitude
            $lat = $_GET['lat'];
            $lng = $_GET['lng'];
            $map = 0; 
            $tipo_txt = 'Mapa';
            $link = false;
            if (isset($_GET['tipo'])){
                $tipo = $_GET['tipo'];
                if ($tipo == 1){ $tipo_txt = 'Chamado'; }
                if ($tipo == 2){ $tipo_txt = 'Técnico'; }
                if ($tipo == 3){ $tipo_txt = 'Cliente'; }
                if (isset($_GET['id'])){
                    $link = true;
                    $id = $_GET['id'];
                    if ($tipo == 1){ $url = 'chamado.php?view='.$id;}
                    if ($tipo == 2){ $url = 'usuario.php?view='.$id;}
                    if ($tipo == 3){ $url = 'cliente.php?view='.$id;}
                }
            }   
        }
        if(isset($_GET['map'])){
            $map = $_GET['map'];
        } 
    } else { //valores pre-definidos centro de cornélio procópio
        $map = 1;
    }    
    # echo 'var map: '.$map;    # for debug
?>
<?php if ($map == 0){ 
    logMsg( $_SESSION['usu_login']." entrou em a mapa.php?tipo=" . $tipo );?>
    <div class="default-tab">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link" href="mapa.php?map=1" aria-selected="false">Chamados</a>
                <a class="nav-item nav-link" href="mapa.php?map=2" aria-selected="false">Técnicos</a>
                <a class="nav-item nav-link" href="mapa.php?map=3" aria-selected="false">Clientes</a> 
                <a class="nav-item nav-link  active show" aria-selected="true"><?php echo $tipo_txt;?></a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade active show" id="nav-chamados" role="tabpanel" aria-labelledby="nav-chamados-tab">
                <div id="map" class="map"></div>
                    <?php                 
                        echo '<script>';
                        echo '  var latitude = '.$_GET['lat'].';';
                        echo '  var longitude = '.$_GET['lng'].';';
                        echo '  function initMap() {';
                            echo '      var map = new google.maps.Map(document.getElementById(\'map\'), {';
                            echo '          zoom: 15,';
                            echo '          center: {lat: latitude, lng: longitude}';
                            echo '      });';
                            echo '   var local = {lat: latitude, lng: longitude};';
                            if ($link){
                                if($tipo == 2){
                                    $sql_user = 'SELECT usu_foto AS foto, usu_nome AS nome FROM usuario WHERE usu_id = ' . $id . ';';
                                    $user = mysqli_fetch_assoc(mysqli_query($conexao, $sql_user));
                                    echo ' var marker1 = new google.maps.Marker( { position: local, map: map, url: \''.$url.'\', icon: \'http://sistema.developintech.com/upload/mini/m_'.$user['foto'].'\', title:"'.$user['nome'].'" } );';
                                } else{
                                    echo ' var marker1 = new google.maps.Marker( { position: local, map: map, url: \''.$url.'\', title:"Endereço"} );';
                                }
                                echo '   google.maps.event.addListener(marker1, \'click\', function() {';
                                echo '        window.location.href = this.url;';
                                echo '   });';
                            } else {
                                echo ' var marker1 = new google.maps.Marker( { position: local, map: map } );';
                            }
                        echo '  }'; #initMap
                        echo '</script>';
                        #echo $teste; #debug
                    ?>
            </div>
        </div>
    </div>
<?php } ?>

<?php if ($map == 1){ 
    logMsg( $_SESSION['usu_login']." entrou em a mapa.php (Chamados)" );?>
    <div class="default-tab">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active show" aria-selected="true">Chamados</a>
                <a class="nav-item nav-link" href="mapa.php?map=2" aria-selected="false">Técnicos</a>
                <a class="nav-item nav-link" href="mapa.php?map=3" aria-selected="false">Clientes</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade active show" id="nav-chamados" role="tabpanel" aria-labelledby="nav-chamados-tab">
                <div id="map" class="map"></div>
                    <?php 
                        #consulta no banco e inicia as variaveis e o mapa
                        $getCoordenadas = mysqli_query($conexao,"SELECT * FROM coordenadas_ct_ativos;");
                        $em_espera = 0;  $em_deslocamento = 0;  $em_execucao = 0;  $designar_tec = 0;
                        echo '<script>';
                        echo '  var latitude = '.$latLoja.';';
                        echo '  var longitude = '.$lngLoja.';';
                        echo '  function initMap() {';

                        #mapa 1
                            echo '      var map = new google.maps.Map(document.getElementById(\'map\'), {';
                            echo '          zoom: 15,';
                            echo '          center: {lat: latitude, lng: longitude}';
                            echo '      });';
                            while ($coordenadas = mysqli_fetch_assoc($getCoordenadas)) {
                                if($coordenadas['cham_status']==1) { $coloricon = 'orange-dot.png'; $designar_tec++; }
                                if($coordenadas['cham_status']==2) { $coloricon = 'yellow-dot.png'; $em_espera++; }
                                if($coordenadas['cham_status']==3) { $coloricon = 'ltblue-dot.png'; $em_deslocamento++; }
                                if($coordenadas['cham_status']==4) { $coloricon = 'blue-dot.png';   $em_execucao++; }
                                echo '   var chamado_' . $coordenadas['cham_id'] . ' = {lat: ' . $coordenadas['end_latitude'] . ', lng: ' . $coordenadas['end_longitude'] . '};';
                                echo '   var marker1 = new google.maps.Marker( { position: chamado_' . $coordenadas['cham_id'] . ', map: map, url: \'chamado.php?view='.$coordenadas['cham_id'].'\', icon: \'http://maps.google.com/mapfiles/ms/micons/'.$coloricon.'\', title:"'.$coordenadas['est_nome'].'"} );';
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
                <div class="legenda mt-2">
                    <div class="col-md-2 col-sm-12 pt-2 text-center"><strong>Legenda</strong></div>
                    <div class="col-md-10 col-sm-12">    
                    <?php
                        echo '<div class="col-lg-3 col-md-6 pl-2 pt-2"><img src="http://maps.google.com/mapfiles/ms/micons/orange-dot.png"/>';
                        echo '    <strong>'.$designar_tec.'</strong> Designar Técnico </div>';
                        echo '<div class="col-lg-3 col-md-6 pl-2 pt-2"><img src="http://maps.google.com/mapfiles/ms/micons/yellow-dot.png"/>';
                        echo '    <strong>'.$em_espera.'</strong> em Espera</div>';
                        echo '<div class="col-lg-3 col-md-6 pl-2 pt-2"><img src="http://maps.google.com/mapfiles/ms/micons/ltblue-dot.png"/>';
                        echo '    <strong>'.$em_deslocamento.'</strong> em Deslocamento </div>';
                        echo '<div class="col-lg-3 col-md-6 pl-2 pt-2"><img src="http://maps.google.com/mapfiles/ms/micons/blue-dot.png"/>';
                        echo '    <strong>'.$em_execucao.'</strong> em Execução </div>';
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if ($map == 2){ 
    logMsg( $_SESSION['usu_login']." entrou em a mapa.php (Tecnicos)" );?>
    <div class="default-tab">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link" href="mapa.php?map=1" aria-selected="false">Chamados</a>
                <a class="nav-item nav-link active show" aria-selected="true">Técnicos</a>
                <a class="nav-item nav-link" href="mapa.php?map=3" aria-selected="false">Clientes</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade active show" id="nav-chamados" role="tabpanel" aria-labelledby="nav-chamados-tab">
                <div id="map" class="map"></div>
                    <?php 
                        #consulta no banco e inicia as variaveis e o mapa           
                        $getTecnicos = mysqli_query($conexao, "SELECT usu_id, usu_nome, usu_latitude, usu_longitude, usu_foto FROM usuario WHERE usu_cargo = 3 AND usu_latitude < 200");
                        echo '<script>';
                        echo '  var latitude = '.$latLoja.';';
                        echo '  var longitude = '.$lngLoja.';';
                        echo '  function initMap() {';
                        echo '      var map = new google.maps.Map(document.getElementById(\'map\'), {';
                        echo '          zoom: 15,';
                        echo '          center: {lat: latitude, lng: longitude}';
                        echo '      });';
                        while ($tecnicos = mysqli_fetch_assoc($getTecnicos)) {
                            echo '   var tecnico_' . $tecnicos['usu_id'] . ' = {lat: ' . $tecnicos['usu_latitude'] . ', lng: ' . $tecnicos['usu_longitude'] . '};';
                            echo '   var marcador_t = new google.maps.Marker( { position: tecnico_' . $tecnicos['usu_id'] . ', map: map, title: "'.$tecnicos['usu_nome'].'", icon: "http://sistema.developintech.com/upload/mini/m_'.$tecnicos['usu_foto'].'", url: \'usuario.php?view='.$tecnicos['usu_id'].'\'} );';
                            echo '   google.maps.event.addListener(marcador_t, \'click\', function() {';
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
            </div>
        </div>
    </div>
    <div class="sufee-alert alert with-close alert-warning alert-dismissible fade show ml-auto mr-auto mt-2">
        <span class="badge badge-pill badge-warning">Aviso</span>&nbsp;Os marcadores exibidos representam a ultima posição atualizada no sistema, e podem deferir da localização atual do usuário!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
<?php } ?>

<?php if ($map == 3){ 
    logMsg( $_SESSION['usu_login']." entrou em a mapa.php (Clientes)" );?>
    <div class="default-tab">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link" href="mapa.php?map=1" aria-selected="false">Chamados</a>
                <a class="nav-item nav-link" href="mapa.php?map=2" aria-selected="false">Técnicos</a>
                <a class="nav-item nav-link active show" aria-selected="true">Clientes</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade active show" id="nav-chamados" role="tabpanel" aria-labelledby="nav-chamados-tab">
                <div id="map1" class="map"></div>
                    <?php 
                        #consulta no banco e inicia as variaveis e o mapa
                        $getClientes = mysqli_query($conexao,"SELECT cli_id, cli_nome, end_latitude, end_longitude FROM cliente, endereco WHERE cli_endereco = end_id AND end_latitude;");
                        echo '<script>';
                        echo '  var latitude = -23.184;';
                        echo '  var longitude = -50.650;';
                        echo '  function initMap() {';

                        #mapa 1
                            echo '      var map1 = new google.maps.Map(document.getElementById(\'map1\'), {';
                            echo '          zoom: 15,';
                            echo '          center: {lat: latitude, lng: longitude}';
                            echo '      });';
                            while ($cli = mysqli_fetch_assoc($getClientes)) {
                                echo '   var cliente_' . $cli['cli_id'] . ' = {lat: ' . $cli['end_latitude'] . ', lng: ' . $cli['end_longitude'] . '};';
                                echo '   var marker1 = new google.maps.Marker( { position: cliente_' . $cli['cli_id'] . ', map: map1, url: \'cliente.php?view='.$cli['cli_id'].'\', icon: \'http://maps.gstatic.com/mapfiles/ridefinder-images/mm_20_red.png\', title: "'.$cli['cli_nome'].'" } );';
                                echo '   google.maps.event.addListener(marker1, \'click\', function() {';
                                echo '        window.location.href = this.url;';
                                echo '   });';
                            }
                        echo '  }'; #initMap
                        
                        echo '</script>';
                    ?>
            </div>
        </div>
    </div>
<?php } ?>

    <!--
            #mapa 2
            echo '      var map2 = new google.maps.Map(document.getElementById(\'map2\'), {';
            echo '          zoom: 15,';
            echo '          center: {lat: latitude, lng: longitude}';
            echo '      });';
            while ($tecnicos = mysqli_fetch_assoc($getTecnicos)) {
                echo '   var tecnico_' . $tecnicos['usu_id'] . ' = {lat: ' . $tecnicos['usu_latitude'] . ', lng: ' . $tecnicos['usu_longitude'] . '};';
                echo '   var marker2 = new google.maps.Marker( { position: tecnico_' . $tecnicos['usu_id'] . ', map: map2, url: \'usuario.php?view='.$tecnicos['usu_id'].'\' } );';
                echo '   google.maps.event.addListener(marker1, \'click\', function() {';
                echo '        window.location.href = this.url;';
                echo '   });';
            }
    -->

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2jlT6C_to6X1mMvR9yRWeRvpIgTXgddM&callback=initMap"></script>

    <!-- 
    label: \'' . $coordenadas['cham_id'] . '\', 
    minha key:  AIzaSyB-L4mY_LPWGd-t9veyr168VAm7-BakpPY -->
    <!-- view coordenadas_ct_ativos: CREATE VIEW coordenadas_ct_ativos AS (SELECT ch.cham_id, ch.cham_status, es.est_nome, en.end_latitude, en.end_longitude
            FROM chamado_tecnico AS ch, endereco AS en, cliente AS cl, estatus AS es
            WHERE ch.cham_cliente = cl.cli_id AND cl.cli_endereco = en.end_id AND ch.cham_status = es.est_id 
            AND ch.cham_status NOT LIKE 5 AND ch.cham_status NOT LIKE 6) 

    SELECT count(c1.cham_status), count(c2.cham_status), count(c3.cham_status) 
FROM chamado_tecnico as c1, chamado_tecnico as c2, chamado_tecnico as c3 
WHERE c1.cham_status = 1 AND c2.cham_status = 2 AND c3.cham_status = 3 


(SELECT es1.est_id, count(c1.cham_status) as em_espera FROM chamado_tecnico as c1 NATURAL JOIN estatus as es1 WHERE c1.cham_status = 1 AND es1.est_id = 1) UNION
(SELECT es2.est_id, count(c2.cham_status) as em_espera FROM chamado_tecnico as c2 NATURAL JOIN estatus as es2 WHERE c2.cham_status = 2 AND es2.est_id = 2) UNION
(SELECT es3.est_id, count(c3.cham_status) as em_espera FROM chamado_tecnico as c3 NATURAL JOIN estatus as es3 WHERE c3.cham_status = 3 AND es3.est_id = 3) UNION
(SELECT es4.est_id, count(c4.cham_status) as em_espera FROM chamado_tecnico as c4 NATURAL JOIN estatus as es4 WHERE c4.cham_status = 4 AND es4.est_id = 4) UNION
(SELECT es5.est_id, count(c5.cham_status) as em_espera FROM chamado_tecnico as c5 NATURAL JOIN estatus as es5 WHERE c5.cham_status = 5 AND es5.est_id = 5) UNION
(SELECT es6.est_id, count(c6.cham_status) as em_espera FROM chamado_tecnico as c6 NATURAL JOIN estatus as es6 WHERE c6.cham_status = 6 AND es6.est_id = 6)


            -->

<?php require_once('after_content.php'); ?>