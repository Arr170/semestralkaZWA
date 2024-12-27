<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="<?php echo BASE_URL;?>/public/styles/style.css">
    <script src="<?php echo BASE_URL;?>/public/scripts/admin.js" type="module" defer></script>
    <title>Test</title>
</head>

<body class="bg-light">

    <?php include BASE_PATH . "/app/views/templates/header.php"; ?>

    <div class="page-body profile-container">
        <!-- Search form -->


        <!-- Display sets -->
        <div class="table-container" id="set-list">
            <form method="GET" action="" class="search-bar">
                <input type="text" name="set-search" placeholder="Search sets by name or id" class=""
                    value="<?php echo htmlspecialchars($_GET['set-search'] ?? ''); ?>">
                <button type="submit" class="btn">Search</button>
            </form>
            <table>
                <thead>
                    <tr>
                        <h2 class="center">
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
                    $searchTerm = $_GET['set-search'] ?? '';

                    foreach ($data["sets"] as $set) {
                        // Check if the name contains the search term
                        if (!$searchTerm || stripos($set->name, $searchTerm) !== false || stripos($set->id, $searchTerm) !== false) {
                            echo '
                        <tr>
                            <td>
                                <a href="'.BASE_URL.'/setCreator/viewer/' . htmlspecialchars($set->id) . '">
                                ' . htmlspecialchars($set->name) . '
                                </a>
                            </td>
                            <td>
                                ' . htmlspecialchars($set->id) . '
                            </td>
                            <td>
                                <button class="btn" onclick="deleteSet(\''.$set->id.'\')" >delete</button>
                            </td>
                        </tr>
                        ';
                        }
                    }
                    ?>
                </tbody>
            </table>



        </div>
        <div class="table-container" id="users-list">
            <form method="GET" action="" class="search-bar">
                <input type="text" name="user-search" placeholder="Search user by name or id" class=""
                    value="<?php echo htmlspecialchars($_GET['user-search'] ?? ''); ?>">
                <button type="submit" class="btn">Search</button>
            </form>
            <table>
                <thead>
                    <h2 class="center">
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
                    $searchTerm = $_GET['user-search'] ?? '';

                    foreach ($data["users"] as $user) {
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
                                <button class="btn" onclick="deleteUser(\''.$user->id.'\')">delete</button>
                            </td>
                        </tr>
                        ';
                        }
                    }
                    ?>
                </tbody>
            </table>



        </div>
    </div>

</body>

</html>