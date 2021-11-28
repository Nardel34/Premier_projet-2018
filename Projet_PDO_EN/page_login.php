<?php
session_start();

include 'Include/database.php';

if(isset($_POST['formconnection'])) {

   $emailconnect = htmlspecialchars($_POST['emailconnect']);
   $passwordconnect = sha1($_POST['passwordconnect']);
   if(!empty($_POST['emailconnect']) AND !empty($_POST['passwordconnect'])) {

      $requser = $db->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
      $requser->execute(array($emailconnect, $passwordconnect));
      $userexist = $requser->rowCount();
      if ($userexist == 1) {

         $userinfo = $requser->fetch();
         $_SESSION['id'] = $userinfo['id'];
         $_SESSION['pseudo'] = $userinfo['pseudo'];
         $_SESSION['email'] = $userinfo['email'];
         $_SESSION['ipcam'] = $userinfo['ipcam'];
         header("location: page_user.php");
      } else {
         $erreur = "Email address or Password is invalid. <br> To register, click <a href=\"page_inscription.php\"> HERE </a>";
         }
   } else {
      $erreur = "Veuillez remplir tous les champs";
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
         <a href="page_signup.php" class="uk-button uk-button-primary uk-button-large"> Sign up </a>
         <a href=""><img src="IMG/logo_projet.png" class="homelogo"></a>
         <a href="page_login.php" class="uk-button uk-button-default uk-button-large"> Log in </a>
      </nav>
      <div class="blockformlogin">
         <h2 class="h2form">Log in</h2>
         <form method="POST">
            <table align="center">
               <tr>
                  <td align="right">
                     <label for="emailconnect"><div class="oo"> Email adress : </div></label>
                  </td>
                  <td>
                     <input type="email" name="emailconnect" placeholder="Email" value="<?php if(isset($emailconnect)) { echo $emailconnect; } ?>" />
                  </td>
               </tr>
               <tr>
                  <td align="right">
                     <label for="passwordconnect"> Password : </label>
                  </td>
                  <td>
                     <input type="password" name="passwordconnect" placeholder="Password" />
                  </td>
               </tr>
               <tr>
                  <td></td>
                  <td align="center">
                     <br>
                     <input type="submit" name="formconnection" value="Log in" />
                  </td>
               </tr>
            </table>
         </form>
         <div align="center">
            <?php
            if(isset($erreur)) {
               echo '<font color="red">'.$erreur."</font>";
            }
            ?>
         </div>
      </div>
   </body>
   <footer>
      <div class="copyright">
         Copyright &copy; HomeConnect - 2020 - All Right Reserved
      </div>
   </footer>
</html>