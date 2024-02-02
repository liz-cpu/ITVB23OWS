<?php

session_start();

use Hive\Util;
use Hive\Database;

$piece = $_POST['piece'];
$to = $_POST['to'];

$player = $_SESSION['player'];
$board = $_SESSION['board'];
$hand = $_SESSION['hand'][$player];

if (!$hand[$piece]) {
    $_SESSION['error'] = "Player does not have the tile";
} elseif (isset($board[$to])) {
    $_SESSION['error'] = 'Board position is not empty';
} elseif (count($board) && !Util::hasNeighbour($to, $board)) {
    $_SESSION['error'] = "Board position has no neighbor";
} elseif (array_sum($hand) < 11 && !Util::neighboursAreSameColor($player, $to, $board)) {
    $_SESSION['error'] = "Board position has an opposing neighbor";
} elseif (array_sum($hand) <= 8 && $hand['Q']) {
    $_SESSION['error'] = 'Must play queen bee';
} else {
    $_SESSION['board'][$to] = [[$_SESSION['player'], $piece]];
    $_SESSION['hand'][$player][$piece]--;
    $_SESSION['player'] = 1 - $_SESSION['player'];

    $db = Database::getInstance();
    $conn = $db->connect();
    $stmt = $conn->prepare('INSERT INTO moves (game_id, type, move_from, move_to, previous_id, state) VALUES (?, "play", ?, ?, ?, ?)');
    $state = $db->getState();
    $stmt->bind_param('issis', $_SESSION['game_id'], $piece, $to, $_SESSION['last_move'], $state);
    $stmt->execute();

    $_SESSION['last_move'] = $conn->insert_id;
}


header('Location: index.php');
