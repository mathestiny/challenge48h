<?php require_once("inc/header.inc.php"); ?>

<div class="starter-template">  

    <br><h1>Rechercher une location</h1>

    <form method="POST" enctype='multipart/form-data'>
        
        
        <div class="form-group">
            <label for="titre">Titre</label>
            <input type="texte" class="form-control" id="titre" name="titre" maxlength = "50" placeholder="Titre de votre produit">
        </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="prix" value="option1">
                <label class="form-check-label" for="inlineCheckbox1">Vertical</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="prix" value="option2">
                <label class="form-check-label" for="inlineCheckbox2">Horizontal</label>
            </div>

            <div class="form-group">
                <label for="prix">Crédits photos</label>
                <input type="text" class="form-control" id="prix" name="prix" maxlength="50" placeholder="Prix minimum de la location">
            </div>
        </div>

        <br><button type="submit" class="btn btn-primary">Valider</button>
        <a class="btn btn-primary" href="index.php">Retour</a>

    </form><br>
    <br> </br>
</div>

<!-- Requête SQL -->
<?php $requeteSQL = "SELECT * FROM annonce a";

if(empty($_POST)){
    //si l'utilisateur ne précise pas la recherche, afficher toutes les annonces
    $annonces = $pdo->query($requeteSQL);
    
}
else{

    //si l'utilisateur recherche des dates précises, la table "reservation" est ajoutée à la recherche
    if(!empty($_POST["datearr"])){
        $requeteSQL .= ", reservation r WHERE r.date_arrive = '$_POST[datearr]'";
    }
    if(!empty($_POST["datedep"])){
        if(!empty($_POST["datearr"])){
            $requeteSQL .= " AND ";
        }
        else{
            $requeteSQL .= ", reservation r WHERE ";
        }
        $requeteSQL .= "r.date_depart = '$_POST[datedep]'";
    }


    if(empty($_POST["datearr"]) && empty($_POST["datedep"])){
        $requeteSQL .= " WHERE ";
    }
    else{
        $requeteSQL .= ", ";
    }


    if(!empty($_POST["titre"])){
        $requeteSQL .= "a.titre = '$_POST[titre]'";
    }
    
    $annonces = $pdo->query($requeteSQL);
}


$nbresults = 0;
//affichage des résultats
while($annonce = $annonces->fetch(PDO::FETCH_OBJ)){ 
    $compte = $pdo->query("SELECT * FROM compte WHERE id_compte=$annonce->id_compte");
    $compte = $compte->fetch(PDO::FETCH_OBJ); ?>
    <div class="card mb-3" style="max-width: 540px;">
        <div class="row no-gutters">
            <div class="col-md-4">
            <?php $photo = $pdo->query("SELECT * FROM photos WHERE id_annonce='$annonce->id_annonce' ORDER BY id_photo LIMIT 1");
            $photo = $photo->fetch(PDO::FETCH_OBJ); ?>
            <img src="img/annonces/<?php echo $photo->nomphoto; ?>" class="card-img" alt="Première photo de l'annonce n°<?php echo $annonce->id_annonce; ?>">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $annonce->titre; ?> par <a href="profil.php?IDcompte=<?php echo $compte->id_compte; ?>&afficherannonces=false"><?php echo $compte->prenom . " " . $compte->nom; ?></a></h5>
                    <p class="card-text">Crédits : <?php echo $annonce->prix; ?></p>
                    <p class="card-text">Format : <?php echo $annonce->ville; ?></p>
                    <p class="card-text"><?php echo substr($annonce->descript, 0, 50) . "..."; ?></p>
                    <a class="btn btn-outline-info my-2 my-sm-0 btn-sm" href="detail.php?IDannonce=<?php echo $annonce->id_annonce; ?>">Détails</a>
                </div>
            </div>
        </div>
    </div>
    <?php $nbresults+=1;
}

if($nbresults == 0){
    echo "<p style='color: red;'> Aucune annonce ne correspond à votre recherche.</p>";
}

require_once("inc/footer.inc.php"); ?>