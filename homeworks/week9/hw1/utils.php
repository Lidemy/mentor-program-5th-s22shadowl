<?php
    require_once('conn.php');
    function getUserFromUsername($username) {
        global $conn;
        $sql = sprintf(
            "select * from s22shadowl_board_users where username ='%s'",
            $username
        );
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        return $row;
    }
?>