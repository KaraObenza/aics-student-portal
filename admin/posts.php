<?php 
require_once '../database-config.php';
include_once '../helpers.php';

$query = "SELECT * FROM posts ORDER BY created_at DESC";

$result = $connection->query($query);
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
                    <a href="/web/admin">Dashboard</a>
                    <a href="/web/admin/posts.php">Posts</a>
                </nav>
            </div>
        </aside>
        <main class="main-content">
            <div class="">
                <a href="/web/admin/create-post.php">Create Post</a>
            </div>
            <?php while ($post = $result->fetch_assoc()): ?>
                <section class="post">
                    <?= $post['content'] ?>
                    <?php if (!is_null($post['images'])): ?>
                        <?php $images = json_decode($post['images']); ?>
                        <div class="images-container">
                            <?php foreach ($images as $image): ?>
                                <img src="<?= '../posts-images/'.$image ?>" class="post-image" />
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <form action="./actions/delete-post.php" method="post">
                        <input type="hidden" name="post" value="<?= $post['id'] ?>" />
                        <button type="submit">Delete</button>
                    </form>
                    <a href="./update-post.php?post=<?= $post['id'] ?>">Update</a>
                </section>
            <?php endwhile; ?>
        </main>
    </div>
</body>
</html>