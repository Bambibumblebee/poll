<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// ID olemas
if (isset($_GET['id'])) {
    // ID kustutamiseks
    $stmt = $pdo->prepare('SELECT * FROM polls WHERE id = ?');
    $stmt->execute([ $_GET['id'] ]);
    $poll = $stmt->fetch(PDO::FETCH_ASSOC);
    // Küsi esmalt
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            
            $stmt = $pdo->prepare('DELETE FROM polls WHERE id = ?');
            $stmt->execute([ $_GET['id'] ]);
            $stmt = $pdo->prepare('DELETE FROM poll_answers WHERE id_a = ?');
            $stmt->execute([ $_GET['id'] ]);

            $msg = 'Edukalt kustutatud!';
        } else {
            header('Location: index.php');
            exit;
        }
    }
} else {
    exit('ID täpsustamata!');
}
?>
<?php require 'templates/header2.php';?>
<div class="content delete">
	<h2>Kustusta hääletus #<?=$poll['id']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Kas oled kindel, et tahad kustutada #<?=$poll['id']?>?</p>
    <div class="yesno">
        <a href="delete.php?id=<?=$poll['id']?>&confirm=yes">Jah</a>
        <a href="delete.php?id=<?=$poll['id']?>&confirm=no">Ei</a>
    </div>
    <?php endif; ?>
</div>
<?php require 'templates/footer.php';?>