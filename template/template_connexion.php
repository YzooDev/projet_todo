<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style/pico.min.css">
    <title><?= $title ?></title>
</head>
<body>
    <?php include 'component/navbar.php'; ?>
    <main class="container-fluid">
        <h2>Se connecter</h2>
        <form action="" method="post">
            <input type="email" name="email" placeholder="email">
            <input type="password" name="password" placeholder="mot de passe">
            <input type="submit" value="Connexion" name="submit">
        </form>
        <p><?= $data["msg"] ?? "" ?></p>
    </main>
</body>
</html>