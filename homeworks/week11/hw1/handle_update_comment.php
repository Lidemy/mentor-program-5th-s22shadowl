<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php');

  if (empty($_POST['content'])) {
    header('Location: index.php?errCode=1');
    die('資料不齊全');
  }

  $username = $_SESSION['username'];
  $user = getUserFromUsername($username);
  $id = $_POST['id'];
  $content = $_POST['content'];
  $title = $_POST['title'];

  if ($user['authority'] == 1) {
    $sql = "UPDATE s22shadowl_board_comments SET content=?, title=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssi', $content, $title, $id);
  } else {
    $sql = "UPDATE s22shadowl_board_comments SET content=?, title=? WHERE id=? AND username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssis', $content, $title, $id, $username);
  }
    $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }
  header("Location: index.php");
?>