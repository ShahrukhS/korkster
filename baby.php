<?php
include 'headers/connect_database.php';      // Connection to Mysql Database.
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$username = $_POST['username-login'];
	$password = $_POST['password-login'];
	$password_md5 = md5($password);
	
    if(isset($_POST['remember'])){
        $varcookie = md5(rand()*1000000000);
        $query = "UPDATE users SET cookie = :cookie WHERE username=:username AND password =:password";
        $sth = $dbh->prepare($query);
        $sth->bindValue(':cookie',$varcookie);
        $sth->bindValue(':username',$username);
        $sth->bindValue(':password',$password_md5);
        $sth->execute();
        $rows = $sth->rowCount();
    }else{
        $query = "SELECT count(*) from users WHERE username=:username AND password =:password";
        $sth = $dbh->prepare($query);
        $sth->bindValue(':username',$username);
        $sth->bindValue(':password',$password_md5);
        $sth->execute();
        $rows = $sth->fetchColumn();
    }
	
	if($rows==1)
	{
		$_SESSION['username'] = $username;
        if(isset($_POST['remember'])){
            setcookie('walknsell_remember', $varcookie, time()+3600 * 24 * 365, '/account', 'www.walknsell.com');
        }
		echo "success";
	}
	else
	{
		echo "incorrect credentials";
	}
}
?>
<html>
    <form action="baby.php" method="post">
        <input type="text" name="username-login" /><p>Username</p>
        <input type="password" name="password-login" /><p>Password</p>
        <input type="checkbox" name="remember" /><p>Remember me</p>
        <input type="submit" value="Submit" />
    </form>
</html>