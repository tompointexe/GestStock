<?php
require('config.php');
if(isset($_GET['id']) AND $_GET['id'] > 0){
	$objid = intval($_GET['id']);
	$req = $bdd->prepare('SELECT * FROM objets WHERE id = ?');
	$req->execute(array($objid));
	$objinfo = $req->fetch();
	if(isset($_POST['moins1'])){
  $newstate = 0;
	$updatecount = $bdd->prepare("UPDATE objets SET instock = ? WHERE id = ? ");
  $updatecount->execute(array($newstate, $objid));
	}
	if(isset($_POST['plus1'])){
  $newstate = 1;
	$updatecount = $bdd->prepare("UPDATE objets SET instock = ? WHERE id = ? ");
  $updatecount->execute(array($newstate, $objid));
	}
	
	
?>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="https://static.pingendo.com/bootstrap/bootstrap-4.3.1.css">
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
        <ul class="navbar-nav mr-auto">
          <li class="nav-item"> <a class="nav-link" href="interface.php"> <i class="fa fa-lg fa-arrow-left"></i> Retour a l'inventaire</a> </li>
          <li class="nav-item"> <a class="nav-link" href="ajouter.php"> <i class="fa fa-lg fa-plus"></i> Ajouter un objet</a> </li>
          <li class="nav-item"> <a class="nav-link" href="search.php"> <i class="fa fa-lg fa-barcode"></i> Scanner un objet<br></a> </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?php echo $_SESSION['username'];?> </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink"> 
            <!--  TODO : Menu -->
            <a class="dropdown-item" href="#">Action</a> 
              <a class="dropdown-item" href="#">Another action</a> 
              <a class="dropdown-item" href="deconnection.php">Deconnection</a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  
  <div class="py-2 bg-light">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1 class="display-2"><?php echo $objinfo['denomination'];?><br></h1>
        </div>
      </div>
    </div>
  </div>
  <div class="py-1">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
		    <form method="POST">
          <ul class="pagination">
             <li class="page-item"> <button type="submit" name="moins1" class="btn btn-primary">Sortir du stock</button> <p>    </p></li>
             <li class="page-item"> <a class="page-link"><?php 
		          	if(isset($newstate)){
                  if($newstate == 1){
                    echo "En stock";
                  }else{
                    echo "Hors stock";
                  }
			          }else{
                  if($objinfo['instock'] == 1){
                    echo "En stock";
                  }else{
                    echo "Hors stock";
                  }
			          }	
			          ?></a></li>
            <li class="page-item"> <p>    </p> <button type="submit" name="plus1" class="btn btn-primary">Rentrer dans le stock</button></li>
          </ul>
		    </form>
        </div>
      </div>
    </div>
  </div>
  <div class="border-0 border-bottom w-100 shadow-none py-3 px-3 p-2 h-50 bg-info">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
        <!--  TODO : Responsive + taile auto -->
          <h2 class=""><?php echo $objinfo['description'];?></h2>
        </div>
      </div>
    </div>
  </div>

  <!--  TODO : Afficher le code bare / générer -->

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<?php
}else { 
?>
	<font color="#ff0000"><H1>Erreur</H1></font>
	<H2>Impossible d'afficher l'objet, redirection vers la page d'accueil <H2>
<?php
	header("Location: interface.php");
}
?>
</body>
</html>