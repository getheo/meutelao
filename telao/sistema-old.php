<?php
include_once("includes/conexao.php");
include_once("includes/valida-cpf.php");
$msg="";

session_start();

if(isset($_POST['postar_fotosss'])){
	$images_array=array();
	foreach($_FILES['fotos']['name'] as $key=>$val){
		
		echo "<script>alert('Postou')</script>";
		
		$uploadfile=$_FILES["fotos"]["tmp_name"][$key];
		$folder="fotos/";
		$target_file = $folder.$_FILES['fotos']['name'][$key];
		
		if(move_uploaded_file($_FILES["fotos"]["tmp_name"][$key], "$folder".$_FILES["fotos"]["name"][$key])){
			$images_array[] = $target_file;
			echo "<script>alert('Postou')</script>";
		}
	}
}
?>
<?php
$msg="";
function resizeImage($resourceType,$image_width,$image_height) {
    $resizeWidth = 1280;
    //$resizeHeight = 768;
    $imageLayer = imagecreatetruecolor($resizeWidth,$resizeHeight);
    imagecopyresampled($imageLayer,$resourceType,0,0,0,0,$resizeWidth,$resizeHeight, $image_width,$image_height);
    return $imageLayer;
}
$imageProcess = 0;

if(isset($_POST["form_submit"])) {
	$imageProcess = 0;
    if(is_array($_FILES)) {
        $fileName = $_FILES['upload_image']['tmp_name']; 
        $sourceProperties = getimagesize($fileName);
        $resizeFileName = time();
        $uploadPath = "fotos/";
        $fileExt = pathinfo($_FILES['upload_image']['name'], PATHINFO_EXTENSION);
        $uploadImageType = $sourceProperties[2];
        $sourceImageWidth = $sourceProperties[0];
        $sourceImageHeight = $sourceProperties[1];
        switch ($uploadImageType) {
            case IMAGETYPE_JPEG:
                $resourceType = imagecreatefromjpeg($fileName); 
                $imageLayer = resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight);
                imagejpeg($imageLayer,$uploadPath.$resizeFileName.'.'. $fileExt);
                break;

            case IMAGETYPE_GIF:
                $resourceType = imagecreatefromgif($fileName); 
                $imageLayer = resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight);
                imagegif($imageLayer,$uploadPath.$resizeFileName.'.'. $fileExt);
                break;

            case IMAGETYPE_PNG:
                $resourceType = imagecreatefrompng($fileName); 
                $imageLayer = resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight);
                imagepng($imageLayer,$uploadPath.$resizeFileName.'.'. $fileExt);
                break;

            default:
                $imageProcess = 0;
                break;
        }
        if(move_uploaded_file($file, $uploadPath. $resizeFileName. ".".$fileExt)){
			$imageProcess = 1; echo "<script>alert('Postou')</script>"; } else { $imageProcess = 0; }
    }
	if($imageProcess===1){
			echo "<script>alert('Postou')</script>";
			
			echo $sqlPostarFoto = "INSERT INTO foto (foto_id, foto_nome, foto_evento_id) VALUES ('','".$resizeFileName.".".$fileExt."','1')";			
			//die();
			$exePostarFoto = mysqli_query($conexao,$sqlPostarFoto);
			$verPostarFoto = mysqli_insert_id($conexao);
			
			if($exePostarFoto==true){
				$msg .= "<div class='alert icon-alert with-arrow alert-success form-alter' role='alert'>
					<i class='fa fa-fw fa-check-circle'></i><strong> Successo!</strong><span class='success-message'> Imagens ajustadas</span></div>";
			} else {
				$msg .= "<div class='alert icon-alert with-arrow alert-danger form-alter' role='alert'>
						<i class='fa fa-fw fa-check-circle'></i><strong> Erro!</strong><span class='danger-message'> Não foi enviada</span></div>";		

			}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <title>Upload</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link href="css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
    <link href="themes/explorer-fas/theme.css" media="all" rel="stylesheet" type="text/css"/>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="js/plugins/piexif.js" type="text/javascript"></script>
    <script src="js/plugins/sortable.js" type="text/javascript"></script>
	
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.js" crossorigin="anonymous"></script>
    <script src="js/fileinput.js" type="text/javascript"></script>
    <script src="js/locales/fr.js" type="text/javascript"></script>
    <script src="js/locales/es.js" type="text/javascript"></script>
    <script src="themes/fas/theme.js" type="text/javascript"></script>
    <script src="themes/explorer-fas/theme.js" type="text/javascript"></script>
	
</head>
<body>
<div class="container my-4">
    
    
    <form method="post" enctype="multipart/form-data">        
        <div class="file">
            <input id="file-br" name="upload_image" class="file" type="file" multiple data-min-file-count="1" data-theme="fas">
        </div>
        <br>
        
		<input type="submit" name="form_submit" class="btn btn-primary" value="Gravar Evento" />
		
        <button type="reset" class="btn btn-outline-secondary">Resetar</button>
		
    </form>
	
	<?php echo $msg; ?>
    
</div>
</body>
<script>
    $('#file-br').fileinput({
        theme: 'fas',
        language: 'pt-br',
        uploadUrl: '#',
        allowedFileExtensions: ['JPG','JPEG','jpg','jpeg','png','gif','mp4']
    });
    
    $(document).ready(function () {
        $("#test-upload").fileinput({
            'theme': 'fas',
            'showPreview': false,
            'allowedFileExtensions': ['JPG','JPEG','jpg','jpeg','png','gif','mp4'],
            'elErrorContainer': '#errorBlock'
        });
        
    });
</script>
	
	<!-- <div class="container mt-5 mb-5">
	<div class="row">
		<div class="col-md-6 offset-md-3">
			<h4>Latest News</h4>
			<ul class="timeline">
				<li>
					<a target="_blank" href="https://www.totoprayogo.com/#">New Web Design</a>
					<a href="#" class="float-right">21 March, 2014</a>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque scelerisque diam non nisi semper, et elementum lorem ornare. Maecenas placerat facilisis mollis. Duis sagittis ligula in sodales vehicula....</p>
				</li>
				<li>
					<a href="#">21 000 Job Seekers</a>
					<a href="#" class="float-right">4 March, 2014</a>
					<p>Curabitur purus sem, malesuada eu luctus eget, suscipit sed turpis. Nam pellentesque felis vitae justo accumsan, sed semper nisi sollicitudin...</p>
				</li>
				<li>
					<a href="#">Awesome Employers</a>
					<a href="#" class="float-right">1 April, 2014</a>
					<p>Fusce ullamcorper ligula sit amet quam accumsan aliquet. Sed nulla odio, tincidunt vitae nunc vitae, mollis pharetra velit. Sed nec tempor nibh...</p>
				</li>
			</ul>
		</div>
	</div>
</div> -->
	
</html>