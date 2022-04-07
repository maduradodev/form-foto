<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

	require_once 'includes/common.php';
	require_once 'includes/database.php';
    require_once('src/PHPMailer.php');
	require_once('src/SMTP.php');
	require_once('src/Exception.php');

    $error = FALSE;
    $success = FALSE;

	// Form was submitted 
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$nome = $_POST['nome'];
		$crm = $_POST['crm'];
		$email = $_POST['email'];
        $uf = $_POST['uf'];
        $autoriza = isset($_POST['autoriza']) ? "SIM" : "NÃO";

        // File extension type
        $imageFileType = strtolower(pathinfo(UPLOAD_DIR . basename($_FILES["foto"]["name"]), PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["foto"]["tmp_name"]);
        if($check === FALSE) {
            $error = "Arquivo inválido.";
        }

        if(!$error){
            $file_name = UPLOAD_DIR . uniqid() . '.' . pathinfo($_FILES["foto"]["name"])['extension'];
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $file_name)) {
                // Insert user data into the database
                $sql = "INSERT INTO cadastro_assistente (nome, email, crm, uf, autoriza, picture) VALUES ('{$nome}', '{$email}', '{$crm}', '{$uf}', '{$autoriza}', '{$file_name}')";
                if ($conn->query($sql) === TRUE) {
                    try {
                        $mail = new PHPMailer;
                        $mail->isHTML(true); // Deixar true se for usar o email_template (usa $SESSION)
                        $mail->CharSet = 'UTF-8';
                        $mail->setFrom('contato@madurado.tech', 'NO_REPLY_TOTEM_CADASTRO'); // From
                        $mail->addAddress('congresso_otorrino_fotografo@jardimeletrico.com.br', 'Congresso Otorrino'); // To
                        $mail->ClearReplyTos();
    			            $mail->addReplyTo('congresso_otorrino_fotografo@jardimeletrico.com.br', 'Congresso Otorrino');
                        $mail->Subject = "Cadastro Viatris"; // Assunto
                        $mail->addAttachment($file_name); // $file_name é a imagem
        
                        ob_start();
                        include 'email_template.php'; // Estrutura do Email
                        $mail->Body = ob_get_clean();
        
                        $mail->send();
                        $success = "Arquivo enviado com sucesso.";
                        session_destroy();
                        header('Location: https://madurado.tech/Viatris/AssistFoto/index.php');
                    } catch (Exception $e) {
                        $error ="Erro ao enviar o email: {$mail->ErrorInfo}";
                    }

                } else {
                    // Store error msg
                    $error = $conn->error;
                }
            } else {
                $error = "Ocorreu um erro ao realizar o upload da imagem.";
            }
        }
	}
?>
<!DOCTYPE html>
<html lang="pt-br">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Cadastro</title>
      <link rel="stylesheet" href="css/bulma.min.css">
      <link rel="stylesheet" href="css/normalize.css">
      <link rel="stylesheet" href="css/style.css">
   </head>
   </head>
   <body>
      <nav class="navbar">
         <img src="img/logo.png" width="460" height="400" alt="Viatris logo">
      </nav>
      <section class="form" style="max-width:50%">
         <div class="container">
            <div class="columns is-centered">
               <div class="column is-half" style="width:100%">
                  <h1 class="title has-text-centered">Insira suas informações</h1>
                  <?php if($error): ?>
                    <div class="notification is-danger"><?= $error ?></div>
                  <?php endif; ?>
                  <?php if($success): ?>
                    <div class="notification is-success"><?= $success ?></div>
                  <?php endif; ?>
                  <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                     <div class="field">
                        <label class="label" color="#363636" for="nome">Nome *</label>
                        <div class="control">
                           <input id="nome" name="nome" class="input" type="text" placeholder="Seu nome" maxlength="30" required />
                        </div>
                     </div>
                     <div class="field">
                        <label class="label" color="#363636" for="email">Email *</label>
                        <div class="control">
                           <input id="email" name="email" class="input" type="email" placeholder="Seu email" required />
                        </div>
                     </div>
                     <div class="field">
                        <label class="label" color="#363636" for="crm">CRM *</label>
                        <div class="control">
                           <input id="crm" name="crm" class="input" type="text" placeholder="Seu CRM" required />
                        </div>
                     </div>
                     <div class="field">
                        <label class="label" color="#363636" for="crm">UF *</label>
                        <select class="uf" name="uf" id="uf" required >
                           <option value="">Selecione</option>
                           <option value="AC">Acre</option>
                           <option value="AL">Alagoas</option>
                           <option value="AP">Amapá</option>
                           <option value="AM">Amazonas</option>
                           <option value="BA">Bahia</option>
                           <option value="CE">Ceará</option>
                           <option value="DF">Distrito Federal</option>
                           <option value="ES">Espírito Santo</option>
                           <option value="GO">Goiás</option>
                           <option value="MA">Maranhão</option>
                           <option value="MT">Mato Grosso</option>
                           <option value="MS">Mato Grosso do Sul</option>
                           <option value="MG">Minas Gerais</option>
                           <option value="PA">Pará</option>
                           <option value="PB">Paraíba</option>
                           <option value="PR">Paraná</option>
                           <option value="PE">Pernambuco</option>
                           <option value="PI">Piauí</option>
                           <option value="RJ">Rio de Janeiro</option>
                           <option value="RN">Rio Grande do Norte</option>
                           <option value="RS">Rio Grande do Sul</option>
                           <option value="RO">Rondônia</option>
                           <option value="RR">Roraima</option>
                           <option value="SC">Santa Catarina</option>
                           <option value="SP">São Paulo</option>
                           <option value="SE">Sergipe</option>
                           <option value="TO">Tocantins</option>
                        </select>
                     </div>
                     <br />
                     <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="checkConfirmo" name="confirmo" required />
                        <label class="title" style="font-size: 110%; color: #363636" for="checkConfirmo">
                        *Confirmo que sou um (a) profissional da saúde que exerce essa função no Brasil.
                        </label>
                     </div>
                     <br />
                     <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="checkAutorizo" name="autoriza" value="SIM" />
                        <label class="title" style="font-size: 110%; color: #363636" for="checkAutorizo">
                        Aceito receber por e-mail informações sobre produtos, marcas e serviços oferecidos
                        pela Viatris e empresas coligadas.
                        </label>
                     </div>
                     </br>
                     <label class="label" color="#363636" for="conteudo">Enviar imagem:</label>
                     <input type="file" name="foto" id="foto" class="send"/>
                     <br>
                     <br />
                     <div class="field is-grouped" style="justify-content: center;">
                        <div class="control">
                           <input value="Enviar" type="submit" class="button" style="color:#703e97"/>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </section>
   </body>
</html>