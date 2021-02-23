<?php require_once("inc/header.inc.php"); 

//page de profil d'un utilisateur

if(!empty($_SESSION["userID"])){
    if(!empty($_GET["IDcompte"])){

        $user = $pdo->query("SELECT * FROM compte WHERE id_compte='$_GET[IDcompte]'");
        $user = $user->fetch(PDO::FETCH_OBJ); 
        $nbannonces = $pdo->query("SELECT COUNT(*) FROM annonce WHERE id_compte = $_GET[IDcompte]")->fetchAll();
        $nbannonces = intval($nbannonces[0]["COUNT(*)"]); ?>

        <h1>Profil de <?php echo $user->prenom . " " . $user->nom; ?></h1><br>

        <div class="row">
            <img class="col-md-4" src="img/profile/<?php echo $user->nomphoto; ?>" alt="Photo de profil de l'utilisateur n°<?php echo $user->id_compte; ?>">
            <div class="col">
                <p>Adresse email : <?php echo $user->email; ?></p>
                <p>Numéro de téléphone : <?php echo $user->tel; ?></p>
                <p>Nombres d'annonces : <?php echo $nbannonces; 

                //lien affichage des annonces
                if($_GET["afficherannonces"]=="false"){?> 
                    <a href="profil.php?IDcompte=<?php echo $_GET['IDcompte']; ?>&afficherannonces=true">(Voir)
                <?php
                }else if($_GET["afficherannonces"]=="true"){ ?> 
                    <a href="profil.php?IDcompte=<?php echo $_GET['IDcompte']; ?>&afficherannonces=false">(Cacher) 
                <?php } ?>
                </a></p>

                <p>Présentation : <?php echo $user->presentation; ?></p>
            </div>
        </div>

        <!-- Affichage des annonces de l'utilisateur -->
        <?php if($_GET["afficherannonces"]=="true"){
            $annonces = $pdo->query("SELECT * FROM annonce WHERE id_compte = $_GET[IDcompte]");
            while($annonce = $annonces->fetch(PDO::FETCH_OBJ)){ ?>
                <br><div class="card mb-3" style="max-width: 540px;">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                        <?php $photo = $pdo->query("SELECT * FROM photos WHERE id_annonce='$annonce->id_annonce' ORDER BY id_photo LIMIT 1");
                        $photo = $photo->fetch(PDO::FETCH_OBJ); ?>
                        <img src="img/annonces/<?php echo $photo->nomphoto; ?>" class="card-img" alt="Première photo de l'annonce n°<?php echo $annonce->id_annonce; ?>">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $annonce->titre; ?></h5>
                                <p class="card-text">Ville : <?php echo $annonce->ville; ?></p>
                                <p class="card-text"><?php echo substr($annonce->descript, 0, 50) . "..."; ?></p>
                                <a class="btn btn-outline-info my-2 my-sm-0 btn-sm" href="detail.php?IDannonce=<?php echo $annonce->id_annonce; ?>">Détails</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
        }

    }else{

        echo "<p style='color: red;>Aucun profil sélectionné.</p>";
    }

    echo '<br><a class="btn btn-primary" href="index.php" style="margin-bottom: 10px;">Retour</a>';
    
}else{
    echo "<p style='color:red;'>Veuillez vous connecter pour accéder à cette page.</p>";
}
require_once("inc/footer.inc.php"); ?>