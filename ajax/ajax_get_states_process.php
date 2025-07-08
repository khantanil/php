<?php
include 'connection.php';

if (isset($_POST['country_id'])) {
    $country_id = $_POST['country_id'];

    $sql = "SELECT * FROM states WHERE country_id = $country_id";
    $result = mysqli_query($conn, $sql);

    echo '<option value="">--Select State--</option>';
    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row['id']}'>{$row['state_name']}</option>";
    }
}
?>
