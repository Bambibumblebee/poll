<?php
include 'functions.php';

$pdo = pdo_connect_mysql();
//adminnile vastuste vaatamiseks
require 'templates/header2.php';

$msg = ''; 

$ip_error = false; 

// IP muutujasse
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

if (isset($_GET['id']) && $_GET['id'] != '') { 
    $id = $_GET['id'];

   
    try {
        $sql = 'SELECT COUNT(*) AS total FROM polls WHERE id =' . $id;
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $total = $stmt->fetch(PDO::FETCH_ASSOC);
        $total = $total['total'];
     
    } catch (PDOException $error) {
        $msg = 'Viga andmebaasist lugemisel: ' . ('<br /> SQL: <strong>' . $sql . '</strong><br />' . $error->getMessage());
    }

    if ($total == 1) { 
        
        if (isset($_GET['answer']) && $_GET['answer'] != '') { 
            $answer = $_GET['answer'];
            
                try {
                    $sql = 'SELECT answer_3 FROM polls WHERE id =' . $id;
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $answer_3_Ok = $stmt->fetch(PDO::FETCH_ASSOC);
                    $answer_3_Ok = $answer_3_Ok['answer_3'];
             
                } catch (PDOException $error) {
                    $msg = 'Viga andmebaasist lugemisel: <br /> ' . ($error->getMessage());
                }

                if ($answer == 3 && $answer_3_Ok == '') { 
                    $msg = 'Selline vastusevariant nagu URL-is märgitud ei ole võimalik!';
                } else {

                    if ($answer == 1 || $answer == 2 || $answer == 3) {

                        try {
                            $sql = 'INSERT INTO poll_answers (poll_id, answer, ip) VALUES (' . $id . ', ' . $answer . ', ' . $ip . '")';
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute();
                            $msg = 'Vastus edukalt salvestatud!';
                        } catch (PDOException $error) {
                            $msg = 'Viga andmebaasi kirjutamisel: ' . ('<br /> SQL: <strong>' . $sql . '</strong><br />' . $error->getMessage());
                        }
                    } else { 
                        $msg = 'URL-is vastuse id vale';
                    }
                }
        }

        try {

            $sql = 'SELECT p.id, p.question, p.answer_1, p.answer_2, p.answer_3, pa.answer FROM polls AS p LEFT JOIN poll_answers AS pa ON id WHERE p.id =' . $id;
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();

        } catch (PDOException $error) {
            $msg = 'Viga andmebaasist lugemisel: ' . ('<br /> SQL: <strong>' . $sql . '</strong><br />' . $error->getMessage());
        }
    } else {
        $msg = 'URL-is oleva id-ga hääletust ei ole andmebaasis';
    }
} else {
    $msg = 'URL-is küsimuse id puudu';
}

if ($msg != '') {
?>
    <div class = "content delete">
        <h2><?php echo $msg ?></h2>
        <div class="yesno">
        <a onclick="location.href='index.php'">Avalehele</a>
        </div>
    </div>
<?php
}
if ($msg == '') { 
    $total = 0;
    $answer_1 = 0;
    $answer_2 = 0;
    $answer_3 = 0;

    for ($i = 0; $i < count($result); $i++) {
        if ($result[$i]['answer'] == 1) {
            $answer_1++;
            $total++;
        }
        if ($result[$i]['answer'] == 2) {
            $answer_2++;
            $total++;
        }
        if ($result[$i]['answer'] == 3) {
            $answer_3++;
            $total++;
        }
    }
    $rel_answer_1 = ($total != 0) ? round($answer_1 / $total * 100) : 0;
    $rel_answer_2 = ($total != 0) ? round($answer_2 / $total * 100) : 0;
    $rel_answer_3 = ($total != 0) ? round($answer_3 / $total * 100) : 0;
?>

    <div class="content poll-result">
        <h2><?php echo ($result[0]['question']); ?></h2>
        <p> Küsitluses on osalenud <?php echo $total ?> inimest.</p>
        <div class="wrapper">
            <div class="poll-question">
                <p><?php echo ($result[0]['answer_1']); ?> (<?php echo $answer_1;
                        echo ($answer_1 == 1) ? ' vastaja' : ' vastajat' ?>)</p>
                <div class="result-bar" style= "width:<?= ($rel_answer_1) ?>%">
                    <?=($rel_answer_1)?>%
                </div>
                <p><?php echo ($result[0]['answer_2']); ?>  (<?php echo $answer_2;
                        echo ($answer_2 == 1) ? ' vastaja' : ' vastajat' ?>) </p>
                <div class="result-bar" style= "width:<?= ($rel_answer_2) ?>%">
                    <?=($rel_answer_2)?>%
                </div>
                <?php if (strlen(trim($result[0]['answer_3'])) > 0) {
                ?>
                <p><?php echo ($result[0]['answer_3']); ?> (<?php echo $answer_3;
                        echo ($answer_2 == 1) ? ' vastaja' : ' vastajat' ?>) </p>
                <div class="result-bar" style= "width:<?=($rel_answer_3)?>%">
                    <?=($rel_answer_3)?>%
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
<?php
}
?>

<?php require 'templates/footer.php'; ?>