<!DOCTYPE html>

<html>

<?php echo BASE_URL; ?>

<head>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/style.css">
    <script src="<?php echo BASE_URL; ?>/public/scripts/createCard.js" type="module" defer></script>
    <title>
        Creating set
    </title>
</head>

<body>
    <?php include BASE_PATH . "/app/views/templates/header.php"; ?>

    <div class="set-builder-container">
        <div id="set-container" class="set-container center">
            <div class="set-name-input-div center">
                <div >
                    <label for="set-name" id="set-name-label" class="set-name-label">Cards set name:</label>
                    <input name="set-name" id="set-name" class="set-name-input center">
                </div>
                <div >
                    <label for="set-private" class="set-name-label">Make private:</label>
                    <input type="checkbox" id="set-private" class="set-name-input">
                </div>

            </div>
            <div id="flipper" class="set-flipper center">
                <button class="set-btn" id="flip-front" disabled>Front side</button>
                <button class="set-btn" id="flip-back">Back side</button>
            </div>
            <div id="active-card" class="set-card">
                <textarea id="set-card-text" class="set-textarea"></textarea>
                <input id="set-card-img" type="file" class="set-img-input" accept="image/png, image/jpeg">
            </div>
            <span class="center" id="counter">
                0/0
            </span>
            <div id="controler" class="set-controller center">
                <button class="set-btn" id="go-back">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="20" fill="currentColor"
                        class="bi bi-arrow-left" viewBox="0 0 15 15">
                        <path fill-rule="evenodd"
                            d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
                    </svg>
                </button>
                <button class="set-btn" id="add-new">Add</button>
                <button class="set-btn" id="go-forward">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="20" fill="currentColor"
                        viewBox="0 0 15 15">
                        <path fill-rule="evenodd"
                            d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                    </svg>
                </button>
            </div>
            <div class="center">
                <button id="submit-btn" class="set-btn">Submit</button>
                <button id="delete-card-btn" class="set-btn">Delete card</button>
            </div>
        </div>
        <div class="set-container center" id="set-preview-container">
            <h2 class="center">Card preview</h2>
            <div class="set-card-preview">
                <div class="preview-left-col">
                    <h4 class="center">Question</h4>
                    <img id="img-preview-front" class="set-preview-img" alt="card img" src="<?php echo BASE_URL; ?>/public/static/question.png" />

                </div>
                <article id="set-preview-question" class="set-preview-text">
                </article>

            </div>
            <div class="set-card-preview">
                <div class="preview-left-col">
                    <h4 class="center">Answer</h4>
                    <img id="img-preview-back" class="set-preview-img" alt="card img" src="<?php echo BASE_URL; ?>/public/static/answer.png" />

                </div>
                <article id="set-preview-answer" class="set-preview-text">
                </article>

            </div>
        </div>

    </div>


</body>

</html>