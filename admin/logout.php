<?php   
// Start de sessie om sessievariabelen te gebruiken
session_start();  

// Vernietig alle sessiegegevens (log de gebruiker uit)
session_destroy();  

// Stuur de gebruiker terug naar de inlogpagina na uitloggen
header("location: pdo_login.php");
?>
