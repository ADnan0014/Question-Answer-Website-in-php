<?php
session_start();

// ✅ Check if user is logged in
if (!isset($_SESSION['user']['id'])) {
    echo "<div class='container'><p class='text-danger'>Please <a href='?login'>login</a> to ask a question.</p></div>";
    exit;
}
?>

<div class="container">
    <h1 class="heading">Ask A Question</h1>

    <form action="./server/requests.php" method="post">

        <!-- Title -->
        <div class="col-6 offset-sm-3 mb-3">
            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control" id="title" placeholder="Enter your question title" required>
        </div>

        <!-- Description -->
        <div class="col-6 offset-sm-3 mb-3">
            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
            <textarea name="description" class="form-control" id="description" rows="5" placeholder="Write your question in detail" required></textarea>
        </div>

        <!-- Category Dropdown -->
        <div class="col-6 offset-sm-3 mb-3">
            <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
            <?php include("category.php"); ?>
        </div>

        <!-- Submit Button -->
        <div class="col-6 offset-sm-3 mb-3">
            <button type="submit" name="ask" class="btn btn-primary w-100">Ask Question</button>
        </div>

    </form>
</div>
