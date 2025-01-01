<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/style.css">
    <script src="<?php echo BASE_URL; ?>/public/scripts/admin.js" type="module" defer></script>
    <title>Test</title>
</head>

<body class="bg-light">

    <?php include BASE_PATH . "/app/views/templates/header.php"; ?>

    <div class="page-body profile-container">
        <!-- Search form -->


        <!-- Display sets -->
        <div class="table-container" id="set-list">
            <form method="GET" action="" class="search-form">
                <input type="text" name="set-search" placeholder="Search set by name or id" class="form-input"
                    value="<?php echo htmlspecialchars($_GET['set-search'] ?? ''); ?>">
                <button type="submit" class="form-btn">Search</button>
            </form>
            <table>
                <thead>
                    <tr>
                        <h2 class="text-center">
                            All sets
                        </h2>

                    </tr>
                    <tr>
                        <th>Name</th>
                        <th>ID</th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Get search term from user input
                    $searchTermSet = $_GET['set-search'] ?? '';
                    $filteredSets = array_filter($data["sets"], function ($set) use ($searchTermSet) {
                        return !$searchTermSet ||
                            stripos($set->name, $searchTermSet) !== false ||
                            stripos($set->id, $searchTermSet);
                    });

                    $perPage = 12;
                    $total = count($filteredSets);
                    $totalPages = ceil($total / $perPage);
                    $currentPage = isset($_GET["page_set"]) ? (int)$_GET["page_set"] : 1;
                    $currentPage = max(1, min($totalPages, $currentPage));
                    $offset = ($currentPage - 1) * $perPage;

                    $paginatedSets = array_slice($filteredSets, $offset, $perPage);

                    foreach ($paginatedSets as $set) {
                        // Check if the name contains the search term
                        echo '
                        <tr>
                            <td>
                                <a href="' . BASE_URL . '/setCreator/viewer/' . htmlspecialchars($set->id) . '">
                                ' . htmlspecialchars($set->name) . '
                                </a>
                            </td>
                            <td>
                                ' . htmlspecialchars($set->id) . '
                            </td>
                            <td>
                                <button class="table-btn" onclick="deleteSet(\'' . $set->id . '\')" >delete</button>
                            </td>
                        </tr>
                        ';
                    }
                    ?>
                </tbody>
            </table>
            <div class="pagination center text-center">
                <a href="?set-search=<?php echo urlencode($searchTermSet); ?>&page_set=<?php echo $currentPage - 1; ?>"
                    class="btn-pagination <?php if ($currentPage == 1): ?> disable <?php endif; ?>">
                    Previous
                </a>


                <span class="sign-pagination">Page: <?php echo $currentPage; ?></span>

                <a href="?set-search=<?php echo urlencode($searchTermSet); ?>&page_set=<?php echo $currentPage + 1; ?>"
                    class="btn-pagination <?php if ($currentPage >= $totalPages): ?> disable <?php endif; ?>">
                    Next
                </a>


            </div>
        </div>
        <div class="table-container" id="users-list">
            <form method="GET" action="" class="search-form">
                <input type="text" name="user-search" placeholder="Search user by name or id" class="form-input"
                    value="<?php echo htmlspecialchars($_GET['user-search'] ?? ''); ?>">
                <button type="submit" class="form-btn">Search</button>
            </form>
            <table>
                <thead>
                    <h2 class="text-center">
                        All users
                    </h2>
                    <tr>
                        <th>Name</th>
                        <th>ID</th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Get search term from user input
                    $searchTermUser = $_GET['user-search'] ?? '';

                    $filteredUsers = array_filter($data["users"], function ($user) use ($searchTermUser) {
                        return !$searchTermUser ||
                            stripos($user->name, $searchTermUser) !== false ||
                            stripos($user->id, $searchTermUser);
                    });

                    $perPage = 12;
                    $total = count($filteredUsers);
                    $totalPagesUsers = ceil($total / $perPage);
                    $currentPageUsers = isset($_GET["page_user"]) ? (int)$_GET["page_user"] : 1;
                    $currentPageUsers = max(1, min($totalPagesUsers, $currentPageUsers));
                    $offset = ($currentPageUsers - 1) * $perPage;

                    $paginatedUsers = array_slice($filteredUsers, $offset, $perPage);


                    foreach ($paginatedUsers as $user) {
                        // Check if the name contains the search term
                        if (!$searchTerm || stripos($user->username, $searchTerm) !== false || stripos($user->id, $searchTerm) !== false) {
                            echo '
                        <tr>
                            <td>
                                ' . htmlspecialchars($user->username) . '
                            </td>
                            <td>
                                ' . htmlspecialchars($user->id) . '
                            </td>
                            <td>
                                <button class="table-btn" onclick="deleteUser(\'' . $user->id . '\')">delete</button>
                            </td>
                        </tr>
                        ';
                        }
                    }
                    ?>
                </tbody>
            </table>

            <div class="pagination center text-center">
                <a href="?set-search=<?php echo urlencode($searchTermSet); ?>&page_user=<?php echo $currentPageUsers - 1; ?>"
                    class="btn-pagination <?php if ($currentPageUsers == 1): ?> disable <?php endif; ?>">
                    Previous
                </a>


                <span class="sign-pagination">Page: <?php echo $currentPageUsers; ?></span>

                <a href="?set-search=<?php echo urlencode($searchTermSet); ?>&page_user=<?php echo $currentPageUsers + 1; ?>"
                    class="btn-pagination <?php if ($currentPageUsers >= $totalPagesUsers): ?> disable <?php endif; ?>">
                    Next
                </a>


            </div>

        </div>
    </div>

</body>

</html>