<?php require_once('before_content.php'); ?>
<?php $clientes = mysqli_query($conexao, "select * from cliente "); ?>
<div class="row">
   <div class="col-md-12">
      <div class="card">
         <div class="card-header">
            <strong class="card-title">Clientes</strong>
         </div>
         <div class="card-body">
            <table id="bootstrap-data-table" class="table table-striped table-bordered">
               <thead>
                  <tr>
                     <th>Nome</th>
                     <th>Telefone</th>
                     <th>Celular</th>
                     <th>Ações</th>
                  </tr>
               </thead>
               <tbody>
                  <?php while($cliente = mysqli_fetch_assoc($clientes)) {
                     echo '<tr>';
                     echo '<td>' . $cliente['cli_nome'] . '</td>';
                     echo '<td>' . $cliente['cli_telefone'] . '</td>';
                     echo '<td>' . $cliente['cli_celular'] . '</td>';
                     echo '<td><a href="/acoes/cliente_editar.php?id=' . $cliente['cli_id'] . '"><i class="fa fa-pencil" style="margin: 0 5px;"></i></a>';
                     echo '<a href="/acoes/cliente_excluir.php?id=' . $cliente['cli_id'] . '"> <i class="fa fa-trash-o" style="margin: 0 5px;"></i></a></td>';
                     echo '</tr>';
                     } ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
   <!-- tabela --> <!-- TABELA -->
</div>
<?php require_once('after_content.php'); ?>