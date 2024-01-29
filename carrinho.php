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

// Inicializa a variável de sessão 'carrinho' como um array se ainda não existir
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = array();
}

// Função para validar e limpar dados
function validarDados($conexao, $dados) {
    $dados = mysqli_real_escape_string($conexao, $dados);
    $dados = htmlspecialchars($dados);
    return $dados;
}

// Variável para armazenar o total dos produtos
$total = 0;

// Variável para armazenar o valor do frete
$frete = 0;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras</title>
    <link rel="stylesheet" href="css/carrinho.css">
</head>

<body>
    <center>
        <section>
            <div class="logo d-flex justify-content-center" id="esper">
                <img src="immg/esper.png" alt="logo" width="100"><br>
                <h2>Carrinho de Compras</h2>

                <?php
                $total = 0;
                if (isset($_SESSION['carrinho'])) {
                    foreach ($_SESSION['carrinho'] as $produtoID) {
                        $query = "SELECT * FROM produtos WHERE id_produtos = $produtoID";
                        $resultado = mysqli_query($conexao, $query);

                        if ($resultado && $produto = mysqli_fetch_assoc($resultado)) {
                            echo '<div class="product">';
                            echo '<img src="' . $produto['imagem_produtos'] . '" alt="Product Image">';
                            echo '<div class="product-info">';
                            echo '<h3>' . $produto['nome_produtos'] . '</h3>';
                            echo '<p>Preço: R$' . $produto['preco_produtos'] . '</p>';
                            echo '<form method="post" action="remover_produto.php">';
                            echo '<input type="hidden" name="produtoID" value="' . $produto['id_produtos'] . '">';
                            echo '<button type="submit">Remover do Carrinho</button>';
                            echo '</form>';
                            echo '</div>';
                            echo '</div>';

                            $total += $produto['preco_produtos'];
                        }
                    }
                }
                ?>

                <div class="frete-section">
                    <h3>Calcular Frete</h3>
                    <form id="calcularFreteForm">
                        <label for="cep">CEP:</label>
                        <input type="text" id="cep" name="cep" placeholder="Digite seu CEP">
                        <button type="button" onclick="consultarCEP()">Calcular Frete</button>
                    </form>
                    <div id="resultadoCEP"></div>
                </div>

                                <div class="total">
                            <p>Total (sem frete): R$<span id="totalSemFrete"><?= $total; ?></span></p>
                            <p>Frete: R$<span id="frete">0</span></p>
                            <p>Total (com frete): R$<span id="totalComFrete"><?= $total; ?></span></p>
                        </div>

                <form id="finalizarCompraForm" method="post" action="sucess.php">
                    <button type="submit" onclick="finalizarCompra()">Finalizar Compra</button>
                </form>
            </div>
        </section>
    </center>
    <script>
    function consultarCEP() {
        var cep = document.getElementById('cep').value;
        cep = cep.replace(/\D/g, '');

        if (cep.length !== 8) {
            alert('CEP inválido. Certifique-se de inserir 8 dígitos.');
            return;
        }

        var url = `https://viacep.com.br/ws/${cep}/json/`;

        fetch(url)
            .then(response => response.json())
            .then(data => exibirResultado(data, determinarRegiao(cep)))
            .catch(error => console.error('Erro:', error));
    }

    function calcularFrete(regiao) {
        switch (regiao.toLowerCase()) {
            case 'sul':
                return 19;
            case 'norte':
                return 20; // Adicione o valor específico para a região Norte
            case 'nordeste':
                return 5;
            case 'centro-oeste':
                return 20;
            case 'sudeste':
                return 18;
            default:
                return 0;
        }
    }

    function determinarRegiao(cep) {
        var numerosCEP = parseInt(cep.substring(0, 5));

        if (numerosCEP >= '70000' && numerosCEP <= 79999) {
            return 'centro-oeste';
        } else if (numerosCEP >= 60000 && numerosCEP <= 69999) {
            return 'norte';
        } else if (numerosCEP >= 50000 && numerosCEP <= 59999) {
            return 'nordeste';
        } else if (numerosCEP >= 40000 && numerosCEP <= 49999) {
            return 'sudeste';
        } else if (numerosCEP >= 80000 && numerosCEP <= 89999) {
            return 'sul';
        } else {
            return 'outra região';
        }
    }

    function exibirResultado(data, regiao) {
        if (data.erro) {
            alert('CEP não encontrado. Verifique se o CEP está correto.');
            return;
        }

        var frete = calcularFrete(regiao);
        var totalSemFrete = <?= $total; ?>;
        var totalComFrete = parseFloat(totalSemFrete) + parseFloat(frete);

        // Adiciona o valor do frete ao total da compra
        

        // Atualiza o frete no HTML
        document.getElementById('frete').textContent = frete;

        // Atualiza o total sem frete no HTML
        document.getElementById('totalSemFrete').textContent = totalSemFrete;

        // Atualiza o total com frete no HTML
        document.getElementById('totalComFrete').textContent = totalComFrete.toFixed(2); // Limita a 2 casas decimais

        // Exibe as informações do CEP e da região no HTML
        document.getElementById('resultadoCEP').innerHTML = `
            <p>CEP: ${data.cep}</p>
            <p>Cidade: ${data.localidade}</p>
            <p>Estado: ${data.uf}</p>
            <p>Região: ${regiao}</p> 
        `;

        // Envia o valor do frete para o PHP usando AJAX
        enviarFreteParaPHP(frete);
    }

    // Restante do seu código JavaScript...

function enviarFreteParaPHP(frete) {
    // Cria uma instância do objeto XMLHttpRequest
    var xhr = new XMLHttpRequest();

    // Especifica o tipo de requisição e a URL
    xhr.open('GET', 'atualizar_frete.php?frete=' + frete, true);

    // Envia a requisição
    xhr.send();
}
    </script>

   
</body>

</html>