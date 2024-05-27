<?php
include("../AdminDashboard/admin/connect.php");

$category = isset($_POST['category']) ? $_POST['category'] : 'all';
$lastId = isset($_POST['PID']) ? $_POST['PID'] : 0;
$limit = 9;
// Construct the HTML to display the products
$output = '';
// Construct the SQL query to retrieve products based on the selected category
if ($category === 'all') {
    $stmt = mysqli_prepare($connect, "SELECT * FROM products ORDER BY PID DESC LIMIT 0,9");
} else {
    $stmt = mysqli_prepare($connect, "SELECT * FROM products WHERE fileCategories=? ORDER BY PID DESC LIMIT 0,9");
    mysqli_stmt_bind_param($stmt, "s", $category);
}

// Execute the query and retrieve the products
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
      $fileId = $row['PID'];
      $fileName = $row['fileName'];
      $fileUpload = $row['fileUpload'];
      $description = substr($row['fileDescription'], 0, 300);
      $fileProfilePicture = $row['fileProfilePicture'];
      $filePersonalName = $row['filePersonalName'];
      $fileProductDate = date("F j, Y, g:i a", strtotime($row['productDate']));
      $fileCategories = $row['fileCategories'];

      $output .= '
      <div class="post-box" data-category="'.$fileCategories.'">
      <a href="html/post-page.php?id='.$fileId.'">
          <img src="AdminDashboard/admin/file/'.$fileUpload.'" alt="" class="post-img">
      </a>
          <h2 class="category">
              '.$fileCategories.'
          </h2>
          <a href="html/post-page.php?id='.$fileId.'" class="post-title">
              '.$fileName.'
          </a>
          <span class="post-date" id="creation-date">
              '.$fileProductDate.'
          </span>
          <p class="post-description">
              '.$description.'
          </p>
          <div class="profile">
              <img src="AdminDashboard/admin/file/'.$fileProfilePicture.'" alt="" class="profile-img">
              <span class="profile-name">'.$filePersonalName.'</span>
          </div>
      </div>';

      $lastId = $fileId; // update lastId with the ID of the last product displayed
  }

  // if the number of rows returned by the query is less than the limit, all products have been displayed and the button should be hidden
  if($result->num_rows < $limit) {
      $output .= '<script>$(".show_more_btn").remove();</script>';
  } else {
      // if there are more products to display, update the button with the last displayed product ID and show the button
      $output .= '
      <div class="show_more_btn">
          <button type="button" id="'.$lastId.'" data-category="'.$category.'" class="btn btn-primary">Load More</button>
      </div>';
    //   $output .= '<script>$(".show_more_btn").remove();</script>';
  }
}
// else {
//   $output .= '<p>No More Data</p>';
// }
// Return the HTML output to the AJAX request
echo $output;

// Close the prepared statement and the database connection
$stmt->close();
$connect->close();
?>