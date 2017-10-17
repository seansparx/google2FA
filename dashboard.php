<?php

session_start();

if(isset($_GET['logout'])) {

    $_SESSION['user_id'] = '';
    header("Location:index.php");
}

if(! ( isset($_SESSION['user_id']) && ($_SESSION['user_id'] > 0) )){
    
    header("Location:index.php");
}

require_once './include/db_connection.php';

$result = mysqli_query($conn, "SELECT full_name, twofa_secret FROM tbl_users WHERE user_id='".$_SESSION['user_id']."' LIMIT 1");

if(mysqli_num_rows($result) > 0) {
    
    $obj = mysqli_fetch_object($result);

}

?>

<html>
    <body>
        <center>
            <h2>Welcome, <?php echo $obj->full_name; ?></h2>

            <?php 
            if(trim($obj->twofa_secret) != '') {
                ?>
                <h3 style="color: green;">Google 2FA Authentication is Active.</h3>
                <p><a href="disable_2fa.php">Disable</a></p>
                <?php
            }
            else{
                ?>
                    <p style="color: red;">You have not activated 2FA Authentication.</p>
                    <h3><a href="activate_2fa.php">Activate 2FA Authentication</a></h3>
                <?php
            }
            ?>

                    <a href="?logout=true">Logout</a>
        </center>
    </body>
</html> 