<?php
session_start();

// Dados de conexão ao banco de dados
$hostname = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "esperfinal";

// Conexão ao MySQL
$conexao = mysqli_connect($hostname, $username, $password) or die("Não foi possível conectar ao Banco de Dados!");

// Seleciona o Banco de Dados
mysqli_select_db($conexao, $dbname);

// Se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifique se um produto foi selecionado
    if (isset($_POST['produto'])) {
        $produtoSelecionado = $_POST['produto'];

        // Adicione o produto à variável de sessão
        $_SESSION['carrinho'][] = $produtoSelecionado;
    }
}

// Selecione seus produtos do banco de dados
$query = "SELECT * FROM produtos";
$resultadoProdutos = mysqli_query($conexao, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ésper</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-TWVsWj57EPBxiazSEntFc1DPt2WGRCxgLpG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous">
    <link rel="stylesheet" href="css/esTela.css">
    <style>
    .product-image {
        max-width: 100%;
        height: auto;
        /* Adicione outras propriedades CSS desejadas para controlar o tamanho da imagem */
    }
</style>
</head>

<body>

    <header>

        <div class="logo d-flex justify-content-center">
            <img src="immg/esper.png" alt="logo" width="200">

            <div class="container">
                <div class="row">

                </div>
                <br>
                <nav id="cabecalho" class="navbar navbar-expand-lg navbar-light bg-custom">

                    <a class="navbar-brand" href="#"></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto topnav">

                           

                            <div class="dropdown">

                            </div>
                            <li class="nav-item">
                                <a class="nav-link" href="https://politicas-esper.elisalopes1.repl.co/">Políticas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="https://fale-conosco.elisalopes1.repl.co/">Fale Conosco</a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link btn btn-danger text-white" type="button"
                                    href="login.php" data-toggle="modal"
                                    data-target="#myModal">Register</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-primary text-white" type="button" href="carrinho.php"
                                    data-toggle="modal" data-target="#myModal">Carrinho</a>
                            </li>
                        </ul>
                    </div>
            </div>
    </header>

    <a href="https://www.google.com" style=" width: 60rem; height: 20rem;">
        <div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary"
            style="background:url('https://images.contentstack.io/v3/assets/blt1d2d260317d3b8f0/blt916bc6a3dedca7ff/60f73a2b60e48e11c968fc90/Web-Banner-LIGHT-TEXT-PS5-Launch-v1.1.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            width: 60rem;
            height: 20rem;" id="ps5">
        </div>
    </a>
<center>
    <div class="container">
        <div class="row row-cols-1 row-cols-md-3">
            <?php
           while ($produto = mysqli_fetch_assoc($resultadoProdutos)) {
            echo '<div class="col mb-4">';
            echo '<div class="card">';
            echo '<img src="' . $produto['imagem_produtos'] . '" class="card-img-top img-fluid product-image" alt="' . $produto['nome_produtos'] . '">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $produto['nome_produtos'] . '</h5>';
            echo '<p class="card-text">R$' . $produto['preco_produtos'] . '</p>';
            echo '<button onclick="adicionarCarrinho(' . $produto['id_produtos'] . ')" class="btn btn-success" style="background-color: #2972d1;">Comprar</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        ?>
          </center>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script>
        function adicionarCarrinho(produtoID) {
            // Enviar uma requisição AJAX para adicionar o produto ao carrinho
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'adicionar_carrinho.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Redirecionar para a página do carrinho após a adição do produto
                    window.location.href = 'carrinho.php';
                }
            };
            xhr.send('produtoID=' + produtoID);
        }
    </script>

</body>

</html>