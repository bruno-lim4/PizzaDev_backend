<?php 
$conn = mysqli_connect('localhost', 'root', 'password', 'pizza_dev');
// mysqli_set_charset($conn, 'utf-8');
if (mysqli_connect_errno()) {
    die('Não foi possível se conectar com o banco de dados: ' . mysqli_connect_error());
}

$msg = array();

try {
    if ($_POST) {

        $nome = filter_var($_POST['nomePizza'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES) ?: throw new Exception('Por favor, preencha o campo Nome da Pizza!');
        $des = filter_var($_POST['descricao'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES) ?: throw new Exception('Por favor, preencha o campo Descrição dos ingredientes!');
        $foto = filter_var($_POST['foto'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES) ?: throw new Exception('Por favor, preencha o campo Foto!');
        $brotinho = filter_var($_POST['precoBrotinho'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) ?: throw new Exception('Por favor, preencha o campo Preço Brotinho!');
        $media = filter_var($_POST['precoMedia'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) ?: throw new Exception('Por favor, preencha o campo Preço Média!');
        $grande = filter_var($_POST['precoGrande'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) ?: throw new Exception('Por favor, preencha o campo Preço Grande!');
        
        var_dump($brotinho);

        $nome = mysqli_real_escape_string($conn, $nome);
        $des = mysqli_real_escape_string($conn, $des);
        $foto = mysqli_real_escape_string($conn, $foto);

        $sql = "INSERT INTO pizzas (nome, ingredientes, img, brotinho, media, grande) VALUES('$nome', '$des', '$foto', $brotinho, $media, $grande)";

        $resultado = mysqli_query($conn, $sql);

        if ($resultado === false || mysqli_errno($conn)) {
            throw new Exception('Erro ao realizar operação no banco de dados: ' . mysqli_error($conn));
        }

        $msg = array(
            'classe' => 'msg-sucesso',
            'mensagem' => 'Pizza cadastrada com sucesso!'
        );
    }
}
catch(Exception $ex)
{
    $msg = array(
        'classe' => 'msg-erro',
        'mensagem' => $ex->getMessage()
    );
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Pizza | Administração | Pizza DEV</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link rel="stylesheet" href="../assets/css/admin.css" />
    <script src="../assets/js/admin.js" defer></script>
</head>
<body>
    <header class="topo flex container-padding">
        <img src="../assets/images/pizza-dev.png" alt="Pizza DEV" />
        <nav class="menu">
            <a href="index.php" class="active">Pizzas</a>
            <a href="mensagens.php">Mensagens</a>
            <a href="usuarios.php">Usuários</a>
            <a href="login.php">Sair</a>
        </nav>
    </header>
    <div class="pagina container">
        <div class="cabecalho flex bordered">
            <h1>Cadastrar Pizza</h1>
            <a href="index.php" class="botao">
                Voltar
            </a>
        </div>

        <?php if ($msg) : ?>
            <div class="<?= $msg['classe'] ?>">
                <?= $msg['mensagem']; ?>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <input type="text" name="nomePizza" id="nomePizza" class="input-field" placeholder="* Nome da Pizza" />
            <textarea name="descricao" id="descricao" cols="1" rows="6" class="input-field" placeholder="* Descrição dos Ingredientes"></textarea>
            <div class="group-field flex">
                <input type="number" name="precoBrotinho" id="precoBrotinho" class="input-field" step=".01" placeholder="* Preço Brotinho" />
                <input type="number" name="precoMedia" id="precoMedia" class="input-field" step=".01" placeholder="* Preço Média" />
                <input type="number" name="precoGrande" id="precoGrande" class="input-field" step=".01" placeholder="* Preço Grande" />
            </div>
            <input type="text" name="foto" id="foto" class="input-field" placeholder="Foto (ex: pizza-calabresa.jpg)" />
            <button type="submit" class="botao">
                Cadastrar
            </button>
        </form>
    </div>
</body>
</html>