<?php
include_once '../helpers.php';
require_once '../database-config.php';

if (isset($_GET['post']) && !empty($_GET['post'])) {
    $sql = "SELECT * FROM posts where id=".$_GET['post'];

    $result = $connection->query($sql);
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
            <?php while ($post = $result->fetch_assoc()): ?>
            <div class="">
                <form method="post" action="./actions/update.php" enctype="multipart/form-data">
                    <input type="hidden" name="post" value="<?= $_GET['post'] ?>" />
                    <div class="form-group">
                        <textarea id="content" name="content"><?= $post['content'] ?></textarea>
                    </div>
                    <input type="file" id="uploads" name="uploads[]" multiple />
                    <div class="button-wrapper">
                        <button name="submit" type="submit" class="btn btn-submit">Save</button>
                    </div>
                    <input type="hidden" value="<?= htmlspecialchars($post['images']) ?>" name="old-images" id="old-images"/>
                    <?php if (!is_null($post['images'])): ?>
                        <div class="post-image-container">
                            <?php foreach (json_decode($post['images']) as $key => $image): ?>
                                <div class="removable-image" id="image-<?= $key ?>">
                                    <button type="button" class="btn btn-remove" data-image-key="<?= $key ?>">
                                        <input type="hidden" name="image" value="<?= $image ?>"/>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="icon-svg">
                                            <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                                        </svg>
                                    </button>
                                    <img class="post-image" src="../posts-images/<?= $image ?>" />
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
            <?php endwhile; ?>
        </main>
    </div>
    <script>
        const removeButtons = document.querySelectorAll('.btn-remove')

        removeButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                let image = button.querySelector('input[type="hidden"]').value
                let imageKey = this.getAttribute('data-image-key')
                let imageContainer = document.querySelector('.post-image-container')

                const http = new XMLHttpRequest()
                
                http.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        let removableImage = document.querySelector('#image-' + imageKey)
                        console.log(removableImage)
                        imageContainer.removeChild(removableImage)
                    }
                }

                http.open('POST', './actions/delete-image.php', true)
                http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                http.send("image=" + image +"&post=" + <?= $_GET['post'] ?>)
            })
        })
    </script>
</body>
</html>