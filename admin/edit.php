<?php

include 'db.php';
if (!empty($_POST['nom'])&& !empty($_POST['description'])&& !empty($_POST['id'])) {

    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $id = $_POST['id'];
    $currentid = $_POST['current-id'];
    try{
        $sql = "UPDATE objet SET id = '".$id."' nom = '".addslashes($nom)."$', description = '".addslashes($description)."'  WHERE id = ".$currentid." ";
        $prep = $bdd->prepare($sql);

        $result = $prep->execute();
    } catch(Exception $e){
        print_r($e);
    }
}

else if (!empty($_POST['id'])&& !empty($_POST['titre'])&& !empty($_POST['texte'])) {
    var_dump($_POST);
    if (!empty($_POST['nom']) && !empty($_POST['desc'])) {
        $sql = 'INSERT INTO `categories` ( nom, description ) VALUES ( "'.addcslashes($_POST['nom']).'", "'.addcslashes($_POST['desc']).'" );';
        $prep = $bdd->prepare($sql);
        $prep->execute();
        /*if ($prep->execute()) {
            $erreu_cat = 'Categorie bien enregistrée';
        } else {
            $erreu_cat =  'Une erreur est survenu';
        }*/
    }
    $extensions_valides = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'PNG', 'GIF');
    echo 'ok';
    if (!empty($_FILES['image-first']['name'])) {

        $resultat1 = false;
        $extension_upload = strtolower(substr(strrchr($_FILES['image-first']['name'], '.'), 1));
        if (in_array($extension_upload, $extensions_valides)) {
            $nom = "../public/img/statue/" . $_FILES['image-first']['name'];
            $resultat1 = move_uploaded_file($_FILES['image-first']['tmp_name'], $nom);
        }
    }
    echo 'ok1';
    if (!empty($_FILES['images']['name'][0])) {


        if(!empty($_FILES['image-first']['name'])) {
            $filename = $_FILES['image-first']['name'];
        } else {
            $sql = "SELECT image_name FROM objet WHERE id = ".$_POST['id']." ";
            $query = $bdd->query($sql);
            $filename = $query->execute()[0]['image_name'];
        }


        foreach ($_FILES['images']['name'] as $key => $val) {
            $extension_upload = strtolower(substr(strrchr($_FILES['images']['name'][$key], '.'), 1));

            if (in_array($extension_upload, $extensions_valides)) {

                $nom = "../public/img/statue/" . explode('.', $filename)[0] . '-' . $key . '.' . explode('.', $filename)[1];
                $resultat = move_uploaded_file($_FILES['images']['tmp_name'][$key], $nom);

            } else {
                $erreur = 'Erreur Mauvais format image';
                return 0;
            }
        }
    }
    echo 'ok2';
    if ($_POST['vendu'] == 'on') {
        $vendu='1';

    } else {
        $vendu='0';
    }
    if (!isset($filename)) {

        $filename = $_POST['current-img'];
    }

    $id = $_POST['id'];
    $curent_id = $_POST['current-id'];
    $titre = addslashes($_POST['titre']);
    $texte = addslashes($_POST['texte']);
    $categ = $_POST['categorie'];

    try{
        $sql = "UPDATE objet SET id = '".$id."', titre = '".$titre."', text = '".$texte."', id_categorie = '".$categ."', image_name = '".$filename."', vendu = '".$vendu."'  WHERE id = ".$curent_id." ";
        $prep = $bdd->prepare($sql);
        $result = $prep->execute();
        var_dump($result);
    } catch(Exception $e){
        print_r($e);
    }
    /*if ($result) {
        $erreur .= PHP_EOL . 'Ajout dans la BDD reussi';
    } else {
        $erreur .= PHP_EOL . 'Erreur a l\'ajout dans la BDD :(';
    }*/



}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Africadmin</title>
    <script src="../public/js/jquery-3.1.1.min.js"></script>
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <script src="../public/js/bootstrap.min.js"></script>

    <script src="js/main.js"></script>
</head>
<body>
<header>
    <div class="header-background">
        <h1 class="logo">Africadmin</h1>
        <h3 class="sublogo">Sculture et art Africain</h3>
        <nav class="nav-conteneur">
            <ul class="menu-table">
                <li><a href="../index.php"><img src="../public/img/baseline-home-24px.svg" alt="home">Retour au site</a></li>
                <li><a href="index.php"><img src="../public/img/baseline-email-24px.svg" alt="contact">Ajouter</a></li>
                <?php if(!empty($_GET['cat'])) { ?>
                    <li><a href="edit.php"><img src="../public/img/baseline-email-24px.svg" alt="contact">Editer les Objets</a></li>
                <?php }  else { ?>
                    <li><a href="edit.php?cat=1"><img src="../public/img/baseline-email-24px.svg" alt="contact">Editer les Categories</a></li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</header>
<div class="content">
    <div class="container">

        <?php
        if (!empty($erreur)) {
            echo $erreur;
        }

        if(!empty($_GET['cat']) && !empty($_GET['id'])) {  // modife cate?>
            <form action="" method="post" enctype="multipart/form-data" class="col-6">
                <?php
                $sql = "SELECT * FROM categories WHERE id = " . $_GET['id'] . " ";
                $query = $bdd->query($sql);
                $data = $query->fetch();
                echo '<label>Ordre : <input class="form-control" name="id" type="number" value="' . $data['id'] . '"></label>';
                echo '<label>Titre : <input class="form-control" name="nom" type="text" value="' . $data['nom'] . '"></label><br>';
                echo '<label>Description : </label><textarea class="form-control" name="description" >' . $data['description'] . '</textarea></label>';

                echo '<input type="hidden" name="current-id" value="'.$data['id'].'"><input class="form-control" type="submit" value="Modifier">'
                ?>


            </form>
            <?php
        } else if (!empty($_GET['id'])) { ?>

            <form action="" method="post" enctype="multipart/form-data" class="col-5">
                <?php

                $sql = "SELECT * FROM objet WHERE id = ".$_GET['id']." ";
                $query = $bdd->query($sql);
                $dvendu=false;
                while ($data = $query->fetch()) {
                    $sql = "SELECT * FROM categories ";
                    $query = $bdd->query($sql);
                    $cate_html = "<br><label>Categorie : <select class='form-control' name='categorie'>";
                    while ($data1 = $query->fetch()) {
                        if ($data1['id'] == $data['id_categorie']) {
                            $cate_html .= '<option value="'.$data1['id'].'" selected >'.$data1['nom'].'</option>';
                        } else {
                            $cate_html .= '<option value="' . $data1['id'] . '">' . $data1['nom'] . '</option>';
                        }
                    }
                    $cate_html .= '</select></label>';


                    echo '<label>Ordre : <input class="form-control" name="id" type="number" value="' . $data['id'] . '"></label>';
                    echo '<label>Titre : <input class="form-control" name="titre" type="text" value="' . $data['titre'] . '"></label>';
                    echo '<label>Description : <textarea class="form-control" name="texte" >' . $data['text'] . '</textarea></label>';
                    if ($data['vendu'] == 1) {
                        echo $cate_html.'<label>Vendu : <input class="form-control" name="vendu" type="radio" checked></label>';
                    } else {
                        echo $cate_html.'<label>Vendu : <input class="form-control" name="vendu" type="radio" ></label>';
                    }


                    echo '<img style="max-height:200px;max-width:200px" src="../public/img/statue/' . $data['image_name'] . '" alt=""><label>Premiere image : <input class="form-control"  type="file" name="image-first" value="'.$data['image_name'].'" "></label>';

                    for ($i = 0; $i < 6; $i++) {
                        echo '<img style="max-height:200px;max-width:200px" src="../public/img/statue/' . explode('.', $data['image_name'])[0] . '-' . $i .'.'. explode('.', $data['image_name'])[1] . '" alt="">';
                    }
                    echo '<label>Images secondaire : <input class="form-control"  type="file" name="images[]" "></label><input type="hidden" name="current-id" value="'.$data['id'].'"><input type="hidden" name="current-img" value="' . $data['image_name'] . '">';
                    echo '<input class="form-control" type="submit" value="Modifier"></form>';
                }
                ?>






        <?php }else if(!empty($_GET['cat'])) { ?>

        <h2>Categories</h2>
        <table>
            <tr>

                <th>Titre</th>
                <th>Description</th>
                <th>Editer</th>
                <th>Suprimer</th>
            </tr>
            <?php
            $page = 0;
            if (!empty($_GET['p'])) {
                $page = addslashes($_GET['p']);
            }
            $sql = "SELECT * FROM categories LiMIT ". 50 * $page . ", 50";
            $query = $bdd->query($sql);

            while ($data = $query->fetch()) {
                echo '<tr>';
                echo '<td>' . $data['nom'] . '</td>';
                echo '<td>' . $data['description'] . '</td>';
                echo '<td><a href="edit.php?cat&id=' . $data['id'] . '">Editer</a></td>';
                echo '<td><a class="delete-cat" data-id="' . $data['id'] . '" href="#">Suprimer</a></td>';
                echo '</tr>';
            }
            echo '</table>';

            $sql1 = "SELECT * FROM categories";
            $line = $bdd->query($sql1)->rowCount();
            if ($line>50) {
                for ($b = 1; $b < $line / 50; $b++) {
                    echo '<a href="edit.php?p=' . $b . '&cat=1">Page ' . $b . '</a>';
                }
            }
            } else {

            ///// Not cat
            ?>


            <h2>Objets</h2>
            <table>
                <tr>
                    <th>Image</th>
                    <th>Titre</th>
                    <th>Editer</th>
                    <th>Suprimer</th>
                </tr>
                <?php
                $page = 0;
                if (!empty($_GET['p'])) {
                    $page = addslashes($_GET['p']);
                }
                $sql = "SELECT * FROM objet LiMIT ". 50 * $page . ", 50";

                $query = $bdd->query($sql);

                while ($data = $query->fetch()) {
                    echo '<tr>';
                    echo '<td><img src="../public/img/statue/' . $data['image_name'] . '" alt="" style="max-height: 50px;min-width: 50px"></td>';
                    echo '<td>' . $data['titre'] . '</td>';
                    echo '<td><a href="edit.php?id=' . $data['id'] . '">Editer</a></td>';
                    echo '<td><a class="delete" data-id="' . $data['id'] . '" href="#">Suprimer</a></td>';
                    echo '</tr>';
                }

                echo '</table>';


                $sql1 = "SELECT * FROM objet";
                $line = $bdd->query($sql1)->rowCount();
                if ($line>50) {
                    for ($b = 1; $b < $line / 50; $b++) {
                        echo '<a href="edit.php?p=' . $b . '">Page ' . $b . '</a>';
                    }
                }
                }?>









    </div>
</div>
</body>
</html>
