<?php
// Vereis het connection.php-bestand om verbinding te maken met de database
require '../connection.php';
// Vereis het login_success.php-bestand om ervoor te zorgen dat de gebruiker is ingelogd
require_once 'login_success.php';

// Haal de gegevens op uit de database, gesorteerd op categorie
$rows = mysqli_query($conn, "SELECT * FROM tb_upload ORDER BY categorie, id DESC");

// Variabele om de vorige categorie bij te houden
$previousCategory = null;
?>

<!DOCTYPE html>
<html lang="en" class="admin-panel-style">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel Mees</title>
    <link rel="stylesheet" href="admin-style.css">
    <!-- Voeg JavaScript toe om een bevestigingsvenster te tonen -->
    <script>
        function confirmDelete() {
            return confirm("Weet je zeker dat je dit item wilt verwijderen?");
        }
    </script>
</head>
<body>
    <div class="header">
        <h1>Dashboard</h1>
        <a href="logout.php">Uitloggen</a>
    </div>
    <div class="container">

        <?php foreach($rows as $row) : ?>
            <?php
            $currentCategory = $row["categorie"];

            // Controleer of de huidige categorie verschilt van de vorige categorie
            if ($currentCategory !== $previousCategory) {
                // Sluit de vorige flex-container en tabel (behalve bij de eerste iteratie)
                if ($previousCategory !== null) {
                    echo '</tbody>'; // Sluit de vorige tbody
                    echo '</table>'; // Sluit de vorige tabel
                    echo '</div>'; // Sluit de vorige flex-container
                }

                // Open een nieuwe flex-container voor de huidige categorie
                echo '<div class="categorie">';
                echo "<h3>$currentCategory</h3>";
                echo '</div>';
                echo '<div class="flex-container">';
                echo '<table>'; // Open een nieuwe tabel
                echo '<thead>';
                echo '<tr>';
                echo '<th>ID</th>';
                echo '<th>Naam</th>';
                echo '<th>Beschrijving</th>';
                echo '<th>Prijs</th>';
                echo '<th>Zichtbaar</th>';
                echo '<th>Edit/Delete</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                $previousCategory = $currentCategory;
            }
            ?>

            <!-- Weergeef de gegevens van elk item in de tabel -->
            <tr>
                <td><?php echo $row["id"]; ?></td>
                <td><?php echo $row["name"]; ?></td>
                <td class="beschrijving"><?php echo $row["beschrijving"]; ?></td>
                <td><?php echo $row["prijs"]; ?></td>
                <td><?php echo $row["visible"] == 0 ? 'Zichtbaar' : 'Niet zichtbaar'; ?></td>
                <td>
                    <!-- Link naar het bewerken en verwijderen van het item -->
                    <a class="edit-link" href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                    <a class="delete-link" href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirmDelete();">Delete</a>
                </td>
            </tr>

        <?php endforeach; ?>

        </tbody>
        </table> <!-- Sluit de laatste tabel -->
    </div>
    <!-- Voeg een link toe om een nieuw gerecht toe te voegen -->
    <div class="add-link">
        <a href="add.php">Nieuw gerecht toevoegen</a>
    </div>
    <!-- Link om terug te gaan naar de menukaart -->
    <div class="menu-link">
        <a href="../index.php">Terug naar menukaart</a>
    </div>
</div>
</body>
</html>
