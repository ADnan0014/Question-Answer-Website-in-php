<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">

    <a class="navbar-brand" href="./">
      <img src="./public/logo.png" alt="Logo" height="40">
    </a>

    <!-- Toggle button for mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar links -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" href="./">Home</a>
        </li>

        <?php if (!empty($_SESSION['user']['username'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="?ask=true">Ask A Question</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?u-id=<?= $_SESSION['user']['user_id'] ?>">My Questions</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./server/requests.php?logout=true">
              Logout (<?= htmlspecialchars(ucfirst($_SESSION['user']['username'])) ?>)
            </a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="?login=true">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?signup=true">SignUp</a>
          </li>
        <?php endif; ?>

        <li class="nav-item">
          <a class="nav-link" href="?latest=true">Latest Questions</a>
        </li>
      </ul>

      <!-- Search bar -->
      <form class="d-flex" method="get" action="">
        <input class="form-control me-2" name="search" type="search" placeholder="Search questions" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>

    </div>
  </div>
</nav>
