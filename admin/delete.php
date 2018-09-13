<?php
include 'db.php';
if (!empty($_GET['id'])) {

    $sql = "DELETE FROM objet WHERE id = ".$_GET['id'];
    $bdd->exec($sql);


} else if (!empty($_GET['cat'])) {
    $sql = "DELETE FROM categories WHERE id = ".$_GET['cat'];
    $bdd->exec($sql);
} else {
    die();
}
?>


