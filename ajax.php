<?php

if ($_POST['id']) {
    include 'admin/db.php';

    $sql = "SELECT text FROM objet WHERE id = ".addslashes($_POST['id']).' ';
    echo $bd->query($sql)->fetch()['text'];
}
