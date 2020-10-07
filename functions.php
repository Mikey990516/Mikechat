<?php
// sever
$dbsevername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "mikechat";

$conn = mysqli_connect($dbsevername, $dbusername, $dbpassword);

function account_exits() {

	echo("<script type=\"text/javascript\">
		alert(\"Email in use. \");
		window.history.go(-1);
		</script>");
}

function sanitizeString($var) {    
	if (get_magic_quotes_gpc())

		$var = stripsloashes($var);   
	$var = htmlentities($var);    
	$var = strip_tags($var); 

	if (strlen($var) > 400 ) {
		echo"Charachter break";
		die("fatal error"); 
	}
	$var = addslashes($var);
	return $var; 
}

function message_information_missing() {
	echo("<script type=\"text/javascript\">
		alert(\"Information missing\");
		</script>");
}

function check_if_empty($var) {
	if (empty($var)) {
		message_information_missing();
		redirect_back();
		die();
	}
}

function critical_check($var){
	if (!isset($_POST[$var])) {
		die("$var not found");
	}
}

function create_account($varconn,$table,$email,$email_info,$name,$name_info,$security_key,$security_key_info) {

	setcookie("email","$email_info",time()+31556926 ,'/');

	$query = "SELECT * FROM $table WHERE $email = '$email_info';";

	$result = mysqli_query($varconn, $query) or die(mysqli_error($varconn));

	$row = mysqli_num_rows($result);
	if ($row !== 0) {
		account_exits();
		exit();
	}

	$query = "INSERT INTO $table ($email,$name,$security_key,account_state) VALUES ('$email_info','$name_info','$security_key_info','1');";

	$result = mysqli_query($varconn, $query) or die(mysqli_error($varconn));

	account_created();

}
