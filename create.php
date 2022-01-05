<?php

$note_error = ''; 
$note_success = ''; 
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
    if (isset($_POST['submit'])) { 


        # andmete kontroll
        if (strlen(trim($_POST['question'])) <= 3) {
            $note_error = 'Viga! Küsimus on tühi või liiga lühike.';
        } elseif (strlen(trim($_POST['answer_1'])) == 0) {
            $note_error = 'Viga! Vastus 1 peab olema täidetud.';
        } elseif (strlen(trim($_POST['answer_2'])) == 0) {
            $note_error = 'Viga! Vastus 2 peab olema täidetud.';
        } else { // 
            # lisamine kui ok
            try {

                $new_question = array(
                    'question' => $_POST['question'],
                    'answer_1'  => $_POST['answer_1'],
                    'answer_2'  => $_POST['answer_2'],
                    'answer_3'  => $_POST['answer_3']
                );
    
                $sql = sprintf(
                    'INSERT INTO %s (%s) VALUES (%s)',
                    'polls',
                    implode(', ', array_keys($new_question)),
                    ':' . implode(', :', array_keys($new_question))
                );
    
                $stmt = $pdo->prepare($sql);
                $stmt->execute($new_question);
                $note_success = 'Uus küsimus edukalt salvestatud!';
            } catch (PDOException $error) {
                $note_error = 'Viga andmebaasist kirjutamisel: ' . ('<br /> SQL: <strong>' . $sql . '</strong><br />' . $error->getMessage());
            }
        }
    }
    
?>

<?php require 'templates/header2.php'; ?>

<div class="content update">
	<h2>Loo uus hääletus</h2>
    <form action="create.php" method="post">
        <label for="title">Küsimus</label>
        <input type="text" name="question" id="question" placeholder="Küsimus" required>
        <label for="title">Vastus 1</label>
        <input type="text" name="answer_1" id="answer_1" placeholder="Vastus 1" required>
        <label for="title">Vastus 2</label>
        <input type="text" name="answer_2" id="answer_2" placeholder="Vastus2" required>
        <label for="title">Vastus 3</label>
        <input type="text" name="answer_3" id="answer_3" placeholder="vastus 3" not_required>
        <label name="feedback-success" class="label has-text-primary m-2"> <?php echo $note_success; ?> </label>
            <label name="feedback-feedback$feedback" class="label has-text-danger m-2"> <?php echo $note_error; ?> </label>

            <input type="submit" name="submit" value="Salvesta küsimus" class="button is-link is-fullwidth">
            

    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>


<?php require 'templates/footer.php'; ?>