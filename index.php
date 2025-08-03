<!DOCTYPE html>
<html lang="en">

<head>
   <title>Discuss Project</title>
   <?php include('./client/commonFiles.php') ?>
</head>

<body>
   <?php
   session_start();
   include('./client/header.php');

   $isLoggedIn = isset($_SESSION['user']) && isset($_SESSION['user']['username']);

   // ✅ Routing logic
   if (isset($_GET['signup']) && !$isLoggedIn) {
      include('./client/signup.php');

   } else if (isset($_GET['login']) && !$isLoggedIn) {
      include('./client/login.php');

   } else if (isset($_GET['ask'])) {
      include('./client/ask.php');

   } else if (isset($_GET['q-id'])) {
      $qid = intval($_GET['q-id']);
      include('./client/question-details.php');

   } else if (isset($_GET['c-id'])) {
      $cid = intval($_GET['c-id']);
      include('./client/questions.php');

   } else if (isset($_GET['u-id'])) {
      $uid = intval($_GET['u-id']);
      include('./client/questions.php');

   } else if (isset($_GET['latest'])) {
      include('./client/questions.php');

   } else if (isset($_GET['search'])) {
      $search = htmlspecialchars(trim($_GET['search']));
      include('./client/questions.php');

   } else {
      include('./client/questions.php');
   }
   ?>
</body>

</html>
