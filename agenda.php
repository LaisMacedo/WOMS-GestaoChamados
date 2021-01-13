<?php require_once('before_content.php'); ?>

<link rel='stylesheet' href='assets/fullcalendar/fullcalendar.css' />
<script src='assets/fullcalendar/lib/jquery.min.js'></script>
<script src='assets/fullcalendar/lib/moment.min.js'></script>
<script src='assets/fullcalendar/fullcalendar.js'></script>
<script src="assets/fullcalendar/locale/pt-br.js"></script>

<style type="text/css">
   	.fc-body {
    	max-width: 900px;
   	}
   	.fc-content, .fc-event{
    	background-color: #007bff !important;
   	}
   	.calendario{
   		max-width: 1000px;
   	}
   	.fc-button-group, .fc-today-button{
   		margin-top: 10px !important;
   	}
</style>

<?php $agendamentos = mysqli_query($conexao, "select * from chamados_agenda;"); ?>

<div class="row">
   <div class="calendario ml-auto mr-auto">
      <div class="card">
         <div class="card-body">
			<div id="calendar"></div>
         </div>
      </div>
   </div>
   <!-- tabela --> <!-- TABELA -->
</div>
<?php ?>

<script> 
$('#calendar').fullCalendar({
   events: 'controller/feed-agenda.php',
   header: { 
         center: 'month,agendaWeek,agendaDay,'    
   },
   defaultView: 'agendaWeek',
   minTime: '8:00:00',
   maxTime: '20:00:00'
}); 
</script> 


<?php 
logMsg( $_SESSION['usu_login']." entrou em a agenda.php" );
require_once('after_content.php'); ?>