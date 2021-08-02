<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php');
  if ( empty($_POST['username']) || empty($_POST['password']) ) {
    header('Location: login.php?errCode=1');
    die();
  }
  $username = $_POST['username'];
  $password = $_POST['password'];
  $sql = sprintf(
    "SELECT * FROM s22shadowl_board_users WHERE username=? ");
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $username);
  $result = $stmt->execute();
  if (!$result) {
    $code = $conn->errno;
    die($conn->error);
  }

  $result = $stmt->get_result();

  if ($result->num_rows === 0) {
    header("Location: login.php?errCode=2");
    exit();
  }
  $row = $result->fetch_assoc();
  if (password_verify($password, $row['password'])) {
    $_SESSION['username'] = $username;
    header("Location: index.php?status=login");
  } else {
    header("Location: login.php?errCode=2");
  }
?>