<?php require_once("inc/header.inc.php"); ?>

<!-- Page de connexion -->

<div class="starter-template">  

    <br><h1>Connexion</h1><br>

    <?php $comptes = $pdo->query("SELECT id_compte, email, mdp FROM compte");?>
    <!-- ^Cherche le contenu de la base de données -->

    <form method="POST">

        <div class="row">
            <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" maxlength = "50" placeholder="Adresse email (1-50 caractères)">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label for="mdp">Mot de passe</label>
                <input type="password" class="form-control" id="mdp" name="mdp" maxlength = "50" placeholder="Mot de passe (1-50 caractères)">
            </div>
        </div>
        <br><button type="submit" class="btn btn-primary">Valider</button>
        <a class="btn btn-primary" href="index.php">Retour</a>

    </form><br>
</div>
<?php if(!empty($_POST["email"]) && !empty($_POST["mdp"])){
    // ^Vérifie que tous les champs sont remplis 

    $_POST["email"] = htmlentities($_POST["email"], ENT_QUOTES);
    $_POST["mdp"] = htmlentities($_POST["mdp"], ENT_QUOTES);
    // ^Vérifie que les données entrées ne contiennent pas de code


    while ($identifiants = $comptes->fetch(PDO::FETCH_OBJ)) { 

        if($identifiants->email==$_POST["email"]){
            if($identifiants->mdp==$_POST["mdp"]){
                $_SESSION["userID"]=$identifiants->id_compte;
                header("Location:index.php");
            }
            else{
                echo("<p style='color: red;'>Mot de passe incorrect</p>");
            }
        }
        else{
            echo("<p style='color: red;'>Adresse email non reconnue</p>");
        }
    }

} else if(!empty($_POST)){
    echo("<p style='color: red;'>Vous n'avez pas rempli tous les champs</p>");
}

require_once("inc/footer.inc.php"); ?>