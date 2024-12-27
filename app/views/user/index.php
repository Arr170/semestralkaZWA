<!DOCTYPE html>

<html>

<head>
    <link rel="stylesheet" href="<?php echo BASE_URL;?>/public/styles/style.css">
    <title>
        test
    </title>
</head>


<body class="bg-light">

    <?php include BASE_PATH . "/app/views/templates/header.php"; ?>


    <div class="page-body profile-container">
        <div class=""><!--my cards holder-->
            <h1 class="center">My sets:</h1>
            <div class="grid-box center">
                <div class="card bg-warning">
                    <div class="card-content">
                        <a href="<?php echo BASE_URL;?>/setCreator/index">
                            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                <path
                                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                            </svg>
                        </a>

                    </div>

                </div>
                <?php
                foreach ($data["sets"] as $set) {
                    echo '
                    <div class="card bg-warning">
                        <a href="'.BASE_URL.'/setCreator/viewer/' . htmlspecialchars($set->id) . '">
                            <div class="card-content">
                            ' . htmlspecialchars($set->name) . '
                            </div>
                        </a>
                    </div>
                ';
                }
                ?>

            </div>
        </div>
        <div class="center profile-stats"><!--profile info-->
            <h1 id="profile-name">
                <?php
                echo $data["username"];
                ?>
            </h1>
            <p>Sets:
                <span id="sets-count">
                <?php
                    echo sizeof($data["sets"]);
                ?>
                </span>
            </p>`
            <p>likes: <span id="likes-count">y</span></p>
        </div>

    </div>

</body>