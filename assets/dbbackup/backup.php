<?php

// Incluindo o autoload do Composer para carregar a biblioteca
require_once 'vendor/autoload.php';

// Incluindo a classe que criamos
require_once 'class/BackupDatabase.php';

// Como a geração do backup pode ser demorada, retiramos
// o limite de execução do script
set_time_limit(0);

// Utilizando a classe para gerar um backup na pasta 'backups'
// e manter os últimos dez arquivos
$backup = new BackupDatabase('backups', 10);
$backup->setDatabase('localhost', 'u894051160_sgct', 'u894051160_admin', 'yamakasi');
$backup->generate();

header('Refresh: 0; url=../../config.php?backup='.$fileName.' ');