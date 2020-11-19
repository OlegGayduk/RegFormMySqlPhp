<?php

require_once("db.php");

if(isset($_POST['login']) && isset($_POST['pass'])) {
	if(strlen($_POST['login']) > 0 && strlen($_POST['login']) <= 40) {
	    if(strlen($_POST['pass']) > 0 && strlen($_POST['pass']) <= 40) {

	        $login = htmlspecialchars($_POST['login']);
	        $login = $db->real_escape_string($login);

	        $pass = htmlspecialchars($_POST['pass']);

	        $res = $db->query("SELECT id,pass FROM users_list WHERE login='$login'");

	        if($res->num_rows > 0) {

	        	$row = $res->fetch_assoc();

	        	if(password_verify($pass, $row['pass'])) {

	        		$id = $row['id'];

	        		$options = ['cost' => 12,];

	                $pass = password_hash($pass,PASSWORD_BCRYPT,$options);
                    
                    $res = $db->query("UPDATE users_list SET pass='$pass' WHERE id='$id'");

                    if($res != false) {

                        setcookie("id", $id, time() + 50000);
                        setcookie("pass", $pass, time() + 50000);
    
	        	        header("Location:welcome.php");
	        	    } else {
	        	    	echo "Something went wrong... <a href='../index.php'>Please return to main page and try again!</a>";
	        	    }
	        	} else {
	        		echo "No such user found! <a href='../index.php'>Please check your credentials and try again!</a>";
	        	}
	        } else {
	        	echo "No such user found! <a href='../index.php'>Please check your credentials and try again!</a>";
	        }
	    } else {
	    	echo "Password length is incorrect! <a href='../index.php'>Please return to main page and try again!</a>";
	    }
	} else {
		echo "Email length is incorrect! <a href='../index.php'>Please return to main page and try again!</a>";
	}
} else {
	header("Location:../index.php");
}

?>