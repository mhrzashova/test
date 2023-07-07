<?php
if (isset($_POST['submit']) && isset($_FILES['my_file'])) {
    // Database Connection
    $connection = new mysqli("localhost", "root", "", "images");

    // Checking Database Connection
    if ($connection->connect_errno != 0) {
        die("Database Connectivity Error");
    }

    $file_name = $_FILES['my_file']['name'];
    $file_size = $_FILES['my_file']['size'];
    $tmp_name = $_FILES['my_file']['tmp_name'];
    $error = $_FILES['my_file']['error'];

    // Get the file extension
    $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // Allowed file extensions
    $allowed_extensions = array('pdf', 'png', 'jpeg', 'jpg');

    if ($error == 0) {
        if (!in_array($file_extension, $allowed_extensions)) {
            $error_var = "Invalid file format. Allowed formats: PDF, PNG, JPEG, JPG";
            header("Location: images.php?error=$error_var");
            exit;
        } elseif ($file_size > 125000) {
            $error_var = "Sorry, your file is too large";
            header("Location: images.php?error=$error_var");
            exit;
        } else {
            $upload_directory = "uploads/";
            $target_file = $upload_directory . $file_name;

            if (move_uploaded_file($tmp_name, $target_file)) {
                $sql = "INSERT INTO images (image_url) VALUES ('$target_file')";
                if ($connection->query($sql) === true) {
                    $success = "File uploaded successfully";
                    header("Location: images.php?success=$success");
                    exit;
                } else {
                    $error_var = "Error uploading the file to the database. Please try again.";
                    header("Location: images.php?error=$error_var");
                    exit;
                }
            } else {
                $error_var = "Error uploading the file. Please try again.";
                header("Location: images.php?error=$error_var");
                exit;
            }
        }
    } else {
        $error_var = "Error uploading the file. Please try again.";
        header("Location: images.php?error=$error_var");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Images Upload Demo</title>
</head>

<body>
    <h1>Images Upload Demo</h1>
    <fieldset>
        <legend>Image Upload</legend>
        <?php if (isset($_GET['error'])) : ?>
            <p><?php echo $_GET['error']; ?></p>
        <?php elseif (isset($_GET['success'])) : ?>
            <p><?php echo $_GET['success']; ?></p>
        <?php endif ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <label for="file">Choose File: <br> <br>
                <input type="file" name="my_file" id="my_file" accept=".pdf, .png, .jpeg, .jpg">
            </label> <br> <br> <br>
            <input type="submit" name="submit" value="Upload">
        </form>
    </fieldset>
</body>
</html>