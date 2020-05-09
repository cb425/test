<?php
session_start();

include("account.php");
$ai = array('hostname'=>$hostname,'username'=>$username,'mysqlpw'=>$mysqlpw,'project'=>$project);
$email = $_SESSION["email"];

function splitSkillList($list){
  $skillList=split(',',$list);
  return $skillList;
}

function displayQuestions($email, $ai){
  $db = mysqli_connect($ai['hostname'], $ai['username'], $ai['mysqlpw'], $ai['project']) or die("Unable to connect to DB");
  $s = "SELECT * FROM Questions where email='$email'";  
  $t = mysqli_query($db, $s) or die("Bad Query");
  $qTable = "<center><table class='table' style=\"table-layout: fixed; width: 70%;word-wrap: break-word\">";
  $qTable.="<tr><th>Name</th><th>Body</th><th>Skills</th></tr>";
  foreach($t as $q){
    $qTable.="<tr><td>".$q['name']."</td>";
    $qTable.="<td>".$q['body']."</td>";
    //$qTable.="<td>".$q['skills']."</td></tr>";
    $skillList = splitSkillList($q['skills']);
    $qTable.='<td>';
    foreach($skillList as $skill){
       $qTable.=$skill.'</br>';
    }
    $qTable.='</td>';
  }
  $qTable.="</table></center>";
  return $qTable;
}

function getFullName($email,$ai){
  $db = mysqli_connect($ai['hostname'], $ai['username'], $ai['mysqlpw'], $ai['project']) or die("Unable to connect to DB");
  mysqli_select_db($db, "sfg4");
  $s = "SELECT * FROM Users where email='$email'";  
  $t = mysqli_query($db, $s) or die("Bad Query");
  $fullName = "";
  foreach($t as $account){
    $fName = $account['firstName'];
    $lName = $account['lastName'];
    
    $fullName = $fName." ".$lName;
  }
  return $fullName;
}
?>


<html>
<head>
 <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Hello, world!</title>

</head>
<body class="bg-info">
<div class="container">


<center><h2>Current User: <b><?php echo getFullName($email,$ai); ?></b></h2></center>
</br>
<h4>
<center><b>Question List</b></center>
</h4>
</br>
<?php echo displayQuestions($email,$ai); ?>

</br></br>


<center>

<form action="qform.html">
    <input class="btn btn-dark" type="submit" value="Add Question" />
</form>

</center>
</div>
</body>
</html>