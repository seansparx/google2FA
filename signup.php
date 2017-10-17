<?php 
    require_once './include/db_connection.php';

    if($_POST['btn_signup']){
                
        $result = mysqli_query($conn, "SELECT email_address FROM tbl_users WHERE email_address='".$_POST['email_address']."' LIMIT 1");
            
        $obj = mysqli_fetch_object($result);
        
        if($obj->email_address == $_POST['email_address']){
            
            echo('<p style="color:red;">Account Already Exist.</p><br/>');
            die('<a href="signup.php">Signup Again</p>');
        }
        
        else if(mysqli_query($conn, "INSERT INTO tbl_users SET full_name='".$_POST['full_name']."', email_address='".$_POST['email_address']."', password='".md5($_POST['password'])."'")) {
            
            echo('<p style="color:green;">Account Created Successfully..</p><br/>');
            die('<a href="index.php">Go to login</p>');
        }
    }
?>

<center>
    <form action="signup.php" method="post">
        
        Full Name: <input type="text" name="full_name" value="" required="true"/><br/><br/>
        Email    : <input type="email" name="email_address" value="" required="true"/><br/><br/>
        Password : <input type="password" name="password" value="" required="true"/><br/><br/>
        
        <br/><br/>
        <input type="submit" name="btn_signup" value="Sign Up"/>
    </form>
</center>