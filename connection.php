<?php
$dbHost = '192.168.1.3';
$dbUser = 'admin';
$dbPass = 'admin';
$dbName = 'Website';

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
}

