<?php require_once("inc/header.inc.php"); ?>

<div class="starter-template">  

    <br><h1>Créer un compte</h1>
    <p><span style="color: red;">*</span>Champs obligatoires</p>
   
    <form method="POST">
        <div class="row">
            <div class="form-group col">
                <label for="prenom">Prénom<span style="color: red;">*</span></label>
                <input type="texte" class="form-control" id="prenom" name="prenom" maxlength = "20" placeholder="Prénom" onkeyup="lettersOnly(this)">
            </div>

            <div class="form-group col">
                <label for="nom">Nom<span style="color: red;">*</span></label>
                <input type="texte" class="form-control" id="nom" name="nom" maxlength = "20" placeholder="Nom de famille" onkeyup="lettersOnly(this)">
            </div>
        </div>
        <div class="row">
            <div class="form-group col">
                <label for="email">Email<span style="color: red;">*</span></label>
                <input type="email" class="form-control" id="email" name="email" maxlength = "50" placeholder="Adresse email (1-50 caractères)">
            </div>
            <div class="form-group col">
                <label for="tel">Numéro de téléphone</label>
                <input type="texte" class="form-control" id="tel" name="tel" maxlength = "14" placeholder="Numéro de téléphone (0-14 caractères)">
            </div>
        </div>

        <div class="row">
            <div class="form-group col">
                <label for="mdp1">Mot de passe<span style="color: red;">*</span></label>
                <input type="password" class="form-control" id="mdp1" name="mdp1" maxlength = "50" placeholder="Mot de passe (1-50 caractères)">
            </div>

            <div class="form-group col">
                <label for="mdp2">Confirmer le mot de passe<span style="color: red;">*</span></label>
                <input type="password" class="form-control" id="mdp2" name="mdp2" maxlength = "50" placeholder="Confirmer le mot de passe">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label for="img">Photo de profil</label>
                <input type="file" class="form-control-file" id="img" name="img[]">
            </div>

            <div class="form-group col-md-8">
                <label for="solde">Solde<span style="color: red;">*</span></label>
                <input type="number" class="form-control" id="solde" name="solde" min="0" max="99999" placeholder="L'argent que vous souhaitez utiliser (en euros, jusqu'à 99.999€)">
            </div>
        </div>

        <div class="row">
            <div class="form-group col">
                <label for="presentation">Présentation</label>
                <textarea rows="3" maxlength="300" class="form-control" id="presentation" name="presentation" placeholder="Présentez-vous ! (0-300 caractères)"></textarea>
            </div>
        </div>
        
        <br><button type="submit" class="btn btn-primary">Valider</button>
        <a class="btn btn-primary" href="index.php">Retour</a>

    </form><br>
</div>
<?php if(!empty($_POST["prenom"]) && !empty($_POST["nom"]) && !empty($_POST["email"]) && !empty($_POST["mdp1"]) && !empty($_POST["mdp2"]) && !empty($_POST["solde"])){
    // ^Vérifie que tous les champs obligatoires sont remplis 

    $_POST["prenom"] = htmlentities($_POST["prenom"], ENT_QUOTES);
    $_POST["nom"] = htmlentities($_POST["nom"], ENT_QUOTES);
    $_POST["email"] = htmlentities($_POST["email"], ENT_QUOTES);
    $_POST["mdp1"] = htmlentities($_POST["mdp1"], ENT_QUOTES);
    $_POST["mdp2"] = htmlentities($_POST["mdp2"], ENT_QUOTES);
    $_POST["solde"] = htmlentities($_POST["solde"], ENT_QUOTES);
    // ^Vérifie que les données entrées ne contiennent pas de code

    $name = "profilepicture.jpg";
    // ^Photo de profile par défaut
    if (isset($_FILES["img"])) {
        foreach ($_FILES["img"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["img"]["tmp_name"][$key];
                $name = basename($_FILES["img"]["name"][$key]);
                move_uploaded_file($tmp_name, "img/profile/$name");
            }
        }
    }
    // ^Vérifie que le fichier est bon, enregistre son nom dans $name et l'enregistre dans le dossier img/profile/      

    $emails = $pdo->query("SELECT email FROM compte");
    $emailexists = false;
    while ($email = $emails->fetch(PDO::FETCH_OBJ)) {
        if($email->email==$_POST["email"]){
            $emailexists=true;
        }
    }
    // ^Vérifie s'il y a déjà un compte qui utilise cette adresse email

    if($emailexists==true){
        echo("<p style='color: red;'>Cette adresse email est déjà utilisée</p>");
    }
    else if($emailexists==false){
        if($_POST["mdp1"]==$_POST["mdp2"]){
            // ^Vérifie que les mots de passe sont identiques
    
            $requeteSQL = "INSERT INTO compte (prenom, nom, email, mdp, nomphoto, solde, tel, presentation) ";
            $requeteSQL .= "VALUE ('$_POST[prenom]', '$_POST[nom]', '$_POST[email]', '$_POST[mdp1]', '$name', '$_POST[solde]'";
            
            //numéro de téléphone (champs non obligatoire)
            if(!empty($_POST["tel"])){
                $_POST["tel"] = htmlentities($_POST["tel"], ENT_QUOTES);
                $requeteSQL .= ", '$_POST[tel]'";
            }else{
                $requeteSQL .= ", 'Non renseigné'";
            }

            //presentation (champs non obligatoire)
            if(!empty($_POST["presentation"])){
                $_POST["presentation"] = htmlentities($_POST["presentation"], ENT_QUOTES);
                $requeteSQL .= ", '$_POST[presentation]')";
            }else{
                $requeteSQL .= ", 'Non renseignée')";
            }

            $pdo->exec($requeteSQL);
            //^Enregistre les données dans la base de données
    
            $userID = $pdo->query("SELECT id_compte FROM compte WHERE email='$_POST[email]'")->fetch(PDO::FETCH_OBJ); 
            $_SESSION["userID"]=$userID->id_compte;
            // ^Connecte l'utilisateur
    
            include("inc/inscription.inc.php");
            // ^Envoie mail de confirmation
        }    
    
        else{
            echo("<p style='color: red;'>Les mots de passe sont différents</p>");
        }
    }
}
else if(!empty($_POST)){
    echo("<p style='color: red;'>Vous n'avez pas rempli tous les champs</p>");
}

require_once("inc/footer.inc.php"); ?>