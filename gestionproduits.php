<?php require_once("inc/header.inc.php"); 

//page de gestion d'un bien mis en location

if(!empty($_SESSION["userID"])){ ?>
    <div class="starter-template">  

        <br><h1>Gestion des Produits</h1><br>

        <?php $annonces = $pdo->query("SELECT * FROM annonce WHERE id_compte='$_SESSION[userID]'");
        if(empty($_GET)){
            while ($annonce = $annonces->fetch(PDO::FETCH_OBJ)) { ?>

                <div class="card mb-3" style="max-width: 540px;">
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
                                <a class="btn btn-outline-info my-2 my-sm-0 btn-sm" href="gestionproduits.php?gerer=modifier&IDannonce=<?php echo $annonce->id_annonce; ?>" style="margin-left : 50px;">Modifier</a>
                                <a class="btn btn-outline-danger my-2 my-sm-0 btn-sm" href="gestionproduits.php?gerer=supprimer&IDannonce=<?php echo $annonce->id_annonce; ?>">Supprimer</a>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>

            <a href="gestionproduits.php?gerer=ajouter" class="btn btn-outline-info" style="margin-bottom: 10px;">Ajouter une annonce</a>

        <?php }

        else if($_GET["gerer"]=="ajouter"){ ?>
            
            <h3>Ajouter un Produit</h3>
            <?php require_once("inc/ajoutproduit.inc.php");

        }
        
        
        else if($_GET["gerer"]=="modifier"){ ?>
            <h3>Modifier un produit</h3>
            <?php require_once("inc/modifproduit.inc.php");
        }

        

        else if($_GET["gerer"]=="supprimer"){
            $photos = $pdo->query("SELECT nomphoto FROM photos WHERE id_annonce = '$_GET[IDannonce]'");
            while ($photo = $photos->fetch(PDO::FETCH_OBJ)){
                unlink("img/annonces/$photo->nomphoto");
            } 
            $pdo->exec("DELETE FROM photos WHERE id_annonce = '$_GET[IDannonce]'");
            $pdo->exec("DELETE FROM reservation WHERE id_annonce = '$_GET[IDannonce]'");
            $pdo->exec("DELETE FROM annonce WHERE id_annonce = '$_GET[IDannonce]'");
            header("Location:gestionproduits.php");
        } ?>

    </div>
<?php }else{
    echo "<p style='color:red;'>Veuillez vous connecter pour accéder à cette page.</p>";
}
require_once("inc/footer.inc.php"); ?>