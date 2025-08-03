<div>
    <h1 class="heading">Categories</h1>
    <?php  
    include('./common/db.php');

    $query = "SELECT * FROM category ORDER BY name ASC";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $name = htmlspecialchars(ucfirst($row['name']));
            $id = intval($row['id']);

            echo "<div class='row question-list'>
                    <h4><a href='?c-id=$id'>$name</a></h4>
                  </div>";
        }
    } else {
        echo "<p>No categories found.</p>";
    }
    ?>
</div>
