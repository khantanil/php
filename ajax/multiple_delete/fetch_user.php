<?php
$conn = mysqli_connect("localhost", "root", "", "test");
$output = "";

$sql = "SELECT * FROM users ORDER BY id ASC";
$result = mysqli_query($conn, $sql);

$output .= '<table>
  <thead>
    <tr>
      <th></th>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Created At</th>
    </tr>
  </thead>
  <tbody>';

if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $output .= "<tr>
      <td><input type='checkbox' class='userCheckbox' value='{$row['id']}'></td>
      <td>{$row['id']}</td>
      <td>{$row['full_name']}</td>
      <td>{$row['email']}</td>
      <td>{$row['created_at']}</td>
    </tr>";
  }
} else {
  $output .= "<tr><td colspan='5'>No data found</td></tr>";
}

$output .= '</tbody></table>';
echo $output;
