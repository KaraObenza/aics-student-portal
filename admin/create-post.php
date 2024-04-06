<?php
include_once '../helpers.php';
require_once '../database-config.php';

$post_images_directory = dirname(getcwd()).'/posts-images';

if ((isset($_POST['content']) && !empty($_POST['content']))) {
    if (count($_FILES['uploads']['name']) > 0) {
        $filenames = [];
        foreach ($_FILES["uploads"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["uploads"]["tmp_name"][$key];
                $name = basename($_FILES["uploads"]["name"][$key]);
                $filenames[] = $name;
                move_uploaded_file($tmp_name, "$post_images_directory/$name");
            }
        }
    }

    $encoded_filenames = isset($filenames)
        ? json_encode($filenames)
        : null;

    $query = "INSERT INTO posts(content, images) VALUES(?, ?)";
    $statement = $connection->prepare($query);
    $statement->bind_param('ss', $_POST['content'], $encoded_filenames);

    $success = $statement->execute();    
    
    if ($success) {
        echo 'Success';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./resources/admin.css" type="text/css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <title>AICS Web Portal</title>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="wrapper">
                <header>
                    <h4>AICS Web Portal</h4>
                </header>
                <nav class="main-nav">
                    <a>Dashboard</a>
                    <a href="/web/admin/posts.php">Posts</a>
                </nav>
            </div>
        </aside>
        <main class="main-content">
            <div class="">
                <a href="/web/admin/posts.php">Back</a>
            </div>
            <div class="">
                <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                    <div class="form-group">
                        <textarea id="content" name="content"></textarea>
                    </div>
                    <input type="file" id="uploads" name="uploads[]" multiple />
                    <div class="button-wrapper">
                        <button name="submit" type="submit" class="btn btn-submit">Save</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>