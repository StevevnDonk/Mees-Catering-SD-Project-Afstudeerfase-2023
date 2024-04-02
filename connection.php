<?php
// Databasegegevens
$servername = "srv042105.webreus.net";
$username = "c49048Mees";
$password = "@OIxinwwNnBV7";
$database = "c49048Mees";

// Create a new connection
$conn = new mysqli($servername, $username, $password, $database);

// Controleer de verbinding
if ($conn->connect_error) {
    die("Fout bij het maken van een verbinding: " . $conn->connect_error);
}
?>