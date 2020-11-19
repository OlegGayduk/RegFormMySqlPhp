<?php

require_once("db.php");

if(isset($_COOKIE['id']) && isset($_COOKIE['pass'])) {

	$id = $_COOKIE['id'];

	$res = $db->query("SELECT pass FROM users_list WHERE id='$id'");

	if($res->num_rows > 0) {

		$row = $res->fetch_assoc();

		if($row['pass'] == $_COOKIE['pass']) {

	        $res = $db->query("SELECT alias FROM users_list WHERE id='$id'");
        
	        if($res->num_rows > 0) {
	        	$row = $res->fetch_assoc();
        
                echo "<h1> Welcome, ".$row['alias']."!</h1>
                <p><a href='log_out.php'>Выйти</a></p>";
	        } else {
	        	header("Location:../index.php");
	        }

	    } else {
	    	setcookie("id", "", time() - 50000); 				
            setcookie("pass", "", time() - 50000);

            header("Location:../index.php");
	    }
	} else {
		setcookie("id", "", time() - 50000); 				
        setcookie("pass", "", time() - 50000);	

        header("Location:../index.php");
	}
} else {
	header("Location:../index.php");
}

?>