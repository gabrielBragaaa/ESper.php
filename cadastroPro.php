<?php
// Dados de conexão ao banco de dados
$hostname = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "esperfinal";

// Conexão ao MySQL
$conexao = mysqli_connect($hostname, $username, $password) or die("Não foi possível conectar ao Banco de Dados!");

// Seleciona o Banco de Dados
mysqli_select_db($conexao, $dbname);

// Função para validar e limpar dados
function validarDados($conexao, $dados) {
    $dados = mysqli_real_escape_string($conexao, $dados);
    $dados = htmlspecialchars($dados);
    return $dados;
}

// Recupera os dados do formulário
$nomeProduto = validarDados($conexao, isset($_POST['nome_produtos']) ? $_POST['nome_produtos'] : '');
$descricaoProduto = validarDados($conexao, isset($_POST['descricao_produtos']) ? $_POST['descricao_produtos'] : '');
$precoProduto = validarDados($conexao, isset($_POST['preco_produtos']) ? $_POST['preco_produtos'] : '');
$imagemProduto = validarDados($conexao, isset($_POST['imagem_produtos']) ? $_POST['imagem_produtos'] : '');



// Query para inserir os dados no banco de dados
$query = "INSERT INTO produtos (nome_produtos, descricao_produtos, preco_produtos,imagem_produtos) VALUES ('$nomeProduto', '$descricaoProduto', '$precoProduto','$imagemProduto')";

// Executa a query
if (mysqli_query($conexao, $query)) {
   
} else {
    echo "Erro ao inserir produto: " . mysqli_error($conexao);
}

// Fechar a conexão
mysqli_close($conexao);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserir Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-image: url('https://png.pngtree.com/back_origin_pic/04/13/30/734f5ba4e4a772658913afbcf380dea5.jpg'); 
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mb-4">Inserir Produto</h2>
                <form action="cadastroPro.php" method="post">
                    <div class="mb-3">
                        <label for="nomeProduto" class="form-label">Nome do Produto</label>
                        <input type="text" class="form-control" id="nomeProduto" name="nome_produtos" required>
                    </div>
                    <div class="mb-3">
                        <label for="descricaoProduto" class="form-label">Descrição do Produto</label>
                        <textarea class="form-control" id="descricaoProduto" name="descricao_produtos" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="precoProduto" class="form-label">Preço do Produto</label>
                        <input type="number" class="form-control" id="precoProduto" name="preco_produtos" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="imagemProduto" class="form-label">Imagem do produto</label>
                        <input type="text" class="form-control" id="imagemProduto" name="imagem_produtos" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Inserir Produto</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-BZR7A6dQcFm3E93/emF8r0QfQv8OKRb6DbLhK8sR/EAQFByKgi6td6b9DqN4jcSM"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+Wy/DUAdhWqAqEtgRQ6IepnTvHDpNlA2CNI"
        crossorigin="anonymous"></script>
</body>

</html>
