<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="../Resources/hmbct.png" />
</head>
<body>
<div style="background-color:#c9c9c9;padding:15px;">
      <button type="button" name="homeButton" onclick="location.href='../homepage.html';">Home Page</button>
      <button type="button" name="mainButton" onclick="location.href='fileupl.html';">Main Page</button>
</div>

<div align="center">
<form action="fileupload1.php" method="POST" enctype="multipart/form-data">
   <br>
    <b>Select image : </b> 
    <input type="file" name="file" id="file" style="border: solid;">
    <input type="submit" value="Submit" name="submit">
</form>
</div>
<?php

// image file check
function isImage($file_path, $file_name) {
  $finfo = new finfo(FILEINFO_MIME_TYPE, null);
  $mime_type = $finfo->file($file_path);
  $image_file_type = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));

  $allowed_mime_type = [
    'png' => 'image/png',
    'jpe' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'jpg' => 'image/jpeg',
    'gif' => 'image/gif',
    'bmp' => 'image/bmp',
    'ico' => 'image/vnd.microsoft.icon',
    'tiff' => 'image/tiff',
    'tif' => 'image/tiff',
    'svg' => 'image/svg+xml',
    'svgz' => 'image/svg+xml',
  ];

  if (array_key_exists($image_file_type, $allowed_mime_type) && in_array($mime_type, $allowed_mime_type)) {
    return TRUE;
  }

  return FALSE;
}

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  if(isImage($_FILES["file"]["tmp_name"], $_FILES['file']['name'])) {
    $target_dir = "uploads/";
    $random_prefix = md5(substr(number_format(time() * rand(),0,'',''),0,10)) . " - ";
    $target_file = $target_dir . $random_prefix . basename($_FILES["file"]["name"]);
    move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
    echo "File successfully uploaded!";
  } else {
    echo "JPG, JPEG, JPE, PNG, GIF, BMP, ICO, TIFF, TIF, SVG & SVGZ files are allowed!";
  }
}
?>
</body>
</html>
