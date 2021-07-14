<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php');

  if ( empty($_GET['id']) || empty($_SESSION['username']) ) {
    header('Location: index.php?errCode=1');
    die('資料不齊全');
  }
  $id = $_GET['id'];
    $sql = "update s22shadowl_blog_articles set is_deleted=1 where id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $result = $stmt->execute();
    
  if (!$result) {
    die($conn->error);
  }
  header("Location: index.php");
?>