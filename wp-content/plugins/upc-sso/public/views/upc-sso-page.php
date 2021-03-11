<html>
<head>
	<script type="text/javascript">
		const returnPage = localStorage.getItem('sso_returnPage') ? localStorage.getItem('sso_returnPage') : '/'
	</script>
</head>
<body>
	


</body>
</html>



<?php

$usertoken = '';




if(isset($_GET['_tk'])){

	$usertoken = $_GET['_tk'];

} else{ 
	?>

	<script type="text/javascript">
		console.log('Redirigiendo a: ', returnPage )
		window.location.href = returnPage
	</script>

 	<?php

 	exit();
}

$sso_req = curl_init();

curl_setopt_array(
	$sso_req,
	array(
		CURLOPT_URL => "https://apicert.upc.edu.pe/v3.0/TokenSSO?token=".$usertoken,
		CURLOPT_USERPWD => 'upc\usrprdpeupcsso' . ":" . 'Ro280221#',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_HEADER => 1,
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET'
	)
);

$sso_response = curl_exec($sso_req);

// Verificar si ocurrió algún error
if (!curl_errno($sso_req)) {
  $info = curl_getinfo($sso_req);
  if($info['http_code'] !== '200'){ ?>

  	<script type="text/javascript">
  		localStorage.setItem('sso_token', '<?php echo  $usertoken; ?>')
  		localStorage.setItem('sso_loged', 'true')
		localStorage.setItem('sso_returnPage', '')
		window.location.href = returnPage
  	</script>
  	
  <?php

  } else{ ?>

  	<script type="text/javascript">
		localStorage.setItem('sso_returnPage', '')
		window.location.href = returnPage
  	</script>
  	
  <?php
}
  

}

curl_close($sso_req);

/*
echo $sso_response;

echo '<br><br><br><br>';

$api_alumno = 'https://apicert.upc.edu.pe/v2/Alumnos?CodLineaNegocio=U&CodUsuario=U201121382';

$alumno_req = curl_init();

curl_setopt_array(
	$alumno_req,
	array(
		CURLOPT_URL => $api_alumno,
		CURLOPT_USERPWD => 'upc\usrprdpeupcsso' . ":" . 'Ro280221#',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_HEADER => 1,
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET'
	));


$alumno_res = curl_exec($alumno_req);

// Verificar si ocurrió algún error
if (!curl_errno($alumno_req)) {
  $info = curl_getinfo($alumno_req);
  echo 'Response code: ' . $info['http_code'];
  echo '<br><br>';
  var_dump($info);
}

curl_close($alumno_req);

echo $alumno_res;*/

?>


<div>SSO</div>
<button id="child-btn">Enviar</button>

<script type="text/javascript">
	document.getElementById("child-btn").addEventListener("click", function myFunction() {
	  console.log('child child')
	  window.opener.loginSuccess();
	})

</script>