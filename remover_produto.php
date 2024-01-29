<?php
session_start();

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se o ID do produto a ser removido está definido
    if (isset($_POST['produtoID'])) {
        $produtoID = $_POST['produtoID'];

        // Encontra a posição do produto no carrinho
        $posicao = array_search($produtoID, $_SESSION['carrinho']);

        // Remove o produto da posição encontrada
        if ($posicao !== false) {
            unset($_SESSION['carrinho'][$posicao]);
        }
    }
}

// Redireciona de volta para a página do carrinho
header("Location: carrinho.php");
exit();
?>