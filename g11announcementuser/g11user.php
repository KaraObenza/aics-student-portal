<?php 
    require_once '../database-config.php';

    $query = "SELECT * FROM posts ORDER BY id DESC";

    $result = $connection->query($query);
?>
 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../admin/resources/admin.css" type="text/css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Grade 11 User</title>
</head>
<body>
    <main class="main-content">
        <?php while ($post = $result->fetch_assoc()):?>
            <section class="post">
                <?= $post['content'] ?>
                <?php if (!is_null($post['images'])): ?>
                    <?php foreach (json_decode($post['images']) as $image): ?>
                        <div class="images-container">
                            <img src="<?= '../posts-images/'.$image ?>" class="post-image"/>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>
        <?php endwhile; ?>
    </main>
    
</body>
</html>