<?php 

require_once("vendor/autoload.php");

$app = new \Slim\Slim();

$app->config('debug', true);

$app->get('/', function() {
    
	$sql = new Hcode\DB\Sql(); //invoca a classe Sql pertencente ao namespace DB, o que é reconhecido com o uso da contra barra ('\')

	var_dump($sql);

	$results = $sql->select("SELECT * FROM tb_users");

	echo json_encode($results);

});

$app->run();

 ?>