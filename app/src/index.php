<?php

require_once 'vendor/autoload.php';
session_start();

use game\Game;
use core\PageActions;

if (!isset($_SESSION['game']) or $_SESSION['game'] === null) {
    $game = new Game();
    $_SESSION['game'] = serialize($game);
} else {
    $game = unserialize($_SESSION['game']);
    $_SESSION['game'] = serialize($game);
}


$handler = new PageActions($game);
$handler->handleAction();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>The Hive Game</title>
    <meta name="description" content="Play Hive in your browser">
    <meta name="author" content="liz-cpu">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./assets/style.css">
    <link rel="shortcut icon" href="./assets/favicon.ico" type="image/x-icon" />
</head>

<body>
    <div class="container main">
        <h1>🐝Hive🐝</h1>

        <main id="game">
            <?php echo $game->renderBoard(); ?>
        </main>

    </div>
    <aside id="sidebar">
        <?php echo $game->renderSidebar(); ?>
    </aside>
</body>

</html>