<?php
session_start();
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

$Npreguntas = intval($_GET["np"]);
// $Npreguntas = 4;
$servername = "uzurdrive.ddns.net:3307";
$username = "gur";
$password = "1234";
$dbname = "quiz";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} else {
  $totId = $conn->query("SELECT id FROM info");
  $arrTotPreguntas = array();
  while ($row = $totId->fetch_assoc()) {
    array_push($arrTotPreguntas, $row["id"]);
  }
  function alterarPreguntas($arrTotPreguntas, $Npreguntas)
  {
    $listPreguntas = array();
    for ($i = 0; $i < $Npreguntas; $i++) {
      $n = array_rand($arrTotPreguntas, 1);
      if (in_array($n, $listPreguntas) && $n == 0) {
        $i--;
      } else {
        array_push($listPreguntas, $n);
      }
    }
    return $listPreguntas;
  }
  $listPreguntas = alterarPreguntas($arrTotPreguntas, $Npreguntas);

  $_SESSION['listPreguntas'] = $listPreguntas;

  $resultat = '{"questions": [';
  for ($j = 0; $j < $Npreguntas; $j++) {
    $result = $conn->query("SELECT id,pregunta,rp1,rp2,rp3,rp4 FROM info where id = $listPreguntas[$j]");
    while ($row = $result->fetch_assoc()) {
      $resultat .= '{"question":' . json_encode($row["pregunta"]) . ',';
      $resultat .= '"answers":[' . json_encode($row["rp1"]) . "," . json_encode($row["rp2"]) . "," . json_encode($row["rp3"]) . "," . json_encode($row["rp4"]) . ']}';
    }
    if ($j != $Npreguntas - 1) {
      $resultat .= ", ";
    }
  }
  $resultat .= ']}';
  echo $resultat;
}
