<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php');

  $username = $_SESSION['username'];
  $user = getUserFromUsername($username);

  if ( empty($_GET['id']) ) {
    header('Location: index.php?errCode=1');
    die('資料不齊全');
  }
  $id = $_GET['id'];
  if ($user['authority'] == 1) {
    $sql = "UPDATE s22shadowl_board_comments SET is_deleted=1 WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);  
  } else {
    $sql = "UPDATE s22shadowl_board_comments SET is_deleted=1 WHERE id=? AND username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('is', $id, $username);
  }
    $result = $stmt->execute();
    
  if (!$result) {
    die($conn->error);
  }
  header("Location: index.php");
?>