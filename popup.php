<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Uploaded Files</title>
    <style>
        .file-item {
            display: flex;
            align-items: center;
            10px;
        }

        .file-name {
            10px;
        }
    </style>
    <script>
        function showFile(file) {
            var popup = window.open(file, '_blank', 'width=800,height=600,menubar=no,status=no,toolbar=no');
            popup.focus();
        }
    </script>
</head>

<body>
    <h1>View Uploaded Files</h1>
    <div id="file-list">
        <?php
        $connection = new mysqli("localhost", "root", "", "images");

        if ($connection->connect_errno != 0) {
            die("Database Connectivity Error");
        }

        $sql = "SELECT image_url FROM images";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $file = $row['image_url'];
                $file_path = dirname($_SERVER['PHP_SELF']) . '/' . $file;
                echo '<div class="file-item">';
                echo '<span class="file-name">' . $file . '</span>';
                //echo '<a href="' . $file_path . '" target="_blank">View</a>';
                echo '<a href="#" onclick="showFile(\'' . $file_path . '\')">View</a>';
                echo '</div>';
            }
        } else {
            echo '<p>No files uploaded yet.</p>';
        }
        ?>
    </div>

</body>

</html>