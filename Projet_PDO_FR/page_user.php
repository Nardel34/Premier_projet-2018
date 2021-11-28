<?php
session_start();

include 'Include/database.php';

if (isset($_SESSION['id'])) {

   $getid = $_SESSION['id'];
   $requser = $db->prepare('SELECT * FROM users WHERE id = ?');
   $requser->execute(array($getid));
   $userinfo = $requser->fetch();
   if (isset($_SESSION['id']) and $userinfo['id'] == $_SESSION['id']) {
      if (!empty($_POST['led1'])) {
         $msg = "Demande envoyé !";
      } else if (isset($_POST['formled'])) {
         $erreur = "Veuillez remplir un des champs afin de <br> d'envoyer la demande.";
      }
   }
}
?>

<html>

<head>
   <title> HomeConnect </title>
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
   <script>
      function ledON1(elemID) {
         var x = document.getElementById("ledOff1");
         x.setAttribute("src", "IMG/Rond_vert.png");
      }

      function ledOFF1(elemID) {
         var x = document.getElementById("ledOff1");
         x.setAttribute("src", "IMG/Rond_gris.png");
      }
   </script>
</head>

<body>
   <nav class="navuser">
      <a href="logout.php" class="uk-button uk-button-primary uk-button-large"> Déconnexion </a>
      <a href="page_user.php"><img src="IMG/logo_projet.png" class="homelogo"></a>
      <a href="page_edit.php" class="uk-button uk-button-primary uk-button-large"> Editer le profil </a>
      <a href="page_edit_ipcam.php" class="uk-button uk-button-primary uk-button-large"> Ajouter une caméra </a>
   </nav>
   <div class="blockhomeuser">
      <h2 class="h2user"> Bonjour <?php echo $userinfo['pseudo']; ?>.</h2>
      <div class="blockcamera">
         <h4 class="h4camera"> Camera de surveillance</h4>
         <iframe src="http://<?php echo $userinfo['ipcam'] ?>/cgi/ieng?320&activex" width="700" height="360" frameborder="0" allowfullscreen="" wmode="Opaque"></iframe>
      </div>
      <div class="blockformled">
         <h4 class="h4management">Gestion domotique</h4>
         <form method="post" action="">
            <table cellpadding="5" align="center" class="formledarray">
               <tr>
                  <td></td>
                  <td>Allumer</td>
                  <td>Eteindre</td>
               </tr>
               <tr>
                  <td align="center">
                     <label for="allumée" for="eteint">LED 1 :</label>
                  </td>
                  <td align="center">
                     <input type="radio" name="led1" value="ON" id="ledOn" onclick="ledON1(this)">
                  </td>
                  <td align="center">
                     <input type="radio" name="led1" value="OFF" id="ledOff" onclick="ledOFF1(this)">
                  </td>
                  <td align="center">
                     <img src="IMG/Rond_gris.png" id="ledOff1" />
                  </td>
               </tr>
            </table>
            <div class="ledsubmit">
               <input type="submit" name="formled" value="Valider" align="center" />
            </div>
         </form>
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