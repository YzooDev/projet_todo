<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style/pico.min.css">
    <title><?= $title ?? "" ?></title>
</head>

<body>
    <?php include 'component/navbar.php'; ?>
    <main class="container-fluid">
        <h2>Ajouter une categorie</h2>
        <form action="" method="post">
            <input type="text" name="name" placeholder="Saisir le nom">
            <input type="submit" name="submit" value="Ajouter">
        </form>
        <p><?= $data["msg"] ?? "" ?></p>
    </main>
</body>

</html>