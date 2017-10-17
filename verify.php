<?php
//4P3PX573LFE2HYZQ    
        session_start();

        if(! ( isset($_SESSION['user_id']) && ($_SESSION['user_id'] > 0) )){

            header("Location:index.php");
        }
        
        require_once './include/GoogleAuthenticator.php';
        require_once './include/db_connection.php';

        $ga = new GoogleAuthenticator();

        $secret = $_SESSION['2fa_secret'];
        
        
        $error = '';
        
        if(isset($_POST['btn_verify'])) {
            
            $oneCode = $_POST['verification_code'];
            
            $checkResult = $ga->verifyCode($secret, $oneCode, 2);    // 2 = 2*30 sec clock tolerance
            
            if ($checkResult) {
                
                if(mysqli_query($conn, "UPDATE tbl_users SET twofa_secret='".$secret."' WHERE user_id='".$_SESSION['user_id']."'")) {

                    echo('<center><p style="color:green;">2FA has been activated successfully..</p>');
                    die('<a href="dashboard.php">Go to Dashboard.</p></center>');
                }
            } 
            else {

                $error = '<p style="color:red;">Incorrect Verification Code.</p>';
            }
        }

        //

        //

        //echo "Checking Code '$oneCode' and Secret '$secret':\n<br/>";

        
        
        
    
        if(isset($_POST['btn_next']) || isset($_POST['btn_verify'])) {

            ?>
                <br/><br/>
                <center>
                    <?php echo $error; ?>
                    <form method="post" action="verify.php">

                        Enter Verification Code : <input type="text" name="verification_code" width="100" value=""/>
                        <input value="Verify" name="btn_verify" type="submit"/>
                    </form>
                </center>                
            <?php
        }
        else{

            header("Location:dashboard.php");
        }
?>
