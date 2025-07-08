<?php
// include 'connection.php';

// if (isset($_POST['blog_id'])) {
//     $blog_id = $_POST['blog_id'];
//     $stmt = $conn->prepare("SELECT category_id FROM blog_categories WHERE blog_id = ?");
//     $stmt->bind_param("i", $blog_id);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     $categoryIds = [];
//     while ($row = $result->fetch_assoc()) {
//         $categoryIds[] = $row['category_id'];
//     }

//     echo json_encode($categoryIds);
// }
// ?>
