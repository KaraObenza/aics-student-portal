<?php

require_once '../../database-config.php';
include_once '../../helpers.php';

$post_images_directory = dirname(dirname(getcwd())).'/posts-images';
$postId = $_POST['post'];

$query = "SELECT * FROM posts WHERE id=". $postId;
$result = $connection->query($query);

$post = $result->fetch_assoc();

if (! is_null($post)) {
    $images = json_decode(json: $post['images'], flags: JSON_OBJECT_AS_ARRAY);

    // ['value1','value2','value3']
    $newImages = array_filter($images, function (string $image) {
        if ($image === $_POST['image']) {
                return false;
        }
        
        return true;
    });

    $encoded_images = json_encode($newImages);

    $statement = $connection->prepare("UPDATE posts SET images=? WHERE id=?");
    $statement->bind_param("si", $encoded_images, $postId);

    $statement->execute();
    
    if (file_exists($post_images_directory.'/'.$_POST['image'])) {
        unlink($post_images_directory.'/'.$_POST['image']);
    }
}