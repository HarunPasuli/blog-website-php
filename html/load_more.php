<?php 
include("../AdminDashboard/admin/connect.php");

$lastId = $_POST['PID'];
$limit = 9;
$category = isset($_POST['category']) ? $_POST['category'] : 'all'; // check if category is set, default to 'All' if not

$output = '';

if ($category == 'all') {
    $query = $connect->prepare("SELECT * FROM products WHERE PID < ? ORDER BY PID DESC LIMIT ?");
    $query->bind_param("ii", $lastId, $limit);
} else {
    $query = $connect->prepare("SELECT * FROM products WHERE PID < ? AND fileCategories = ? ORDER BY PID DESC LIMIT ?");
    $query->bind_param("isi", $lastId, $category, $limit);
}

$query->execute();
$result = $query->get_result();

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
    }
} 
else {
    $output .= '<p>No More Data</p>';
}

echo $output;

// Close the prepared statement and the database connection
$query->close();
$connect->close();
?>