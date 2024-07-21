<?php
session_start();

// Vérifier si la requête est de type POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  // Info ID
  $servername = "localhost";
  $dbusername = "root";
  $dbpassword = "tony1234";
  $dbname = "employer_db";

  // Créer une connexion à la base de données
  $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

  // Vérifier la connexion
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Préparer la requête SQL
  $sql = "SELECT * FROM users WHERE username = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $username);

  // Exécuter la requête
  $stmt->execute();
  $result = $stmt->get_result();

  // Vérifier si l'utilisateur existe
  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Vérifier le mot de passe
    if (password_verify($password, $user["password"])) {
      // Vérifier si l'utilisateur a dépassé le nombre de tentatives autorisées
      if ($user["login_attempts"] >= 3) {
        $error = "Compte bloqué";
      } else {
        // Stocker les informations de l'utilisateur dans la session
        $_SESSION["username"] = $user["username"];
        $_SESSION["role"] = $user["role"];

        // Réinitialiser le compteur de tentatives
        $sql = "UPDATE users SET login_attempts = 0 WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();

        // Rediriger vers le tableau de bord
        header("Location: dashboard.php");
        exit();
      }

    } else {
      // Incrémenter le compteur de tentatives
      $sql = "UPDATE users SET login_attempts = login_attempts + 1 WHERE username = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $username);
      $stmt->execute();

      $error = "Mot de passe incorrect";
    }

  } else {
    $error = "Utilisateur inconnu";
  }


  // Fermer la connexion à la base de données
  $conn->close();
}

?>

<!DOCTYPE html>
<html>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #171717;
            color: #fff;
        }

        h1 {
            text-align: center;
            margin-top: 50px;
        }

        form {
            width: 300px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        p {
            color: red;
            margin-top: 10px;
            text-align: center;
        }

        .btn-compte {
            margin-top: 10px;
            border: none;
            background-color: transparent;
            text-decoration: none;
            cursor: text;
        }

        .btn-compte:hover {
            text-decoration: underline;
        }

    </style>
<head>
  <title>Connexion</title>
</head>
<body>
  <h1>Connexion</h1>
  <?php if (isset($error)): ?>
    <p><?php echo $error; ?></p>
  <?php endif; ?>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="username">Nom d'utilisateur:</label>
    <input type="text" name="username" id="username" required>
    <br>
    <label for="password">Mot de passe:</label>
    <input type="password" name="password" id="password" required>
    <br>
    <input type="submit" value="Connexion">
  </form>
    <form action="mailto:arcadia.employer@exemple.com" method="post" enctype="text/plain">
        <input class="btn-compte" type="submit" value="Demandez un compte à l'aide de votre adresse email">
    </form>
</body>
</html>

