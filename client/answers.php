<div class="container">
    <div class="offset-sm-1">
        <h5>Answers:</h5>

        <?php
        // ✅ Ensure $qid is set
        if (isset($qid)) {
            include("./common/db.php");

            // ✅ Secure the query with intval
            $qid = intval($qid);
            $query = "SELECT * FROM answers WHERE question_id = $qid";
            $result = $conn->query($query);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $answer = htmlspecialchars($row['answer']);  // ✅ Escape output
                    echo "<div class='row'>
                            <p class='answer-wrapper'>$answer</p>
                          </div>";
                }
            } else {
                echo "<p>No answers found.</p>";
            }
        } else {
            echo "<p>Invalid question ID.</p>";
        }
        ?>
    </div>
</div>
