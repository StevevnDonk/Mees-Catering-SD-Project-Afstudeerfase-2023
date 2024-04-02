<?php
// Start de sessie
session_start();

// Database gegevens
$host = "srv042105.webreus.net";
$username = "c49048Mees";
$password = "@OIxinwwNnBV7";
$database = "c49048Mees";

// Bericht voor meldingen
$message = "";

try {
    // Maak verbinding met de database
    $connect = new PDO("mysql:host=$host; dbname=$database", $username, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Controleer of het login formulier is ingediend
    if (isset($_POST["login"])) {
        // Controleer of zowel gebruikersnaam als wachtwoord zijn ingevuld
        if (empty($_POST["username"]) || empty($_POST["password"])) {
            $message = '<label>All fields are required</label>';
        } else {
            // Voorbereid de SQL query om gebruiker op te halen
            $query = "SELECT * FROM users WHERE username = :username AND password = :password";
            $statement = $connect->prepare($query);
            // Hash het wachtwoord voordat het wordt vergeleken met de database
            $hashedwachtwoord = hash('sha512', $_POST["password"]);
            $statement->execute(
                array(
                    'username'     =>     $_POST["username"],
                    'password'     =>     $hashedwachtwoord
                )
            );

            // Tel het aantal resultaten van de query
            $count = $statement->rowCount();
            // Haal resultaten op als objecten
            $results = $statement->fetchAll(PDO::FETCH_OBJ);
            // Itereer door de resultaten
            foreach ($results as $result) {
                // Dit is optioneel: je kunt de gehashte wachtwoord hier uitprinten om te controleren
                // echo $result->password;
            }

            // Als er een gebruiker is gevonden met de ingediende gegevens, log de gebruiker in
            if ($count > 0) {
                $_SESSION["username"] = $_POST["username"];
                // Stuur de gebruiker door naar het admin panel
                header("location: admin_panel.php");
            } else {
                // Als er geen overeenkomende gebruiker is gevonden, toon een foutmelding
                $message = '<label>Wrong Data</label>';
            }
        }
    }

} catch (PDOException $error) {
    // Vang eventuele database fouten op
    $message = $error->getMessage();
}

?>

<!DOCTYPE html>
<html class="login-page">
<head>
     <title>Login</title>
     <link rel="stylesheet" href="../css/style.css">
     <style>
          body {
               display: flex;
               justify-content: center;
               align-items: center;
               height: 100vh;
               margin: 0;
          }

          .header{
            font-size: 25px;
            color: #EE9955;
            font-family: 'Kaushan Script', cursive;
            text-align: center;
            padding-top: 20px;
        }

          .container {
               width: 100%;
               max-width: 500px;
               padding: 20px;
               -webkit-box-shadow: 0px 0px 17px 0px rgba(0,0,0,0.24);
               -moz-box-shadow: 0px 0px 17px 0px rgba(0,0,0,0.24);
               box-shadow: 0px 0px 17px 0px rgba(0,0,0,0.24);
               border-radius: 8px;
          }

          .login-container {
               text-align: center;
          }

          .login-container h3 {
               margin-bottom: 20px;
          }

          .login-container input[type="text"],
          .login-container input[type="password"] {
               /* width: 100%; */
               padding: 10px;
               /* margin: 5px 0; */
               border: 1px solid #EE9955;
               border-radius: 5px;
               margin-bottom: 5px;
          }

          .login-container .btn {
               margin-top: 20px;
               padding: 10px 20px;
               background-color: #EE9955;
               border-radius: 8px;
               border: 0px;
               color: #fff;
          }
     </style>
</head>
<body>
     <br />
     <div class="container">
          <?php
          // Toon eventuele foutmeldingen
          if (isset($message)) {
               echo '<label class="text-danger">' . $message . '</label>';
          }
          ?>
          <div class="header">
               <h1>Login page</h1>
          </div>
          <div class="login-container">
               <form method="post">
                    <!-- Invoervelden voor gebruikersnaam en wachtwoord -->
                    <input type="text" name="username" placeholder="Username" />
                    <br />
                    <input type="password" name="password" placeholder="Password" />
                    <br />
                    <!-- Knop om in te loggen -->
                    <input type="submit" name="login" class="btn" value="Login" />
               </form>
          </div>
     </div>
     <br />


     <script>
          // Timer voor automatische doorverwijzing
          var start = 2000; // Startwaarde in seconden

          // Toon het initiële bericht
          document.getElementById("demo").innerHTML = "Redirect after " + start + " seconds";

          // Update de timer elke seconde
          var x = setInterval(function() {
               start--; // Verminder de resterende tijd met 1 seconde
               document.getElementById("demo").innerHTML = "Redirect after " + start + " seconds";

               // Als de tijd op is, doorverwijzen naar de index pagina
               if (start <= 0) {
                    window.location.href = '../index.php';
               }
          }, 1000);

          // JavaScript-functie voor terugknop
          function goBack() {
               window.location.href = "../index.php";
          }
     </script>
</body>
</html>
