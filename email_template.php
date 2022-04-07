<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Cadastro Viatris</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
		html {
			-webkit-font-smoothing: antialiased;
  			text-rendering: optimizeLegibility;
		}
	</style>
</head>
<div class="container" style="width: 390px; background-color:#FFFFFF">
	
	<nav class="navbar">
  		<img src="https://madurado.tech/Viatris/AssistFoto/img/logo.png" width="360" alt="Viatris logo">
	</nav>
 <br>
    <div class="email_body">
    	<h1 style="font-size: 23px; font-family: Epilogue;font-weight:600; letter-spacing:1px; text-align: center;">Nome: <?= $nome ?></h1>
		<h1 style="font-size: 23px; font-family: Epilogue;font-weight:600; letter-spacing:1px; text-align: center;">E-mail: <?= $email ?> </p>
		<h1 style="font-size: 23px; font-family: Epilogue;font-weight:600; letter-spacing:1px; text-align: center;">UF: <?= $uf ?> </p>
		<p style="font-size: 10px; font-family: Epilogue;font-weight:400; letter-spacing:1px; text-align: center;">*Este é um e-mail automático, por favor, não responda.</p>
		<img alt="Foto do Cadastro" style="width: 50%; display: block;margin-left: auto;margin-right: auto;" src="https://madurado.tech/Viatris/AssistFoto/<?=$file_name?>" /> 
	</div>

</div>
</body>

</html>