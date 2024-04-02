<?php
// Vereis het login_success.php-bestand om ervoor te zorgen dat de gebruiker is ingelogd
require_once 'login_success.php';
// Vereis de connection.php om verbinding te maken met de database
require '../connection.php';

// Controleer of er een ID is doorgegeven via de URL
if (isset($_GET['id'])) {
    // Haal de ID op uit de URL en zorg ervoor dat het een integer is
    $id = intval($_GET['id']);

    // Maak een voorbereide statement om SQL-injectie te voorkomen
    $query = "DELETE FROM tb_upload WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);

    // Bind de ID aan de voorbereide statement
    mysqli_stmt_bind_param($stmt, 'i', $id);

    // Voer de voorbereide statement uit
    $result = mysqli_stmt_execute($stmt);

    // Controleer of het verwijderen succesvol is uitgevoerd
    if ($result) {
        // Toon een succesbericht als het item succesvol is verwijderd
        echo "Gerecht succesvol verwijderd.";
        // Voeg een link toe naar het admin paneel om terug te keren
        echo '<a href="admin_panel.php">Admin Panel</a>';

    } else {
        // Toon een foutmelding als er een fout is opgetreden bij het verwijderen van het item
        echo "Er is een fout opgetreden bij het verwijderen van het item.";
    }
} else {
    // Toon een melding als er geen ID is opgegeven om te verwijderen
    echo "Geen ID opgegeven om te verwijderen.";
}
?>
