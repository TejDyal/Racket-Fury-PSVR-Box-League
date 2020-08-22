<?php

//connect to db
$servername = "localhost:3306";
$username = "Normal User";
$pwd = "password";
$db = "rf_league_db";
$conn = mysqli_connect($servername, $username, $pwd, $db);

$result = mysqli_query($conn, "SELECT serverName FROM server");
    if(mysqli_num_rows($result)> 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo $row["serverName"];
            //array_push($serverArray, $row["Server_id"]);
        }
    }

?>