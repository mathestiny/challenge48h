<p><span style="color: red;">*</span>Champs obligatoires</p><br>     

<?php $result = $pdo->query("SELECT * FROM annonce WHERE id_annonce = '$_GET[IDannonce]'"); 
$annonce = $result->fetch(PDO::FETCH_OBJ);?>

<form method="POST" enctype='multipart/form-data'>

    <div class="row">
        <div class="form-group col-md-7">
            <label for="titre">Titre<span style="color: red;">*</span></label>
            <input type="texte" class="form-control" id="titre" name="titre" value="<?php echo $annonce->titre; ?>" maxlength = "50">
        </div>
    </div>

    <h7>Type d’image</h7>
    <div class="row">
        <div class="form-group col-md-2">
            <label for="numerorue">Photo avec produit<span style="color: red;">*</span></label>
            <input type="texte" class="form-control" id="numerorue" name="numerorue" maxlength="3" placeholder="oui/non">
        </div>

        <div class="form-group col-md-5">
            <label for="nomrue">Nom de la rue<span style="color: red;">*</span></label>
            <input type="texte" class="form-control" id="nomrue" name="nomrue" maxlength="50" value="<?php echo $annonce->nomrue; ?>">
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-2">
            <label for="codepostal">Code Postal<span style="color: red;">*</span></label>
            <input type="number" class="form-control" id="codepostal" name="codepostal" min="1000" max="99999" value="<?php echo $annonce->codepostal; ?>">
        </div>

        <div class="form-group col-md-5">
            <label for="ville">Ville<span style="color: red;">*</span></label>
            <input type="texte" class="form-control" id="ville" name="ville" maxlength="50" value="<?php echo $annonce->ville; ?>">
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-7">
            <label for="description">Description<span style="color: red;">*</span></label>
            <textarea rows="5" class="form-control" id="description" name="description"><?php echo $annonce->descript; ?></textarea>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-3">
            <label for="nbplaces">Nombre de places<span style="color: red;">*</span></label>
            <input type="number" class="form-control" id="nbplaces" name="nbplaces" min="0" max="99" value="<?php echo $annonce->nb_places; ?>">
        </div>

        <div class="form-group col-md-4">
            <label for="prix">Prix<span style="color: red;">*</span></label>
            <input type="number" class="form-control" id="prix" name="prix" min="1" max="99999" value="<?php echo $annonce->prix; ?>">
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Modifier une annonce</button>
    <a class="btn btn-primary" href="photoproduits.php?IDannonce=<?php echo $_GET['IDannonce']; ?>">Modifier les photos</a>
    <a class="btn btn-primary" href="gestionproduits.php">Retour</a>
</form><br>

<?php 
if(!empty($_POST["titre"]) && !empty($_POST["numerorue"]) && !empty($_POST["nomrue"]) && !empty($_POST["codepostal"]) && !empty($_POST["ville"]) && !empty($_POST["description"]) && !empty($_POST["titre"]) && !empty($_POST["nbplaces"]) && !empty($_POST["prix"])){

    $_POST["titre"] = htmlentities($_POST["titre"], ENT_QUOTES);
    $_POST["numerorue"] = htmlentities($_POST["numerorue"], ENT_QUOTES);
    $_POST["nomrue"] = htmlentities($_POST["nomrue"], ENT_QUOTES);
    $_POST["codepostal"] = htmlentities($_POST["codepostal"], ENT_QUOTES);
    $_POST["ville"] = htmlentities($_POST["ville"], ENT_QUOTES);
    $_POST["description"] = htmlentities($_POST["description"], ENT_QUOTES);
    $_POST["nbplaces"] = htmlentities($_POST["nbplaces"], ENT_QUOTES);
    $_POST["prix"] = htmlentities($_POST["prix"], ENT_QUOTES);
    // ^Vérifie que les données entrées ne contiennent pas de code

    $requeteSQL = "UPDATE annonce SET titre='$_POST[titre]', descript='$_POST[description]', ";
    $requeteSQL .= "nb_places='$_POST[nbplaces]', numerorue='$_POST[numerorue]', nomrue='$_POST[nomrue]', ";
    $requeteSQL .= "ville='$_POST[ville]', codepostal='$_POST[codepostal]', prix='$_POST[prix]' ";
    $requeteSQL .= "WHERE id_annonce='$_GET[IDannonce]'";

    $pdo->exec($requeteSQL);


} 