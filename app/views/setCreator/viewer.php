<!DOCTYPE html>

<html>

<head>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/style.css">
    <script src="<?php echo BASE_URL; ?>/public/scripts/viewSet.js" type="module" defer></script>

    <title>
        Viewing set
    </title>
</head>

<body>
    <?php include BASE_PATH . "/app/views/templates/header.php"; ?>

    <div class="image-big">

    </div>
    <div id="card-container" class="page-body">
        <div class="set-card-viewer">
            <div class="viewer-left-col">
                <img id="card-img" class="set-viewer-img" alt="card image" src="<?php echo BASE_URL; ?>/public/static/answer.png">
            </div>
            <textarea id="card-text" class="set-preview-text center" disabled>

            </textarea>
        </div>
        <div class="set-viewer-controller no-print">
            <button id="prev-btn" class="set-btn-big">previous</button>
            <button id="show-btn" class="set-btn-big">show</button>
            <button id="next-btn" class="set-btn-big">next</button>
        </div>
        <?php if ($data["owner"]): ?>
            <div class="center text-center">
                <a href="<?php echo BASE_URL; ?>/setCreator/index/<?php echo $data["setId"]; ?>">
                    <button class="set-btn-big" >Edit</button>

                </a>
            </div>
        <?php endif ?>
    </div>

</body>

</html>