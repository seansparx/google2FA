<?php

    session_start();

    if(! ( isset($_SESSION['user_id']) && ($_SESSION['user_id'] > 0) )){

        header("Location:index.php");
    }
    
    require_once './include/db_connection.php';

    if(mysqli_query($conn, "UPDATE tbl_users SET twofa_secret='' WHERE user_id='".$_SESSION['user_id']."'")){

        echo('<p style="color:green;">2FA Authentication has been disabled successfully..</p><br/>');
        header("Location:dashboard.php");
    }

?>