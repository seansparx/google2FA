<?php

session_start();

if(! ( isset($_SESSION['user_id']) && ($_SESSION['user_id'] > 0) )){
    
    header("Location:index.php");
}

?>
<html>
    <body>
    <center>
        <h2>Google 2FA Authentication</h2>
        <a href="step_1.php"><img width="" src="img/2fa.png" title="Click to Configure"/></a>
        </br><br/>
        Make sure "Google Authenticator" app is install on your mobile device. If not <a target="_blank" href="https://support.google.com/accounts/answer/1066447?co=GENIE.Platform%3DAndroid&hl=en">install Google Authenticator</a> First.
        <h3><a href="step_1.php">Activate</a></h3>
        
        <br/><br/><h3>Steps :</h3>
        <br/>1. Install Google Authenticator on your mobile device. <a target="_blank" href="https://support.google.com/accounts/answer/1066447?co=GENIE.Platform%3DAndroid&hl=en">Need help?</a>
        <br/><br/>2. Scan QR Code ( will generates in next step ) using Google Authenticator mobile app.
        <br/><br/>3. Enter 6 digit code which showing in your google authenticator mobile app ( after setup ).
        <br/><br/>4. Click on verify button.
    </center>
    </body>
</html>