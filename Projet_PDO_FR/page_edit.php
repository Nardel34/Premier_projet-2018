<?php
session_start();

include 'Include/database.php';

if (isset($_SESSION['id'])) {

   $requser = $db->prepare("SELECT * FROM users WHERE id = ?");
   $requser->execute(array($_SESSION['id']));
   $userinfo = $requser->fetch();
   if (isset($_POST['formedition'])) {

      if (!empty($_POST['newmdp']) and !empty($_POST['newmdp']) and isset($_POST['newmdp2']) and !empty($_POST['newmdp2'])) {

         $oldmdp = sha1($_POST['oldmdp']);
         $requser = $db->prepare("SELECT * FROM users WHERE password = ?");
         $requser->execute(array($oldmdp));
         $mdpexist = $requser->rowCount();
         if ($mdpexist == 1) {

            $newmdp = sha1($_POST['newmdp']);
            $newmdp2 = sha1($_POST['newmdp2']);
            if ($newmdp == $newmdp2) {

               $insertmdp = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
               $insertmdp->execute(array($newmdp, $_SESSION['id']));
               header('Location: page_user.php');
            } else {
               $erreur = "Vos deux mdp ne correspondent pas !";
            }
         } else {
            $erreur = "Le mot de passe actuel saisie est incorrect.";
         }
      } else {
         $erreur = "Veuillez compléter tous les champs.";
      }
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
   <nav class="navuser">
      <a href="logout.php" class="uk-button uk-button-primary uk-button-large"> Déconnexion </a>
      <a href="page_user.php"><img src="IMG/logo_projet.png" class="homelogo"></a>
      <a href="page_edit.php" class="uk-button uk-button-default uk-button-large"> Editer le profil </a>
      <a href="page_edit_ipcam.php" class="uk-button uk-button-primary uk-button-large"> Ajouter une caméra </a>
   </nav>
   <div class="blockformedit">
      <h2 class="h2form">Edition du profil</h2>
      <form method="POST">
         <table align="center">
            <tr>
               <td align="right">
                  Pseudo :
               </td>
               <td>
                  <?php echo $userinfo['pseudo']; ?>
               </td>
            </tr>
            <tr>
               <td align="right">
                  Email :
               </td>
               <td>
                  <?php echo $userinfo['email']; ?>
               </td>
            </tr>
            <tr>
               <td align="right">
                  <label for="oldmdp"> Mot de passe actuel : </label>
               </td>
               <td>
                  <input type="password" placeholder="mdp actuel" id="oldmdp" name="oldmdp" />
               </td>
            </tr>
            <tr>
               <td align="right">
                  <label for="newmdp"> Nouveau mot de passe : </label>
               </td>
               <td>
                  <input type="password" placeholder="Nouveau mdp" id="newmdp" name="newmdp" />
               </td>
            </tr>
            <tr>
               <td align="right">
                  <label for="newmdp2"> Confirmez le nouveau mot de passe : </label>
               </td>
               <td>
                  <input type="password" placeholder="Confirmation nouveau mdp" id="newmdp2" name="newmdp2" />
               </td>
            </tr>
            <tr>
               <td></td>
               <td align="center">
                  <br />
                  <input type="submit" name="formedition" value="Mettre à jour" />
               </td>
            </tr>
         </table>
      </form>
      <div align="center">
         <?php
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