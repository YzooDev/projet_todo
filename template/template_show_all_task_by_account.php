<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style/pico.min.css">
    <link rel="stylesheet" href="../assets/style/main.css">
    <title><?= $title ?? "" ?></title>
</head>

<body>
    <?php include 'component/navbar.php'; ?>
    <main class="container-fluid">
        <h2>Liste des taches</h2>
        <section>
        <?php foreach ($data["tasks"] as $task): ?>
            <article>
                <h3><?= $task->getTitle() ?></h3>
                <p><?= $task->getDescription() ?></p>
                <?php if($task->getFinishOn()->format('d/m/Y') !=  $task->getCreatedAt()->format('d/m/Y')): ?>
                <h4><?= $task->getFinishOn()->format('d/m/Y') ?></h4>
                <?php endif ?>
                <div class="categories">
                    <?php foreach ($task->getCategories() as $category): ?>
                    <button class="pill-button"><?= $category->getName() ?></button>
                    <?php endforeach ?>
                </div>
                <a href="/task/update?id=<?= (string)$task->getId() ?>"><button>valider</button></a>
            </article>
        <?php endforeach ?>
        </section>
        
    </main>
</body>

</html>