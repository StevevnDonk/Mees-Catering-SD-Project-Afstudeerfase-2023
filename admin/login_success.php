<?php  
// Start de sessie om sessievariabelen te gebruiken
session_start();  

// Controleer of de gebruiker is ingelogd (gecontroleerd aan de hand van een sessievariabele)
if(isset($_SESSION["username"])){   
    // Als de gebruiker is ingelogd, hoeft er niets te gebeuren
}  
else{  
    // Als de gebruiker niet is ingelogd, stuur ze terug naar de inlogpagina
    header("location: pdo_login.php");
}  
?>  
