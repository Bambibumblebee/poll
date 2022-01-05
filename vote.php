<?php
include 'functions.php';
$note_error = ''; 
$pdo = pdo_connect_mysql();

if (isset($_GET['id'])) {
$id = $_GET['id'];
    $stmt = $pdo->prepare('SELECT * FROM polls WHERE id =' . $id);
    $stmt->execute([ $_GET['id'] ]);
    $poll = $stmt->fetch(PDO::FETCH_ASSOC);
} 

try {
    
    $sql = 'SELECT COUNT(*) as total FROM poll_answers WHERE id_a =' . $id;
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $answers = $stmt->fetch(PDO::FETCH_ASSOC);
    $total = $answers['total'];

} catch (PDOException $error) {
    if (empty($total)) {
        $note_error = 'Viga andmebaasist lugemisel: ' . ('<br /> SQL: <strong>' . $sql . '</strong><br />' . $error->getMessage());
    }
}
?>

<?php require 'templates/header.php';?>
<div class="content poll-vote">
	<h2><?=$poll['question']?></h2>

   <form >
 

        <label>
        <input type="radio" id="answer_1" name="answer_1" value="1" onclick="location.href='result.php?id=<?=$poll['id'];?>&answer=1'">
    <label class="radio has-text-weight-bold" for="answer_1"> <?php echo ($poll['answer_1']); ?> </label><br>
    <input type="radio" id="answer_2" name="answer_2" value="2" onclick="location.href='result.php?id=<?=$poll['id'];?>&answer=2'">
    <label class="radio has-text-weight-bold" for="answer_2"> <?php echo ($poll['answer_2']); ?> </label><br>
    <!-- 3 küsimust -->
    <?php if (strlen(trim($poll['answer_3'])) != 0) {
    ?>
    <input type="radio" id="answer_3" name="answer_3" value="3" onclick="location.href='result.php?id=<?=$poll['id'];?>&answer=3'">
    <label class="radio has-text-weight-bold" for="answer_3"> <?php echo ($poll['answer_3']); ?> </label>

            
<?php
}

?>
    <p class="is-italic"> Küsitluses on osalenud <?php echo $total ?> inimest.</p>



<?php require 'templates/footer.php';?>