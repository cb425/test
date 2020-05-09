<?php
session_start();
include("account.php");
$email = $_GET['email'];
$password = $_GET['password'];

$loginValid = true;

if(empty($email)){
  echo "Please enter an email.<br/>";
  $loginValid = false;
}
if(strpos($email,'@')== false){
  echo "ERROR: Invalid Email<br/>";
  $loginValid = false;
}
if(empty($password)){
  echo "Please enter an password.<br/>";
  $loginValid = false;
}
if(strlen($password)<8){
  echo "ERROR: Password is too short.<br/>";
  $loginValid = false;
}

if($loginValid){  
  $db = mysqli_connect($hostname, $username, $mysqlpw, $project) or die("Unable to connect to DB");
  mysqli_select_db($db, "sfg4");
  $s = "SELECT * FROM Users WHERE email='$email' AND password='$password'";  
  $t = mysqli_query($db, $s) or die("Bad Query");
  
  $confirmation = mysqli_num_rows($t);
  
  if($confirmation==1){
    $_SESSION['email'] = $email;
    header("Location: homepage.php");
  } else {
    header("Location: index.html");
  }
  
  echo "Email: $email<br/>";
  echo "Password: $password<br/>";
  
}

?>