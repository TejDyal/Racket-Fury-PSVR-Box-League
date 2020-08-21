<?php

// Create connection

function connectToDB ($conn) {
  $servername = "localhost:3306";
  $username = "Normal User";
  $password = "password";
  $conn = new mysqli($servername, $username, $password);
  return $conn;
}

// Check connection
/* if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully";
} */
