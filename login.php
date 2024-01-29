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
$nome = isset($_POST['nome']) ? $_POST['nome'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$senha = isset($_POST['senhaCli']) ? $_POST['senhaCli'] : '';
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

// Query para inserir os dados no banco de dados
$query = "INSERT INTO cliente (nome, email, senhaCli) VALUES ('$nome', '$email', '$senhaHash')";



// Executa a query
if (mysqli_query($conexao, $query)) {

} else {
    echo "Erro ao inserir registro: " . mysqli_error($conexao);
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
  <link rel="stylesheet" href="css/estilo.css">

  <title>Inscreva-se</title>
</head>

<body>
  <center>
    <div class="card" style="width: 25rem;">
      <img src="immg/esper.png" class="card-img-top" alt="imagem_formulário">
      <div class="card-body">
      <form method="post" action="login.php">
    <h2>Inscreva-se</h2><br>
    <input name="nome" class="form-control" type="text" placeholder="Nome*" autofocus><br>
    <input name="email" class="form-control" type="email" placeholder="Email*"><br>
    <input name="senhaCli" class="form-control" type="password" placeholder="Crie uma Senha*"><br>
    <input class="form-check-input mt-0" id="caixa" type="checkbox"> Aceito receber emails de publicidade.<hr>
    <p id="mensagem"></p>
    <button class="btn btn-danger" type="reset" onclick="limpar()">Limpar formulário</button>
    <button class="btn btn-success" type="submit">Criar seu cadastro</button><br>
</form>
      </div>
    </div>
    <p>
      <h5>Inscreva-se também com:</h5>
    </p>
    <div class="container_logo">
      <img class="logo" src="https://cdn-icons-png.flaticon.com/128/300/300221.png" alt="logo_google">
    </div>
  </center>

  <!-- Adicione antes do fechamento da tag </body> -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-BZR7A6dQcFm3E93/emF8r0QfQv8OKRb6DbLhK8sR/EAQFByKgi6td6b9DqN4jcSM"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+Wy/DUAdhWqAqEtgRQ6IepnTvHDpNlA2CNI"
    crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>

</html>