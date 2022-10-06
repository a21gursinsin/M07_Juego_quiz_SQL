<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

$data = file_get_contents('./Quiz.json');
$info = json_decode($data);
session_start();
$listPreguntas = $_SESSION['listPreguntas'];
$jugada = json_decode($_POST["dades"]);
$count = intval(0);

for ($i = 0; $i < $jugada->nrespuestas; $i++) {
    if ($jugada->respuestas[$i] == $info[$listPreguntas[$i]]->correctIndex) {
        $count++;
    }
}

echo json_encode($count);
