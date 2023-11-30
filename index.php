<?php
require './vendor/autoload.php';

use chillerlan\QRCode\QRCode;

// Definindo uma mensagem padrão e estilo para exibir na interface
$info = ['type' => 'text-warning', 'msg' => 'Preecha o campo URL e clique em GERAR QR CODE, exemplo: http://google.com.br'];

// Verificando se o método de requisição é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtendo o valor do campo "link" do formulário
    $link = $_POST["link"];

    // Verificando se o valor fornecido é uma URL válida
    if (!filter_var($link, FILTER_VALIDATE_URL)) {
        // Atualizando a mensagem e estilo em caso de URL inválida
        $info = ['type' => 'text-danger', 'msg' => 'Preecha o campo com uma URL corretamente.'];
    } else {
        // Atualizando a mensagem e estilo em caso de URL válida
        $info = ['type' => 'text-success', 'msg' => 'QR code para ' .  $link . ' gerado com sucesso!'];

        // Gerando o código QR e criando a tag HTML para exibição na interface
        $qrCode = '<img src="' . (new QRCode())->render($link) . '" alt="QR Code" class="h-auto w-50" />';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<title>Gerador de QRCode</title>
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="card card-shadow">
				<div class="card-header">
					<h1>Gerador de QR code</h1>
				</div>
				<div class="card-body">
					<div class="col-12">
						<label for="link_imagem">URL:</label>
						<form action="" method="post">
							<div class="row">
								<div class="col-4">
									<input type="text" name="link" id="link" class="form-control" required value="<?php echo $_POST["link"] ?? '' ?>">
								</div>
								<div class="col-4">
									<button type="submit" class="btn btn-primary ">Gerar QR Code</button>
								</div>
							</div>
						</form>
					</div>
					<div class="col-12">
						<h4 class="<?php echo $info['type'] ?> "><?php echo $info['msg'] ?></h4>
					</div>
					<?php if (!empty($qrCode)) : ?>
						<div class="col-12 text-center">
							<?php echo $qrCode ?>
						</div>
					<?php endif; ?>
				</div>

			</div>
		</div>
	</div>
</body>

</html>