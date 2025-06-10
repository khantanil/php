<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    // echo "Connected successfully<br>";
}

$sql = "SELECT * FROM contact";
$result = mysqli_query($conn, $sql);


// Showing total records
$num_rows = mysqli_num_rows($result);
echo  $num_rows. " records found<br>";

if($num_rows>0){
    echo "<table class='table table-striped'>
            <thead>
                <tr>
                    <th scope='col'>ID</th>
                    <th scope='col'>Name</th>
                    <th scope='col'>Email</th>
                    <th scope='col'>Concern</th>
                    <th scope='col'>Date</th>
                </tr>
            </thead>
            <tbody>";
    
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['sno']}</td>
                <td>{$row['name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['concern']}</td>
                <td>{$row['date']}</td>
              </tr>";
    }
    
    echo "</tbody></table>";
} else {
    echo "No records found.";
}
?>