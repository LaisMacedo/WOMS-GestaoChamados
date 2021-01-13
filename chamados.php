<?php require_once('before_content.php'); ?>

<link rel="stylesheet" type="text/css" href="assets/DataTables/datatables.min.css"/>
<script type="text/javascript" src="assets/DataTables/datatables.min.js"></script>

<style type="text/css">
  .chamados-list td {
    padding: 5px;
    height: 40px;
  }
  .list-inline{
    margin: 0;
  }
  .table a{
    color:#000000;
  }
  .table a:hover{
    color:#007bff;
  }
  .table img{
    transition: 0.3s;
  }
  .table img:hover{
    border-radius: 50%;
    border: 1px #007bff solid;
    transition: 0.3s;
  }
  .icon{
    font-size: 14px !important;
  }
  .dropdown-item{
    cursor: pointer;
  }
  .dropdown-item:hover{
    color: #007bff !important;
  }
  .modal-body p{
    color:#000;
    padding-left: 15px;
  }
  #tabela-chamados{
    overflow: scroll;
  }
  @media (max-width: 575.99px){
    body {
      display: inline-grid;
    }
  }

  @media print {
    .table {
        background-color: white;
        height: 100%;
        width: 100%;
        position: fixed;
        top: 0;
        left: 0;
        margin: 0;
        padding: 15px;
        font-size: 14px;
        line-height: 18px;
    }
    .coluna-menu{
        display: none;   
    }
}
</style>

<?php 
  #ordenado por nome do status ascendente por definição
  $selectfrom = 'SELECT * FROM chamados_web_simples ';  
  $where = '';  
  $orderby = 'ORDER BY cham_status ASC, cham_id ASC';  
  $or = '';

  $order_id = "asc";  
  $order_serv = "asc";
  $order_tec = "asc";   
  $order_prog = "asc";   
  $order_stat = "desc";
  $st1 = "checked"; $st2 = "checked"; $st3 = "checked";
  $st4 = "checked"; $st5 = "checked"; $st6 = "checked";
  $addurl = "&st1=1&st2=1&st3=1&st4=1&st5=1&st6=1";

  if($_SERVER['REQUEST_METHOD'] == "GET") { //requisição via get (ordena conforme os parametros)  
    if(isset($_GET['st1']) || isset($_GET['st2']) || isset($_GET['st3']) || isset($_GET['st4']) || isset($_GET['st5']) || isset($_GET['st6'])){
        logMsg( $_SESSION['usu_login']." aplicou filtro em chamados.php" ); 
        $st1 = ""; $st2 = ""; $st3 = "";
        $st4 = ""; $st5 = ""; $st6 = "";
        $addurl = "";
        $where = " WHERE cham_status ";

        if(isset($_GET['id'])){ //filtra por id do tecnico
          $where = " WHERE usu_id = ".$_GET['id']." AND cham_status ";
        }

        if(isset($_GET['st1'])){
          $where = $where . "= 1";
          $or = " OR cham_status ";
          $st1 = "checked";
          $addurl = "&st1=1";
        }
        if(isset($_GET['st2'])){
          $where = $where . $or . " = 2 ";
          $or = " OR cham_status ";
          $st2 = "checked";
          $addurl = $addurl."&st2=1";
        }
        if(isset($_GET['st3'])){
          $where = $where . $or . " = 3 ";
          $or = " OR cham_status ";
          $st3 = "checked";
          $addurl = $addurl."&st3=1";
        }
        if(isset($_GET['st4'])){
          $where = $where . $or . " = 4 ";
          $or = " OR cham_status ";
          $st4 = "checked";
          $addurl = $addurl."&st4=1";
        }
        if(isset($_GET['st5'])){
          $where = $where . $or . " = 5 ";
          $or = " OR cham_status ";
          $st5 = "checked";
          $addurl = $addurl."&st5=1";
        }
        if(isset($_GET['st6'])){
          $where = $where . $or . " = 6 ";
          $st6 = "checked";
          $addurl = $addurl."&st6=1";
        }
    }
    if(isset($_GET['id'])){  
        if($_GET['id'] == 'desc'){
            $orderby = ' ORDER BY cham_id DESC;'; 
            $order_id = "asc";
        } else {
            $orderby = ' ORDER BY cham_id ASC;'; 
            $order_id = "desc";
        }
    }
    if(isset($_GET['serv'])){    
        if($_GET['serv'] == 'desc'){
            $orderby = ' ORDER BY serv_nome DESC, cham_id ASC;'; 
            $order_serv = "asc";
        } else {
            $orderby = ' ORDER BY serv_nome ASC, cham_id ASC;';
            $order_serv = "desc";
        }
    }
    if(isset($_GET['tec'])){    
        if($_GET['tec'] == 'desc'){
            $orderby = ' ORDER BY usu_nome DESC, cham_id ASC;'; 
            $order_tec = "asc";
        } else {
            $orderby = ' ORDER BY usu_nome ASC, cham_id ASC;';
            $order_tec = "desc";
        }
    }
    if(isset($_GET['prog'])){    
        if($_GET['prog'] == 'desc'){
            $orderby = ' ORDER BY cham_status DESC, cham_id ASC;';
            $order_prog = "asc";
        } else {
            $orderby = ' ORDER BY cham_status ASC, cham_id ASC;';
            $order_prog = "desc";
        }
    }
    if(isset($_GET['stat'])){    
        if($_GET['stat'] == 'desc'){
            $orderby = ' ORDER BY est_nome DESC, cham_id ASC;';
            $order_stat = "asc";
        } else {
            $orderby = ' ORDER BY est_nome ASC, cham_id ASC;';
            $order_stat = "desc";
        }
    }
  }
  #executa a query conforme o critério
  $cham_sql = $selectfrom . $where . $orderby;
  $chamados = mysqli_query($conexao, $cham_sql);
  #echo '<br> SLQ command: '.$cham_sql; #for debug
?>

<div class="row">
  <div class="col-md-12">
      <div class="chamados-list">
        <?php
          echo '<div class="col-md-5 col-sm-12 mb-3"><h2>Chamados</h2></div>';
          echo '<div class="dropdown col-md-7 col-sm-12 mb-3">';
          #imprimir
          echo '    <button class="float-right btn btn-outline-secondary ml-1 mr-1 mt-1" type="button" id="printButton" onclick="printPage()"><i class="fa fa-print"></i></button>';
          #filtrar
          echo '    <button class="float-right btn btn-outline-secondary dropdown-toggle theme-toggle ml-1 mr-1 mt-1" type="button" id="dropdownFilterButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
          echo '        <i class="fa fa-filter"></i> Filtrar Status';
          echo '    </button>';
                    $sql_prox_id = 'SELECT max(cham_id)+1 AS prox_id FROM chamado_tecnico';
                    $proximo_id = mysqli_fetch_assoc(mysqli_query($conexao, $sql_prox_id));
                    $prox_id  = $proximo_id['prox_id'];
          #novo
          echo '    <a href="chamado.php?new='.$prox_id.'"><button class="float-right btn btn-outline-secondary ml-1 mr-1 mt-1" type="button"><i class="fa fa-plus-square"></i> Novo</button></a>';
          echo '    <div class="dropdown-menu mt-4" aria-labelledby="dropdownFilterButton" aria-haspopup="true">';
          echo '        <div class="dropdown-menu-content pl-4">';
          echo '          <form action="chamados.php" method="get">';
          echo '           <div class="checkbox"><label for="checkbox1" class="form-check-label ">';
          echo '                 <input type="checkbox" id="checkbox1" name="st1" value="1" class="form-check-input" '.$st1.'>Designar técnico';
          echo '              </label></div>';
          echo '           <div class="checkbox"><label for="checkbox2" class="form-check-label ">';
          echo '                 <input type="checkbox" id="checkbox2" name="st2" value="1" class="form-check-input" '.$st2.'>Em espera';
          echo '              </label></div>';
          echo '           <div class="checkbox"><label for="checkbox3" class="form-check-label ">';
          echo '                 <input type="checkbox" id="checkbox3" name="st3" value="1" class="form-check-input" '.$st3.'>Em deslocamento';
          echo '              </label></div>';
          echo '           <div class="checkbox"><label for="checkbox4" class="form-check-label ">';
          echo '                 <input type="checkbox" id="checkbox4" name="st4" value="1" class="form-check-input" '.$st4.'>Em execução';
          echo '              </label></div>';
          echo '           <div class="checkbox"><label for="checkbox5" class="form-check-label ">';
          echo '                 <input type="checkbox" id="checkbox5" name="st5" value="1" class="form-check-input" '.$st5.'>Finalizado';
          echo '              </label></div>';
          echo '           <div class="checkbox"><label for="checkbox6" class="form-check-label ">';
          echo '                 <input type="checkbox" id="checkbox6" name="st6" value="1" class="form-check-input" '.$st6.'>Cancelado';
          echo '              </label></div>';
          echo '           <input class="btn btn-primary btn-sm float-right mr-2 mt-2" type="submit" value="Filtrar">';
          echo '          </form>';
          echo '        </div>';
          echo '    </div>';
          echo '</div>';
        ?>
        <table class="table table-striped border" id="tabela-chamados">
          <thead>
            <tr>
            <?php
              echo '<th class="pl-1 pr-1 text-center" style="width: 60px"><a href="chamados.php?id='.$order_id.$addurl.'"># <i class="fa fa-sort-numeric-'.$order_id.' icon"></i></a></th>';
              echo '<th style="width: 20%"><a href="chamados.php?serv='.$order_serv.$addurl.'">Serviço <i class="fa fa-sort-alpha-'.$order_serv.' icon"></i></a></th>';
              echo '<th><a href="chamados.php?tec='.$order_tec.$addurl.'">Técnico <i class="fa fa-sort-alpha-'.$order_tec.' icon"></i></a></th>';
              echo '<th><a href="chamados.php?prog='.$order_prog.$addurl.'">Progresso <i class="fa fa-sort-amount-'.$order_prog.' icon"></i></a></th>';
              echo '<th class="coluna-menu pl-3"><a href="chamados.php?stat='.$order_stat.$addurl.'">Status <i class="fa fa-sort-alpha-'.$order_stat.' icon"></i></a></th>';

              if($_SESSION['usu_cargo'] == 1) {
                echo '<th style="width: 15%">Ações</th>';
              }
            ?>
            </tr>
          </thead>
          <tbody>
			<?php while($cham = mysqli_fetch_assoc($chamados)) {


            if($cham['cham_status'] == 1){	$progress = 20;		$fundo_status = "badge-warning"; } 	// designar tecnico  20%		laranja
            if($cham['cham_status'] == 2){	$progress = 40;		$fundo_status = "badge-secondary"; }// em espera 			   40%		cinzento
            if($cham['cham_status'] == 3){ 	$progress = 60;		$fundo_status = "badge-info"; } 	  // em deslocamento 	 60%		azul-claro
            if($cham['cham_status'] == 4){	$progress = 80;		$fundo_status = "badge-primary"; } 	// em execução 			 80%		azul-escuro
            if($cham['cham_status'] == 5){ 	$progress = 100;	$fundo_status = "badge-success"; } 	// finalizado 			100%	  verde
            if($cham['cham_status'] == 6){  $progress = 0;    $fundo_status = "badge-danger"; }   // cancelado          0%    vermelho

            echo '<tr calss="mp-2">';
            echo '<td class="text-center"><a href="chamado.php?view='.$cham['cham_id'].'">' . $cham['cham_id'] . '</a></td>';
            echo '  <td>';
            echo '    <a href="chamado.php?view='.$cham['cham_id'].'">' . $cham['serv_nome'] . '</a>';
            echo '    <br>';
            echo '    <a href="chamado.php?view='.$cham['cham_id'].'"><small>' . $cham['cham_agendado'] . '</small></a>';
            echo '  </td>';
            echo '  <td>';
            echo '    <a href="usuario.php?view='.$cham['usu_id'].'"><ul class="list-inline align-middle">';
            echo '      <li>';
            echo '        <img src="upload/' . $cham['usu_foto'] . '" class="avatar" alt="Avatar" style="height: 45px; width: 45px;"> ' . $cham['usu_nome'];
            echo '      </li>';
            echo '    </ul></a>';
            echo ' </td>';
            echo '  <td class="project_progress align-middle">';
            if ($progress == 0){
              echo '    <div class="progress" style="border: 1px solid #dc3545; margin-top: 4px ; height: 18px">'; 
            } else {
              echo '    <div class="progress" style="border: 1px solid #17a2b8; margin-top: 4px ; height: 18px">';
            }
            echo '        <div class="progress-bar bg-info" role="progressbar" style="width: ' . $progress . '%;" aria-valuenow="' . $progress . '" aria-valuemin="0" aria-valuemax="100"></div>';
            echo '    </div>';
            echo '  </td>';
            echo '  <td class="align-middle">';
            echo '    <div class="ml-3 badge ' . $fundo_status . ' md">' . $cham['est_nome'] . '</div>';
            echo '  </td>';
            if($_SESSION['usu_cargo'] == 1) {
              echo '  <td class="coluna-menu align-middle">';
              echo '    <div class="dropdown">';
              echo '        <button class="btn bg-secondary dropdown-toggle theme-toggle text-light" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">';
              echo '            Opções';
              echo '        </button>';
              echo '        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" style="position: absolute; transform: translate3d(-102px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">';
              echo '            <div class="dropdown-menu-content">';
              echo '                <a class="dropdown-item" href="chamado.php?view='.$cham['cham_id'].'"><i class="fa fa-folder"></i> Ver </a>'; 
                                  if($cham['cham_status']!=5){
              echo '                <a class="dropdown-item" href="chamado.php?edit='.$cham['cham_id'].'"><i class="fa fa-pencil"></i> Editar </a>'; //modal passando informação do id
              echo '                <a class="dropdown-item" data-toggle="modal" data-target="#delete-modal'.$cham['cham_id'].'"><i class="fa fa-trash-o"></i> Excluir </a>'; 
                                    //modal confirmação           
                                  }
              echo '            </div>';
              echo '        </div>';
              echo '    </div>';
              echo '  </td>';
            }
            echo '</tr>';
            ?>

            <!-- MODAL CONFIRMAR EXCLUSÃO -->
            <?php echo '<div onload="myFunction()" class="modal fade" id="delete-modal'.$cham['cham_id'].'" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" style="display: none;" aria-hidden="true">'; ?>
              <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="smallModalLabel">Confirmar exclusão</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                  </div>
                  <div class="modal-body">
                    <?php 
                          echo '<p>Tem certeza que deseja excluir: <strong>' . $cham['serv_nome'] . '</strong></p>';
                          echo '<div class="col-7 pt-1 align-right"><h6> Chamado Técnico # ' . $cham['cham_id'] . '</h6></div>';
                          echo '<div class="col-5"><div class="ml-3 badge ' . $fundo_status . ' md">' . $cham['est_nome'] . '</div></div>';
                    ?>
                  </div>
                  <div class="modal-footer">   
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>
                    <?php echo '<a id="bt_confirma" href="controler/edit-chamado.php?delete='. $cham['cham_id'] .'"><button class="btn btn-success">Sim</button></a>'; ?>
                  </div>
                </div>
              </div>
            </div>

          <? } /* end of while */ ?>

          </tbody>
        </table>
      </div>
  </div>
</div>

<!--  
 CREATE OR REPLACE VIEW chamados_web_simples AS (
      SELECT c.cham_id, DATE_FORMAT(c.cham_agendado, '%d/%m/%Y - %H:%i') AS cham_agendado, c.cham_status, s.serv_nome, u.usu_id, u.usu_nome, u.usu_foto, e.est_nome
      FROM chamado_tecnico AS c, servico AS s, usuario AS u, estatus AS e 
      WHERE c.cham_servico = s.serv_id AND c.cham_tecnico = u.usu_id AND c.cham_status = e.est_id ORDER BY c.cham_status);
-->

<?php require_once('after_content.php'); ?>