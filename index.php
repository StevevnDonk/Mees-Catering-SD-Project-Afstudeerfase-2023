<?php
// Inclusief het bestand voor databaseverbinding
require 'connection.php';

// Haal de gegevens op uit de database, gesorteerd op categorie en ID
$rows = mysqli_query($conn, "SELECT * FROM tb_upload WHERE visible = 0 ORDER BY categorie, id DESC");

// Variabele om de vorige categorie bij te houden
$previousCategory = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data</title>
    <!-- Koppel een extern CSS-bestand(moet nog gemaakt worden) -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Navigatiemenu -->
    <div class="navigation">
        <nav>
            <ul>
                <!-- Logo met link naar admin panel (moet nog gemaakt worden)-->
                <li id="logo"><a href="admin/admin_panel.php"><img src="img/mees-logo.png" alt="Logo"></a></li>
            </ul>
        </nav>
    </div>

    <?php foreach($rows as $row) : ?>
        <?php
        // Haal de huidige categorie op uit de huidige rij
        $currentCategory = $row["categorie"];
        
        // Controleer of de huidige categorie verschilt van de vorige categorie
        if ($currentCategory !== $previousCategory) {
            // Sluit de vorige flex-container (behalve bij de eerste iteratie)
            if ($previousCategory !== null) {
                echo '</div>'; // Sluit de vorige flex-container
            }

            // Open een nieuwe flex-container voor de huidige categorie
            echo '<div class="categorie">';
            echo "<h3>$currentCategory</h3>"; // Toon de categorie als een titel
            echo '</div>'; // Sluit de categorie container
            echo '<div class="flex-container">'; // Open een nieuwe flex-container
            $previousCategory = $currentCategory; // Werk de vorige categorie bij
        }
        ?>
        <!-- Productinformatie -->
        <div class="flex-item">
            <!-- Afbeelding van het product -->
            <img src="img/<?php echo $row['image']; ?>" title="<?php echo $row['image']; ?>">
            <div class="product-info">
                <h3 class="naam"><?php echo $row["name"]; ?></h3> <!-- Naam van het product -->
                <p class="beschrijving"><?php echo $row["beschrijving"]; ?></p> <!-- Beschrijving van het product -->
                <h4 class="prijs"><?php echo $row["prijs"]; ?></h4> <!-- Prijs van het product -->
            </div>
        </div>
    <?php endforeach; ?>
    <br> <!-- Extra ruimte onderaan de pagina -->
</body>
</html>
