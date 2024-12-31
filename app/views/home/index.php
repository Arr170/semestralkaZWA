<!DOCTYPE html>

<html>

<head>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/style.css">
    <title>
        test
    </title>
</head>


<body class="bg-light">
    <?php include BASE_PATH . "/app/views/templates/header.php"; ?>


    <div class="page-body">
        <h1 class="center">Popular sets:</h1>
        <div class="grid-box center">
            <?php foreach ($data as $set): ?>
                <div class="card bg-warning">
                    <a href="./setCreator/viewer/<?php echo $set->id; ?>">
                        <h2 class="card-content">
                            <?php echo htmlspecialchars($set->name); ?>
                        </h2>
                    </a>
                    <p>
                        Views: <?php echo $set->views; ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>

</html>