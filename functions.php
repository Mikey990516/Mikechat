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
