<?php
require_once('dao/conexao.php');
$filename = "backup-" . date("d-m-Y") . ".sql";
$mime = "application/x-gzip";
header( "Content-Type: " . $mime );
header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
$cmd = "mysqldump -u $usuariobanco --password=$senhabanco $bancosrv | sql --best";   
passthru( $cmd );
exit(0);
?>