<?php

    session_start();

    if(! ( isset($_SESSION['user_id']) && ($_SESSION['user_id'] > 0) )){

        header("Location:index.php");
    }
    
    require_once './include/GoogleAuthenticator.php';
    require_once './include/db_connection.php';

    $ga = new GoogleAuthenticator();
    $secret = $ga->createSecret(); 

    $qrCodeUrl = $ga->getQRCodeGoogleUrl('SeanRock', $secret);
    $oneCode = $ga->getCode($secret);

    echo '<br/><br/>';
    echo '<center>';
    echo '<h2>Activate Google 2FA</h2>';
    echo '<h4>Scan QR Code using your 2FA Authenticator mobile App</h4>';
    echo "<img src='".$qrCodeUrl."'/><br/><br/>";
    echo "16 Digit Secret Code : " . $secret . "\n\n<br/>";
    
    echo '<br/><small style="color:red;">Note: Take a print out of this page or Write down your 16 digit secret code, and keep it safe,<br/> It will be needed in case you want to setup on diffrent mobile device.</small>';
        
    $_SESSION['2fa_secret'] = $secret; // Store into database.
    
    echo '</center>';
?>

<br/><br/>
<center>
    <form method="post" action="verify.php">
        <input value="Next" name="btn_next" type="submit"/>
    </form>
</center>


