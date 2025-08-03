<?php
include("./common/db.php");
session_start();

// ✅ Validate and sanitize question id
if (!isset($_GET['q-id']) || !is_numeric($_GET['q-id'])) {
    echo "<div class='container'><p class='text-danger'>Invalid question ID.</p></div>";
    exit;
}

$qid = intval($_GET['q-id']);

// ✅ Get the question from DB
$query = "SELECT * FROM questions WHERE id = $qid";
$result = $conn->query($query);

if (!$result || $result->num_rows === 0) {
    echo "<div class='container'><p class='text-danger'>Question not found.</p></div>";
    exit;
}

$row = $result->fetch_assoc();
$cid = intval($row['category_id']);
$title = htmlspecialchars($row['title']);
$desc = nl2br(htmlspecialchars($row['description']));
?>

<div class="container">
    <h1 class="heading">Question</h1>
    <div class="row">
        <!-- Left Column -->
        <div class="col-8">
            <h4 class="mb-3 question-title">Question: <?= $title ?></h4>
            <p class="mb-4"><?= $desc ?></p>

            <?php include("answers.php"); ?>

            <!-- Only allow logged-in users to answer -->
            <?php if (isset($_SESSION['user']['id'])): ?>
                <form action="./server/requests.php" method="post">
                    <input type="hidden" name="question_id" value="<?= $qid ?>">
                    <textarea name="answer" class="form-control mb-3" placeholder="Write your answer here..." required></textarea>
                    <button class="btn btn-primary">Submit Answer</button>
                </form>
            <?php else: ?>
                <p class="text-danger">Please <a href="?login=true">login</a> to post an answer.</p>
            <?php endif; ?>
        </div>

        <!-- Right Column -->
        <div class="col-4">
            <?php
            // ✅ Fetch category name
            $categoryQuery = "SELECT name FROM category WHERE id = $cid";
            $categoryResult = $conn->query($categoryQuery);
            $categoryRow = $categoryResult->fetch_assoc();
            $categoryName = htmlspecialchars(ucfirst($categoryRow['name']));
            echo "<h4 class='mb-3'>Category: $categoryName</h4>";

            // ✅ Related questions (not current)
            $relatedQuery = "SELECT * FROM questions WHERE category_id = $cid AND id != $qid ORDER BY id DESC";
            $relatedResult = $conn->query($relatedQuery);

            if ($relatedResult && $relatedResult->num_rows > 0) {
                while ($related = $relatedResult->fetch_assoc()) {
                    $relatedTitle = htmlspecialchars($related['title']);
                    $relatedId = intval($related['id']);
                    echo "<div class='question-list mb-2'>
                            <h5><a href='?q-id=$relatedId'>$relatedTitle</a></h5>
                          </div>";
                }
            } else {
                echo "<p>No related questions found.</p>";
            }
            ?>
        </div>
    </div>
</div>
