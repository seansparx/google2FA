<?php 
    
    session_start();
    
    if( isset($_SESSION['user_id']) && ($_SESSION['user_id'] > 0) ){

        header("Location:dashboard.php");
    }

    require_once './include/GoogleAuthenticator.php';
    require_once './include/db_connection.php';
    
    if(isset($_POST['btn_verify_code'])) {
        
            $ga = new GoogleAuthenticator();
            
            $secret  = $_SESSION['twofa_secret'];
            $oneCode = $_POST['verification_code'];
            
            $checkResult = $ga->verifyCode($secret, $oneCode, 2);    // 2 = 2*30 sec clock tolerance
            
            if ($checkResult) { // Login Success with 2FA.
                
                $result = mysqli_query($conn, "SELECT user_id, full_name, email_address FROM tbl_users WHERE twofa_secret='".$secret."' LIMIT 1");
            
                if(mysqli_num_rows($result) > 0) {
                    
                    $obj = mysqli_fetch_object($result);

                    $_SESSION['user_id']   = $obj->user_id;
                    $_SESSION['full_name'] = $obj->full_name;

                    header("Location:dashboard.php");
                }
            } 
            else {

                ?>
                <br/><br/>
                <center>
                    <center><p style="color:red;">Incorrect Verification Code.</p></center>
                    <form method="post" action="index.php">
                        Enter 2FA Code : <input type="text" name="verification_code" width="100" value=""/>
                        <input value="Verify" name="btn_verify_code" type="submit"/>
                    </form>
                </center>    
                <?php
            }
        
    }
    else if(isset ($_POST['btn_login'])) {
                
        $result = mysqli_query($conn, "SELECT user_id, full_name, email_address, twofa_secret FROM tbl_users WHERE email_address='".$_POST['email_address']."' AND password='".md5($_POST['password'])."' LIMIT 1");
            
        $obj = mysqli_fetch_object($result);
        
        if(! mysqli_num_rows($result) > 0){
            
            die('<a href="index.php">Incorrect Login or Password, Try Again</p>');
        }
        else if(trim($obj->twofa_secret) != '') {
            
            $_SESSION['twofa_secret'] = $obj->twofa_secret;

            ?>
            <br/><br/>
            <center>
                <form method="post" action="index.php">
                    Enter 2FA Code : <input type="text" name="verification_code" width="100" value=""/>
                    <input value="Verify" name="btn_verify_code" type="submit"/>
                </form>
            </center>    
            <?php
        }
        else {
            
            $_SESSION['user_id']   = $obj->user_id;
            $_SESSION['full_name'] = $obj->full_name;
            
            header("Location:dashboard.php");
        }
    }
    else{
        ?>
            <br/>
            <center>
                <h2>Please Login : </h2>
                <form action="index.php" method="post">

                    Email    : <input type="email" name="email_address" value="" required="true"/><br/><br/>
                    Password : <input type="password" name="password" value="" required="true"/><br/><br/>        
                    <br/>
                    <input type="submit" name="btn_login" value="Login"/>
                    <a href="signup.php"> Create Account </a>
                </form>
            </center>
        <?php
    }
?>
