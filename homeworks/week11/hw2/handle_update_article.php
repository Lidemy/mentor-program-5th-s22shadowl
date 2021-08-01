<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php');

  if ( empty($_POST['content']) && empty($_POST['title']) ) {
    header('Location: index.php?errCode=1');
    die('資料不齊全');
  }

  $user = $_SESSION['username'];
  if (empty($user)) {
    header('Location: index.php?errCode=2');  
    die('權限錯誤');
  }

  $id = $_POST['id'];
  $content = $_POST['content'];
  $title = $_POST['title'];

  if ($_POST['title']) {
    $sql = "UPDATE s22shadowl_blog_articles SET title=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $title, $id);
  } 
  if ($_POST['content']) {
    $sql = "UPDATE s22shadowl_blog_articles SET content=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $content, $id);
  }
    $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }
  header("Location: article.php?id=$id");
?>