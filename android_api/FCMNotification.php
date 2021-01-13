<?php
#API access key from Google API's Console
    define( 'API_ACCESS_KEY', 'AAAAXZTE6sE:APA91bF4bf1hNDYOy_4hXt001iALde71Ilbr_6ZbZKcZbA8h9jlUpEUDNX4ISoPwAj0x7nddZi8Z3qYiCz8G0f-OAC75Qc84E7k-3m0Ebg8b1m7NfUvhIBaNntyd8urL-fK_D7LZeHOu' );
    $registrationIds = 'ex0aezuyqGg:APA91bFBa44IEjLmaMuQWmipDjzqPtff-yLwmqe-yWokozeyvG6RYdFxysLTpv3k7jgcEXt3RGbauIkqJO7EfuiGS29_ZMGEJekPGPF5Aa9a7j6fsM1e4PQUmL6pdwZX8W1dhJ1daMLw';
#prep the bundle
     $msg = array
          (
		'body' 	=> 'Um novo chamado foi designado em sua agenda',
		'title'	=> 'Novo Chamado Técinco',
             	'icon'	=> 'myicon',/*Default Icon*/
              	'sound' => 'mySound'/*Default sound*/
          );
	$fields = array
			(
				'to'			=> $registrationIds,
				'notification'	=> $msg
			);
	
	
	$headers = array
			(
				'Authorization: key=' . API_ACCESS_KEY,
				'Content-Type: application/json'
			);
#Send Reponse To FireBase Server	
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
		curl_close( $ch );
#Echo Result Of FireBase Server
echo $result;
?>