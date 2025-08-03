<select class="form-control" name="category" id="category" required>
    <option value="">Select A Category</option>
    <?php 
    include("./common/db.php");

    $query = "SELECT * FROM category ORDER BY name ASC";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $name = htmlspecialchars(ucfirst($row['name']));
            $id = intval($row['id']);
            echo "<option value=\"$id\">$name</option>";
        }
    } else {
        echo "<option disabled>No categories found</option>";
    }
    ?>
</select>
