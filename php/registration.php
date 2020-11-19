<?php 

require_once("db.php");

if(isset($_POST['login']) && isset($_POST['pass']) && isset($_POST['alias'])) {
	if(strlen($_POST['login']) > 0 && strlen($_POST['login']) <= 40) {

		if(preg_match("/[0-9a-z]+@[a-z]/",$_POST['login'])) {

	        $login = htmlspecialchars($_POST['login']);
	        $login = $db->real_escape_string($login);

	        $res = $db->query("SELECT login FROM users_list WHERE login='$login'");

	        if($res->num_rows > 0) exit("This login is already taken! <a href='registr.php'>Please come up with new login, return to registration page and try again!</a>");

	        if(strlen($_POST['pass']) >= 8 && strlen($_POST['pass']) <= 40) {
	        	if(strlen($_POST['alias']) > 0 && strlen($_POST['alias']) <= 12) {
	        		
	                $pass = htmlspecialchars($_POST['pass']);
	                $pass = $db->real_escape_string($pass);

	                $alias = htmlspecialchars($_POST['alias']);
	                $alias = $db->real_escape_string($alias);

	                $options = ['cost' => 12,];

	                $pass = password_hash($pass,PASSWORD_BCRYPT,$options);

                    $res = $db->query("INSERT INTO users_list(login,pass,alias) VALUES ('$login','$pass','$alias')");

                    if($res != false) {
                        $res = $db->query("SELECT id FROM users_list WHERE login='$login' AND pass='$pass'");

                        if($res->num_rows > 0) {
                        	$row = $res->fetch_assoc();

                        	setcookie("id", $row['id'], time() + 50000);
                        	setcookie("pass", $pass, time() + 50000);

                        	header("Location:welcome.php");
                        } else {
                        	echo "Something went wrong... <a href='registr.php'>Please return to registration page and try again!</a>";
                        }
                    } else {
                    	header("Location:registr.php");
                    }
	        	} else {
	        		echo "Alias length is incorrect! <a href='registr.php'>Please return to registration page and try again!</a>";
	        	}
	        } else {
	        	echo "Password length is incorrect! <a href='registr.php'>Please return to registration page and try again!</a>";
	        }
	    } else {
	    	echo "Email format is incorrect! <a href='registr.php'>Please return to registration page and try again!</a>";
	    }
	} else {
		echo "Email length is incorrect! <a href='registr.php'>Please return to registration page and try again!</a>";
	}
} else {
	header("Location:registr.php");
}

?>