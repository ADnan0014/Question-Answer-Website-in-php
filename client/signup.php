<?php


// ✅ Already logged in? Don't allow signup
if (isset($_SESSION['user']['username'])) {
    echo "<div class='container'><p class='text-success'>You are already logged in as <strong>{$_SESSION['user']['username']}</strong>.</p></div>";
    exit;
}
?>

<div class="container">
    <h1 class="heading">Signup</h1>

    <!-- Flash message (set in requests.php if needed) -->
    <?php if (isset($_SESSION['signup_error'])): ?>
        <div class="alert alert-danger text-center col-6 offset-sm-3">
            <?= $_SESSION['signup_error']; unset($_SESSION['signup_error']); ?>
        </div>
    <?php endif; ?>

    <form method="post" action="./server/requests.php">

        <!-- Username -->
        <div class="col-6 offset-sm-3 mb-3">
            <label for="username" class="form-label">User Name</label>
            <input type="text" name="username" class="form-control" id="username" placeholder="Enter username" required>
        </div>

        <!-- Email -->
        <div class="col-6 offset-sm-3 mb-3">
            <label for="email" class="form-label">User Email</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
        </div>

        <!-- Password -->
        <div class="col-6 offset-sm-3 mb-3">
            <label for="password" class="form-label">User Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Enter password" required>
        </div>

        <!-- Address -->
        <div class="col-6 offset-sm-3 mb-3">
            <label for="address" class="form-label">User Address</label>
            <input type="text" name="address" class="form-control" id="address" placeholder="Enter address" required>
        </div>

        <!-- Submit -->
        <div class="col-6 offset-sm-3 mb-3">
            <button type="submit" name="signup" class="btn btn-primary w-100">Signup</button>
        </div>

    </form>
</div>
