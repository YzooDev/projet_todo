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
        <form action="" method="post">
            <input type="text" name="firstname" placeholder="Prénom" aria-label="Prénom">
            <input type="text" name="lastname" placeholder="Nom" aria-label="Nom">
            <input type="email" name="email" placeholder="email">
            <input type="password" name="password" placeholder="mot de passe">
            <input type="password" name="confirm-password" placeholder="confirmer le mot de passe">
            <input type="submit" value="Inscription" name="submit">
        </form>
        <?php if(isset($data["msg"])) : ?>
        <p><?= $data["msg"] ?></p>
        <?php endif; ?>
    </main>
</body>
</html>