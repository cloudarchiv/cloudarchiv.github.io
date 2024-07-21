<?php
session_start();

// redirection de l'utilisateur si non connecté vers la page de connexion
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Contenue du dashboard
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Vétérinaire</title>
    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        h2 {
            color: #666;
            margin-bottom: 10px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 5px;
        }

        .container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-gap: 20px;
        }

        .card {
            background-color: #f5f5f5;
            padding: 20px;
            border-radius: 5px;
        }

    </style>
</head>
<body>
    <h1>Bienvenue sur le Dashboard d'Arcadia</h1>
    <p>Bonjour, <?php echo $_SESSION['username']; ?>!</p>
    <div class="container">
        <div class="card">
            <h2>Commandes à recevoir</h2>
            <ul>
                <li>Colis #12345 (nourriture pour Bruce) - Date : 2024-07-18</li>
            </ul>
        </div>
        <div class="card">
            <h2>Nourriture à donner ou à modifier</h2>
            <ul>
                <li>Bruce : 20kg à 18kg puisqu'il a grossi / changement fait à 8h12 après le checkup du 2024-07-15</li>
            </ul>
        </div>
        <div class="card">
            <h2>Evenements à préparer</h2>
            <ul>
                <li>Ouverture du nouvelle Enclot aux Serpents. (s'assurer de la santé des résidents et de leurs sécurités) - Date: 2024-08-25</li>
            </ul>
        </div>
        <div class="card">
            <h2>Activités récentes</h2>
            <ul>
                <li>Connecter à <?php echo date('Y-m-d H:i:s'); ?></li>
            </ul>
        </div>
        <div class="card">
            <h2>Notifications</h2>
            <ul>
                <li>Il faut modifier le poids de Kiara qui fait maintenant 12kg</li>
            </ul>
        </div>
    </div>
</body>
</html>