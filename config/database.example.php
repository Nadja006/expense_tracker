<?php

$conn = new mysqli("localhost", "root", "YOUR_PASSWORD", "expense_tracker");
if ($conn->connect_error){
    die("Connection error!");
}


?>