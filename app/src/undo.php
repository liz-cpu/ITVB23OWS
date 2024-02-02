<?php
namespace Hive;
session_start();

use Hive\Database;

$db = Database::getInstance();
$conn = $db->connect();
$stmt = $conn->prepare('SELECT * FROM moves WHERE id = ' . $_SESSION['last_move']);
$stmt->execute();
$result = $stmt->get_result()->fetch_array();
$_SESSION['last_move'] = $result[5];
$db->setState($result[6]);
header('Location: index.php');
