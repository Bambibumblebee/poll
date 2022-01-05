<?php
/** Muudab HTML märgid turvaliseks */
function escape($html) {
    return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Näita massiivi inimlikul kuju */
function show($array) {
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}
?>