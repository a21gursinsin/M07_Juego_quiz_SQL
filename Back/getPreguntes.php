<?php
session_start();
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

// $Npreguntas = intval($_GET["np"]);
$Npreguntas=4;
$servername = "uzurdrive.ddns.net:3307";
$username = "gur";
$password = "1234";
$dbname = "quiz";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} else {
  function alterarPreguntas($Npreguntas)
  {
    $listPreguntas = array();
    for ($i = 0; $i < $Npreguntas; $i++) {
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

  $result = $conn->query("SELECT id,pregunta,rp1,rp2,rp3,rp4 FROM info");
  
  $i = 0;
  $resultat = '{"questions": [';
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc() ) {
      if (in_array($row["id"], $listPreguntas)) {
        $resultat .= '{"question":' . json_encode($row["pregunta"]) . ',';
        $resultat .= '"answers":[' . json_encode($row["rp1"])."," . json_encode($row["rp2"]) .",". json_encode($row["rp3"])."," . json_encode($row["rp4"]) . ']} ';
        
        if ($i != $Npreguntas-1 ) {
          $resultat .= ", ";
        }
        $i++;
      }
    }
    $resultat .= ']}';
  }else{
    die("Sense dades");
  }
  echo $resultat;
}
