<?php
	session_start(); 
	set_time_limit(0);
	
	include("../conexionli.php");
	date_default_timezone_set("America/Santiago"); 
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		$link->close();
	}else{
		header("Location: index.php");
	}

	if(isset($_POST['Cerrar'])){
		header("Location: cerrarsesion.php");
	}
	$accion 	= '';
	$carpeta 	= '';
	if(isset($_GET['accion']))	{ $accion 	= $_GET['accion']; 	}
	if(isset($_GET['carpeta']))	{ $carpeta 	= $_GET['carpeta']; }

//	if(isset($_POST['CrearTablas'])){
	function creatablas(){
		$link=Conectarse();

		$sql = "DROP TABLE accesoDoc";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE accesoDoc (
										nDocGes 	int(4) 		NOT NULL,
										usr 		varchar(40) NOT NULL,
										accDoc 		varchar(3) 	NOT NULL,
										Lectura 	varchar(3) 	NOT NULL,
										downLoad 	varchar(3) 	NOT NULL,
										fechaAcceso date 		NOT NULL,
										horaAcceso 	time 		NOT NULL
										) 
				ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE accionesCorrectivas";
		$bd=$link->query($sql);

		$sql = "CREATE TABLE accionesCorrectivas (
									  	nInformeCorrectiva 	int(5) NOT NULL,
									  	fechaApertura 		date NOT NULL,
									  	usrApertura 		varchar(40) NOT NULL,
									  	fteRecCliExt 		varchar(3) NOT NULL,
									  	fteNroRecCliExt		int(10) NOT NULL,
									  	fteRecCliInt 		varchar(3) NOT NULL,
									  	fteNroRecCliInt 	int(10) NOT NULL,
									  	fteAut		 		varchar(3) NOT NULL,
									  	fteAutFecha			date NOT NULL,
									  	fteAudInt			varchar(3) NOT NULL,
									  	fteAudIntFecha		date NOT NULL,
									  	fteAudExt			varchar(3) NOT NULL,
									  	fteAudExtFecha		date NOT NULL,
									  	fteOtros			varchar(3) NOT NULL,
									  	fteOtrosTxt			text NOT NULL,
									  	oriSisGes			varchar(3) NOT NULL,
									  	oriSisGesFecha		date NOT NULL,
									  	oriEnsayos			varchar(3) NOT NULL,
									  	oriNroAso			int(10) NOT NULL,
									  	oriLeyReg			varchar(3) NOT NULL,
									  	oriLeyRegFecha		date NOT NULL,
									  	oriTnc				varchar(3) NOT NULL,
									  	oriTncFecha			date NOT NULL,
									  	oriInterLab			varchar(3) NOT NULL,
									  	oriInterLabFecha	date NOT NULL,
									  	oriOtros			varchar(3) NOT NULL,
									  	oriOtrosTxt			text NOT NULL,
									  	desClasificacion	varchar(3) NOT NULL,
									  	desClasNoConf		varchar(3) NOT NULL,
									  	desClasObs			varchar(3) NOT NULL,
									  	desIdentificacion	text NOT NULL,
									  	desHallazgo			text NOT NULL,
									  	desEvidencia		text NOT NULL,
									  	Causa				text NOT NULL,
									  	accCorrecion		text NOT NULL,
									  	accAccionCorrectiva	text NOT NULL,
									  	accFechaImp			date NOT NULL,
									  	accFechaTen			date NOT NULL,
									  	accFechaApli		date NOT NULL,
									  	accFechaVer			date NOT NULL,
									  	verResAccCorr		text NOT NULL,
									  	verCierreAccion		varchar(3) NOT NULL,
									  	fechaCierre			date NOT NULL,
									  	usrEncargado		varchar(40) NOT NULL,
									  	usrResponsable		varchar(40) NOT NULL,
									  	usrCalidad			varchar(20) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1";
		$bd=$link->query($sql);
		

		$sql = "DROP TABLE accionesPreventivas";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  accionesPreventivas  (
									   nInformePreventiva  int(5) NOT NULL,
									   fechaApertura  date NOT NULL,
									   usrApertura  varchar(40) NOT NULL,
									   fteRecCliExt  varchar(3) NOT NULL,
									   fteNroRecCliExt  int(10) NOT NULL,
									   fteRecCliInt  varchar(3) NOT NULL,
									   fteNroRecCliInt  int(10) NOT NULL,
									   fteAut  varchar(3) NOT NULL,
									   fteAutFecha  date NOT NULL,
									   fteAudInt  varchar(3) NOT NULL,
									   fteAudIntFecha  date NOT NULL,
									   fteAudExt  varchar(3) NOT NULL,
									   fteAudExtFecha  date NOT NULL,
									   fteOtros  varchar(3) NOT NULL,
									   fteOtrosTxt  text NOT NULL,
									   oriSisGes  varchar(3) NOT NULL,
									   oriSisGesFecha  date NOT NULL,
									   oriEnsayos  varchar(3) NOT NULL,
									   oriNroAso  int(10) NOT NULL,
									   oriLeyReg  varchar(3) NOT NULL,
									   oriLeyRegFecha  date NOT NULL,
									   oriTnc  varchar(3) NOT NULL,
									   oriTncFecha  date NOT NULL,
									   oriInterLab  varchar(3) NOT NULL,
									   oriInterLabFecha  date NOT NULL,
									   oriOtros  varchar(3) NOT NULL,
									   oriOtrosTxt  text NOT NULL,
									   desClasificacion  varchar(3) NOT NULL,
									   desClasNoConf  varchar(3) NOT NULL,
									   desClasObs  varchar(3) NOT NULL,
									   desIdentificacion  text NOT NULL,
									   desHallazgo  text NOT NULL,
									   desEvidencia  text NOT NULL,
									   Causa  text NOT NULL,
									   accCorrecion  text NOT NULL,
									   accAccionCorrectiva  text NOT NULL,
									   accFechaImp  date NOT NULL,
									   accFechaTen  date NOT NULL,
									   accFechaApli  date NOT NULL,
									   accFechaVer  date NOT NULL,
									   verResAccCorr  text NOT NULL,
									   verCierreAccion  varchar(3) NOT NULL,
									   fechaCierre  date NOT NULL,
									   usrEncargado  varchar(40) NOT NULL,
									   usrResponsable  varchar(40) NOT NULL,
									   usrCalidad  varchar(20) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE Actividades";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Actividades  (
									   idActividad  int(8) NOT NULL,
									   Acreditado  varchar(3) NOT NULL,
									   Actividad  varchar(50) NOT NULL,
									   tipoActividad  varchar(20) NOT NULL,
									   actRepetitiva  varchar(3) NOT NULL,
									   prgActividad  date NOT NULL,
									   tpoProx  int(3) NOT NULL,
									   tpoAvisoAct  int(3) NOT NULL,
									   fechaProxAct  date NOT NULL,
									   realizadaAct  varchar(3) NOT NULL,
									   fechaAccionAct  date NOT NULL,
									   Comentarios  text NOT NULL,
									   usrResponsable  varchar(40) NOT NULL,
									   fechaUltCorreo  date NOT NULL,
									   registradaAct  varchar(3) NOT NULL,
									   fechaRegAct  date NOT NULL,
									   Estado  varchar(1) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE actividadesHistorial";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  actividadesHistorial  (
									   idActividad  int(8) NOT NULL,
									   prgActividad  date NOT NULL,
									   fechaActividad  date NOT NULL,
									   Actividad  varchar(50) NOT NULL,
									   fechaRegistro  date NOT NULL,
									   usrResponsable  varchar(40) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE amEnsayos";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  amEnsayos  (
									   nEns  int(2) NOT NULL,
									   idEnsayo  varchar(3) NOT NULL,
									   Ensayo  varchar(30) NOT NULL,
									   Suf  varchar(2) NOT NULL,
									   Status  varchar(3) NOT NULL,
									   Estadistica  varchar(3) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE amInformes";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  amInformes  (
									   CodInforme  varchar(20) NOT NULL,
									   tpEnsayo  int(2) NOT NULL,
									   nroInformes  int(2) NOT NULL,
									   RutCli  varchar(12) NOT NULL,
									   nContacto  int(2) NOT NULL,
									   fechaRecepcion  date NOT NULL,
									   fechaInforme  date NOT NULL,
									   Estado  varchar(1) NOT NULL,
									   ingResponsable  varchar(20) NOT NULL,
									   cooResponsable  varchar(20) NOT NULL,
									   tipoMuestra  varchar(50) NOT NULL,
									   nMuestras  int(2) NOT NULL,
									   CodigoVerificacion  varchar(20) NOT NULL,
									   imgQR  varchar(100) NOT NULL,
									   Ind  int(2) NOT NULL,
									   imgMuestra  varchar(100) NOT NULL,
									   fechaUp  date NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE amMuestras";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  amMuestras  (
									   CodInforme  varchar(20) NOT NULL,
									   idItem  varchar(20) NOT NULL,
									   idMuestra  text NOT NULL,
									   idEnsayo  varchar(3) NOT NULL,
									   tpMuestra  varchar(3) NOT NULL,
									   Taller  varchar(3) NOT NULL,
									   conEnsayo  varchar(3) NOT NULL,
									   Ref  varchar(2) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE amNotas";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  amNotas  (
									   nNota  int(2) NOT NULL,
									   idEnsayo  varchar(3) NOT NULL,
									   Nota  text NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE amTabEnsayos";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  amTabEnsayos  (
									   CodInforme  varchar(20) NOT NULL,
									   idItem  varchar(20) NOT NULL,
									   idEnsayo  varchar(3) NOT NULL,
									   tpMuestra  varchar(3) NOT NULL,
									   Ref  varchar(2) NOT NULL,
									   cEnsayos  int(3) NOT NULL,
									   Ind  int(2) NOT NULL,
									   Tem  varchar(11) NOT NULL,
									   tpMedicion  varchar(4) NOT NULL,
									   distanciaMax  decimal(5,2) NOT NULL,
									   separacion  decimal(5,2) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE amTpEnsayo";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  amTpEnsayo  (
									   tpEnsayo  int(2) NOT NULL,
									   Ensayo  varchar(30) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE amTpsMuestras";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  amTpsMuestras  (
									   idEnsayo  varchar(3) NOT NULL,
									   tpMuestra  varchar(3) NOT NULL,
									   Muestra  varchar(30) NOT NULL,
									   tipoEnsayo  varchar(20) NOT NULL,
									   factorY  decimal(6,3) NOT NULL,
									   constanteY  decimal(6,3) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE Autoriza";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Autoriza  (
									   IdAutoriza  varchar(5) NOT NULL,
									   Autorizador  varchar(50) NOT NULL,
									   Cargo  varchar(30) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE CajaChica";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  CajaChica  (
									   nIngreso  int(11) NOT NULL,
									   IdRecurso  varchar(2) NOT NULL,
									   FechaIng  date NOT NULL,
									   Hora  time NOT NULL,
									   Detalle  varchar(50) NOT NULL,
									   Ingreso  int(12) NOT NULL,
									   Egreso  int(12) NOT NULL,
									   Saldo  int(12) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE Clientes";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Clientes  (
									   RutCli  char(10) NOT NULL,
									   Cliente  varchar(80) CHARACTER SET utf8 NOT NULL,
									   Giro  char(210) NOT NULL,
									   Direccion  char(50) NOT NULL,
									   Telefono  char(30) NOT NULL,
									   Celular  char(14) NOT NULL,
									   Email  char(50) NOT NULL,
									   Contacto  char(50) NOT NULL,
									   DeptoContacto  varchar(50) NOT NULL,
									   FonoContacto  char(30) NOT NULL,
									   EmailContacto  char(50) NOT NULL,
									   Contacto2  char(50) NOT NULL,
									   DeptoContacto2  varchar(50) NOT NULL,
									   FonoContacto2  char(30) NOT NULL,
									   EmailContacto2  char(50) NOT NULL,
									   Contacto3  char(50) NOT NULL,
									   DeptoContacto3  varchar(50) NOT NULL,
									   FonoContacto3  char(30) NOT NULL,
									   EmailContacto3  char(50) NOT NULL,
									   Contacto4  char(50) NOT NULL,
									   DeptoContacto4  varchar(50) NOT NULL,
									   FonoContacto4  char(30) NOT NULL,
									   EmailContacto4  char(50) NOT NULL,
									   Sitio  char(50) NOT NULL,
									   Logo  char(50) NOT NULL,
									   Msg  longtext NOT NULL,
									   IdPerfil  char(2) NOT NULL,
									   Publicar  varchar(1) NOT NULL,
									   cFree  varchar(2) NOT NULL,
									   Docencia  varchar(2) NOT NULL,
									   condicionPago  int(3) NOT NULL,
									   nFactPend  int(3) NOT NULL,
									   Estado  varchar(3) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE codOtam";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  codOtam  (
									   nOtam  bigint(20) unsigned NOT NULL AUTO_INCREMENT,
									   cOtam  varchar(5) NOT NULL,
									   Descripcion  varchar(30) NOT NULL,
									  UNIQUE KEY  nOtam  ( nOtam )
									) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE contactosCli";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  contactosCli  (
									   RutCli  varchar(10) NOT NULL,
									   nContacto  int(2) NOT NULL,
									   Contacto  varchar(50) NOT NULL,
									   Depto  varchar(50) NOT NULL,
									   Email  varchar(50) NOT NULL,
									   Telefono  varchar(50) NOT NULL,
									   Celular  varchar(50) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);
		
		/* CONSULTAR SI BORRAR EL CONTADOR */
/*
		$sql = "DROP TABLE contador";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  contador  (
									   id  int(11) NOT NULL AUTO_INCREMENT,
									   ip  varchar(20) NOT NULL,
									   num_visitas  varchar(30) NOT NULL DEFAULT '0',
									   fecha  datetime NOT NULL,
									  PRIMARY KEY ( id )
									) ENGINE=MyISAM AUTO_INCREMENT=28070 DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);
*/
		/* CONSULTAR SI BORRAR EL CONTADOR */

		$sql = "DROP TABLE Cotizaciones";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Cotizaciones  (
									   IdProyecto  varchar(10) NOT NULL,
									   Observacion  text NOT NULL,
									   obsServicios  text NOT NULL,
									   CAM  int(10) NOT NULL,
									   Cta  int(2) NOT NULL,
									   Rev  int(2) NOT NULL,
									   nexoRev  int(2) NOT NULL,
									   fechaCotizacion  date NOT NULL,
									   RutCli  varchar(10) NOT NULL,
									   nContacto  int(2) NOT NULL,
									   Atencion  varchar(50) NOT NULL,
									   correoAtencion  varchar(50) NOT NULL,
									   Validez  int(3) NOT NULL,
									   proxRecordatorio  date NOT NULL,
									   contactoRecordatorio  text NOT NULL,
									   ultimoRecordatorio  date NOT NULL,
									   dHabiles  int(2) NOT NULL,
									   Moneda  varchar(1) NOT NULL,
									   pDescuento  decimal(5,2) NOT NULL,
									   exentoIva  varchar(3) NOT NULL,
									   valorUF  decimal(12,2) NOT NULL,
									   fechaUF  date NOT NULL,
									   NetoUF  decimal(12,2) NOT NULL,
									   IvaUF  decimal(12,2) NOT NULL,
									   BrutoUF  decimal(12,2) NOT NULL,
									   Neto  int(12) NOT NULL,
									   Iva  int(12) NOT NULL,
									   Bruto  int(12) NOT NULL,
									   Estado  varchar(1) NOT NULL,
									   enviadoCorreo  varchar(2) NOT NULL,
									   fechaEnvio  date NOT NULL,
									   fechaAceptacion  date NOT NULL,
									   fechaInicio  date NOT NULL,
									   correoInicioPAM  varchar(3) NOT NULL,
									   horaPAM  time NOT NULL,
									   fechaEstimadaTermino  date NOT NULL,
									   fechaTermino  date NOT NULL,
									   fechaCierre  date NOT NULL,
									   usrCotizador  varchar(40) NOT NULL,
									   usrResponzable  varchar(40) NOT NULL,
									   oCompra  varchar(3) NOT NULL,
									   nOC  varchar(24) NOT NULL,
									   oMail  varchar(3) NOT NULL,
									   oCtaCte  varchar(3) NOT NULL,
									   Oportunidad  varchar(2) NOT NULL,
									   RAM  int(10) NOT NULL,
									   Descripcion  text NOT NULL,
									   informeUP  varchar(3) NOT NULL,
									   nInforme  int(10) NOT NULL,
									   fechaInformeUP  date NOT NULL,
									   Facturacion  varchar(3) NOT NULL,
									   fechaFacturacion  date NOT NULL,
									   nFactura  int(12) NOT NULL,
									   Archivo  varchar(3) NOT NULL,
									   fechaArchivo  date NOT NULL,
									   infoNumero  int(11) NOT NULL,
									   infoSubidos  int(11) NOT NULL,
									   RAMarchivada  varchar(3) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE CotizacionesSegimiento";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  CotizacionesSegimiento  (
									   CAM  int(10) NOT NULL,
									   Cta  int(2) NOT NULL,
									   Rev  int(2) NOT NULL,
									   fechaContacto  date NOT NULL,
									   proxRecordatorio  date NOT NULL,
									   contactoRecordatorio  text NOT NULL,
									   ultimoRecordatorio  date NOT NULL,
									   Estado  varchar(1) NOT NULL,
									   RAM  int(10) NOT NULL,
									   Descripcion  text NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE ctrlrespaldos";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  ctrlrespaldos  (
									   fechaBackup  date NOT NULL,
									   usrResponsable  varchar(20) NOT NULL,
									   ipRespaldo  varchar(20) NOT NULL,
									   horaBackup  time NOT NULL,
									   archivoBackup  varchar(100) NOT NULL
									) ENGINE=InnoDB DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE ctrlrestauracion";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  ctrlrestauracion  (
									   fechaRestauracion  date NOT NULL,
									   usrResponsable  varchar(20) NOT NULL,
									   ipRespaldo  varchar(20) NOT NULL,
									   horaBackup  time NOT NULL,
									   archivoBackup  varchar(100) NOT NULL
									) ENGINE=InnoDB DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE Cumplimentado";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Cumplimentado  (
									   RutCli  varchar(10) NOT NULL,
									   RutCump  varchar(10) NOT NULL,
									   Cumplimentado  varchar(200) NOT NULL,
									   Cargo  varchar(100) NOT NULL,
									   nFolio  int(10) NOT NULL
									) ENGINE=InnoDB DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE dCotizacion";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  dCotizacion  (
									   CAM  int(10) NOT NULL,
									   Rev  int(2) NOT NULL,
									   Cta  int(2) NOT NULL,
									   nLin  int(3) NOT NULL,
									   Cantidad  decimal(5,2) NOT NULL,
									   nServicio  int(3) NOT NULL,
									   unitarioUF  decimal(12,2) NOT NULL,
									   unitarioP  int(12) NOT NULL,
									   Servicio  varchar(80) NOT NULL,
									   NetoUF  decimal(12,2) NOT NULL,
									   IvaUF  decimal(12,2) NOT NULL,
									   TotalUF  decimal(12,2) NOT NULL,
									   Neto  int(12) NOT NULL,
									   Iva  int(12) NOT NULL,
									   Bruto  int(12) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE Departamentos";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Departamentos  (
									   nDepartamento  varchar(10) NOT NULL,
									   NomDpto  varchar(40) NOT NULL,
									   nombreDepto  varchar(100) NOT NULL,
									   Laboratorio  varchar(100) NOT NULL,
									   Direccion  varchar(100) NOT NULL,
									   envioMuestras  text NOT NULL,
									   nomSector  varchar(30) NOT NULL,
									   Telefono  varchar(30) NOT NULL,
									   RutDirector  varchar(10) NOT NULL,
									   NomDirector  varchar(50) NOT NULL,
									   Cargo  varchar(50) NOT NULL,
									   SubDirectorProyectos  varchar(50) NOT NULL,
									   EmailDepto  varchar(50) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE detSolFact";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  detSolFact  (
									   nSolicitud  int(7) NOT NULL,
									   fechaSolicitud  date NOT NULL,
									   RutCli  varchar(10) NOT NULL,
									   nItems  int(2) NOT NULL,
									   Cantidad  decimal(15,2) NOT NULL,
									   Especificacion  text NOT NULL,
									   valorUnitario  int(12) NOT NULL,
									   valorTotal  int(12) NOT NULL,
									   valorUnitarioUF  decimal(15,2) NOT NULL,
									   valorTotalUF  decimal(15,2) NOT NULL
									) ENGINE=InnoDB DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE Documentacion";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Documentacion  (
									   nDocGes  int(4) NOT NULL,
									   Referencia  varchar(30) NOT NULL,
									   Documento  varchar(100) NOT NULL,
									   Revision  varchar(2) NOT NULL,
									   fechaAprobacion  date NOT NULL,
									   pdf  varchar(100) NOT NULL,
									   word  varchar(100) NOT NULL,
									   sinAcceso  varchar(3) NOT NULL,
									   accRestringido  varchar(3) NOT NULL,
									  PRIMARY KEY ( nDocGes )
									) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE Empresa";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Empresa  (
									   RutEmp  varchar(10) NOT NULL,
									   NombreEmp  varchar(100) NOT NULL,
									   nombreFantasia  varchar(100) NOT NULL,
									   razonSocial  varchar(50) NOT NULL,
									   Giro  varchar(50) NOT NULL,
									   encFinanzas  varchar(50) NOT NULL,
									   CtaCte  varchar(15) NOT NULL,
									   Banco  varchar(15) NOT NULL,
									   Direccion  varchar(50) NOT NULL,
									   Comuna  varchar(50) NOT NULL,
									   Fax  varchar(15) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE Encuestas";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Encuestas  (
									   nEnc  int(2) NOT NULL,
									   nomEnc  varchar(100) NOT NULL,
									   infoEnc  text NOT NULL,
									   nResp  int(10) NOT NULL,
									   Estado  varchar(3) NOT NULL
									) ENGINE=InnoDB DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE Ensayos";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Ensayos  (
									   codEnsayo  varchar(3) NOT NULL,
									   Ensayo  varchar(20) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE equipos";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  equipos  (
									   codigo  varchar(20) NOT NULL,
									   nSerie  varchar(20) NOT NULL,
									   codBarra  varchar(12) NOT NULL,
									   Acreditado  varchar(3) NOT NULL,
									   nomEquipo  varchar(50) NOT NULL,
									   tipoEquipo  varchar(1) NOT NULL,
									   espacioFisico  int(2) NOT NULL,
									   necesitaCal  varchar(3) NOT NULL,
									   fechaCal  date NOT NULL,
									   tpoProxCal  int(3) NOT NULL,
									   tpoAvisoCal  int(3) NOT NULL,
									   fechaProxCal  date NOT NULL,
									   realizadaCal  varchar(3) NOT NULL,
									   fechaAccionCal  date NOT NULL,
									   registradaCal  varchar(3) NOT NULL,
									   fechaRegCal  date NOT NULL,
									   necesitaVer  varchar(3) NOT NULL,
									   fechaVer  date NOT NULL,
									   tpoProxVer  int(3) NOT NULL,
									   tpoAvisoVer  int(3) NOT NULL,
									   fechaProxVer  date NOT NULL,
									   realizadaVer  varchar(3) NOT NULL,
									   fechaAccionVer  date NOT NULL,
									   registradaVer  varchar(3) NOT NULL,
									   fechaRegVer  date NOT NULL,
									   necesitaMan  varchar(3) NOT NULL,
									   fechaMan  date NOT NULL,
									   tpoProxMan  int(3) NOT NULL,
									   tpoAvisoMan  int(3) NOT NULL,
									   fechaProxMan  date NOT NULL,
									   realizadaMan  varchar(3) NOT NULL,
									   fechaAccionMan  date NOT NULL,
									   registradaMan  varchar(3) NOT NULL,
									   fechaRegMan  date NOT NULL,
									   lugar  varchar(50) NOT NULL,
									   usrResponsable  varchar(40) NOT NULL,
									   fechaUltCorreo  date NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE equiposHistorial";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  equiposHistorial  (
									   codigo  varchar(20) NOT NULL,
									   nSerie  varchar(20) NOT NULL,
									   fechaTentativa  date NOT NULL,
									   fechaAccion  date NOT NULL,
									   Accion  varchar(3) NOT NULL,
									   fechaRegistro  date NOT NULL,
									   usrResponsable  varchar(40) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE Facturas";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Facturas  (
									   nMov  varchar(11) NOT NULL,
									   PeriodoPago  varchar(7) NOT NULL,
									   RutProv  varchar(10) NOT NULL,
									   nFactura  varchar(11) NOT NULL,
									   FechaFactura  date NOT NULL,
									   nLinea  varchar(2) NOT NULL,
									   IdProyecto  varchar(10) NOT NULL,
									   nItem  varchar(2) NOT NULL,
									   IdGasto  varchar(3) NOT NULL,
									   IdRecurso  varchar(3) NOT NULL,
									   IdAutoriza  varchar(5) NOT NULL,
									   PerIniServ  date NOT NULL,
									   PerTerServ  date NOT NULL,
									   LugarTrabajo  varchar(30) NOT NULL,
									   FuncionCargo  varchar(50) NOT NULL,
									   Descripcion  varchar(50) NOT NULL,
									   Neto  int(11) NOT NULL,
									   Iva  int(11) NOT NULL,
									   Bruto  int(11) NOT NULL,
									   TpCosto  varchar(1) NOT NULL,
									   FechaPago  date NOT NULL,
									   Estado  varchar(1) NOT NULL,
									   nInforme  varchar(10) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE foliosEncuestas";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  foliosEncuestas  (
									   nFolio  int(10) NOT NULL,
									   nEnc  int(2) NOT NULL,
									   RutCli  varchar(10) NOT NULL,
									   Cumplimentado  varchar(100) NOT NULL,
									   Cargo  varchar(50) NOT NULL,
									   Email  varchar(100) NOT NULL,
									   fechaEnvio  date NOT NULL,
									   fechaRespuesta  date NOT NULL
									) ENGINE=InnoDB DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE formRAM";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  formRAM  (
									   CAM  int(10) NOT NULL,
									   RAM  int(10) NOT NULL,
									   fechaInicio  date NOT NULL,
									   ingResponsable  varchar(20) NOT NULL,
									   cooResponsable  varchar(20) NOT NULL,
									   Obs  text NOT NULL,
									   nMuestras  int(3) NOT NULL,
									   Taller  varchar(3) NOT NULL,
									   nSolTaller  int(7) NOT NULL,
									   Archivada  varchar(3) NOT NULL,
									   fechaArchivo  date NOT NULL,
									   Estado  varchar(1) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE Formularios";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Formularios  (
									   nInforme  int(10) NOT NULL,
									   Modulo  varchar(1) NOT NULL,
									   IdProyecto  varchar(10) NOT NULL,
									   Formulario  varchar(15) NOT NULL,
									   Impuesto  varchar(5) NOT NULL,
									   Fecha  date NOT NULL,
									   nDocumentos  int(3) NOT NULL,
									   Concepto  varchar(100) NOT NULL,
									   Neto  int(11) NOT NULL,
									   Iva  int(11) NOT NULL,
									   Bruto  int(11) NOT NULL,
									   Total  int(11) NOT NULL,
									   Retencion  int(11) NOT NULL,
									   Liquido  int(11) NOT NULL,
									   Fotocopia  varchar(3) NOT NULL,
									   fechaFotocopia  date NOT NULL,
									   Reembolso  varchar(3) NOT NULL,
									   fechaReembolso  date NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE Gastos";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Gastos  (
									   IdProyecto  char(10) NOT NULL,
									   nGasto  int(2) NOT NULL,
									   Mes  int(2) NOT NULL,
									   Agno  int(4) NOT NULL,
									   FechaGasto  date NOT NULL,
									   DiaGasto  int(2) NOT NULL,
									   MesGasto  int(2) NOT NULL,
									   AgnoGasto  int(4) NOT NULL,
									   nItem  int(2) NOT NULL,
									   TpDoc  char(1) NOT NULL,
									   nDoc  int(7) NOT NULL,
									   Detalle  longtext NOT NULL,
									   Monto  int(7) NOT NULL,
									   Impuesto  int(7) NOT NULL,
									   Liquido  int(7) NOT NULL,
									   Estado  char(1) NOT NULL,
									   DiaPago  int(2) NOT NULL,
									   MesPago  int(2) NOT NULL,
									   AgnoPago  int(4) NOT NULL,
									   Inversion  char(1) NOT NULL,
									   Msg  longtext NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE Honorarios";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Honorarios  (
									   PeriodoPago  varchar(7) NOT NULL,
									   Run  varchar(10) NOT NULL,
									   nBoleta  varchar(11) NOT NULL,
									   nLinea  varchar(2) NOT NULL,
									   IdProyecto  varchar(10) NOT NULL,
									   fechaContrato  date NOT NULL,
									   fechaInforme  date NOT NULL,
									   PerIniServ  date NOT NULL,
									   PerTerServ  date NOT NULL,
									   LugarTrabajo  varchar(30) NOT NULL,
									   FuncionCargo  varchar(50) NOT NULL,
									   Descripcion  varchar(80) NOT NULL,
									   Total  int(11) NOT NULL,
									   Retencion  int(11) NOT NULL,
									   Liquido  int(11) NOT NULL,
									   TpCosto  varchar(1) NOT NULL,
									   FechaPago  date NOT NULL,
									   Estado  varchar(1) NOT NULL,
									   Cancelado  varchar(3) NOT NULL,
									   fechaCancelacion  date NOT NULL,
									   nInforme  varchar(10) NOT NULL,
									   actRealizada  text NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE horarioLab";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  horarioLab  (
									   idLaboratorio  varchar(30) NOT NULL,
									   Dia  int(1) NOT NULL,
									   Desde  time NOT NULL,
									   Hasta  time NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE Informes";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Informes  (
									   IdProyecto  char(10) NOT NULL,
									   nOrden  char(20) NOT NULL,
									   RutCli  char(10) NOT NULL,
									   nInforme  int(10) NOT NULL,
									   CodInforme  char(20) NOT NULL,
									   DiaInforme  int(2) NOT NULL,
									   MesInforme  int(2) NOT NULL,
									   AgnoInforme  int(4) NOT NULL,
									   CodigoVerificacion  char(20) NOT NULL,
									   nNoConformidad  int(2) NOT NULL,
									   Detalle  longtext NOT NULL,
									   Estado  char(1) NOT NULL,
									   informePDF  char(50) NOT NULL,
									   loginResp  varchar(40) NOT NULL,
									   fechaUp  date NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE Ingresos";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Ingresos  (
									   nIngreso  int(11) NOT NULL,
									   IdRecurso  varchar(2) NOT NULL,
									   FechaIng  date NOT NULL,
									   Hora  time NOT NULL,
									   Detalle  varchar(50) NOT NULL,
									   Ingreso  int(12) NOT NULL,
									   Egreso  int(12) NOT NULL,
									   Saldo  int(12) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE Items";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Items  (
									   nItem  int(2) NOT NULL,
									   Items  char(60) NOT NULL,
									   Tp  char(1) NOT NULL,
									   Inversion  char(1) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE ItemsGastos";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  ItemsGastos  (
									   nItem  int(2) NOT NULL,
									   Items  char(60) NOT NULL,
									   Tp  char(1) NOT NULL,
									   Inversion  char(1) NOT NULL,
									   Estado  varchar(3) NOT NULL,
									   Monto  int(12) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE ItemsMod";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  ItemsMod  (
									   nMod  int(2) NOT NULL,
									   Modificacion  varchar(100) NOT NULL,
									   cMov  int(5) NOT NULL,
									   eCorreo  varchar(3) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE itEncuesta";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  itEncuesta  (
									   nEnc  int(2) NOT NULL,
									   nItem  varchar(2) NOT NULL,
									   titItem  text NOT NULL,
									   tpEva  int(1) NOT NULL
									) ENGINE=InnoDB DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE Laboratorio";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Laboratorio  (
									   idLaboratorio  varchar(30) NOT NULL,
									   nombreLaboratorio  varchar(100) NOT NULL,
									   Direccion  varchar(50) NOT NULL,
									   Telefono  varchar(30) NOT NULL,
									   jefeLaboratorio  varchar(50) NOT NULL,
									   correoLaboratorio  varchar(50) NOT NULL,
									   contactoLaboratorio  varchar(50) NOT NULL,
									   entregaMuestras  varchar(100) NOT NULL,
									   Sector  varchar(50) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE Masivos";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Masivos  (
									   RutCli  varchar(10) NOT NULL,
									   Contacto  varchar(50) NOT NULL,
									   Email  varchar(50) NOT NULL
									) ENGINE=InnoDB DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE menuGrupos";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  menuGrupos  (
									   nMenu  int(2) NOT NULL,
									   nomMenu  varchar(30) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE menuItems";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  menuItems  (
									   nMenu  int(2) NOT NULL,
									   nModulo  int(2) NOT NULL,
									   titulo  varchar(50) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE Modulos";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Modulos  (
									   nModulo  int(3) NOT NULL,
									   Modulo  varchar(30) NOT NULL,
									   dirProg  varchar(50) NOT NULL,
									   iconoMod  varchar(100) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE ModUsr";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  ModUsr  (
									   usr  varchar(40) NOT NULL,
									   nModulo  int(3) NOT NULL,
									   Estado  varchar(2) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE MovGastos";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  MovGastos  (
									   nGasto  int(8) NOT NULL,
									   Modulo  varchar(1) NOT NULL,
									   FechaGasto  date NOT NULL,
									   Hora  time NOT NULL,
									   TpDoc  varchar(1) NOT NULL,
									   Proveedor  varchar(50) NOT NULL,
									   nDoc  int(11) NOT NULL,
									   Bien_Servicio  varchar(100) NOT NULL,
									   Neto  int(11) NOT NULL,
									   Iva  int(11) NOT NULL,
									   Bruto  int(11) NOT NULL,
									   nItem  varchar(2) NOT NULL,
									   IdGasto  varchar(3) NOT NULL,
									   IdRecurso  varchar(3) NOT NULL,
									   IdProyecto  varchar(10) NOT NULL,
									   IdAutoriza  varchar(5) NOT NULL,
									   Estado  varchar(1) NOT NULL,
									   FechaInforme  date NOT NULL,
									   nInforme  int(10) NOT NULL,
									   Fotocopia  varchar(3) NOT NULL,
									   fechaFotocopia  date NOT NULL,
									   Reembolso  varchar(3) NOT NULL,
									   fechaReembolso  date NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE OTAMs";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  OTAMs  (
									   CodInforme  varchar(20) NOT NULL,
									   CAM  int(10) NOT NULL,
									   RAM  int(10) NOT NULL,
									   idItem  varchar(10) NOT NULL,
									   Otam  varchar(10) NOT NULL,
									   ObsOtam  text NOT NULL,
									   rTaller  varchar(3) NOT NULL,
									   idEnsayo  varchar(3) NOT NULL,
									   tpMuestra  varchar(3) NOT NULL,
									   Ind  int(2) NOT NULL,
									   Tem  varchar(11) NOT NULL,
									   Archivada  varchar(3) NOT NULL,
									   fechaArchivo  date NOT NULL,
									   fechaCreaRegistro  date NOT NULL,
									   Estado  varchar(3) NOT NULL,
									   tpMedicion  varchar(4) NOT NULL,
									   distanciaMax  decimal(5,2) NOT NULL,
									   separacion  decimal(5,2) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE pcam";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  pcam  (
									   idPreCAM  int(8) NOT NULL,
									   RutCli  varchar(10) NOT NULL,
									   Correo  text NOT NULL,
									   Estado  varchar(1) NOT NULL,
									   Conclusion  text NOT NULL,
									   Impresa  varchar(3) NOT NULL,
									   fechaPreCAM  date NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE Perfiles";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Perfiles  (
									   IdPerfil  char(2) NOT NULL,
									   Perfil  varchar(30) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE Periodo";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Periodo  (
									   Agno  int(4) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE Personal";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Personal  (
									   Run  char(10) NOT NULL,
									   Paterno  char(50) NOT NULL,
									   Materno  char(50) NOT NULL,
									   Nombres  char(50) NOT NULL,
									   Sexo  varchar(1) NOT NULL,
									   FechaNac  date NOT NULL,
									   ProfesionOficio  varchar(50) NOT NULL,
									   Direccion  varchar(50) NOT NULL,
									   Comuna  varchar(25) NOT NULL,
									   Ciudad  varchar(25) NOT NULL,
									   Cargo  char(40) NOT NULL,
									   LugarTrabajo  varchar(50) NOT NULL,
									   TipoContrato  varchar(1) NOT NULL,
									   FechaContrato  date NOT NULL,
									   TerminoContrato  date NOT NULL,
									   ServicioIntExt  varchar(1) NOT NULL,
									   SueldoBase  int(9) NOT NULL,
									   PeriodoPago  varchar(1) NOT NULL,
									   Banco  varchar(25) NOT NULL,
									   nCuenta  varchar(20) NOT NULL,
									   Fonos  char(40) NOT NULL,
									   Celular  varchar(30) NOT NULL,
									   Email  char(50) NOT NULL,
									   usr  char(20) NOT NULL,
									   pwd  char(20) NOT NULL,
									   IdPerfil  char(2) NOT NULL,
									   Msg  longtext NOT NULL,
									   Estado  varchar(1) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE PersonalHonorarios";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  PersonalHonorarios  (
									   Run  char(10) NOT NULL,
									   Paterno  char(50) NOT NULL,
									   Materno  char(50) NOT NULL,
									   Nombres  char(50) NOT NULL,
									   Sexo  varchar(1) NOT NULL,
									   FechaNac  date NOT NULL,
									   ProfesionOficio  varchar(50) NOT NULL,
									   Direccion  varchar(50) NOT NULL,
									   Comuna  varchar(25) NOT NULL,
									   Ciudad  varchar(25) NOT NULL,
									   Cargo  char(50) NOT NULL,
									   FuncionCargo  varchar(80) NOT NULL,
									   LugarTrabajo  varchar(50) NOT NULL,
									   TipoContrato  varchar(1) NOT NULL,
									   FechaContrato  date NOT NULL,
									   TerminoContrato  date NOT NULL,
									   ServicioIntExt  varchar(1) NOT NULL,
									   SueldoBase  int(9) NOT NULL,
									   IdProyecto  varchar(10) NOT NULL,
									   UltimaBoleta  varchar(11) NOT NULL,
									   PeriodoPago  varchar(1) NOT NULL,
									   Banco  varchar(25) NOT NULL,
									   nCuenta  varchar(20) NOT NULL,
									   Fonos  char(40) NOT NULL,
									   Celular  varchar(30) NOT NULL,
									   Email  char(50) NOT NULL,
									   usr  char(20) NOT NULL,
									   pwd  char(20) NOT NULL,
									   IdPerfil  char(2) NOT NULL,
									   Msg  longtext NOT NULL,
									   Estado  varchar(1) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE precam";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  precam  (
									   idPreCAM  int(8) NOT NULL,
									   Correo  text NOT NULL,
									   Estado  varchar(3) NOT NULL,
									   fechaPreCAM  date NOT NULL,
									   usrResponsable  varchar(20) NOT NULL,
									   Conclusion  text NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE prEncuesta";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  prEncuesta  (
									   nEnc  int(2) NOT NULL,
									   nItem  varchar(2) NOT NULL,
									   nCon  int(2) NOT NULL,
									   Consulta  text NOT NULL,
									   rEscala  int(10) NOT NULL,
									   rSiNo  int(1) NOT NULL,
									   rTexto  text NOT NULL
									) ENGINE=InnoDB DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE Proveedores";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Proveedores  (
									   RutProv  char(10) NOT NULL,
									   Proveedor  char(50) NOT NULL,
									   tpCliente  varchar(3) NOT NULL,
									   Direccion  char(50) NOT NULL,
									   Telefono  char(30) NOT NULL,
									   Celular  char(13) NOT NULL,
									   Email  char(50) NOT NULL,
									   Contacto  char(50) NOT NULL,
									   FonoContacto  char(30) NOT NULL,
									   Contacto2  char(50) NOT NULL,
									   FonoContacto2  char(30) NOT NULL,
									   TpCta  char(40) NOT NULL,
									   NumCta  char(40) NOT NULL,
									   Banco  char(50) NOT NULL,
									   Msg  longtext NOT NULL,
									   UltimoPago  int(11) NOT NULL,
									   TpCosto  varchar(1) NOT NULL,
									   ProfesionOficio  varchar(50) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE Proyectos";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Proyectos  (
									   IdProyecto  char(10) NOT NULL,
									   Proyecto  char(50) NOT NULL,
									   JefeProyecto  varchar(60) NOT NULL,
									   Rut_JefeProyecto  varchar(10) NOT NULL,
									   Cta_Corriente  varchar(20) NOT NULL,
									   Banco  varchar(20) NOT NULL,
									   Email  varchar(30) NOT NULL,
									   Cta_Corriente2  varchar(20) NOT NULL,
									   Banco2  varchar(12) NOT NULL,
									   Ingreso  int(12) NOT NULL,
									   Egreso  int(12) NOT NULL,
									   Saldo  int(12) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE Rank";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Rank  (
									   RutCli  char(10) NOT NULL,
									   Agno  int(4) NOT NULL,
									   Ene  int(12) NOT NULL,
									   Feb  int(12) NOT NULL,
									   Mar  int(12) NOT NULL,
									   Abr  int(12) NOT NULL,
									   May  int(12) NOT NULL,
									   Jun  int(12) NOT NULL,
									   Jul  int(12) NOT NULL,
									   Ago  int(12) NOT NULL,
									   Sep  int(12) NOT NULL,
									   Oct  int(12) NOT NULL,
									   Nov  int(12) NOT NULL,
									   Dic  int(12) NOT NULL,
									   MontoTotal  int(12) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE Ranking";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Ranking  (
									   RutCli  char(10) NOT NULL,
									   Agno  int(4) NOT NULL,
									   Ene  int(12) NOT NULL,
									   Feb  int(12) NOT NULL,
									   Mar  int(12) NOT NULL,
									   Abr  int(12) NOT NULL,
									   May  int(12) NOT NULL,
									   Jun  int(12) NOT NULL,
									   Jul  int(12) NOT NULL,
									   Ago  int(12) NOT NULL,
									   Sep  int(12) NOT NULL,
									   Oct  int(12) NOT NULL,
									   Nov  int(12) NOT NULL,
									   Dic  int(12) NOT NULL,
									   Monto  int(12) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE Recursos";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Recursos  (
									   IdRecurso  varchar(3) NOT NULL,
									   Recurso  varchar(20) NOT NULL,
									   Monto  int(12) NOT NULL,
									   Ingreso  int(24) NOT NULL,
									   Egreso  int(24) NOT NULL,
									   Saldo  int(11) NOT NULL,
									   Estado  varchar(3) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE regCharpy";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  regCharpy  (
									   CodInforme  varchar(20) NOT NULL,
									   idItem  varchar(10) NOT NULL,
									   tpMuestra  varchar(3) NOT NULL,
									   Tem  varchar(11) NOT NULL,
									   Ancho  decimal(5,2) NOT NULL,
									   Alto  decimal(5,2) NOT NULL,
									   resEquipo  decimal(5,2) NOT NULL,
									   nImpacto  int(2) NOT NULL,
									   vImpacto  decimal(7,2) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE regDoblado";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  regDoblado  (
									   CodInforme  varchar(20) NOT NULL,
									   idItem  varchar(10) NOT NULL,
									   tpMuestra  varchar(3) NOT NULL,
									   nIndenta  int(2) NOT NULL,
									   vIndenta  decimal(5,1) NOT NULL,
									   cIndenta  decimal(5,1) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE regDureza";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  regDureza  (
									   CodInforme  varchar(20) NOT NULL,
									   idItem  varchar(10) NOT NULL,
									   tpMuestra  varchar(3) NOT NULL,
									   nIndenta  int(2) NOT NULL,
									   vIndenta  decimal(5,1) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE registroMuestras";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  registroMuestras  (
									   RAM  int(10) NOT NULL,
									   CAM  int(10) NOT NULL,
									   fechaRegistro  date NOT NULL,
									   RutCli  varchar(24) NOT NULL,
									   nContacto  int(2) NOT NULL,
									   Atencion  varchar(50) NOT NULL,
									   Descripcion  text NOT NULL,
									   servicioTaller  varchar(3) NOT NULL,
									   nSolicitudTaller  int(10) NOT NULL,
									   situacionMuestra  varchar(1) NOT NULL,
									   Estado  varchar(1) NOT NULL,
									   usrRecepcion  varchar(40) NOT NULL,
									   usrResponsable  varchar(40) NOT NULL
									) ENGINE=InnoDB DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE regQuimico";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  regQuimico  (
									   CodInforme  varchar(20) NOT NULL,
									   idItem  varchar(10) NOT NULL,
									   tpMuestra  varchar(3) NOT NULL,
									   cC  varchar(9) NOT NULL,
									   cSi  varchar(9) NOT NULL,
									   cMn  varchar(9) NOT NULL,
									   cP  varchar(9) NOT NULL,
									   cS  varchar(9) NOT NULL,
									   cCr  varchar(9) NOT NULL,
									   cNi  varchar(9) NOT NULL,
									   cMo  varchar(9) NOT NULL,
									   cAl  varchar(9) NOT NULL,
									   cCu  varchar(9) NOT NULL,
									   cCo  varchar(9) NOT NULL,
									   cTi  varchar(9) NOT NULL,
									   cNb  varchar(9) NOT NULL,
									   cV  varchar(9) NOT NULL,
									   cW  varchar(9) NOT NULL,
									   cPb  varchar(9) NOT NULL,
									   cB  varchar(9) NOT NULL,
									   cSb  varchar(9) NOT NULL,
									   cSn  varchar(9) NOT NULL,
									   cZn  varchar(9) NOT NULL,
									   cAs  varchar(9) NOT NULL,
									   cBi  varchar(9) NOT NULL,
									   cTa  varchar(9) NOT NULL,
									   cCa  varchar(9) NOT NULL,
									   cCe  varchar(9) NOT NULL,
									   cZr  varchar(9) NOT NULL,
									   cLa  varchar(9) NOT NULL,
									   cSe  varchar(9) NOT NULL,
									   cN  varchar(9) NOT NULL,
									   cFe  varchar(9) NOT NULL,
									   cMg  varchar(9) NOT NULL,
									   cTe  varchar(9) NOT NULL,
									   cCd  varchar(9) NOT NULL,
									   cAg  varchar(9) NOT NULL,
									   cAu  varchar(9) NOT NULL,
									   cAi  varchar(9) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE regRevisiones";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  regRevisiones  (
									   CodInforme  varchar(20) NOT NULL,
									   nRev  varchar(2) NOT NULL,
									   nMod  int(2) NOT NULL,
									   fechaMod  date NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE regTraccion";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  regTraccion  (
									   CodInforme  varchar(20) NOT NULL,
									   idItem  varchar(10) NOT NULL,
									   tpMuestra  varchar(3) NOT NULL,
									   aIni  varchar(9) NOT NULL,
									   cFlu  varchar(9) NOT NULL,
									   cMax  varchar(9) NOT NULL,
									   tFlu  varchar(9) NOT NULL,
									   tMax  varchar(9) NOT NULL,
									   aSob  varchar(9) NOT NULL,
									   rAre  varchar(9) NOT NULL,
									   Espesor  decimal(5,2) NOT NULL,
									   Ancho  decimal(5,2) NOT NULL,
									   Li  decimal(5,2) NOT NULL,
									   Lf  decimal(5,2) NOT NULL,
									   Di  decimal(5,2) NOT NULL,
									   Df  decimal(5,2) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE respEncuesta";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  respEncuesta  (
									   nFolio  int(10) NOT NULL,
									   RutCli  varchar(10) NOT NULL,
									   RutCump  varchar(10) NOT NULL,
									   Cumplimentado  varchar(50) NOT NULL,
									   nEnc  int(2) NOT NULL,
									   nItem  varchar(2) NOT NULL,
									   nCon  int(2) NOT NULL,
									   rEscala  int(10) NOT NULL,
									   rSiNo  int(1) NOT NULL,
									   rTexto  text NOT NULL
									) ENGINE=InnoDB DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE Servicios";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Servicios  (
									   nServicio  int(3) NOT NULL,
									   Servicio  text NOT NULL,
									   ValorUF  decimal(15,2) NOT NULL,
									   ValorPesos  int(12) NOT NULL,
									   tpServicio  varchar(1) NOT NULL,
									   Estado  varchar(3) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE serviciosRAM";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  serviciosRAM  (
									   RAM  int(10) NOT NULL,
									   id  int(2) NOT NULL,
									   idMuestra  varchar(100) NOT NULL,
									   OTAM  varchar(10) NOT NULL,
									   nServicio  int(3) NOT NULL,
									   CAM  int(10) NOT NULL,
									   estadoServ  varchar(3) NOT NULL
									) ENGINE=InnoDB DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE SolFactura";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  SolFactura  (
									   nSolicitud  int(7) NOT NULL,
									   fechaSolicitud  date NOT NULL,
									   IdProyecto  char(10) NOT NULL,
									   Fotocopia  varchar(3) NOT NULL,
									   fechaFotocopia  date NOT NULL,
									   nOrden  char(100) NOT NULL,
									   FechaOrden  date NOT NULL,
									   RutCli  char(10) NOT NULL,
									   Contacto  varchar(50) NOT NULL,
									   Factura  varchar(3) NOT NULL,
									   nFactura  int(12) NOT NULL,
									   fechaFactura  date NOT NULL,
									   pagoFactura  varchar(3) NOT NULL,
									   fechaPago  date NOT NULL,
									   vencimientoSolicitud  int(2) NOT NULL,
									   valorUF  decimal(15,2) NOT NULL,
									   fechaUF  date NOT NULL,
									   tipoValor  varchar(1) NOT NULL,
									   Exenta  varchar(3) NOT NULL,
									   netoUF  decimal(15,2) NOT NULL,
									   ivaUF  decimal(15,2) NOT NULL,
									   brutoUF  decimal(15,2) NOT NULL,
									   Neto  int(9) NOT NULL,
									   Iva  int(9) NOT NULL,
									   Bruto  int(9) NOT NULL,
									   informesAM  text NOT NULL,
									   cotizacionesCAM  text NOT NULL,
									   Observa  text NOT NULL,
									   Estado  char(1) NOT NULL,
									   Msg  longtext NOT NULL,
									   usr  varchar(40) NOT NULL,
									   enviarFactura  varchar(1) NOT NULL,
									   Redondear  varchar(3) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE Solicitudes";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Solicitudes  (
									   IdProyecto  char(10) NOT NULL,
									   nOrden  char(20) NOT NULL,
									   Mes  int(2) NOT NULL,
									   Agno  int(4) NOT NULL,
									   FechaOrden  date NOT NULL,
									   DiaOrden  int(2) NOT NULL,
									   MesOrden  int(2) NOT NULL,
									   AgnoOrden  int(4) NOT NULL,
									   RutCli  char(10) NOT NULL,
									   Factura  int(7) NOT NULL,
									   DiaFactura  int(2) NOT NULL,
									   MesFactura  int(2) NOT NULL,
									   AgnoFactura  int(4) NOT NULL,
									   ValEnUF  float NOT NULL,
									   MontoEnUF  float NOT NULL,
									   Neto  int(9) NOT NULL,
									   Iva  int(9) NOT NULL,
									   Bruto  int(9) NOT NULL,
									   DiaPago  int(2) NOT NULL,
									   MesPago  int(2) NOT NULL,
									   AgnoPago  int(4) NOT NULL,
									   Estado  char(1) NOT NULL,
									   Msg  longtext NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE Sueldos";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Sueldos  (
									   PeriodoPago  varchar(7) NOT NULL,
									   Run  varchar(10) NOT NULL,
									   IdProyecto  varchar(10) NOT NULL,
									   PerIniServ  date NOT NULL,
									   PerTerServ  date NOT NULL,
									   FuncionCargo  varchar(50) NOT NULL,
									   Descripcion  varchar(50) NOT NULL,
									   SueldoBase  int(11) NOT NULL,
									   Prevision  int(11) NOT NULL,
									   Liquido  int(11) NOT NULL,
									   nHorasExtras  int(2) NOT NULL,
									   FechaPago  date NOT NULL,
									   Estado  varchar(1) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE tabIndices";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  tabIndices  (
									   fechaIndice  date NOT NULL,
									   iProductividad  decimal(5,2) NOT NULL,
									   iMinimo  decimal(5,2) NOT NULL,
									   iMeta  decimal(5,2) NOT NULL,
									   indVtas  decimal(5,2) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE tablaIndicadores";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  tablaIndicadores  (
									   mesInd  int(2) NOT NULL,
									   agnoInd  int(4) NOT NULL,
									   indMin  double(5,2) NOT NULL,
									   indMeta  double(5,2) NOT NULL,
									   rCot  decimal(12,2) NOT NULL
									) ENGINE=InnoDB DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE tablaRegForm";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  tablaRegForm  (
									   nSolFactura  int(12) NOT NULL,
									   CAM  int(10) NOT NULL,
									   nOrden  int(12) NOT NULL,
									   nInforme  int(12) NOT NULL,
									   nAM  int(4) NOT NULL,
									   indMin  double(5,2) NOT NULL,
									   indMeta  double(5,2) NOT NULL,
									   nTaller  int(7) NOT NULL,
									   rCot  decimal(12,2) NOT NULL,
									   Bloqueado  varchar(2) NOT NULL,
									   valorUFRef  decimal(15,2) NOT NULL
									) ENGINE=InnoDB DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE tipoEnsayo";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  tipoEnsayo  (
									   tpEnsayo  int(2) NOT NULL,
									   nomTipoEnsayo  varchar(25) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE tipoGasto";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  tipoGasto  (
									   IdGasto  varchar(3) NOT NULL,
									   TpGasto  varchar(15) NOT NULL,
									   Monto  int(12) NOT NULL,
									   Desde  int(11) NOT NULL,
									   Hasta  int(11) NOT NULL,
									   Estado  varchar(3) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE tpEscala";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  tpEscala  (
									   nEnc  int(2) NOT NULL,
									   nItem  varchar(2) NOT NULL,
									   nEscala  int(2) NOT NULL,
									   desEscala  varchar(18) NOT NULL
									) ENGINE=InnoDB DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE tpEvaluacion";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  tpEvaluacion  (
									   tpEva  int(1) NOT NULL,
									   nomEva  varchar(15) NOT NULL,
									   desde  int(10) NOT NULL,
									   hasta  int(10) NOT NULL
									) ENGINE=InnoDB DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE UF";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  UF  (
									   fechaUF  date NOT NULL,
									   ValorUF  decimal(7,2) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		/* NO BORRAR NI CREAR */
/*
		$sql = "DROP TABLE Usuarios";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Usuarios  (
									   usr  varchar(40) NOT NULL,
									   pwd  varchar(20) NOT NULL,
									   usuario  varchar(50) NOT NULL,
									   nPerfil  char(2) NOT NULL,
									   email  varchar(50) NOT NULL,
									   tpUsr  varchar(1) NOT NULL,
									   celular  varchar(20) NOT NULL,
									   firma  varchar(100) NOT NULL,
									   vCAM  varchar(3) NOT NULL,
									   vRAM  varchar(3) NOT NULL,
									   vAM  varchar(3) NOT NULL,
									   resumenGral  varchar(3) NOT NULL,
									   cargoUsr  varchar(50) NOT NULL,
									   firmaUsr  varchar(100) NOT NULL,
									   responsableInforme  varchar(3) NOT NULL,
									   titPie  varchar(30) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);
*/		
		/* NO BORRAR NI CREAR */

		$sql = "DROP TABLE Vales";
		$bd=$link->query($sql);



		$sql = 'CREATE TABLE  Vales  (
									   nVale  int(12) NOT NULL,
									   fechaVale  date NOT NULL,
									   tpMov  varchar(1) NOT NULL,
									   Descripcion  text NOT NULL,
									   Ingreso  int(12) NOT NULL,
									   Egreso  int(12) NOT NULL,
									   Reembolso  varchar(3) NOT NULL,
									   fechaReembolso  date NOT NULL,
									   Deposito  varchar(3) NOT NULL,
									   fechaDeposito  date NOT NULL,
									   Estado  varchar(1) NOT NULL
									) ENGINE=InnoDB DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE Visitas";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Visitas  (
									   idVisita  int(8) NOT NULL,
									   Acreditado  varchar(3) NOT NULL,
									   RutCli  varchar(10) NOT NULL,
									   nContacto  int(2) NOT NULL,
									   Actividad  text NOT NULL,
									   tipoActividad  varchar(20) NOT NULL,
									   actRepetitiva  varchar(3) NOT NULL,
									   prgActividad  date NOT NULL,
									   tpoProx  int(3) NOT NULL,
									   tpoAvisoAct  int(3) NOT NULL,
									   fechaProxAct  date NOT NULL,
									   realizadaAct  varchar(3) NOT NULL,
									   fechaAccionAct  date NOT NULL,
									   Comentarios  text NOT NULL,
									   usrResponsable  varchar(40) NOT NULL,
									   fechaUltCorreo  date NOT NULL,
									   registradaAct  varchar(3) NOT NULL,
									   fechaRegAct  date NOT NULL,
									   Estado  varchar(1) NOT NULL,
									   Conclusion  text NOT NULL,
									   Impresa  varchar(3) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE visitasHistorial";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  visitasHistorial  (
									   idVisita  int(8) NOT NULL,
									   prgActividad  date NOT NULL,
									   fechaActividad  date NOT NULL,
									   Actividad  varchar(50) NOT NULL,
									   fechaRegistro  date NOT NULL,
									   usrResponsable  varchar(40) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$sql = "DROP TABLE Zonas";
		$bd=$link->query($sql);

		$sql = 'CREATE TABLE  Zonas  (
									   nZona  int(2) NOT NULL,
									   nomZona  varchar(30) NOT NULL
									) ENGINE=MyISAM DEFAULT CHARSET=latin1';
		$bd=$link->query($sql);

		$link->close();
			
	}
	if($accion == 'Levantar'){
		//creatablas();
/*
		$nombre_archivo = $_FILES['copiaRes']['name'];
		$tipo_archivo 	= $_FILES['copiaRes']['type'];
		$tamano_archivo = $_FILES['copiaRes']['size'];
		$desde 			= $_FILES['copiaRes']['tmp_name'];
*/
		$link=Conectarse();
		$archivo = "";
		$ruta	 = '';
		
		$tables = array();
		$result = $link->query('SHOW TABLES');
		while($row = mysql_fetch_row($result))
		{
			$tables[] = $row[0];
		}
		$link->close();
		foreach($tables as $table){
			$ruta = 'z:backup/'.$carpeta.'/';
			$archivo = $ruta.$table.'.sql';
			if(file_exists($archivo)){
				echo 'Recuperando '.$archivo.'...';
				$sql = '';
				$fp = fopen($archivo, 'r');
				while(!feof($fp)) {
					$linea = fgets($fp);
					$sql .= $linea;
				}
				fclose($fp);
				//echo $sql;
				
				$fd=explode(';Fin',$sql);
				$link=Conectarse();
				foreach ($fd as $valor) {
					$valor .= ';';
					//echo $valor.'<br><br>';
					$bd=$link->query($valor);
				}
				$link->close();
			}
		}


		//if($tipo_archivo == "application/octet-streamdb-backup.sql application/octet-stream") {
/*
		if(move_uploaded_file($desde, $nombre_archivo)){ 
			//echo $nombre_archivo;
	  
			$sql = '';
			$fp = fopen($nombre_archivo, 'r');
			while(!feof($fp)) {
				$linea = fgets($fp);
				$sql .= $linea;
			}
			fclose($fp);
			//echo $sql;
				
			$fd=explode(';Fin',$sql);
			$link=Conectarse();
			foreach ($fd as $valor) {
				$valor .= ';';
				//echo $valor.'<br><br>';
				$bd=$link->query($valor);
			}
			$link->close();
		}
*/			
		//}
			
			$fechaBackup 	= date('Y-m-d');
			$usrResponsable = $_SESSION['usr'];
			$horaBackup		= date('H:i');
			
			
			$link=Conectarse();
			$link->query("insert into ctrlrestauracion(	
																	fechaRestauracion,
																	usrResponsable,
																	horaBackup,
																	archivoBackup
																	) 
															values 	(	
																	'$fechaBackup',
																	'$usrResponsable',
																	'$horaBackup',
																	'$nombre_archivo'
									)");
			$link->close();
		
		header("Location: backup.php");
	}	

?>

<!doctype html>
 
<html lang="es">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="shortcut icon" href="../favicon.ico" />
	<link rel="apple-touch-icon" href="../touch-icon-iphone.png" />
	<link rel="apple-touch-icon" href="../touch-icon-ipad.png" />
	<link rel="apple-touch-icon" href="../touch-icon-iphone4.png" />

	<title>Plataforma ERP de Simet</title>

	<link href="../css/tpv.css" 	rel="stylesheet" type="text/css">
	<link href="../css/styles.css" 	rel="stylesheet" type="text/css">
	<link href="../estilos.css" 	rel="stylesheet" type="text/css">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">

	<style type="text/css">
		* {
  			box-sizing: border-box;
		}
		.verde-class{
		  background-color 	: green;
		  color 			: #fff;
		  font-weight 		: bold;
		}
		.verdechillon-class{
		  background-color 	: #33FFBE;
		  color 			: #fff;
		  font-weight 		: bold;
		}
		.azul-class{
		  background-color 	: blue;
		  color 			: #fff;
		  font-weight 		: bold;
		}
		.amarillo-class{
		  background-color 	: yellow;
		  color 			: black;
		}
		.rojo-class{
		  background-color 	: red;
		  color 			: black;
		}
		.default-color{
		  background-color 	: #fff;
		  color 			: black;
		}	
	</style>


</head>

<body ng-app="myApp" ng-controller="CtrlRespaldos" ng-cloak>
	<?php include_once('head.php'); ?>

	<nav class="navbar navbar-expand-lg navbar-dark bg-danger static-top">
		<div class="container-fluid">
  	    	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
	          <span class="navbar-toggler-icon"></span>
	        </button>
	    	<div class="collapse navbar-collapse" id="navbarResponsive">

				<a class="navbar-brand" href="#">
					<img src="../imagenes/simet.png" alt="logo" style="width:40px;">
				</a>


	      		<ul class="navbar-nav ml-auto">
	        		<li class="nav-item active">
	          			<a class="nav-link fa fa-home" href="../plataformaErp.php"> Principal
	                	<span class="sr-only">(current)</span>
	              		</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="../cerrarsesion.php"> Cerrar</a>
	        		</li>
	      		</ul>
	    	</div>
	  	</div>
	</nav>

	<div class="container-fluid m-2">

		<div class="row">
			<div class="col-sm-6">
				<?php include_once('controlRespaldo.php'); ?>
			</div>
			<div class="col-sm-6">
				<?php include_once('regRespaldo.php'); ?>
			</div>
		</div>

	</div>

	
	<script src="../bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../angular/angular.js"></script>
	<script src="respaldos.js"></script>


</body>
</html>
