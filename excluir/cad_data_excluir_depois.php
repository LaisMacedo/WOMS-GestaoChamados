<?php require_once('before_content.php'); ?>

		<link href="assets/css/bootstrap-datepicker.min.css" rel="stylesheet"/>
		<script src="assets/js/bootstrap-datepicker.min.js"></script> 
		<script src="assets/js/bootstrap-datepicker.pt-BR.min.js" charset="UTF-8"></script>

		<div class="container">
			<h1>Cadastar Data</h1>
			<form class="form-horizontal">
				 <div class="form-group">
					<label class="col-sm-2 control-label">Data</label>
					<div class="col-sm-10">
						<div class="input-group date">
							<input type="text" class="form-control" id="exemplo" >
							<div class="input-group-addon">
								<span class="glyphicon glyphicon-th"></span>
							</div>
						</div>

					</div>
				  </div>
				  
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-success">Cadastrar</button>
					</div>
				</div>
			</form>
		</div>
		
		<script type="text/javascript">
			$('#exemplo').datepicker({	
				format: "dd/mm/yyyy",	
				language: "pt-BR",
				startDate: '+0d',
				maxViewMode: 1,
			    todayBtn: "linked",
			    daysOfWeekHighlighted: "0",
			    todayHighlight: true
			});
		</script>

<?php require_once('after_content.php'); ?>

