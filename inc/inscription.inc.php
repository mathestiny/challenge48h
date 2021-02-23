<?php
    
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $mdp = $_POST['mdp1'];
    $solde = $_POST['solde'];
     
     
    $subject = "Copie de l'inscription de l'utilisateur " . $prenom . " " . $nom;
    $subjectuser = "Confirmation de votre inscription chez PASSIONFROID";
        
    $emailmessage = "Bonjour " . $prenom . " " . $nom . ", voici la confirmation de votre inscription.\n\n";
    $emailmessage .= "Prénom : ".  $prenom . "\n";
    $emailmessage .= "Nom : ". $nom . "\n";
    $emailmessage .= "Email : ". $email . "\n";
    $header = "From:" . $email;
    $headeruser = "From:passionfroidynov@gmail.com";
       
    mail("passionfroidynov@gmail.com", $subject, $emailmessage, $header);
    mail($email, $subjectuser, $emailmessage, $headeruser);

?>