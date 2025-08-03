<?php
session_start();
include("../common/db.php");

// -------- SIGNUP --------
if (isset($_POST['signup'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password
    $address = trim($_POST['address']);

    if ($username && $email && $password && $address) {
        // ✅ Prepared statement
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, address) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $password, $address);

        if ($stmt->execute()) {
            $_SESSION["user"] = [
                "username" => $username,
                "email" => $email,
                "user_id" => $stmt->insert_id
            ];
            header("Location: /discuss");
        } else {
            $_SESSION['signup_error'] = "Signup failed. Try another email.";
            header("Location: /discuss?signup=true");
        }
    } else {
        $_SESSION['signup_error'] = "Please fill in all fields.";
        header("Location: /discuss?signup=true");
    }
    exit;
}

// -------- LOGIN --------
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $row = $res->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION["user"] = [
                "username" => $row['username'],
                "email" => $email,
                "user_id" => $row['id']
            ];
            header("Location: /discuss");
            exit;
        }
    }

    $_SESSION['login_error'] = "Invalid email or password.";
    header("Location: /discuss?login=true");
    exit;
}

// -------- LOGOUT --------
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: /discuss");
    exit;
}

// -------- ASK QUESTION --------
if (isset($_POST["ask"]) && isset($_SESSION['user'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $category_id = intval($_POST['category']);
    $user_id = $_SESSION['user']['user_id'];

    if ($title && $description && $category_id) {
        $stmt = $conn->prepare("INSERT INTO questions (title, description, category_id, user_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $title, $description, $category_id, $user_id);

        if ($stmt->execute()) {
            header("Location: /discuss");
            exit;
        } else {
            echo "Error: Question not submitted.";
        }
    } else {
        echo "Please fill all fields.";
    }
}

// -------- ANSWER SUBMIT --------
if (isset($_POST["answer"]) && isset($_SESSION['user'])) {
    $answer = trim($_POST['answer']);
    $question_id = intval($_POST['question_id']);
    $user_id = $_SESSION['user']['user_id'];

    if ($answer && $question_id) {
        $stmt = $conn->prepare("INSERT INTO answers (answer, question_id, user_id) VALUES (?, ?, ?)");
        $stmt->bind_param("sii", $answer, $question_id, $user_id);

        if ($stmt->execute()) {
            header("Location: /discuss?q-id=$question_id");
            exit;
        } else {
            echo "Answer not submitted.";
        }
    } else {
        echo "Please enter an answer.";
    }
}

// -------- DELETE QUESTION --------
if (isset($_GET["delete"]) && isset($_SESSION['user'])) {
    $qid = intval($_GET["delete"]);

    // Optional: verify ownership before deletion
    $check = $conn->prepare("SELECT user_id FROM questions WHERE id = ?");
    $check->bind_param("i", $qid);
    $check->execute();
    $res = $check->get_result();
    if ($res->num_rows > 0) {
        $owner = $res->fetch_assoc()['user_id'];
        if ($owner == $_SESSION['user']['user_id']) {
            $stmt = $conn->prepare("DELETE FROM questions WHERE id = ?");
            $stmt->bind_param("i", $qid);
            if ($stmt->execute()) {
                header("Location: /discuss");
                exit;
            } else {
                echo "Question could not be deleted.";
            }
        } else {
            echo "Unauthorized: You can only delete your own questions.";
        }
    } else {
        echo "Question not found.";
    }
}
?>
