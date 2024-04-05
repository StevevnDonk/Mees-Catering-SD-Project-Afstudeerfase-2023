<?php
// Inclusie van het connection.php-bestand om verbinding te maken met de database
require '../connection.php';

// Controleer of het een POST-verzoek is
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ontvang de invoergegevens van het formulier
    $id = $_POST['id'];
    $name = $_POST['name'];
    $beschrijving = $_POST['beschrijving'];
    $prijs = $_POST['prijs'];
    $visibility = $_POST['visibility']; // Zichtbaarheid toevoegen

    // Verwerking van de nieuwe afbeelding (indien geüpload)
    if ($_FILES['new_image']['error'] === 0) {
        // Ontvang de gegevens van de geüploade afbeelding
        $fileName = $_FILES['new_image']['name'];
        $tmpName = $_FILES['new_image']['tmp_name'];

        // Genereer een unieke bestandsnaam voor de nieuwe afbeelding
        $newImageName = uniqid() . '_' . $fileName;

        // Verplaats het tijdelijke bestand naar de gewenste map op de server
        if (move_uploaded_file($tmpName, '../img/' . $newImageName)) {
            // Voorbereid SQL-statement om SQL-injectie te voorkomen
            $query = "UPDATE tb_upload SET name=?, beschrijving=?, prijs=?, image=?, visible=? WHERE id=?";
            $stmt = mysqli_prepare($conn, $query);

            // Controleer of het statement correct is voorbereid
            if ($stmt) {
                // Bind de parameters aan de voorbereide statement
                mysqli_stmt_bind_param($stmt, "ssdsii", $name, $beschrijving, $prijs, $newImageName, $visibility, $id);

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
            echo "Er is een fout opgetreden bij het uploaden van de nieuwe afbeelding.";
        }
    } else {
        // Geen nieuwe afbeelding geüpload, behoud de bestaande afbeeldingsnaam in de database
        $newImageName = $_POST['image']; // Haal de bestaande afbeeldingsnaam op uit het formulier

        // Voorbereid SQL-statement om SQL-injectie te voorkomen
        $query = "UPDATE tb_upload SET name=?, beschrijving=?, prijs=?, visible=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $query);

        // Controleer of het statement correct is voorbereid
        if ($stmt) {
            // Bind de parameters aan de voorbereide statement
            mysqli_stmt_bind_param($stmt, "ssdii", $name, $beschrijving, $prijs, $visibility, $id);

            // Voer de voorbereide statement uit
            if (mysqli_stmt_execute($stmt)) {
                echo "Item succesvol bijgewerkt (geen nieuwe afbeelding geüpload).";
            } else {
                echo "Er is een fout opgetreden bij het bijwerken van het item in de database.";
            }

            // Sluit de voorbereide statement
            mysqli_stmt_close($stmt);
        } else {
            echo "Er is een fout opgetreden bij het voorbereiden van de SQL-instructie.";
        }
    }
} else {
    // Geef een melding weer voor een ongeldige aanvraag
    echo "Ongeldige aanvraag.";
}

// Voeg een link toe naar de adminpanel
echo '<a href="admin_panel.php">Admin Panel</a>';
?>
