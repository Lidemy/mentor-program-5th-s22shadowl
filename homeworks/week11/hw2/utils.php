<?php
    require_once('conn.php');
    function getUserFromUsername($username) {
        global $conn;
        $sql = sprintf(
            "select * from s22shadowl_blog_users where username ='%s'",
            $username
        );
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        return $row;
    }
    function escape($str) {
        return htmlspecialchars($str, ENT_QUOTES);
    }
    function updateUserinfo($rowname, $rowvalue) {
        global $conn;
        $sql = "update s22shadowl_blog_users set {$rowname}=? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $rowvalue);
        return $stmt->execute();
    }
?>