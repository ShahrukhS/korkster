<?php
include 'headers/connect_database.php';      // Connection to Mysql Database.
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $sth = $dbh->prepare("SELECT username from users WHERE email=:email");
		$sth->bindValue(':email',$_POST['email']);
		$sth->execute();
		$emailAdd_check = $sth->fetchColumn();
        
        if($emailAdd_check != null || $emailAdd_check != ''){
            echo $emailAdd_check;
        }else{
            echo 'bhens';
        }
}
?>
<html>
    <form action="baby.php" method="post">
        <input type="text" name="username-login" /><p>Username</p>
        <input type="email" name="email" /><p>Email</p>
        <input type="checkbox" name="remember" /><p>Remember me</p>
        <input type="submit" value="Submit" />
    </form>
</html>