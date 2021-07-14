<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php');

  if (empty($_SESSION['username'])) {
    header("Location: index.php?errCode=2");
  }

  if ( empty($_POST['title']) || empty($_POST['content']) ) {
    header('Location: index.php?errCode=1');
    die('資料不齊全');
  }
  $content = $_POST['content'];
  $title = $_POST['title'];

  $sql = sprintf("insert into s22shadowl_blog_articles(title, content) values(?, ?)");
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ss', $title, $content);
  $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }
  header("Location: index.php");
?>