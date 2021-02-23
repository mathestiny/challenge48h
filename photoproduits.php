<?php require_once("inc/header.inc.php");

//permet d'ajouter et supprimer les photos d'une annonce

if(!empty($_SESSION["userID"])){?>
    <br><h1>Gestion des photos de l'annonce</h1><br>
    <?php if(isset($_GET["IDannonce"])){ ?>
        <h5>Supprimer des photos (<span style='color: red;'>*</span>1 minimum)</h5>

        <?php $photos = $pdo->query("SELECT * FROM photos WHERE id_annonce = $_GET[IDannonce]");
        
        $nbphotos = $pdo->query("SELECT COUNT(*) FROM photos WHERE id_annonce = $_GET[IDannonce]")->fetchAll();
        
        while($photo = $photos->fetch(PDO::FETCH_OBJ)){  
            if(intval($nbphotos[0]["COUNT(*)"]) > 1){ ?>
                <a href="photoproduits.php?IDannonce=<?php echo $_GET["IDannonce"]; ?>&delphoto=<?php echo $photo->id_photo; ?>">
            <?php } ?>
                    <img src="img/annonces/<?php echo $photo->nomphoto; ?>" style="height: 200px; width: 200px; border: 1px solid grey; margin: 20px;" alt="Photo de l'annonce">
                </a>
        <?php }

        if(intval($nbphotos[0]["COUNT(*)"]) == 1){
            echo "<p><span style='color: red;'>*</span>Vous n'avez pas assez de photos pour en supprimer</p>";
        } ?>
        
        <br><form method="POST" enctype='multipart/form-data'>
            <div class="form-group">
                <h5>Ajouter des photos</h5>
                <input type="file" class="form-control-file" id="img" name="img[]" multiple>
            </div>

            <br><button type="submit" class="btn btn-primary">Ajouter une photo</button>
            <a class="btn btn-primary" href="gestionbiens.php">Retour</a>
        </form><br>

        <?php if(isset($_GET["delphoto"])){
            $photo = $pdo->query("SELECT nomphoto FROM photos WHERE id_photo = '$_GET[delphoto]'");
            $photo = $photo->fetch(PDO::FETCH_OBJ);
            unlink("img/annonces/$photo->nomphoto");
            $pdo->exec("DELETE FROM photos WHERE id_photo = $_GET[delphoto]");
            header("Location:photoproduits.php?IDannonce=$_GET[IDannonce]");
        } 

        if(isset($_FILES["img"])){
            $name = "";
            foreach ($_FILES["img"]["error"] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES["img"]["tmp_name"][$key];
                    $name = basename($_FILES["img"]["name"][$key]);
                    move_uploaded_file($tmp_name, "img/annonces/$name");
                    $requeteSQL = "INSERT INTO photos (id_annonce, nomphoto) VALUE ('$_GET[IDannonce]','$name')";
                    $pdo->exec($requeteSQL);
                }
            }
            header("Location:photoproduits.php?IDannonce=$_GET[IDannonce]");
        }

    }else{
        echo "<p style='color: red;'>Aucune annonce sélectionnée. Veuillez choisir l'annonce dont vous voulez modifier les photos en cliquant <a href='gestionbiens.php'>ici</a>.</p><br>";
    } 
}else{
    echo "<p style='color:red;'>Veuillez vous connecter pour accéder à cette page.</p>";
}

require_once("inc/footer.inc.php"); ?>