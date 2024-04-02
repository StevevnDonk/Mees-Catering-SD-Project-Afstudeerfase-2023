<?php
// Vereis het login_success.php-bestand om ervoor te zorgen dat de gebruiker is ingelogd
require_once 'login_success.php';
// Vereis de connection.php om verbinding te maken met de database
require '../connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin-style.css">
    <title>Edit</title>
</head>
<body>
    <!-- Header sectie -->
    <div class="header">
        <h1>Edit panel</h1>
    </div>

    <?php
    // Controleer of er een ID is doorgegeven via de URL
    if (isset($_GET['id'])) {
        // Verkrijg de ID vanuit de URL
        $id = $_GET['id'];

        // Maak een voorbereide statement om SQL-injectie te voorkomen
        $query = "SELECT * FROM tb_upload WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        // Bind de ID aan de voorbereide statement
        mysqli_stmt_bind_param($stmt, 'i', $id);
        // Voer de voorbereide statement uit
        mysqli_stmt_execute($stmt);
        // Krijg het resultaat van de voorbereide statement
        $result = mysqli_stmt_get_result($stmt);

        // Controleer of er resultaten zijn gevonden
        if (mysqli_num_rows($result) == 1) {
            // Haal de gegevens op van het geselecteerde item
            $row = mysqli_fetch_assoc($result);

            // Toon het bewerkingsformulier
            echo '<form method="POST" action="update.php" enctype="multipart/form-data">';
            echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
            echo 'Naam: <input type="text" name="name" value="' . $row['name'] . '"><br>';
            echo 'Beschrijving: <textarea name="beschrijving">' . $row['beschrijving'] . '</textarea><br>';
            echo 'Afbeelding: <input type="file" name="new_image"><br>';
            echo 'Prijs: <input type="text" name="prijs" id="prijs" value="' . $row['prijs'] . '"><br>';
            
            // Voeg het dropdown-menu voor zichtbaarheid toe
            echo 'Zichtbaarheid: <select name="visibility">';
            echo '<option value="1" ' . ($row['visible'] == 1 ? 'selected' : '') . '>Zichtbaar</option>';
            echo '<option value="0" ' . ($row['visible'] == 0 ? 'selected' : '') . '>Niet zichtbaar</option>';
            echo '</select><br>';

            echo '<button type="submit" value="Opslaan">Opslaan</button>';
            echo '</form>';
        } else {
            echo "Item niet gevonden.";
        }
    } else {
        echo "Geen ID opgegeven om te bewerken.";
    }
    ?>

    <!-- JavaScript voor het valideren van de prijs -->
    <script>
        document.querySelector("form").addEventListener("submit", function(event) {
            // Haal de prijsinvoer op en vervang eventuele komma's door punten
            var prijsInput = document.getElementById("prijs");
            var prijs = parseFloat(prijsInput.value.replace(",", "."));

            // Valideer of de prijs een geldig getal is en niet meer dan 100 euro
            if (isNaN(prijs) || prijs > 100) {
                // Voorkom het verzenden van het formulier als de prijs ongeldig is
                event.preventDefault();
                // Toon een waarschuwingsbericht
                alert("De prijs moet een geldig getal zijn en mag niet meer dan 100 euro zijn.");
            }
        });
    </script>
</body>
</html>
