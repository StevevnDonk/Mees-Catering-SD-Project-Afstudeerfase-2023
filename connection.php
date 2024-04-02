<?php
// Databasegegevens
$host = "localhost";
$username = "c49046Mees";
$password = "";
$database = "c49046Mees";

// Create a new connection
$conn = new mysqli($servername, $username, $password, $database);

// Controleer de verbinding
if ($conn->connect_error) {
    die("Fout bij het maken van een verbinding: " . $conn->connect_error);
}
?>