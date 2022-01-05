<?php

include 'functions.php';
// ühenda
$pdo = pdo_connect_mysql();
//MySQL küsitluste ja vastuste jaoks
$stmt = $pdo->query('SELECT p.*, GROUP_CONCAT(pa.poll_id ORDER BY pa.id_a) AS answers FROM polls p LEFT JOIN poll_answers pa ON pa.id_a = p.id GROUP BY p.id');
$polls = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php require 'templates/header.php';?>


<div class="content home">
	<h2>Hääletused</h2>
	<p>Siin saad näha enda küsitlust, vaadata tulemusi ja avades küsitluse, siis ka vastata.</p>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Küsimus</td>
				<td>Vastus 1</td>
                <td>Vastus 2</td>
                <td>Vastus 3</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
        <?php $jrk = + 1; ?>
            <?php foreach($polls as $poll): ?>
            <tr>
                <td><?=$jrk?></td>
                <td><?=$poll['question']?></td>
				<td><?=$poll['answer_1']?></td>
                <td><?=$poll['answer_2']?></td>
                <td><?=$poll['answer_3']?></td>
                <td class="actions">
                <a href="result.php?id=<?=$poll['id']?>" class="view" title="Vaata tulemusi"><i class="fas fa-eye fa-xs"></i></a>
					<a href="vote.php?id=<?=$poll['id']?>" class="fas fa-poll-h" title="Hääleta"><i class="fas fa-eye fa-xs"></i></a>

                </td>
            </tr>
            <?php $jrk++;?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require 'templates/footer.php';?>