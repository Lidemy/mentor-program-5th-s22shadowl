<?php
    require_once('conn.php');
    function getUserFromUsername($username) {
        global $conn;
        $sql = "SELECT * FROM s22shadowl_blog_users WHERE username=?";
        $stmt->bind_param('i', $username);
        $result = $stmt->execute();
        if (!$result) {
            die('Error:' . $conn->error);
        }
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row;
    }
    function escape($str) {
        return htmlspecialchars($str, ENT_QUOTES);
    }
    function updateUserinfo($rowname, $rowvalue) {
        global $conn;
        $sql = "UPDATE s22shadowl_blog_users SET {$rowname}=? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $rowvalue);
        return $stmt->execute();
    }
?>