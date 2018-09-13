<?php
$bdd = new PDO('mysql:host=localhost;dbname=africa', 'africa', 'dLyw3C8WsaXXbwyg');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Africa Dan - Sculture et Art Africain</title>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open Sans">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Josefin Slab">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Tangerine">
    <script src="public/js/jquery-3.1.1.min.js"></script>
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <script src="public/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="public/css/main.css">
    <script src="public/js/index.js"></script>

</head>
<body>
<header>

    <div class="jumbotron" style="margin-bottom: 0">
        <h1 style="text-align: center;font-family: 'Josefin Slab';font-weight: bolder">Africa Dan</h1>
        <p class="sub-title">Sculture et Art Africain</p>
    </div>


</header>
<nav class="navbar navbar-expand-md navbar-bg sticky-top">

    <button class="navbar-toggler" data-toggle="collapse" data-target="#collapse_target">
        <img src="public/img/baseline-menu-24px.svg" alt="">
    </button>
    <!--<a class="navbar-brand " style="display: contents;" href="#">Logo</a>-->
    <div class="collapse navbar-collapse" id="collapse_target">
        <ul class="navbar-nav offset-1">
            <li class="nav-item" ><a class="nav-link" href="index.php"><img src="public/img/baseline-home-24px.svg" alt="home">Accueil</a></li>
            <li class="nav-item dropdown" ><a class="nav-link dropdown-toggle" data-target="dropdown_target" data-toggle="dropdown" href=""><img
                        src="public/img/baseline-arrow_right-24px.svg" id="dropdown_icon" alt="">Categorie</a>
                <div class="dropdown-menu" aria-labelledby="dropdown_target" style="background-color: #53310b;">
                    <?php
                    $sql = 'SELECT * FROM categories';
                    $query = $bdd->query($sql);
                    while ($data = $query->fetch()) {
                        echo '<a class="dropdown-item"  href="index.php?cat='.$data['id'].'">'.$data['nom'].'</a>';
                    }
                    ?>
                </div>
            </li>
            <li class="nav-item active" ><a class="nav-link" href="contact.php"><img src="public/img/baseline-email-24px.svg" alt="contact">Contact</a></li>
        </ul>
    </div>
</nav>
<div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="mymodal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modal-title" class="modal-title text-center"></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <p style="font-size: 1.2em;" id="modal-text"></p>
                <img src="" class="enlargeImageModalSource">
                <div class="modal-imgs-container">
                    <img class="modal-opt-img" style="max-height: 100px" src="public/img/statue/a17cdff8-0f9e-47be-9103-b01b26d96762.jpg" alt="">
                    <img class="modal-opt-img" style="max-height: 100px" src="public/img/statue/a17cdff8-0f9e-47be-9103-b01b26d96762.jpg" alt="">
                    <img class="modal-opt-img" style="max-height: 100px" src="public/img/statue/a17cdff8-0f9e-47be-9103-b01b26d96762.jpg" alt="">
                    <img class="modal-opt-img" style="max-height: 100px" src="public/img/statue/a17cdff8-0f9e-47be-9103-b01b26d96762.jpg" alt="">
                    <img class="modal-opt-img" style="max-height: 100px" src="public/img/statue/a17cdff8-0f9e-47be-9103-b01b26d96762.jpg" alt="">
                    <img class="modal-opt-img" style="max-height: 100px" src="public/img/statue/a17cdff8-0f9e-47be-9103-b01b26d96762.jpg" alt="">
                </div>
                <p style="font-size: 1.2em;" id="modal-text-handheld"></p>
            </div>
        </div>
    </div>
</div>
<aside class="float-left menu-left">
    <ul>
        <li class="menu-title"><h4>Categorie</h4></li>
        <?php
        $sql = 'SELECT * FROM categories';
        $query = $bdd->query($sql);
        while ($data = $query->fetch()) {
            echo '<li class="menu-item"><a href="index.php?cat='.$data['id'].'">'.$data['nom'].'</a></li>';
        }
        ?>
    </ul>
</aside>
<section class="container container-bg">
    <form class="row" action="" method="post">
        <div class="col-6">

            <input placeholder="Nom :" class="form-control" name="nom" type="text">

            <input placeholder="Prenom :" class="form-control" name="prenom" type="text">

            <input placeholder="Email :" class="form-control" name="email" type="text">

        </div>
        <div class="col-6">

            <input style="margin-left: 0;" placeholder="Objet :" class="form-control" name="obj" type="text">

            <textarea placeholder="Message :" class="form-control" name="msg" type="text" ></textarea>

        </div>

        <span class="text-warning span-error"></span>
        <input type="submit" value="Envoyer" class="form-control btn-custom">

    </form>
</section>
<footer>

</footer>
</body>
</html>
