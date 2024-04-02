<?php
// Vereis de connection.php om verbinding te maken met de database
require '../connection.php';
// Vereis het login_success.php-bestand om ervoor te zorgen dat de gebruiker is ingelogd
require_once 'login_success.php';

// Controleer of het formulier is verzonden
if(isset($_POST["submit"])){
    // Haal gegevens op uit het formulier en maak ze schoon voor gebruik in de query
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $beschrijving = mysqli_real_escape_string($conn, $_POST["beschrijving"]);
    $categorie = mysqli_real_escape_string($conn, $_POST["categorie"]);
    $prijs = $_POST["prijs"];

    // Valideer of $prijs een geldig kommagetal is (optioneel)
    if (!is_numeric($prijs) || $prijs <= 0) {
        echo "<script> alert('Invalid price'); </script>";
    } else {
        // Controleer of er een afbeelding is geüpload
        if($_FILES["image"]["error"] === 4){
            echo "<script> alert('Image does not exist'); </script>";
        }
        else{
            // Haal informatie op over de geüploade afbeelding
            $fileName = $_FILES["image"]["name"];
            $fileSize = $_FILES["image"]["size"];
            $tmpName = $_FILES["image"]["tmp_name"];

            // Valideer het bestandsextensie en de grootte van de afbeelding
            $validImageExtensions = ['jpg', 'jpeg', 'png'];
            $imageExtension = explode('.', $fileName);
            $imageExtension = strtolower(end($imageExtension));
            if(!in_array($imageExtension, $validImageExtensions)){
                echo "<script> alert('Invalid image extension'); </script>";
            }
            else if($fileSize > 1000000000000){
                echo "<script> alert('Image size too large'); </script>";
            }
            else{
                // Genereer een unieke bestandsnaam en verplaats de afbeelding naar de juiste map
                $newImageName = uniqid() . '.' . $imageExtension;
                move_uploaded_file($tmpName, '../img/' . $newImageName);
                
                // Opmaak van de prijs als een kommagetal
                $formattedPrice = sprintf("%.2f", $prijs);
                
                // Maak een voorbereide statement om SQL-injectie te voorkomen
                $query = "INSERT INTO tb_upload (name, beschrijving, categorie, image, prijs) VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $query);
                
                // Bind parameters aan de voorbereide statement
                mysqli_stmt_bind_param($stmt, 'sssss', $name, $beschrijving, $categorie, $newImageName, $formattedPrice);
                
                // Voer de voorbereide statement uit en toon een bericht aan de gebruiker
                if(mysqli_stmt_execute($stmt)){
                    echo "<script> alert('Successfully Added'); </script>";
                }
                else{
                    echo "<script> alert('Error in SQL query'); </script>";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add</title>
    <link rel="stylesheet" href="../css/admin-style.css">
</head>

<body>
<div class="header">
        <h1>Product toevoegen</h1>
    </div>
    <!-- Formulier om een nieuw product toe te voegen -->
    <form class="" action="" method="post" autocomplete="off" enctype="multipart/form-data">
        <!-- Invoervelden voor naam, beschrijving, categorie, afbeelding en prijs -->
        <input type="text" name="name" id="name" required placeholder="Name"><br>
        <input type="text" name="beschrijving" id="beschrijving" required placeholder="Beschrijving"><br>
        <select name="categorie" id="categorie">
            <option value="Broodjes">Broodjes</option>
            <option value="Soepen">Soepen</option>
            <option value="Snacks">Snacks</option>
            <option value="Dranken">Dranken</option>
        </select><br>
        <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png" placeholder="Image"><br>
        <input type="text" name="prijs" id="prijs" placeholder="Prijs"><br>
        <br>
        <!-- Knoppen om het formulier te verzenden en links naar andere pagina's -->
        <div class="add-link">
        <button type="submit" name="submit">Submit</button>
        </div>
        <div class="add-link">
            <a href="admin_panel.php">Dashboard</a>
        </div>
    <div class="menu-link">
        <a href="../index.php">Terug naar menukaart</a>
    </div>
    </form>
    <br>
</body>
</html>
