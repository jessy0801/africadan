<?php
include 'db.php';
//$bdd = new PDO('mysql:host=localhost;dbname=africa', 'africa', 'dLyw3C8WsaXXbwyg');
//var_dump($_FILES);
if (!empty($_POST)) {

    if (!empty($_POST['nom']) && !empty($_POST['desc'])) {
        $sql = 'INSERT INTO `categories` ( nom, description ) VALUES ( "'.$_POST['nom'].'", "'.$_POST['desc'].'" );';
        $prep = $bdd->prepare($sql);
        $prep->execute();
        /*if ($prep->execute()) {
            $erreu_cat = 'Categorie bien enregistrée';
        } else {
            $erreu_cat =  'Une erreur est survenu';
        }*/
    }

    $extensions_valides = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'PNG', 'GIF');

    //1. strrchr renvoie l'extension avec le point (« . »).
    //2. substr(chaine,1) ignore le premier caractère de chaine.
    //3. strtolower met l'extension en minuscules.
    $resultat1=false;
    $extension_upload = strtolower(substr(strrchr($_FILES['image-first']['name'], '.'), 1));
    if (in_array($extension_upload, $extensions_valides)) {
        $nom = "/var/www/html/africa2/public/img/statue/".$_FILES['image-first']['name'];
        chmod($nom, 0755);
        $resultat1 = move_uploaded_file($_FILES['image-first']['tmp_name'],$nom);
    }
    if (!empty($_FILES['image']['name'][0])) {
        foreach ($_FILES['image']['name'] as $key => $val) {
            $extension_upload = strtolower(substr(strrchr($_FILES['image']['name'][$key], '.'), 1));

            if (in_array($extension_upload, $extensions_valides)) {
                $filename = $_FILES['image-first']['name'];
                $nom = "/var/www/html/africa2/public/img/statue/" . explode('.', $filename)[0] . '-' . $key . '.' . explode('.', $filename)[1];


                chmod($nom, 0755);
                $resultat = move_uploaded_file($_FILES['image']['tmp_name'][$key], $nom);
                var_dump($resultat);
                if ($resultat && $resultat1) {
                    $erreur = "Transfert réussi";


                } else {
                    $erreur = 'Erreur upload';
                    /*return 0;*/
                }

            } else {
                $erreur = 'Erreur Mauvais format image';
                return 0;
            }
        }
    }
    if ($resultat1) {
        $filename = $_FILES['image-first']['name'];
        if ($_POST['vendu']) {
            $vendu=1;
        } else {
            $vendu=0;
        }

        $sql = 'INSERT INTO `objet` ( titre, text, id_categorie, image_name, vendu ) VALUES ( "' . addslashes($_POST['titre']) . '", "' . addslashes($_POST['texte']) . '", "' . addslashes($_POST['categorie']) . '", "' . addslashes($filename) . '", "' .$vendu . '" );';
        $prep = $bdd->prepare($sql);
        $result = $prep->execute();
        if ($result) {
            $erreur .= PHP_EOL . 'Ajout dans la BDD reussi';
        } else {
            $erreur .= PHP_EOL . 'Erreur a l\'ajout dans la BDD :(';
        }
    }



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
    <!--<link rel="stylesheet" href="css/main.css">-->
    <script src="../public/js/index.js"></script>
</head>
<body>
<header>
    <div class="header-background">
        <h1 class="logo">Africadmin</h1>
        <h3 class="sublogo">Sculture et art Africain</h3>
        <nav class="nav-conteneur">
            <ul class="menu-table">
                <li><a href="../index.php"><img src="../public/img/baseline-home-24px.svg" alt="home">Retour au site</a></li>
                <li><a href="edit.php"><img src="../public/img/baseline-email-24px.svg" alt="contact">Editer</a></li>

            </ul>
        </nav>
    </div>
</header>
<div class="content">
    <div class="container">
        <h2 class="content-titre">Ajouter un Objet</h2>
        <?php
        if(!empty($erreur)) {
            echo $erreur;
        }
        ?>
        <form action="" method="post" enctype="multipart/form-data" class="col-5">
            <label  for="titre">Titre : </label>
            <input class="form-control" type="text" id="titre" name="titre">

            <label  for="texte">Texte : </label>
            <textarea  class="form-control" name="texte" id="texte" cols="30" rows="10"></textarea>

            <label  for="categorie">Categorie : </label>
            <select id="categorie" name="categorie">
                <?php
                $sql = 'SELECT * FROM categories';
                $query = $bdd->query($sql);
                while ($data = $query->fetch()) {
                    echo '<option value="'.$data['id'].'">'.$data['nom'].'</option>';
                }
                ?>

            </select><br>

            <label  for="vendu">Vendu : </label>
            <input  type="checkbox" id="vendu" name="vendu"><br>

            <label  for="image-first">Image Principal : </label>
            <input class="form-control" type="file" id="image-fisrt" name="image-first" />

            <label  for="image">Images : </label>
            <input class="form-control" type="file" id="image" name="image[]" multiple="multiple" />
            <br><br>
            <input class="form-control btn btn-primary" type="submit" value="Ajouter">

        </form>
        <br><br><br>
        <h2 class="content-titre">Ajouter une categories</h2>
        <?php
        if (!empty($erreu_cat)) {
            echo $erreu_cat;
        }
        ?>
        <form action="" method="post"  class="col-5">
            <label  for="nom">Nom : </label>
            <input class="form-control" type="text" id="nom" name="nom">

            <label  for="desc">Description : </label>
            <textarea  class="form-control" name="desc" id="desc" cols="30" rows="10"></textarea>

            <br><br>
            <input class="btn btn-primary form-control " type="submit" value="Ajouter">

        </form>
    </div>
    <div class="container last-item">
        <h2>Liste des plus recent ajout</h2>
        <ul>
            <?php
            $sql = 'SELECT * FROM objet ORDER BY date_ajout LiMIT 10';
            $query = $bdd->query($sql);
            while ($data=$query->fetch()) {
                echo '<li><a href="edit.php?id='.$data['id'].'"><img class="item-img" src="../public/img/statue/'.$data['image_name'].'" alt="'.$data['titre'].'" title="'.$data['titre'].'">'.$data['titre'].'</a></li>';
            }
            ?>
        </ul>
    </div>
</div>
</body>
</html>
