<?php
session_start();
require 'db_conexao.php';

// Inicializa o carrinho
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Verifica se uma ação foi enviada
if (isset($_POST['acao'])) {
    
    $id_produto = (int) $_POST['id_produto'];

    switch ($_POST['acao']) {
        
        // --- ADICIONAR ---
        case 'adicionar':
            $quantidade = (int) $_POST['quantidade'];
            if ($quantidade <= 0) $quantidade = 1;

            // Buscar os detalhes do produto no BD
            $stmt = $pdo->prepare("SELECT nome, preco, estoque FROM produtos WHERE id = ?");
            $stmt->execute([$id_produto]);
            $produto = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($produto) {
                if (isset($_SESSION['carrinho'][$id_produto])) {
                    // Atualiza quantidade
                    $_SESSION['carrinho'][$id_produto]['quantidade'] += $quantidade;
                } else {
                    // Adiciona novo produto
                    $_SESSION['carrinho'][$id_produto] = [
                        'nome' => $produto['nome'],
                        'preco' => $produto['preco'],
                        'quantidade' => $quantidade
                    ];
                }
            }
            break;

        // --- ATUALIZAR ---
        case 'atualizar':
            $quantidade = (int) $_POST['quantidade'];
            if ($quantidade > 0) {
                if (isset($_SESSION['carrinho'][$id_produto])) {
                    $_SESSION['carrinho'][$id_produto]['quantidade'] = $quantidade;
                }
            } else {
                unset($_SESSION['carrinho'][$id_produto]);
            }
            break;

        // --- REMOVER ---
        case 'remover':
            if (isset($_SESSION['carrinho'][$id_produto])) {
                unset($_SESSION['carrinho'][$id_produto]);
            }
            break;
    }
}

// Redireciona de volta
if (isset($_SERVER['HTTP_REFERER'])) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    header('Location: index.php');
}
exit;
?>