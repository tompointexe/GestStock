<?php
require('config.php');
if(isset($_POST['AjouterObjet'])){
	if($_POST['id'] != null AND $_POST['name'] != null AND $_POST['desc'] != null AND $_POST['quantity'] != null){
			$id = htmlspecialchars($_POST['id']);
			$denomination = htmlspecialchars($_POST['name']);
			$description = htmlspecialchars($_POST['desc']);
			$quantite = htmlspecialchars($_POST['quantity']);

				$insertobj = $bdd->prepare("INSERT INTO objets(barcode, denomination, description, instock) VALUES(?, ?, ?, ?)");
				$insertobj->execute(array($id, $denomination, $description, $quantite));
				$ok = "L'objet a bien été ajouté";
	 }else {
	 	$erreur = "Vous devez remplir tout les champs";
	 }
}
?>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="https://static.pingendo.com/bootstrap/bootstrap-4.3.1.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" href="ajouter.css" type="text/css">
  <title>Ajouter un objet au stock</title>
</head>
<?php if(isset($_GET['id']) AND $_GET['id'] > 0){ ?>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container"> 
	 <a class="navbar-brand" href="#">
        <i class="fa d-inline fa-lg fa-circle-o"></i>
        <b> GestionDeStockDEOUF</b>
      </a> <button class="navbar-toggler navbar-toggler-right border-0" type="button" data-toggle="collapse" data-target="#navbar11">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbar11">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item"> <a class="nav-link" href="interface.php"> <i class="fa fa-lg fa-list-ul"></i> Inventaire</a> </li>
          <li class="nav-item active"> <a class="nav-link" href="ajouter.php"> <i class="fa fa-lg fa-plus"></i> Ajouter un objet</a> </li>
          <li class="nav-item"> <a class="nav-link" href="search.php"> <i class="fa fa-lg fa-barcode"></i> Scanner un objet<br></a> </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?php echo $_SESSION['username'];?> </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink"> 
			<!--  TODO : Menu -->
				<a class="dropdown-item" href="#">Action</a> 
				<a class="dropdown-item" href="#">Another action</a> 
				<a class="dropdown-item" href="#">Something else here</a> 
			</div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="py-5 text-center bg-dark">
    <div class="container">
      <div class="row">
        <div class="mx-auto">
          <h1 class="text-light">Creation d'un objet dans le stock</h1>
		 	<?php
				if(isset($ok)){
					echo '<h1><font color="green">'.$ok."</font></h1>";
				}else {
					if(isset($erreur)){
						echo '<h1><font color="red">'.$erreur."</font></h1>";
					}
				}
			?>
          <form method="POST" class="text-left">
            <div class="form-group">
			<label for="form16" class="text-light">Nom de l'objet</label>
			<input type="text" name="name" class="form-control" id="name" placeholder="TV Samsung">
			</div>
			<div class="form-group">
			<label for="form16" class="text-light">description</label>
			<input type="text" name="desc" class="form-control" id="desc" placeholder="Ecran de télévision samsung averc cable">
			</div>
			<div class="form-group">
			<label for="form16" class="text-light">En stock ?</label>
			<input type="text" name="quantity" class="form-control" id="quantity" placeholder="A changer par un dropdown avec oui ou non ou inconnu">
			</div>
      <div class="form-group">
			<label for="form17" class="text-light">Code barre</label> <input type="text" name="id" class="form-control" id="barcode" placeholder="Id de l'objet">
			</div>
			<div class="py-5">
				<div class="container">
					<div class="row">
		   			<div class="col-md-6">
							<div class="panel panel-primary autocollapse">
								<div class="panel-heading clickable">
									<h3 class="panel-title text-light">
										Scanner de code barre
									</h3>
								</div>
								<div class="panel-body">
									<div class="form-group">
										<div class="col-md-4">
											<a class="btn text-light btn-primary" id="startButton">Démarer le scanner</a>
											<a class="btn text-light btn-primary" id="resetButton">Aréter le scanner</a>
										</div>
										<br>
										<video id="video" width="300" height="200" style="border: 1px solid gray"></video>
										<br>
										<br>
										<div id="sourceSelectPanel" style="display:none">
               								 <label for="sourceSelect" style="color:white;">Change video source:</label>
            								 <select id="sourceSelect" style="max-width:400px">
                						  	 </select>
           								 </div>
										<br>
										</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="panel panel-primary autocollapse">
								<div class="panel-heading clickable">
									<h3 class="panel-title text-light">
										Generateur de codes barres
									</h3>
								</div>
								<div class="panel-body">
									<div class="alert alert-danger" role="alert">En cours de developpement</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
            <button type="submit" name="AjouterObjet" class="btn btn-primary">Ajouter l'objet au stock</button>
          </form>

	      <script type="text/javascript" src="https://unpkg.com/@zxing/library@latest"></script>
          <script type="text/javascript">
            window.addEventListener('load', function () {
              let selectedDeviceId;
              const codeReader = new ZXing.BrowserBarcodeReader()
              console.log('ZXing code reader initialized')
              codeReader.getVideoInputDevices()
                .then((videoInputDevices) => {
                    const sourceSelect = document.getElementById('sourceSelect')
                    selectedDeviceId = videoInputDevices[0].deviceId
                    if (videoInputDevices.length > 1) {
                        videoInputDevices.forEach((element) => {
                            const sourceOption = document.createElement('option')
                            sourceOption.text = element.label
                            sourceOption.value = element.deviceId
                            sourceSelect.appendChild(sourceOption)
                        })

                        sourceSelect.onchange = () => {
                            selectedDeviceId = sourceSelect.value;
                        }

                        const sourceSelectPanel = document.getElementById('sourceSelectPanel')
                        sourceSelectPanel.style.display = 'block';
                    }

                    document.getElementById('startButton').addEventListener('click', () => {
                        codeReader.decodeOnceFromVideoDevice(selectedDeviceId, 'video').then((result) => {
                            //console.log(result)
                            document.getElementById('barcode').value = result.text;
                        }).catch((err) => {
                            console.error(err)
                            document.getElementById('barcode').value = `Une erreur est survenue, merci de contacter le developpeur` ;
                        })
                        console.log(`Started continous decode from camera with id ${selectedDeviceId}`)
                    })

                    document.getElementById('resetButton').addEventListener('click', () => {
                        codeReader.reset();
                        console.log('Reset.')
                    })

                })
                .catch((err) => {
                    console.error(err)
                })
            })
          </script>
		  <script type="text/javascript">
					$(document).on('click', '.panel div.clickable', function (e) {
						var $this = $(this); //Heading
						var $panel = $this.parent('.panel');
						var $panel_body = $panel.children('.panel-body');
						var $display = $panel_body.css('display');

						if ($display == 'block') {
							$panel_body.slideUp();
						} else if($display == 'none') {
							$panel_body.slideDown();
						}
					});

					$(document).ready(function(e){
						var $classy = '.panel.autocollapse';

						var $found = $($classy);
						$found.find('.panel-body').hide();
						$found.removeClass($classy);
					});
          </script>
        </div>
      </div>
    </div>
  </div>
   <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
<?php }else { ?>

<!-- TODO : Page d'erreur-->


<?php } ?>
	


</html>
