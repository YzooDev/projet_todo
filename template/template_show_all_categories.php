<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style/pico.min.css">
    <title><?= $title ?? "" ?></title>
</head>

<body>
    <?php include 'component/navbar.php'; ?>
    <main class="container-fluid">
        <section>
            <h2>Liste des categories</h2>
            <?php foreach ($data as $category) : ?>
                <article>
                    <h3><?= $category->getName() ?></h3>
                </article>
            <?php endforeach ?>
        </section>
    </main>
</body>

</html>