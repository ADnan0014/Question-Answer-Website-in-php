<div class="container">
    <div class="row">
        <div class="col-8">
            <h1 class="heading">Questions</h1>
            <?php
            include("./common/db.php");
            
            $query = "SELECT * FROM questions";
            $condition = "";

            // Check filters
            if (isset($_GET["c-id"]) && is_numeric($_GET["c-id"])) {
                $cid = intval($_GET["c-id"]);
                $condition = " WHERE category_id = $cid";

            } else if (isset($_GET["u-id"]) && is_numeric($_GET["u-id"])) {
                $uid = intval($_GET["u-id"]);
                $condition = " WHERE user_id = $uid";

            } else if (isset($_GET["search"])) {
                $search = htmlspecialchars($_GET["search"]);
                $condition = " WHERE title LIKE '%$search%'";

            } else if (isset($_GET["latest"])) {
                $condition = " ORDER BY id DESC";
            }

            // Final query
            if (strpos($condition, 'ORDER') !== false) {
                $query = "SELECT * FROM questions $condition";
            } else {
                $query .= $condition . " ORDER BY id DESC";
            }

            $result = $conn->query($query);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $title = htmlspecialchars($row['title']);
                    $id = intval($row['id']);
                    $author_id = intval($row['user_id']);

                    echo "<div class='row question-list'>
                            <h4 class='my-question'>
                                <a href='?q-id=$id'>$title</a>";

                    // Show delete link only if the logged-in user is the owner
                    if (isset($_SESSION['user']['user_id']) && $_SESSION['user']['user_id'] == $author_id) {
                        echo " | <a href='./server/requests.php?delete=$id' class='text-danger'>Delete</a>";
                    }

                    echo "</h4></div>";
                }
            } else {
                echo "<p class='text-muted'>No questions found.</p>";
            }
            ?>
        </div>

        <div class="col-4">
            <?php include('categorylist.php'); ?>
        </div>
    </div>
</div>
