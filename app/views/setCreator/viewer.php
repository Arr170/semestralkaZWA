<!DOCTYPE html>

<html>

<head>
    <link rel="stylesheet" href="/../public/styles/style.css">
    <!-- <script src="/../public/scripts/createCard.js" type="module" defer></script> -->
    <script src="/../public/scripts/viewCard.js" type="module" defer></script>

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
                <img id="card-img" class="set-viewer-img" alt="card image" src="/../public/static/answer.png">
            </div>
            <article id="card-text" class="set-preview-text">

            </article>
        </div>
        <div class="set-viewer-controller ">
            <button id="prev-btn" class="set-btn-big">prev</button>
            <button id="show-btn" class="set-btn-big">show</button>
            <button id="next-btn" class="set-btn-big">next</button>
        </div>
    </div>

</body>

</html>