<?php
namespace Hive;
session_start();

use Hive\Database;

$db = Database::getInstance();
$conn = $db->connect();
$stmt = $conn->prepare('insert into moves (game_id, type, move_from, move_to, previous_id, state) values (?, "pass", null, null, ?, ?)');
$state = $db->getState();
$stmt->bind_param('iis', $_SESSION['game_id'], $_SESSION['last_move'], $state);
$stmt->execute();
$_SESSION['last_move'] = $conn->insert_id;
$_SESSION['player'] = 1 - $_SESSION['player'];

header('Location: index.php');
