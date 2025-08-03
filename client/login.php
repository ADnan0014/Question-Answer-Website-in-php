<?php


// ✅ If already logged in, redirect or show message
if (isset($_SESSION['user']['username'])) {
    echo "<div class='container'><p class='text-success'>You are already logged in as <strong>{$_SESSION['user']['username']}</strong>.</p></div>";
    exit;
}
?>

<div class="container">
    <h1 class="heading">Login</h1>

    <!-- Optional: Flash message (can be set in requests.php on failed login) -->
    <?php if (isset($_SESSION['login_error'])): ?>
        <div class="alert alert-danger text-center col-6 offset-sm-3">
            <?= $_SESSION['login_error']; unset($_SESSION['login_error']); ?>
        </div>
    <?php endif; ?>

    <form action="./server/requests.php" method="post">

        <!-- Email -->
        <div class="col-6 offset-sm-3 mb-3">
            <label for="email" class="form-label">User Email</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
        </div>

        <!-- Password -->
        <div class="col-6 offset-sm-3 mb-3">
            <label for="password" class="form-label">User Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
        </div>

        <!-- Submit -->
        <div class="col-6 offset-sm-3 mb-3">
            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
        </div>

    </form>
</div>
