<!DOCTYPE html>

<html lang="en">

<head>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/style.css">
    <title>
        User
    </title>
</head>


<body class="bg-light">

    <?php include BASE_PATH . "/app/views/templates/header.php"; ?>


    <div class="page-body">
        <h1 class="center text-center"><?php echo $data["username"];?>'s sets:</h1>
        <form method="GET" class="search-form">
            <input oninput="this.form.submit()"
                autofocus
                type="text"
                name="search"
                placeholder="Search set by name or id"
                class="form-input"
                onfocus="this.setSelectionRange(this.value.length, this.value.length)"
                value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
        </form>
        <div class="grid-box center">
            <?php
            $searchTermSet = $_GET['search'] ?? '';
            $filteredSets = array_filter($data["sets"], function ($set) use ($searchTermSet) {
                return !$searchTermSet ||
                    stripos($set->name, $searchTermSet) !== false;
            });

            $perPage = 11;
            $total = count($filteredSets);
            $totalPages = ceil($total / $perPage);
            $currentPage = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
            $currentPage = max(1, min($totalPages, $currentPage));
            $offset = ($currentPage - 1) * $perPage;

            $paginatedSets = array_slice($filteredSets, $offset, $perPage);
            ?>
            <div class="card bg-warning">
                    <a href="<?php echo BASE_URL; ?>/setCreator/index" class="simple-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor"
                            viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                            <path
                                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                        </svg>
                    </a>
            </div>
            <?php  foreach ($paginatedSets as $set): ?>
                <div class="card bg-warning">
                    <a href="<?php echo BASE_URL; ?>/setCreator/viewer/<?php echo $set->id; ?>" class="simple-link">

                        <h1 class="center">
                            <?php echo htmlspecialchars($set->name); ?>
                        </h1>

                        <p>
                            Views: <?php echo $set->views; ?>
                        </p>
                    </a>

                </div>
            <?php endforeach; ?>

        </div>
        <?php if($totalPages > 1):?>
        <div class="pagination center text-center">
            <a href="?set-search=<?php echo urlencode($searchTermSet); ?>&page=<?php echo $currentPage - 1; ?>"
                class="btn-pagination <?php if ($currentPage == 1): ?> disable <?php endif; ?>">
                Previous
            </a>


            <span class="sign-pagination">Page: <?php echo $currentPage; ?></span>

            <a href="?set-search=<?php echo urlencode($searchTermSet); ?>&page=<?php echo $currentPage + 1; ?>"
                class="btn-pagination <?php if ($currentPage >= $totalPages): ?> disable <?php endif; ?>">
                Next
            </a>


        </div>
        <?php endif;?>

    </div>

</body>