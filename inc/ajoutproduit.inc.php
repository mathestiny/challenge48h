<p><span style="color: red;">*</span>Champs obligatoires</p><br>     
        
<form method="POST" enctype='multipart/form-data'>

    <div class="row">
        <div class="form-group col-md-7">
            <label for="titre">Titre<span style="color: red;">*</span></label>
            <input type="texte" class="form-control" id="titre" name="titre"  maxlength = "50">
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-7">
            <label for="description">Description<span style="color: red;">*</span></label>
            <input type="texte" class="form-control" id="description" name="description" >
        </div>
    </div>
    
    <div class="form-group">
        <label for="img">Photos</label>
        <p><span style="color: red;">*</span>Une au minimum</p>
        <input type="file" class="form-control-file" id="img" name="img[]" multiple>
    </div>

    <button type="submit" class="btn btn-primary">Ajouter une annonce</button>
    
</form>

<br><a href="gestionproduits.php" class="btn btn-primary">Retour</a><br><br><br>

<?php if(!empty($_POST["titre"]) && !empty($_POST["description"]) && !empty($_POST["titre"]) && !empty($_FILES["img"])){

    $_POST["titre"] = htmlentities($_POST["titre"], ENT_QUOTES);
    $_POST[""] = htmlentities($_POST[""], ENT_QUOTES);
    $_POST[""] = htmlentities($_POST[""], ENT_QUOTES);
    $_POST[""] = htmlentities($_POST[""], ENT_QUOTES);
    $_POST[""] = htmlentities($_POST[""], ENT_QUOTES);
    $_POST["description"] = htmlentities($_POST["description"], ENT_QUOTES);
    $_POST[""] = htmlentities($_POST[""], ENT_QUOTES);
    $_POST[""] = htmlentities($_POST[""], ENT_QUOTES);
    
    // ^Vérifie que les données entrées ne contiennent pas de code

    $requeteSQL = "INSERT INTO annonce (id_compte, titre, descript) VALUE ";
    $requeteSQL .= "($_SESSION[userID], '$_POST[titre]', '$_POST[description]')";
    

    $pdo->exec($requeteSQL);

    $annonce = $pdo->query("SELECT id_annonce FROM annonce WHERE id_compte='$_SESSION[userID]' ORDER BY id_annonce DESC LIMIT 1");
    $cherche_id_annonce = $annonce->fetch(PDO::FETCH_OBJ);
    $id_annonce = $cherche_id_annonce->id_annonce;

    
    $name = "";
    foreach ($_FILES["img"]["error"] as $key => $error) {
        if ($error == UPLOAD_ERR_OK) {
            $tmp_name = $_FILES["img"]["tmp_name"][$key];
            $name = basename($_FILES["img"]["name"][$key]);
            move_uploaded_file($tmp_name, "img/annonces/$name");
            $pdo->exec("INSERT INTO photos (id_annonce, nomphoto) VALUE ('$id_annonce','$name')");
        }
    }

    header("Location:gestionproduits.php");

} 


    