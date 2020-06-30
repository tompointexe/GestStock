<?php
session_start();

require('config.php');
if(isset($_POST['AjouterObjet']))
{
	if($_POST['id'] != null AND $_POST['name'] != null AND $_POST['desc'] != null AND $_POST['quantity'] != null){
			$id = htmlspecialchars($_POST['id']);
			$denomination = htmlspecialchars($_POST['name']);
			$description = htmlspecialchars($_POST['desc']);
			$quantite = htmlspecialchars($_POST['quantity']);

				$insertobj = $bdd->prepare("INSERT INTO objets(barcode, denomination, description, quantité) VALUES(?, ?, ?, ?)");
				$insertobj->execute(array($id, $denomination, $description, $quantite));
				$ok = "L'objet a bien été ajouté";
	 }else {
	 	$erreur = "Vous devez remplir tout les champs"
	 }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="https://static.pingendo.com/bootstrap/bootstrap-4.3.1.css">
  <title>Ajouter un objet au stock</title>
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
          <li class="nav-item"> <a class="nav-link" href="inventaire.html">Inventaire</a> </li>
          <li class="nav-item"> <a class="nav-link" href="ajouter.php">Ajouter un objet</a> </li>
          <li class="nav-item"> <a class="nav-link" href="search.php">Scanner un objet<br></a> </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Dropdown link </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink"> <a class="dropdown-item" href="#">Action</a> <a class="dropdown-item" href="#">Another action</a> <a class="dropdown-item" href="#">Something else here</a> </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="py-5 text-center bg-dark">
    <div class="container">
      <div class="row">
        <div class="mx-auto col-lg-6 col-10">
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
            <div class="form-group"> <label for="form16" class="text-light">Nom de l'objet</label> <input type="text" name="name" class="form-control" id="name" placeholder="TV Samsung"> </div>
						<div class="form-group"> <label for="form16" class="text-light">description</label> <input type="text" name="desc" class="form-control" id="desc" placeholder="Ecran de télévision samsung averc cable"> </div>
						<div class="form-group"> <label for="form16" class="text-light">Quantité totale</label> <input type="text" name="quantity" class="form-control" id="quantity" placeholder="50"> </div>
            <div class="form-group"> <label for="form17" class="text-light">Code bare</label> <input type="text" name="id" class="form-control" id="barcode" placeholder="Id de l'objet"></div>
            <div class="form-group">
              <div class="col-md-4"><a class="btn text-light btn-primary" id="startButton">Démarer le scanner</a></div>
							<br>
								<div id="sourceSelectPanel" style="display:none">
											<label class="text-light" for="sourceSelect">Change video source:</label></br>
											<select id="sourceSelect" style="max-width:400px"></select>
								</div>
              </div>
              <video id="video" width="300" height="200" style="border: 1px solid gray"></video> <br>
            <button type="submit" name="AjouterObjet" class="btn btn-primary">Ajouter l'objet au stock</button>
          </form>
          <script type="text/javascript" src="https://unpkg.com/@zxing/library@latest"></script>
          <script type="text/javascript">
            window.addEventListener('load', function() {
              let selectedDeviceId;
              const codeReader = new ZXing.BrowserMultiFormatReader()
              console.log('ZXing code reader initialized')
              codeReader.getVideoInputDevices().then((videoInputDevices) => {
                const sourceSelect = document.getElementById('sourceSelect')
                selectedDeviceId = videoInputDevices[0].deviceId
                if (videoInputDevices.length >= 1) {
                  videoInputDevices.forEach((element) => {
                    const sourceOption = document.createElement('option')
                    sourceOption.text = element.label
                    sourceOption.value = element.deviceId
                    sourceSelect.appendChild(sourceOption)
                  })
                  sourceSelect.onchange = () => {
                    selectedDeviceId = sourceSelect.value;
                  };
                  const sourceSelectPanel = document.getElementById('sourceSelectPanel')
                  sourceSelectPanel.style.display = 'block'
                }
                document.getElementById('startButton').addEventListener('click', () => {
                  codeReader.decodeFromVideoDevice(selectedDeviceId, 'video', (result, err) => {
                    if (result) {
                      console.log(result)
                      document.getElementById('barcode').value = result.text
                    }
                    if (err && !(err instanceof ZXing.NotFoundException)) {
                      console.error(err)
                      document.getElementById('barcode').value = err
                    }
                  })
                  console.log(`Started continous decode from camera with id ${selectedDeviceId}`)
                })
                document.getElementById('resetButton').addEventListener('click', () => {
                  codeReader.reset()
                  document.getElementById('barcode').value = '';
                  console.log('Reset.')
                })
              }).catch((err) => {
                console.error(err)
              })
            })

          </script>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
