<?php
// Vereis het connection.php-bestand om verbinding te maken met de database
require '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ontvang de invoergegevens van het formulier en ontsmet ze
    $id = $_POST['id'];
    $name = $_POST['name'];
    $beschrijving = $_POST['beschrijving'];
    $prijs = $_POST['prijs'];
    $visibility = $_POST['visibility']; // Voeg zichtbaarheid toe

    // Voorbereid SQL-statement om SQL-injectie te voorkomen
    $query = "UPDATE tb_upload SET name=?, beschrijving=?, prijs=?, visible=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);

    // Controleer of het statement correct is voorbereid
    if ($stmt) {
        // Bind de parameters aan de voorbereide statement
        mysqli_stmt_bind_param($stmt, "ssdsi", $name, $beschrijving, $prijs, $visibility, $id);

        // Voer de voorbereide statement uit
        if (mysqli_stmt_execute($stmt)) {
            echo "Item succesvol bijgewerkt.";
        } else {
            echo "Er is een fout opgetreden bij het bijwerken van het item in de database.";
        }

        // Sluit de voorbereide statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Er is een fout opgetreden bij het voorbereiden van de SQL-instructie.";
    }
} else {
    echo "Ongeldige aanvraag.";
}

// Voeg de link naar de adminpanel toe
echo '<a href="admin_panel.php">Admin Panel</a>';
?>
