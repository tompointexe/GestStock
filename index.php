<?php
require('config.php');
if(isset($_POST['formconnect'])){
		$mailconnect = htmlspecialchars($_POST['mailconnect']);
		$mdpconnect =sha1($_POST['mdp']);
		if(!empty($mailconnect) AND !empty($mdpconnect))
		{
			$requser = $bdd->prepare("SELECT * FROM membres WHERE `username` = ? AND `password` = ?");
			$requser->execute(array($mailconnect, $mdpconnect));
			$userexist = $requser->rowCount();
			if($userexist ==1)
			{

				$userinfo = $requser->fetch();
				$_SESSION['id'] = $userinfo['id'];
				$_SESSION['pseudo'] = $userinfo['pseudo'];
				header("Location: interface.php");
			}
			else
			{
				$erreur = "Mauvais mail ou mot de passe";
			}
		}
		else
		{
			$erreur = "Tous les champs doivent être complétés !";
		}

	}
?>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="theme.css" type="text/css">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container"> <a class="navbar-brand" href="#">
        <i class="fa d-inline fa-lg fa-circle-o"></i>
        <b> GestionDeStockDEOUF</b>
      </a> <button class="navbar-toggler navbar-toggler-right border-0" type="button" data-toggle="collapse" data-target="#navbar11">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbar11">
      </div>
    </div>
  </nav>
  <div class="py-5 text-center" style="background-image: url(&quot;https://static.pingendo.com/cover-bubble-dark.svg&quot;); background-size: cover; opacity: 0.5;">
    <div class="container">
      <div class="row">
        <div class="mx-auto col-md-6 col-10 bg-white p-5">
          <h1 class="mb-4">Conectez vous avant d'acceder a l'interface<br></h1>
          <form method="post">
		  	<?php
			if(isset($erreur))
			{
				echo '<font color="red">'.$erreur."</font>";
			}else{

			}
			?>
            <div class="form-group"> <input type="text" name="mailconnect" class="form-control" placeholder="Nom d'utilisateur" id="form9"> </div>
            <div class="form-group mb-3"> <input type="password" name="mdp" class="form-control" placeholder="Mot de passe" id="form10"> </div>
			<button type="submit" name="formconnect" class="btn btn-primary">Submit</button>

          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
