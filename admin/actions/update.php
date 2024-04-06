<?php
require_once '../../database-config.php';
include '../../helpers.php';

if (isset($_POST['content']) && !empty($_POST['content'])) {
    $postId = $_POST['post'];

    if (count($_FILES['uploads']['name']) > 0) {
        $filenames = [];
        foreach ($_FILES["uploads"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["uploads"]["tmp_name"][$key];
                $name = basename($_FILES["uploads"]["name"][$key]);

                $post_images_directory = dirname(dirname(getcwd())).'/posts-images';

                $filenames[] = $name;
                move_uploaded_file($tmp_name, "$post_images_directory/$name");
            }
        }
   
        $query = "SELECT * from posts WHERE id=".$postId;
        $result = $connection->query($query);

        $post = $result->fetch_assoc();
        $images = array_merge(json_decode(json: $post['images'], flags: JSON_OBJECT_AS_ARRAY), $filenames);
        $encoded_images = json_encode($images);

        $updateQuery = "UPDATE posts SET images=? WHERE id=?";
        $stmt = $connection->prepare($updateQuery);

        $stmt->bind_param("si", $encoded_images, $postId);
        $stmt->execute();
    }

    $sql = "UPDATE posts SET content=? WHERE id=?";

    $statement = $connection->prepare($sql);
    $statement->bind_param('si', $_POST['content'], $postId);

    if($statement->execute()) {
        header('Location: ../posts.php');
    }
}