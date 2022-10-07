<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

session_start();
$listPreguntas = $_SESSION['listPreguntas'];
$jugada = json_decode($_POST["dades"]);
$count = intval(0);

$servername = "uzurdrive.ddns.net:3307";
$username = "gur";
$password = "1234";
$dbname = "quiz";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  } else {
      
  }

for ($i = 0; $i < $jugada->nrespuestas; $i++) {
    if ($jugada->respuestas[$i] == $info[$listPreguntas[$i]]->correctIndex) {
        $count++;
    }
}

echo json_encode($count);
