<?php
session_start();

include 'Include/database.php';

if(isset($_SESSION['id'])) {

   	$requser = $db->prepare("SELECT * FROM users WHERE id = ?");
   	$requser->execute(array($_SESSION['id']));
   	$userinfo = $requser->fetch();
   	if(isset($_POST['passwordip']) AND !empty($_POST['passwordip']) AND isset($_POST['ipcam']) AND !empty($_POST['ipcam'])) {

      	$passwordip = sha1($_POST['passwordip']);
      	$requser = $db->prepare("SELECT * FROM users WHERE password = ?");
      	$requser->execute(array($passwordip));
      	$mdpexist = $requser->rowCount();
      	if($mdpexist == 1) {

      		$ipcam = htmlspecialchars($_POST['ipcam']);
      		$reqipcam = $db->prepare("SELECT * FROM users WHERE ipcam = ?");
            $reqipcam->execute(array($ipcam));
            $ipexist = $reqipcam->rowCount();
            if($ipexist == 0){

	      		$requser = $db->prepare("UPDATE users SET ipcam = ? WHERE id = ?");
	   			$requser->execute(array($ipcam, $_SESSION['id']));
	      		echo "OK";

	      	} else {
	      		$erreur = "This IP address is already in use.";
	      		}
      	} else {
      		$erreur = "The password is incorrect.";
      		}
    } else if (isset($_POST['formcam'])) {
      $erreur = "Please complete all fields.";
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
        <a href="logout.php" class="uk-button uk-button-primary uk-button-large"> log Out </a>
        <a href="page_user.php"><img src="IMG/logo_projet.png" class="homelogo"></a>
        <a href="page_edit.php" class="uk-button uk-button-primary uk-button-large"> Profile editing </a>
        <a href="page_edit_ipcam.php" class="uk-button uk-button-default uk-button-large"> add camera </a>
    </nav>
    <div class="blockformcam">
    	<h2 class="h2form">Camera editing</h2>
		<form method="POST">
	        <table align="center">
	           <tr>
	               <td align="right">
	                  <label for="passwordip"><div class="oo"> Password : </div></label>
	               </td>
	               <td>
	                  <input type="password" name="passwordip" placeholder="Password" />
	               </td>
	            </tr>
	            <tr>
	               <td align="right">
	                  <label for="ipcam"> Camera IP adress : </label>
	               </td>
	               <td>
	                  <input type="text" name="ipcam" placeholder="Ex : 192.168.25.1" />
	               </td>
	            </tr>
	            <tr>
	            	<td></td>
	            	<td align="center">
	            		<br>
	            		<input type="submit" name="formcam" value="Update">
	            	</td>
	            </tr>
	        </table>
	    </form>
	    <?php
	      	if(isset($erreur)) {
	          	echo '<font color="red">'.$erreur."</font>";
	       	}
	    ?>
	</div>
</body>
</html>