<?php require_once('Connections/Conexion.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.

// *** REGISTRO ***

$editFormAction = $_SERVER['PHP_SELF'];

if (isset($_SERVER['QUERY_STRING'])) {
	  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
	}

if ((isset($_POST["btnRegistro"])) && ($_POST["btnRegistro"] == "Aceptar")) {

	
	
	//if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frmAcceso")) {
	  $insertSQL = sprintf("INSERT INTO usuarios (strCorreo, strPass, intActivo) VALUES (%s, %s, %s)",
						   GetSQLValueString($_POST['strCorreo'], "text"),
						   GetSQLValueString(md5($_POST['strPass']), "text"),
						   GetSQLValueString($_POST['intActivo'], "int"));
	
	  mysql_select_db($database_Conexion, $Conexion);
	  $Result1 = mysql_query($insertSQL, $Conexion) or die(mysql_error());
	
	  $insertGoTo = "altaOK.php";
	  if (isset($_SERVER['QUERY_STRING'])) {
		$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
		$insertGoTo .= $_SERVER['QUERY_STRING'];
	  }
	  header(sprintf("Location: %s", $insertGoTo));
	//}
}

/////////REGISTRO////////////

// *** LOGEO ***

$loginFormAction = $_SERVER['PHP_SELF'];
//If perteneciente al botón del logueo
if ((isset($_POST["btnAcceso"])) && ($_POST["btnAcceso"] == "Acceder")) {

	if (!isset($_SESSION)) {
	  session_start();
	}



if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['email'])) {
  $loginUsername=$_POST['email'];
  $password=md5($_POST['pass']);
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "logueoOK.php";
  $MM_redirectLoginFailed = "logueoFAIL.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_Conexion, $Conexion);
  
  $LoginRS__query=sprintf("SELECT strCorreo, strPass FROM usuarios WHERE strCorreo=%s AND strPass=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $Conexion) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
/////////LOGUEO////////////
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="ico/pmpicon.png">
    
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/apple-touch-icon-72x72-precomposed.png" />

<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/apple-touch-icon-114x114precomposed.png" />

<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/apple-touch-icon-144x144-precomposed.png" />

    <title>Pets meet Pets</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom bootstrap styles -->
    <link href="css/overwrite.css" rel="stylesheet">

	<!-- Flexslider styles -->
    <link href="css/flexslider.css" rel="stylesheet">

	<!-- prettyPhoto styles -->
    <link href="css/prettyPhoto.css" rel="stylesheet">
	
	<!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">

	<!-- Skin color styles for this template -->
    <link href="skin/default.css" rel="stylesheet">
    
  
	<!-- Font -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Oleo+Script' rel='stylesheet' type='text/css'>
    <link href=
'http://fonts.googleapis.com/css?family=Dosis:300' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
	
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="assets/js/respond.min.js"></script>
    <![endif]-->
    
    
  </head>

  <body> 
   
  <div id="cbp-so-scroller" class="cbp-so-scroller">
		<!-- Start section home -->
		<section id="home">
			<div class="container text-center">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<a href="index.html" class="logo"><img src="img/logo-pmp.png" alt="" /></a>
						<div class="intro">							
							<div class="scrolltop">                     
								<ul>
									<li>
										<h3>Pets meet Pets</h3>
										<p>La red social para propietarios de mascotas más completa</p>
									</li>
									<li>
										<h3>Collar nfc</h3>
										<p>Sistema de recuperación de animales perdidos</p>
									</li>	
									<li>
										<h3>Herramientas</h3>
										<p>Agenda profiláctica, predispoción racial, diagnóstico, noticias, eventos...</p>
									</li>								
								</ul>						
							</div>
							<div class="intro-divider"></div>
							<p>
							 Pets meet Pets es una red social para propietarios de mascotas que ofrece los servicios básicos de una red social: perfiles públicos y privados, grupos, publicación de estados, mensajería, etc. Además, al ser una red social dedicada a las mascotas, ofrecerá otra serie de servicios relacionados con los animales de compañía como: agenda profiláctica, herramienta de diagnóstico y predisposición racial a enfermedades. 
							</p>
                            <p>
							 Pets meet Pets también dispone de un novedoso sistema de recuperación de animales perdidos a través de su collar NFC. 
							</p>
							<a href="#contact" class="btn btn-lg btn-tertiary">Regístrate</a>
                            <p> </p>
							<a href="#login" class="btn btn-lg btn-tertiary">Ya estoy registrado</a>							
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Start section home -->

		<!-- Start header -->
		<header>
			<div class="navbar navbar-inverse">
				<div class="container">
					<div class="navbar-header">
						<a class="navbar-brand" href="#"><img src="img/logo-small-pmp.png" alt="" /></a>
					</div>
					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav">
							<li><a href="#home">Home</a></li>
							<li><a href="#about">Proyecto</a></li>
							<li><a href="#testimoni">Testimonios</a></li>
							<li><a href="#services">Servicios</a></li>
							<li><a href="#gallery">Pioneros</a></li>
							<li><a href="#contact">Registro</a></li>							
						</ul>
					</div><!--/.nav-collapse -->		
				</div>
			</div>
		</header>
		<!-- End header --> 
        
		<!-- Start section about -->
		<section id="about">
			<div class="container">
				<div class="row cbp-so-section">
					<div class="col-md-5 cbp-so-side cbp-so-side-left">
						<img src="img/iphone-pmp.png" class="img-responsive" alt="" />				
					</div>
					<div class="col-md-7 cbp-so-side cbp-so-side-right">	
						<h3 class="heading">Proyecto Pets meet Pets</h3>
						<p>
						Pets meet Pets pretende, por un lado, crear una plataforma en la Red que sirva de punto de encuentro para los propietarios y amantes de mascotas además de proporcionales una serie de servicios útiles online; y por otro, crear, mediante su collar NFC, un sistema que funcionando conjuntamente con la red social permita recuperar animales perdidos.
						</p>
						<p>
						Este proyecto es fruto del "crowdfunding" y su puesta marcha ha sido posible gracias a las aportaciones de un buen número de personas que conviven con animales y quieren cuidarlos y protegerlos.
						</p>
                        <a href="#contact" class="btn btn-lg btn-tertiary">  Regístrate  </a>
                        <p> </p>
                        <p>Si  quieres saber sobre este proyecto: </p>
						<a href="http://goteo.org/project/collar-nfc-pets" target="_blank" class="btn btn-default">Crowdfunding</a>
						<a href="http://vimeo.com/76229705" data-pretty="prettyPhoto" class="btn btn-tertiary">Video</a>
					</div>				
				</div>
			</div>				
		</section>
		<!-- End section about -->
		
		<!-- Start testimoni -->
		<section id="testimoni" class="container-wrapper">
			<div class="container">
				<div class="row">
					<div class="col-md-12">	
						<h3 class="heading centered">Testimonios</h3>
						<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
							<ol class="carousel-indicators">
								<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
								<li data-target="#carousel-example-generic" data-slide-to="1"></li>
								<li data-target="#carousel-example-generic" data-slide-to="2"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="3"></li>
							</ol>
							<div class="carousel-inner">
								<div class="item active">
									<div class="testimoni-wrapp">
										<img src="img/testimoni/testimoniogloria.jpg" class="img-circle" alt="" />
                                        <p></p>
										<p>Las personas que encontraron a Sira no pudieron contactar conmigo.<br> Si mi perrita hubiera tenido este collar aún estaría con nosotros.</p>
										<p class="clent-info">
											Gloria Lorenzo
										</p>							
									</div>			
								</div>
                                <div class="item">
									<div class="testimoni-wrapp">
										<img src="img/testimoni/testimoniodiariohoy.jpg" class="img-circle" alt="" />
                                        <p></p>
										<p>Llega la tecnología para perros despistados. Dos extremeños patentan un collar que al pasarle el móvil muestra los datos de la mascota y envía un mensaje al dueño</p>
										<p class="clent-info">
											Puerto Blázquez <a href="http://www.hoy.es/v/20130817/regional/llega-tecnologia-para-perros-20130817.html" target="_blank">Diario Hoy</a>
										</p>							
									</div>	
								</div>
								<div class="item">
									<div class="testimoni-wrapp">
										<img src="img/testimoni/testimoniopedro.jpg" class="img-circle" alt="" />
                                        <p></p>
										<p>Me gusta el proyecto, me gusta el collar, me gustan los servicios.<br> Danko y yo estamos en Pets meet Pets!</p>
										<p class="clent-info">
											Pedro Bautista
										</p>							
									</div>	
								</div>
								<div class="item">
									<div class="testimoni-wrapp">
										<img src="img/testimoni/testimoniocadenaser.jpg" class="img-circle" alt="" />
                                        <p></p>
										<p>Pets meet Pets es una red social que tiene el objetivo de poner en contacto a personas que pierden a sus mascotas con aquellas que las encuentran, a través de su collar NFC.</p>
										<p class="clent-info">
											José Emiliano Barrena <a href="http://www.cadenaser.com/tecnologia/articulo/pets-meet-pets-red-social-perros/csrcsrpor/20131113csrcsrtec_2/Tes" target="_blank">Cadena Ser</a>
										</p>							
									</div>	
								</div>
							</div>
						</div>						
					</div>
				</div>
			</div>	
		</section>
		<!-- End testimoni -->
	
		<!-- Start section services -->
		<section id="services" class="container-wrapper">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h3 class="heading centered">Servicios</h3>
					</div>			
				</div>			
				<div class="row cbp-so-section text-center">
					<div class="col-md-4 cbp-so-side cbp-so-side-left">
						<img src="img/icon-redsocial.png" class="service-icon tertiary-icon marginbot30" alt="" />
						<h4>Red Social</h4>
						<p>
						Conéctate con tus amigos y comparte
						</p>
                        <p><a href="redsocial/presentacion.html" target="_blank" class="btn btn-sm btn-default">+ Info</a></p>
					</div>
					<div class="col-md-4">	
						<img src="img/icon-fonendo.png" class="service-icon secondary-icon marginbot30" alt="" />
						<h4>Salud y cuidados</h4>
						<p>
						Información y herramientas para cuidar a tu mascota
						</p>
                        
                        <!-- Hacer imagen
                        <p><a href="redsocial/presentacion.html?iframe=true&width=600&height=460" class="btn btn-sm btn-default" data-pretty="prettyPhoto">+ Info</a></p>	
                        <!-- Hacer imagen -->
                        
					</div>
					<div class="col-md-4 cbp-so-side cbp-so-side-right">	
						<img src="img/icon-collar.png" class="service-icon default-icon marginbot30" alt="" />
						<h4>Collar NFC</h4>
						<p>
						Identifica y recupera tu mascota
						</p>
												<p><a href="img/gallery/img-big-collar.jpg" class="btn btn-sm btn-default" data-pretty="prettyPhoto">+ Info</a></p>
					</div>				
				</div>
			</div>				
		</section>
		<!-- End section services -->
		
		<!-- Start section gallery -->
		<section id="gallery">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h3 class="heading centered">Pioneros</h3>

							<p>
							 Pets meet Pets es fruto de la ayuda y financiación de decenas de amantes de las mascotas. Ellos son los "pioneros" de Pets meet Pets: 
							</p>
                            <p> </p>							

					</div>
					<div class="col-md-12">
					<div class="flexslider">
					  <ul class="slides">
						<!-- Start gallery row 1 -->
						<li>
							<div class="row gallery">
								<div class="col-md-3">
									<div class="gallery-img-wrapper">
										<div class="caption-wrapper">
											<div class="caption-text">
												<a href="img/gallery/img-big.jpg" class="zoom" data-pretty="prettyPhoto">zoom</a>
												<p>
												En construcción
												</p>
											</div>
											<div class="caption-bg"></div>
										</div>								
										<img src="img/gallery/img1.jpg" class="img-responsive" alt="" />														
									</div>
									<h5 class="gallery-title">En construcción</h5>
								</div>
								
								<div class="col-md-3">
									<div class="gallery-img-wrapper">
										<div class="caption-wrapper">
											<div class="caption-text">
												<a href="img/gallery/img-big.jpg" class="zoom" data-pretty="prettyPhoto">zoom</a>
												<p>
												En construcción
												</p>
											</div>
											<div class="caption-bg"></div>
										</div>								
										<img src="img/gallery/img2.jpg" class="img-responsive" alt="" />														
									</div>
									<h5 class="gallery-title">En construcción</h5>
								</div>
								
								<div class="col-md-3">
									<div class="gallery-img-wrapper">
										<div class="caption-wrapper">
											<div class="caption-text">
												<a href="img/gallery/img-big.jpg" class="zoom" data-pretty="prettyPhoto">zoom</a>
												<p>
												En construcción
												</p>
											</div>
											<div class="caption-bg"></div>
										</div>								
										<img src="img/gallery/img3.jpg" class="img-responsive" alt="" />														
									</div>
									<h5 class="gallery-title">En construcción</h5>
								</div>
								
								<div class="col-md-3">
									<div class="gallery-img-wrapper">
										<div class="caption-wrapper">
											<div class="caption-text">
												<a href="img/gallery/img-big.jpg" class="zoom" data-pretty="prettyPhoto">zoom</a>
												<p>
												En construcción
												</p>
											</div>
											<div class="caption-bg"></div>
										</div>								
										<img src="img/gallery/img4.jpg" class="img-responsive" alt="" />														
									</div>
									<h5 class="gallery-title">En construcción</h5>
								</div>
								
								<div class="col-md-3">
									<div class="gallery-img-wrapper">
										<div class="caption-wrapper">
											<div class="caption-text">
												<a href="img/gallery/img-big.jpg" class="zoom" data-pretty="prettyPhoto">zoom</a>
												<p>
												En construcción
												</p>
											</div>
											<div class="caption-bg"></div>
										</div>								
										<img src="img/gallery/img5.jpg" class="img-responsive" alt="" />														
									</div>
									<h5 class="gallery-title">En construcción</h5>
								</div>	
								
								<div class="col-md-3">
									<div class="gallery-img-wrapper">
										<div class="caption-wrapper">
											<div class="caption-text">
												<a href="img/gallery/img-big.jpg" class="zoom" data-pretty="prettyPhoto">zoom</a>
												<p>
												En construcción
												</p>
											</div>
											<div class="caption-bg"></div>
										</div>								
										<img src="img/gallery/img6.jpg" class="img-responsive" alt="" />														
									</div>
									<h5 class="gallery-title">En construcción</h5>
								</div>	
								
								<div class="col-md-3">
									<div class="gallery-img-wrapper">
										<div class="caption-wrapper">
											<div class="caption-text">
												<a href="img/gallery/img-big.jpg" class="zoom" data-pretty="prettyPhoto">zoom</a>
												<p>
												En construcción
												</p>
											</div>
											<div class="caption-bg"></div>
										</div>								
										<img src="img/gallery/img7.jpg" class="img-responsive" alt="" />														
									</div>
									<h5 class="gallery-title">En construcción</h5>
								</div>	
								
								<div class="col-md-3">
									<div class="gallery-img-wrapper">
										<div class="caption-wrapper">
											<div class="caption-text">
												<a href="img/gallery/img-big.jpg" class="zoom" data-pretty="prettyPhoto">zoom</a>
												<p>
												En construcción
												</p>
											</div>
											<div class="caption-bg"></div>
										</div>								
										<img src="img/gallery/img8.jpg" class="img-responsive" alt="" />														
									</div>
									<h5 class="gallery-title">En construcción</h5>
								</div>						
						   </div>
						</li>
						<!-- End gallery row 1 -->
						
						<!-- Start gallery row 2 -->
						<li>
							<div class="row gallery">
								<div class="col-md-3">
									<div class="gallery-img-wrapper">
										<div class="caption-wrapper">
											<div class="caption-text">
												<a href="img/gallery/img-big.jpg" class="zoom" data-pretty="prettyPhoto">zoom</a>
												<p>
												En construcción
												</p>
											</div>
											<div class="caption-bg"></div>
										</div>								
										<img src="img/gallery/img9.jpg" class="img-responsive" alt="" />														
									</div>
									<h5 class="gallery-title">En construcción</h5>
								</div>
								
								<div class="col-md-3">
									<div class="gallery-img-wrapper">
										<div class="caption-wrapper">
											<div class="caption-text">
												<a href="img/gallery/img-big.jpg" class="zoom" data-pretty="prettyPhoto">zoom</a>
												<p>
												En construcción
												</p>
											</div>
											<div class="caption-bg"></div>
										</div>								
										<img src="img/gallery/img10.jpg" class="img-responsive" alt="" />														
									</div>
									<h5 class="gallery-title">En construcción</h5>
								</div>
								
								<div class="col-md-3">
									<div class="gallery-img-wrapper">
										<div class="caption-wrapper">
											<div class="caption-text">
												<a href="img/gallery/img-big.jpg" class="zoom" data-pretty="prettyPhoto">zoom</a>
												<p>
												En construcción
												</p>
											</div>
											<div class="caption-bg"></div>
										</div>								
										<img src="img/gallery/img11.jpg" class="img-responsive" alt="" />														
									</div>
									<h5 class="gallery-title">En construcción</h5>
								</div>
								
								<div class="col-md-3">
									<div class="gallery-img-wrapper">
										<div class="caption-wrapper">
											<div class="caption-text">
												<a href="img/gallery/img-big.jpg" class="zoom" data-pretty="prettyPhoto">zoom</a>
												<p>
												En construcción
												</p>
											</div>
											<div class="caption-bg"></div>
										</div>								
										<img src="img/gallery/img12.jpg" class="img-responsive" alt="" />														
									</div>
									<h5 class="gallery-title">En construcción</h5>
								</div>
								
								<div class="col-md-3">
									<div class="gallery-img-wrapper">
										<div class="caption-wrapper">
											<div class="caption-text">
												<a href="img/gallery/img-big.jpg" class="zoom" data-pretty="prettyPhoto">zoom</a>
												<p>
												En construcción
												</p>
											</div>
											<div class="caption-bg"></div>
										</div>								
										<img src="img/gallery/img13.jpg" class="img-responsive" alt="" />														
									</div>
									<h5 class="gallery-title">En construcción</h5>
								</div>	
								
								<div class="col-md-3">
									<div class="gallery-img-wrapper">
										<div class="caption-wrapper">
											<div class="caption-text">
												<a href="img/gallery/img-big.jpg" class="zoom" data-pretty="prettyPhoto">zoom</a>
												<p>
												En construcción
												</p>
											</div>
											<div class="caption-bg"></div>
										</div>								
										<img src="img/gallery/img14.jpg" class="img-responsive" alt="" />														
									</div>
									<h5 class="gallery-title">En construcción</h5>
								</div>	
								
								<div class="col-md-3">
									<div class="gallery-img-wrapper">
										<div class="caption-wrapper">
											<div class="caption-text">
												<a href="img/gallery/img-big.jpg" class="zoom" data-pretty="prettyPhoto">zoom</a>
												<p>
												En construcción
												</p>
											</div>
											<div class="caption-bg"></div>
										</div>								
										<img src="img/gallery/img15.jpg" class="img-responsive" alt="" />														
									</div>
									<h5 class="gallery-title">En construcción</h5>
								</div>	
								
								<div class="col-md-3">
									<div class="gallery-img-wrapper">
										<div class="caption-wrapper">
											<div class="caption-text">
												<a href="img/gallery/img-big.jpg" class="zoom" data-pretty="prettyPhoto">zoom</a>
												<p>
												En construcción
												</p>
											</div>
											<div class="caption-bg"></div>
										</div>								
										<img src="img/gallery/img16.jpg" class="img-responsive" alt="" />														
									</div>
									<h5 class="gallery-title">En construcción</h5>
								</div>						
						   </div>
						</li>
						<!-- End gallery row 2 -->
						
						<!-- Start gallery row 3 -->
						<li>
							<div class="row gallery">
								<div class="col-md-3">
									<div class="gallery-img-wrapper">
										<div class="caption-wrapper">
											<div class="caption-text">
												<a href="img/gallery/img-big.jpg" class="zoom" data-pretty="prettyPhoto">zoom</a>
												<p>
												En construcción
												</p>
											</div>
											<div class="caption-bg"></div>
										</div>								
										<img src="img/gallery/img4.jpg" class="img-responsive" alt="" />														
									</div>
									<h5 class="gallery-title">En construcción</h5>
								</div>
								
								<div class="col-md-3">
									<div class="gallery-img-wrapper">
										<div class="caption-wrapper">
											<div class="caption-text">
												<a href="img/gallery/img-big.jpg" class="zoom" data-pretty="prettyPhoto">zoom</a>
												<p>
												En construcción
												</p>
											</div>
											<div class="caption-bg"></div>
										</div>								
										<img src="img/gallery/img6.jpg" class="img-responsive" alt="" />														
									</div>
									<h5 class="gallery-title">En construcción</h5>
								</div>
								
								<div class="col-md-3">
									<div class="gallery-img-wrapper">
										<div class="caption-wrapper">
											<div class="caption-text">
												<a href="img/gallery/img-big.jpg" class="zoom" data-pretty="prettyPhoto">zoom</a>
												<p>
												En construcción
												</p>
											</div>
											<div class="caption-bg"></div>
										</div>								
										<img src="img/gallery/img10.jpg" class="img-responsive" alt="" />														
									</div>
									<h5 class="gallery-title">En construcción</h5>
								</div>
								
								<div class="col-md-3">
									<div class="gallery-img-wrapper">
										<div class="caption-wrapper">
											<div class="caption-text">
												<a href="img/gallery/img-big.jpg" class="zoom" data-pretty="prettyPhoto">zoom</a>
												<p>
												En construcción
												</p>
											</div>
											<div class="caption-bg"></div>
										</div>								
										<img src="img/gallery/img2.jpg" class="img-responsive" alt="" />														
									</div>
									<h5 class="gallery-title">En construcción</h5>
								</div>
								
								<div class="col-md-3">
									<div class="gallery-img-wrapper">
										<div class="caption-wrapper">
											<div class="caption-text">
												<a href="img/gallery/img-big.jpg" class="zoom" data-pretty="prettyPhoto">zoom</a>
												<p>
												En construcción
												</p>
											</div>
											<div class="caption-bg"></div>
										</div>								
										<img src="img/gallery/img11.jpg" class="img-responsive" alt="" />														
									</div>
									<h5 class="gallery-title">En construcción</h5>
								</div>	
								
								<div class="col-md-3">
									<div class="gallery-img-wrapper">
										<div class="caption-wrapper">
											<div class="caption-text">
												<a href="img/gallery/img-big.jpg" class="zoom" data-pretty="prettyPhoto">zoom</a>
												<p>
												En construcción
												</p>
											</div>
											<div class="caption-bg"></div>
										</div>								
										<img src="img/gallery/img16.jpg" class="img-responsive" alt="" />														
									</div>
									<h5 class="gallery-title">En construcción</h5>
								</div>	
								
								<div class="col-md-3">
									<div class="gallery-img-wrapper">
										<div class="caption-wrapper">
											<div class="caption-text">
												<a href="img/gallery/img-big.jpg" class="zoom" data-pretty="prettyPhoto">zoom</a>
												<p>
												En construcción
												</p>
											</div>
											<div class="caption-bg"></div>
										</div>								
										<img src="img/gallery/img8.jpg" class="img-responsive" alt="" />														
									</div>
									<h5 class="gallery-title">En construcción</h5>
								</div>	
								
								<div class="col-md-3">
									<div class="gallery-img-wrapper">
										<div class="caption-wrapper">
											<div class="caption-text">
												<a href="img/gallery/img-big.jpg" class="zoom" data-pretty="prettyPhoto">zoom</a>
												<p>
												En construcción
												</p>
											</div>
											<div class="caption-bg"></div>
										</div>								
										<img src="img/gallery/img7.jpg" class="img-responsive" alt="" />														
									</div>
									<h5 class="gallery-title">En construcción</h5>
								</div>						
						   </div>
						</li>
						<!-- End gallery row 3 -->
						
						<!-- Start gallery row 4 -->
						<li>
							<div class="row gallery">
								<div class="col-md-3">
									<div class="gallery-img-wrapper">
										<div class="caption-wrapper">
											<div class="caption-text">
												<a href="img/gallery/img-big.jpg" class="zoom" data-pretty="prettyPhoto">zoom</a>
												<p>
												En construcción
												</p>
											</div>
											<div class="caption-bg"></div>
										</div>								
										<img src="img/gallery/img16.jpg" class="img-responsive" alt="" />														
									</div>
									<h5 class="gallery-title">En construcción</h5>
								</div>
								<div class="col-md-3">
									<div class="gallery-img-wrapper">
										<div class="caption-wrapper">
											<div class="caption-text">
												<a href="img/gallery/img-big.jpg" class="zoom" data-pretty="prettyPhoto">zoom</a>
												<p>
												En construcción
												</p>
											</div>
											<div class="caption-bg"></div>
										</div>								
										<img src="img/gallery/img5.jpg" class="img-responsive" alt="" />														
									</div>
									<h5 class="gallery-title">En construcción</h5>
								</div>
								<div class="col-md-3">
									<div class="gallery-img-wrapper">
										<div class="caption-wrapper">
											<div class="caption-text">
												<a href="img/gallery/img-big.jpg" class="zoom" data-pretty="prettyPhoto">zoom</a>
												<p>
												En construcción
												</p>
											</div>
											<div class="caption-bg"></div>
										</div>								
										<img src="img/gallery/img10.jpg" class="img-responsive" alt="" />														
									</div>
									<h5 class="gallery-title">En construcción</h5>
								</div>
								<div class="col-md-3">
									<div class="gallery-img-wrapper">
										<div class="caption-wrapper">
											<div class="caption-text">
												<a href="img/gallery/img-big.jpg" class="zoom" data-pretty="prettyPhoto">zoom</a>
												<p>
												En construcción
												</p>
											</div>
											<div class="caption-bg"></div>
										</div>								
										<img src="img/gallery/img15.jpg" class="img-responsive" alt="" />														
									</div>
									<h5 class="gallery-title">En construcción</h5>
								</div>
								<div class="col-md-3">
									<div class="gallery-img-wrapper">
										<div class="caption-wrapper">
											<div class="caption-text">
												<a href="img/gallery/img-big.jpg" class="zoom" data-pretty="prettyPhoto">zoom</a>
												<p>
												En construcción
												</p>
											</div>
											<div class="caption-bg"></div>
										</div>								
										<img src="img/gallery/img3.jpg" class="img-responsive" alt="" />														
									</div>
									<h5 class="gallery-title">En construcción</h5>
								</div>	
								<div class="col-md-3">
									<div class="gallery-img-wrapper">
										<div class="caption-wrapper">
											<div class="caption-text">
												<a href="img/gallery/img-big.jpg" class="zoom" data-pretty="prettyPhoto">zoom</a>
												<p>
												En construcción
												</p>
											</div>
											<div class="caption-bg"></div>
										</div>								
										<img src="img/gallery/img9.jpg" class="img-responsive" alt="" />														
									</div>
									<h5 class="gallery-title">En construcción</h5>
								</div>	
								<div class="col-md-3">
									<div class="gallery-img-wrapper">
										<div class="caption-wrapper">
											<div class="caption-text">
												<a href="img/gallery/img-big.jpg" class="zoom" data-pretty="prettyPhoto">zoom</a>
												<p>
												En construcción
												</p>
											</div>
											<div class="caption-bg"></div>
										</div>								
										<img src="img/gallery/img14.jpg" class="img-responsive" alt="" />														
									</div>
									<h5 class="gallery-title">En construcción</h5>
								</div>	
								<div class="col-md-3">
									<div class="gallery-img-wrapper">
										<div class="caption-wrapper">
											<div class="caption-text">
												<a href="img/gallery/img-big.jpg" class="zoom" data-pretty="prettyPhoto">zoom</a>
												<p>
												En construcción
												</p>
											</div>
											<div class="caption-bg"></div>
										</div>								
										<img src="img/gallery/img8.jpg" class="img-responsive" alt="" />														
									</div>
									<h5 class="gallery-title">En construcción</h5>
								</div>						
						   </div>
						</li>
						<!-- End gallery row 4 -->
					  </ul>
					</div>							
					</div>
				</div>
			</div>
		</section>
		<!-- End section gallery -->
		
		<!-- Start contact -->
		<section id="contact" class="container-wrapper">
			<div class="container">
				<div class="row ">
					<div class="col-md-12">
						<h3 class="heading centered">Registro</h3>
					</div>
				</div>
				<div class="row cbp-so-section">
					<div class="col-md-8 cbp-so-side cbp-so-side-left">
                    
							<form id="frmRegistro" action="<?php echo $editFormAction; ?>" method="post" name="frmRegistro">
								<div id="sendmessage">
									<div class="alert alert-info marginbot35">
										 <button type="button" class="close" data-dismiss="alert">&times;</button>
										 <strong>Registro finalizado. ¡Muchas Gracias!</strong><br />
										 
									</div>							
								</div>								
								<ul class="listForm">
									<li>									
										<input class="form-control" type="text" name="strCorreo" data-rule="email" data-msg="Introduce una dirección de correo" placeholder="Correo Electrónico" />									
										<div class="validation"></div>
									</li>
									<li>
										<input class="form-control" type="password" name="strPass" data-rule="pass" placeholder="Contraseña"
										/>										
										<div class="validation"></div>
									</li>
									<li class="list-block">
																					
										<div class="validation"></div>
									</li>
									<li class="list-block">
										<input type="submit" value="Aceptar" class="btn btn-tertiary btn-block" name="btnRegistro" />
									</li>
                                    <input type="hidden" name="intActivo" value="0">
                          			<input type="hidden" name="MM_insert" value="frmRegistro">
								</ul>
							</form>				
					</div>
					<div class="col-md-4 cbp-so-side cbp-so-side-right">
						<div class="contact-detail">
							<h5>Condiciones</h5>
							<p>
							Al crear una cuenta, acepto las <a href="www.petsmeetpets.com">Condiciones del Servicio</a> y la <a href="www.petsmeetpets.com">Política de Privacidad</a> de Pets meet Pets</p>	
                            						<a href="#login" class="btn btn-default">Ya estoy registrado</a>						
						</div>				
					</div>
				</div>
			</div>
            <br><br><br><br><br><br>
		</section>
		<!-- End contact -->
        
		<!-- Start login -->
		<section id="login" class="container-wrapper">
			<div class="container">
				<div class="row ">
					<div class="col-md-12">
						<h3 class="heading centered">Login</h3>
					</div>
				</div>
				<div class="row cbp-so-section">
					<div class="col-md-8 cbp-so-side cbp-so-side-left">
							
                            <form id="frmAcceso" action="<?php echo $loginFormAction; ?>" method="POST" name="frmAcceso">
																
							  <ul class="listForm">
									<li>									
										<input class="form-control" type="text" name="email" data-rule="email" data-msg="Por favor, introduce un email correcto" placeholder="Correo Electrónico" />									
										<div class="validation"></div>
									</li>
									<li>
										<input class="form-control" type="password" name="pass" placeholder="Contraseña"
										/>										
										<div class="validation"></div>
									</li>
									<li class="list-block">
														
										<div class="validation"></div>
									</li>
									<li class="list-block">
										<input type="submit" value="Acceder" class="btn btn-tertiary btn-block" id="btnAcceso" name="btnAcceso" />
									</li>
								</ul>
							</form>				
					</div>
					<div class="col-md-4 cbp-so-side cbp-so-side-right">
						<div class="contact-detail">
							<h5>Condiciones</h5>
							<p>
							Al tener una cuenta, acepto las <a href="www.petsmeetpets.com">Condiciones del Servicio</a> y la <a href="www.petsmeetpets.com">Política de Privacidad</a> de Pets meet Pets</p>	
	
                            <a href="#contact" class="btn btn-defaultb">Aún no estoy registrado</a>					
						</div>				
					</div>
				</div>
			</div>
            <br><br><br><br>
		</section>
		<!-- End login -->
        
		<footer>
			<div class="container">
				<div class="row cbp-so-section">
                
                <!--Social link 
					<div class="col-md-8 col-md-offset-2 cbp-so-side cbp-so-side-left">
						<h5>Stay update with us</h5>
						<p>
						Nihil no ei eam esse nibh volumus. Falli verear cu qui, dicam tation omnesque ei nec.
						</p>
						<form>
							<fieldset class="subscribe-form">
								<input class="subscribe" type="text" placeholder="Enter your email address">
								<button class="subscribe-button" type="button">Subscribe now</button>
							</fieldset>	
						</form>	
					</div>
                    <!-- Social link -->
                    
				</div>
			</div>
		</footer>
		<div class="subfooter">
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
                    	
                     <!--Social link -->
					<div class="social-network">
						<a href="https://wwww.facebook.com/petsmeetpets" target="_blank" class="social-link facebook">Facebook</a>
						<a href="https://plus.google.com/103623907064819988668" target="_blank" class="social-link googleplus">googleplus</a>
						<a href="http://www.pinterest.com/petsmeetpets" target="_blank" class="social-link pinterest">Pinterest</a>
                        <a href="http://instagram.com/petsmeetpets" target="_blank" class="social-link instagram">Instagram</a>
						<a href="https://twitter.com/PetsmeetPets" target="_blank" class="social-link twitter">Twitter</a>
                        
					</div>
                     <!-- Social link -->
                     
					<p class="copyright">2014 &copy; Copyright <a href="www.petsmeetpets.com">Pets meet Pets</a>. All rights Reserved.</p>					
					</div>
				</div>
			</div>					
		</div>
	</div>

                             
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/jquery-easing-1.3.js"></script>
	
	<script src="js/bootstrap.min.js"></script>

	<!-- JavaScript navigation -->	
	<script src="js/navigation/jquery.smooth-scroll.js"></script>
	<script src="js/navigation/waypoints.min.js"></script>
	<script src="js/navigation/navbar.js"></script>
	
	<!-- JavaScript jcarousellite -->
	<script src="js/jcarousellite/jcarousellite_1.0.1c4.js"></script>	
	<script src="js/jcarousellite/setting.js"></script>

	<!-- JavaScript cbpscroller -->
	<script src="js/cbpscroller/modernizr.custom.js"></script>	
	<script src="js/cbpscroller/classie.js"></script>
	<script src="js/cbpscroller/cbpScroller.js"></script>
	
	<!-- JavaScript flexslider -->
	<script src="js/flexslider/jquery.flexslider.js"></script>		
	<script src="js/flexslider/setting.js"></script>

	<!-- JavaScript prettyPhoto -->
	<script src="js/prettyPhoto/jquery.prettyPhoto.js"></script>		
	<script src="js/prettyPhoto/setting.js"></script>

	<!-- JavaScript validation -->	
	<script src="js/validation.js"></script>
	
	<!-- JavaScript custom -->	
	<script src="js/custom.js"></script>
 
  
  </body>
</html>
