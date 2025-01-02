<!DOCTYPE html>

<html lang="en">

<head>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/style.css">
    <script src="<?php echo BASE_URL; ?>/public/scripts/viewSet.js" type="module"></script>

    <title>
        Viewing set
    </title>
</head>

<body>
    <?php include BASE_PATH . "/app/views/templates/header.php"; ?>

    <div id="card-container" class="page-body">
        <h1 class="text-center" id="card-sign"></h1>
        <div class="set-card-viewer">
            <div class="viewer-left-col" id="left-col">
                <img id="card-img" class="set-viewer-img" alt="card image" src="<?php echo BASE_URL; ?>/public/static/answer.png">
            </div>
            <textarea id="card-text" class="set-preview-text center" disabled>

            </textarea>
        </div>
        <div class="set-viewer-controller no-print center">
            <button id="prev-btn" class="set-viewer-btn bg-lightgrey">Previous</button>
            <button id="show-btn" class="set-viewer-btn bg-lightgrey">Flip</button>
            <button id="next-btn" class="set-viewer-btn bg-lightgrey">Next</button>
            <?php if ($data["owner"]): ?>
                <a class="set-viewer-btn bg-lightgrey text-center" href="<?php echo BASE_URL; ?>/setCreator/index/<?php echo $data["setId"]; ?>">
                    Edit

                </a>
            <?php endif ?>
        </div>


    </div>

</body>

</html>