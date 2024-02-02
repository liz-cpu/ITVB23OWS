<?php

namespace Hive;

session_start();

use Hive\Util;
use Hive\Database;
use Hive\Game;

if (!isset($_SESSION['board'])) {
    header('Location: restart.php');
    exit(0);
}

$game = new Game($_SESSION['board'], $_SESSION['player'], $_SESSION['hand']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Hive</title>
    <style>
        <?php include 'style.css'; ?>
    </style>
</head>

<body>
    <?php $game->renderBoard(); ?>

    <div class="hand">
        White: <?php $game->renderHand(0); ?>
    </div>

    <div class="hand">
        Black: <?php $game->renderHand(1); ?>
    </div>

    <div class="turn">
        Turn: <?php $game->renderTurn(); ?>
    </div>

    <form method="post" action="play.php">
        <select name="piece">
            <?php
            foreach ($hand[$player] as $tile => $ct) {
                echo "<option value=\"$tile\">$tile</option>";
            }
            ?>
        </select>
        <select name="to">
            <?php
            foreach ($to as $pos) {
                echo "<option value=\"$pos\">$pos</option>";
            }
            ?>
        </select>
        <input type="submit" value="Play">
    </form>
    <form method="post" action="move.php">
        <select name="from">
            <?php
            foreach (array_keys($board) as $pos) {
                echo "<option value=\"$pos\">$pos</option>";
            }
            ?>
        </select>
        <select name="to">
            <?php
            foreach ($to as $pos) {
                echo "<option value=\"$pos\">$pos</option>";
            }
            ?>
        </select>
        <input type="submit" value="Move">
    </form>
    <form method="post" action="pass.php">
        <input type="submit" value="Pass">
    </form>
    <form method="post" action="restart.php">
        <input type="submit" value="Restart">
    </form>
    <strong>
        <?php if (isset($_SESSION['error'])) {
            echo $_SESSION['error'];
        }
        unset($_SESSION['error']);
        ?>
    </strong>
    <ol>
        <?php
        $db = Database::getInstance();
        $conn = $db->connect();
        $stmt = $conn->prepare('SELECT * FROM moves WHERE game_id = ' . $_SESSION['game_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_array()) {
            echo '<li>' . $row[2] . ' ' . $row[3] . ' ' . $row[4] . '</li>';
        }
        ?>
    </ol>
    <form method="post" action="undo.php">
        <input type="submit" value="Undo">
    </form>
</body>

</html>