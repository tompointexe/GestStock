<?php
require('config.php');
if(isset($_POST['AjouterObjet'])){

}
?>
<!--  TODO : Mise a jour de la page dynamiquement ? -->
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="https://static.pingendo.com/bootstrap/bootstrap-4.3.1.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <title>Scanner un objet</title>
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
              <a class="dropdown-item" href="deconnection.php">Deconnection</a>
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

<!-- TODO : Page d'erreur -->


<?php } ?>
	


</html>
