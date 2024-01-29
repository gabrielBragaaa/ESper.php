<?php
// Dados de conexão ao banco de dados
$hostname = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "carrinhoesp";

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


// Query para inserir os dados no banco de dados
$query = "SELECT * FROM produtos ";

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
  <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/128/9623/9623872.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="style.css">
  <title>Compra Concluída</title>
</head>

<body style="text-align: center; padding: 50px;">
    <h1>Compra Concluída com Sucesso!</h1>
    
    <img src="immg/ok.jpg" alt="Sucesso" width="100">
    <!-- Substitua "caminho_para_o_seu_simbolo_de_sucesso.png" pelo caminho real do seu símbolo -->
</body>

</html>