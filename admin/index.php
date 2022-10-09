<?php
$servername = "uzurdrive.ddns.net:3307";
$username = "gur";
$password = "1234";
$dbname = "quiz";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM info";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"] . " - Name: " . $row["pregunta"] . " " . $row["correct"] . "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
