<?php
// ============================================
// CARRINHO_ACOES.PHP - BACKEND DO CARRINHO
// ============================================
// Este arquivo processa TODAS as ações do carrinho:
// - Adicionar produtos
// - Atualizar quantidade
// - Remover produtos
//
// IMPORTANTE: Este arquivo NÃO exibe HTML!
// Ele apenas processa e redireciona de volta

// INICIA A SESSÃO
// Necessário para acessar $_SESSION['carrinho']
session_start();

// CONECTA AO BANCO DE DADOS
// Precisamos buscar informações dos produtos
require 'db_conexao.php';

// ============================================
// INICIALIZA O CARRINHO (SE NÃO EXISTIR)
// ============================================
// Na primeira vez que o usuário adiciona algo, cria o array vazio
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// ============================================
// VERIFICA SE UMA AÇÃO FOI ENVIADA
// ============================================
// O formulário envia um campo 'acao' (adicionar, atualizar ou remover)
if (isset($_POST['acao'])) {
    
    // ========================================
    // PEGA OS DADOS DO FORMULÁRIO
    // ========================================
    // (int): converte para número inteiro (segurança)
    $id_produto = (int) $_POST['id_produto'];

    // ========================================
    // SWITCH: Executa código diferente para cada ação
    // ========================================
    // É como vários IF juntos, mais organizado
    switch ($_POST['acao']) {
        
        // ====================================
        // AÇÃO: ADICIONAR PRODUTO AO CARRINHO
        // ====================================
        case 'adicionar':
            
            // PEGA A QUANTIDADE (mínimo 1)
            $quantidade = (int) $_POST['quantidade'];
            if ($quantidade <= 0) $quantidade = 1;  // Garante que seja pelo menos 1

            // ================================
            // BUSCA OS DETALHES DO PRODUTO NO BANCO
            // ================================
            // Precisamos do nome e preço para guardar no carrinho
            $stmt = $pdo->prepare("SELECT nome, preco, estoque FROM produtos WHERE id = ?");
            $stmt->execute([$id_produto]);
            $produto = $stmt->fetch(PDO::FETCH_ASSOC);

            // SE O PRODUTO EXISTE NO BANCO...
            if ($produto) {
                
                // ============================
                // VERIFICA SE JÁ ESTÁ NO CARRINHO
                // ============================
                if (isset($_SESSION['carrinho'][$id_produto])) {
                    
                    // JÁ EXISTE: apenas ADICIONA à quantidade existente
                    // Exemplo: tinha 2, adiciona +1 = 3
                    $_SESSION['carrinho'][$id_produto]['quantidade'] += $quantidade;
                    
                } else {
                    
                    // NÃO EXISTE: CRIA NOVO ITEM no carrinho
                    // Guardamos: nome, preço e quantidade
                    $_SESSION['carrinho'][$id_produto] = [
                        'nome' => $produto['nome'],
                        'preco' => $produto['preco'],
                        'quantidade' => $quantidade
                    ];
                }
            }
            
            // break: sai do switch (não executa os outros cases)
            break;

        // ====================================
        // AÇÃO: ATUALIZAR QUANTIDADE
        // ====================================
        case 'atualizar':
            
            // PEGA A NOVA QUANTIDADE
            $quantidade = (int) $_POST['quantidade'];
            
            // SE A QUANTIDADE FOR MAIOR QUE ZERO...
            if ($quantidade > 0) {
                
                // VERIFICA SE O PRODUTO EXISTE NO CARRINHO
                if (isset($_SESSION['carrinho'][$id_produto])) {
                    // ATUALIZA a quantidade (substitui a antiga)
                    $_SESSION['carrinho'][$id_produto]['quantidade'] = $quantidade;
                }
                
            } else {
                // SE A QUANTIDADE FOR 0 OU MENOS...
                // REMOVE o produto do carrinho
                unset($_SESSION['carrinho'][$id_produto]);
            }
            
            break;

        // ====================================
        // AÇÃO: REMOVER PRODUTO DO CARRINHO
        // ====================================
        case 'remover':
            
            // VERIFICA SE O PRODUTO EXISTE NO CARRINHO
            if (isset($_SESSION['carrinho'][$id_produto])) {
                // unset: remove o item do array
                unset($_SESSION['carrinho'][$id_produto]);
            }
            
            break;
            
        // ====================================
        // SE A AÇÃO NÃO FOR RECONHECIDA
        // ====================================
        // (adicionar, atualizar ou remover)
        // Não faz nada (segurança)
    }
}

// ============================================
// REDIRECIONA DE VOLTA
// ============================================
// Após processar, volta para a página de onde veio

// $_SERVER['HTTP_REFERER']: URL da página anterior
if (isset($_SERVER['HTTP_REFERER'])) {
    // Redireciona para a página anterior
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    // Se não souber de onde veio, vai para o catálogo
    header('Location: index.php');
}

// exit: IMPORTANTE! Para a execução após redirecionar
exit;
?>

<!-- ============================================ -->
<!-- COMO ESTE ARQUIVO É USADO: -->
<!-- ============================================ -->
<!--
1. ADICIONAR PRODUTO:
   <form action="carrinho_acoes.php" method="POST">
       <input type="hidden" name="acao" value="adicionar">
       <input type="hidden" name="id_produto" value="1">
       <input type="number" name="quantidade" value="1">
       <button type="submit">Adicionar</button>
   </form>

2. ATUALIZAR QUANTIDADE:
   <form action="carrinho_acoes.php" method="POST">
       <input type="hidden" name="acao" value="atualizar">
       <input type="hidden" name="id_produto" value="1">
       <input type="number" name="quantidade" value="3">
       <button type="submit">Atualizar</button>
   </form>

3. REMOVER PRODUTO:
   <form action="carrinho_acoes.php" method="POST">
       <input type="hidden" name="acao" value="remover">
       <input type="hidden" name="id_produto" value="1">
       <button type="submit">Remover</button>
   </form>
-->

<!-- ============================================ -->
<!-- ESTRUTURA DO CARRINHO NA SESSÃO: -->
<!-- ============================================ -->
<!--
$_SESSION['carrinho'] = [
    1 => [                        // ID do produto
        'nome' => 'Mouse Gamer',
        'preco' => 149.90,
        'quantidade' => 2
    ],
    3 => [                        // Outro produto
        'nome' => 'Teclado RGB',
        'preco' => 299.90,
        'quantidade' => 1
    ]
];
-->