<?php require_once("inc/header.inc.php"); 

//page de gestion de compte

if(!empty($_SESSION["userID"])){

    $user = $pdo->query("SELECT * FROM compte WHERE id_compte='$_SESSION[userID]'");
    $user = $user->fetch(PDO::FETCH_OBJ);

    ?>

    <!-- Permet à l'utilisateur de gérer les infos de son compte -->

    <div class="starter-template">  

        <br><h1>Modifier votre compte</h1>
        <p><span style="color: red;">*</span>Champs obligatoires</p>
    
        <form method="POST" enctype='multipart/form-data'>

            <div class="row">
                <div class="form-group col">
                    <label for="prenom">Prénom<span style="color: red;">*</span></label>
                    <input type="texte" class="form-control" id="prenom" name="prenom" maxlength = "20" value="<?php echo $user->prenom; ?>" onkeyup="lettersOnly(this)">
                </div>

                <div class="form-group col">
                    <label for="nom">Nom<span style="color: red;">*</span></label>
                    <input type="texte" class="form-control" id="nom" name="nom" maxlength = "20" value="<?php echo $user->nom; ?>" onkeyup="lettersOnly(this)">
                </div>
            </div>

            <div class="row">
                <div class="form-group col">
                    <label for="email">Email<span style="color: red;">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" maxlength = "50" value="<?php echo $user->email; ?>">
                </div>
                <div class="form-group col">
                    <label for="tel">Numéro de téléphone<span style="color: red;">*</span></label>
                    <input type="texte" class="form-control" id="tel" name="tel" maxlength = "14" value="<?php echo $user->tel; ?>">
                </div>
            </div>

            <div class="row">
                <div class="form-group col">
                    <label for="mdp1">Mot de passe<span style="color: red;">*</span></label>
                    <input type="password" class="form-control" id="mdp1" name="mdp1" maxlength = "50" value="<?php echo $user->mdp; ?>">
                </div>

                <div class="form-group col">
                    <label for="mdp2">Confirmer le mot de passe<span style="color: red;">*</span></label>
                    <input type="password" class="form-control" id="mdp2" name="mdp2" maxlength = "50" value="<?php echo $user->mdp; ?>">
                </div>
            </div>
            
            <div class="form-group row">
                <img src="img/profile/<?php echo $user->nomphoto; ?>" alt="Votre photo de profil" style="height: 150px;" class="col-md-2">
                <div class="col-md-4">
                    <label for="img">Photo de profil</label>
                    <input type="file" class="form-control-file" id="img" name="img[]">
                </div>
                <div class="col">
                    <p>Votre solde (non modifiable) <br><?php echo $user->solde; ?> €</p>
                </div>
            </div>

            <div class="row">
                <div class="form-group col">
                    <label for="presentation">Présentation</label>
                    <textarea rows="3" maxlength="300" class="form-control" id="presentation" name="presentation"><?php echo $user->presentation; ?></textarea>
                </div>
            </div>

            <br><button type="submit" class="btn btn-primary">Valider</button>
            <a class="btn btn-primary" href="index.php">Retour</a>

        </form><br>
    </div>

    <?php if(!empty($_POST["prenom"]) && !empty($_POST["nom"]) && !empty($_POST["email"]) && !empty($_POST["mdp1"]) && !empty($_POST["mdp2"])){

        $_POST["prenom"] = htmlentities($_POST["prenom"], ENT_QUOTES);
        $_POST["nom"] = htmlentities($_POST["nom"], ENT_QUOTES);
        $_POST["email"] = htmlentities($_POST["email"], ENT_QUOTES);
        $_POST["mdp1"] = htmlentities($_POST["mdp1"], ENT_QUOTES);
        $_POST["mdp2"] = htmlentities($_POST["mdp2"], ENT_QUOTES);
        // ^Vérifie que les données entrées ne contiennent pas de code

        $name = $user->nomphoto;
        // ^Récupère la photo de profile actuelle au cas où l'utilisateur ne souhaite pas la changer
        if (isset($_FILES)) {
            foreach ($_FILES["img"]["error"] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES["img"]["tmp_name"][$key];
                    $name = basename($_FILES["img"]["name"][$key]);
                    move_uploaded_file($tmp_name, "img/profile/$name");
                }
            }
        }
        // ^Vérifie que le fichier est bon, enregistre son nom dans $name et l'enregistre dans le dossier img/profile/
        
        if($_POST["mdp1"]==$_POST["mdp2"]){
            // ^Vérifie que les mots de passe sont identiques
            $requeteSQL = "UPDATE compte SET prenom = '$_POST[prenom]', nom = '$_POST[nom]', email = '$_POST[email]', mdp = '$_POST[mdp2]', nomphoto = '$name'";
            
            //vérifie s'il y a eu modif des champs non obligatoires 
            if(!empty($_POST["tel"])){
                $requeteSQL .= ", tel = '$_POST[tel]'";
            }
            if(!empty($_POST["presentation"])){
                $requeteSQL .= ", presentation = '$_POST[presentation]'";
            }

            $requeteSQL .= "WHERE id_compte='$_SESSION[userID]'";
            $pdo->exec($requeteSQL);
            //^Enregistre les données modifiées dans la base de données

            
            header("Location:index.php");
            // ^Retourne à la page d'accueil
        }    

        else{
            echo("<p style='color: red;'>Les mots de passe sont différents</p>");
        }
    }
    
}else{
    echo "<p style='color:red;'>Veuillez vous connecter pour accéder à cette page.</p>";
}
require_once("inc/footer.inc.php"); ?>