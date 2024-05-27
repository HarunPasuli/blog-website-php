<?php session_start() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../images/favicon2.png">
    <title>Update Blog</title>
       <link rel = "stylesheet" href = "CSS/form.css">    
    <script
  src="https://code.jquery.com/jquery-3.6.3.js"
  integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
  crossorigin="anonymous"></script>
    <script src = "../../js/form2.js" defer></script>
</head>

<body>

<?php

include('connect.php');

if(isset($_GET['update'])) {

    $update_id = $_GET['update'];

    $select = "SELECT * FROM products WHERE PID = '$update_id'";

    $query = mysqli_query($connect, $select);

    $row = mysqli_fetch_array($query);

?>

    <div class="container">
        <!-- <h1>Update Product</h1> -->
        <h1 style = "text-align: center;">Update Product</h1>
        <form method='post' action="update_ID.php" id="upload-form" enctype="multipart/form-data">
            <input type="hidden" name="PID" value="<?php echo $row['PID'];?>">
        <h1>Update Product</h1>
    <div class="form-group">
        <label for="file-name">File Name:</label>
        <input type="text" class="form-control" name="fileName" id="file-name">
    </div>
    <div class="form-group">
        <label for="file-upload">File Upload:</label>
        <div class="file-upload">
            <input type="file" name="fileUpload" id="file-upload" onchange="getFileData()">
            <span class="file-upload-text">Drag and drop or click to select file</span>
        </div>
        <div class="file-name-preview my-element" id="file-upload-preview"></div>
    </div>
    <div class="form-group">
        <label for="file-category">File Category:</label>
        <select class="form-control" name='fileCategories' id="file-category">
            <option value='Mobile'>Mobile</option>
            <option value='Tech'>Tech</option>
            <option value='Gaming'>Gaming</option>
            <option value='Design'>Design</option>
            <option value='Anime'>Anime</option>
            <option value='Programming'>Programming</option>
            <option value='Sports'>Sports</option>
        </select>
    </div>
    <div class="form-group">
        <label for="file-description">File Description:</label>
        <textarea class="form-control" name='content' cols='30' rows='15' id="file-description"></textarea>
    </div>
    <div class="form-group">
    <input type="submit" name="update" value="Update" class = "insert-btn">
        <button type="reset" name="cancel" class="cancel-btn">Cancel</button>
    </div>
    </div>

<?php }?>
</body>
</html>
