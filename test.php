<?php

$servername = "sql1.njit.edu";// you need to put your assigned server name
$username = "cb425";// your ucid
$password = "Megurine123/";// database password
$dbname = "cb425"; // your ucid is your database name

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
    echo "<br>";

    $query = 'SELECT * FROM accounts where id < 6';
    $statement = $conn ->prepare($query);
    $statement->execute();
    $accounts = $statement->fetchAll();
    $statement->closeCursor();

    echo "<table width = 45%; border = 1px>
        <tr>
            <th>id</th>
            <th>email</th>
            <th>fname</th>
            <th>lname</th>
            <th>phone</th>
            <th>birthday</th>
            <th>gender</th>
            <th>password</th>
            
            
        </tr>";

    foreach ($accounts as $result) {
        echo "<tr>
                    <td>".$result["id"]."</td>
                    <td>".$result["email"]."</td>
                    <td>".$result["fname"]."</td>
                    <td>".$result["lname"]."</td>
                    <td>".$result["phone"]."</td>
                    <td>".$result["birthday"]."</td>
                    <td>".$result["gender"]."</td>
                    <td>".$result["password"]."</td>
               </tr>";
    }

    echo "<br>". 'There are '.count($accounts).' record(s) with a user ID less than 6 characters';
    echo "<br><br>";
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();

}
?>