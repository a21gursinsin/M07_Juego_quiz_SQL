<?php
session_start();
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

$Npreguntas = intval($_GET["np"]);
$data = file_get_contents("./Quiz.json");
$quiz = json_decode($data);

function alterarPreguntas($Npreguntas)
{
  $listPreguntas = array();
  for ($i = 0; $i <= $Npreguntas; $i++) {
    $n = rand(0, 11);
    if (in_array($n, $listPreguntas)) {
      $i--;
    } else {
      array_push($listPreguntas, $n);
    }
  }
  return $listPreguntas;
}
$listPreguntas = alterarPreguntas($Npreguntas);
$_SESSION['listPreguntas'] = $listPreguntas;

$resultat = '{"questions": [';

for ($i = 0; $i < $Npreguntas; $i++) {
  $resultat .= '{"question":' . json_encode($quiz[$listPreguntas[$i]]->question) . ',';
  $resultat .= '"answers":' . json_encode($quiz[$listPreguntas[$i]]->answers) . '} ';
  if ($i != $Npreguntas - 1) {
    $resultat .= ", ";
  }
}
$resultat .= ']}';
echo $resultat;
