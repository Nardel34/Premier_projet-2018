<?php
include 'Include/database.php';

if (isset($_POST['forminscription'])) {

   $pseudo = htmlspecialchars($_POST['pseudo']);
   $email = htmlspecialchars($_POST['email']);
   $mdp = sha1($_POST['mdp']);
   $mdp2 = sha1($_POST['mdp2']);
   $ipcam = htmlspecialchars($_POST['ipcam']);
   if (!empty($_POST['pseudo']) and !empty($_POST['email'])  and !empty($_POST['mdp']) and !empty($_POST['mdp2']) and !empty($_POST['ipcam'])) {

      $pseudolength = strlen($pseudo);
      if ($pseudolength <= 20) {

         if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $reqemail = $db->prepare("SELECT * FROM users WHERE email = ?");
            $reqemail->execute(array($email));
            $emailexist = $reqemail->rowCount();
            if ($emailexist == 0) {

               $reqpseudo = $db->prepare("SELECT * FROM users WHERE pseudo = ?");
               $reqpseudo->execute(array($pseudo));
               $pseudoexist = $reqpseudo->rowCount();
               if ($pseudoexist == 0) {

                  $reqipcam = $db->prepare("SELECT * FROM users WHERE ipcam = ?");
                  $reqipcam->execute(array($ipcam));
                  $ipexist = $reqipcam->rowCount();
                  if ($ipexist == 0) {

                     if ($mdp == $mdp2) {

                        $insertoUser = $db->prepare("INSERT INTO users(pseudo, email, password, ipcam) VALUES (?, ?, ?, ?)");
                        $insertoUser->execute(array($pseudo, $email, $mdp, $ipcam));
                        $msg = "Votre compte a bien été créé ! <a href=\"page_login.php\"> Me connecter </a>";
                     } else {
                        $erreur = "Vos mots de passes ne correspondent pas !";
                     }
                  } else {
                     $erreur = "cette adresse IP est déjà utilisé";
                  }
               } else {
                  $erreur = "Le Pseudo est déjà utilisé !";
               }
            } else {
               $erreur = "L'adresse Email est déjà utilisée, <a href=\"page_connection.php\"> Me connecter </a>";
            }
         } else {
            $erreur = "Votre adresse Email n'est pas valide !";
         }
      } else {
         $erreur = "Votre pseudo ne doit pas dépasser 20 caractères !";
      }
   } else {
      $erreur = "Tous les champs doivent être complétés !";
   }
}
?>

<html>

<head>
   <title>HomeConnect</title>
   <meta charset="utf-8">
   <link rel="stylesheet" type="text/css" href="CSS/style.css">
   <link rel="stylesheet" type="text/css" href="style_css/uikit.css">
   <link rel="stylesheet" type="text/css" href="style_css/uikit.min.css">
   <link rel="stylesheet" type="text/css" href="style_css/uikit-rtl.css">
   <link rel="stylesheet" type="text/css" href="style_css/uikit-rtl.min.css">
   <script type='text/javascript' src='style_js/uikit-icons.js'></script>
   <script type='text/javascript' src='style_js/uikit-icons.min.js'></script>
   <script type='text/javascript' src='style_js/uikit.js'></script>
   <script type='text/javascript' src='style_js/uikit.min.js'></script>
   <link rel="shortcut icon" href="IMG\logo_projet.png">
</head>

<body>
   <nav class="nav">
      <a href="page_signup.php" class="uk-button uk-button-default uk-button-large"> S'inscrire </a>
      <a href=""><img src="IMG/logo_projet.png" class="homelogo"></a>
      <a href="page_login.php" class="uk-button uk-button-primary uk-button-large"> Se connecter </a>
   </nav>
   <div class="blockformsignup">
      <h2 class="h2form">Inscription</h2>
      <form method="POST">
         <table align="center">
            <tr>
               <td align="right">
                  <label for="pseudo"> Pseudo : </label>
               </td>
               <td>
                  <input type="text" placeholder="Votre pseudo" id="pseudo" name="pseudo" value="<?php if (isset($pseudo)) {
                                                                                                      echo $pseudo;
                                                                                                   } ?>" />
               </td>
            </tr>
            <tr>
               <td align="right">
                  <label for="mail"> Adresse Email : </label>
               </td>
               <td>
                  <input type="email" placeholder="Votre Email" id="email" name="email" value="<?php if (isset($email)) {
                                                                                                   echo $email;
                                                                                                } ?>" />
               </td>
            </tr>
            <tr>
               <td align="right">
                  <label for="mdp"> Mot de passe : </label>
               </td>
               <td>
                  <input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp" />
               </td>
            </tr>
            <tr>
               <td align="right">
                  <label for="mdp2"> Confirmez le mot de passe : </label>
               </td>
               <td>
                  <input type="password" placeholder="Confirmation" id="mdp2" name="mdp2" />
               </td>
            </tr>
            <tr>
               <td align="right">
                  <label for="ipcam"> IP de la caméra :</label>
               </td>
               <td>
                  <input type="text" placeholder="Ex : 192.168.25.36" id="ipcam" name="ipcam" />
               </td>
            </tr>
            <tr>
               <td></td>
               <td align="center">
                  <br>
                  <input type="submit" name="forminscription" value="S'inscrire" />
               </td>
            </tr>
         </table>
      </form>
      <div align="center">
         <?php
         if (isset($msg)) {
            echo '<font color="green">' . $msg . "</font>";
         }
         if (isset($erreur)) {
            echo '<font color="red">' . $erreur . "</font>";
         }
         ?>
      </div>
   </div>
</body>
<footer>
   <div class="copyright">
      Copyright &copy; HomeConnect - 2018 - Tous Droits Réservés
   </div>
</footer>

</html>