<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['produtoID'])) {
        $produtoID = $_POST['produtoID'];

        // Adicionar o produto à variável de sessão
        $_SESSION['carrinho'][] = $produtoID;
    }
}
?>