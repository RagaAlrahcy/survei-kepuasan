<?php
$mysqli = new mysqli("localhost", "root", "", "speak_production");
if ($mysqli->connect_errno) {
    die("Conn failed: " . $mysqli->connect_error);
}

$res = $mysqli->query("SHOW TABLES");
while ($row = $res->fetch_row()) {
    echo $row[0] . "\n";
}
$mysqli->close();
