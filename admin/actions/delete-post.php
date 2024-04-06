<?php 
require_once '../../database-config.php';

if (isset ($_POST['post']) && !empty($_POST['post'])) {   
    $sql = "DELETE FROM posts where id=?";
    
    $statement = $connection->prepare($sql);
    $statement->bind_param('i', $_POST['post']);

   $result = $statement->execute();

   if ($result) {
     echo "<script>alert('DELETED SUCCESSS')</script>";
     header('Location: ../posts.php');
   }
}