<?php
// carrinho_acoes.php
session_start();
require 'db_conexao.php'; // Precisamos do BD para pegar os detalhes do produto

// Inicializa o carrinho na sessão se ele não existir
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Verifica se uma ação foi enviada
if (isset($_POST['acao'])) {
    
    $id_produto = (int) $_POST['id_produto']; // Garante que é um número

    switch ($_POST['acao']) {
        
        // --- CREATE ---
        case 'adicionar':
            $quantidade = (int) $_POST['quantidade'];
            if ($quantidade <= 0) $quantidade = 1;

            // 1. Buscar os detalhes do produto no BD
            $stmt = $pdo->prepare("SELECT nome, preco, estoque FROM produtos WHERE id = ?");
            $stmt->execute([$id_produto]);
            $produto = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($produto) {
                // 2. Verificar se o produto já está no carrinho
                if (isset($_SESSION['carrinho'][$id_produto])) {
                    // Se sim, apenas atualiza a quantidade
                    $_SESSION['carrinho'][$id_produto]['quantidade'] += $quantidade;
                } else {
                    // Se não, adiciona o produto (com nome e preço) ao carrinho
                    $_SESSION['carrinho'][$id_produto] = [
                        'nome' => $produto['nome'],
                        'preco' => $produto['preco'],
                        'quantidade' => $quantidade
                    ];
                }
            }
            break;

        // --- UPDATE ---
        case 'atualizar':
            $quantidade = (int) $_POST['quantidade'];
            if ($quantidade > 0) {
                if (isset($_SESSION['carrinho'][$id_produto])) {
                    $_SESSION['carrinho'][$id_produto]['quantidade'] = $quantidade;
                }
            } else {
                // Se a quantidade for 0 ou menos, remove o item
                unset($_SESSION['carrinho'][$id_produto]);
            }
            break;

        // --- DELETE ---
        case 'remover':
            if (isset($_SESSION['carrinho'][$id_produto])) {
                unset($_SESSION['carrinho'][$id_produto]);
            }
            break;
    }
}

// Redireciona o usuário de volta para a página de onde ele veio (o catálogo)
// Isso faz com que a página seja recarregada, mostrando o carrinho atualizado.
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
?>