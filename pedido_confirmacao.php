<?php
// Inicia a sessão para poder acessar as variáveis globais $_SESSION
session_start();

// --- VERIFICAÇÃO DE SEGURANÇA ---
// Verifica se a variável 'pedido_finalizado' NÃO existe na sessão.
// Isso impede que alguém acesse essa página digitando a URL diretamente 
// sem ter passado pelo processo de checkout.
if (!isset($_SESSION['pedido_finalizado'])) {
    // Se não existe, redireciona o usuário de volta para a página inicial.
    header('Location: index.php');
    exit; // Encerra o script para garantir que o resto da página não carregue.
}

// Recupera o número do pedido que foi salvo na sessão durante o checkout
$numero_pedido = $_SESSION['numero_pedido'];

// --- LIMPEZA DA SESSÃO ---
// Remove a confirmação da sessão.
// Isso é crucial! Se o usuário atualizar a página (F5), o código de segurança acima
// vai rodar, ver que essa variável não existe mais, e redirecionar para a home.
// Isso evita que o pedido seja processado duas vezes ou que a página fique acessível para sempre.
unset($_SESSION['pedido_finalizado']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Confirmado - Tech Store</title>
    <link rel="stylesheet" href="css/material.css">
</head>
<body>

    <header class="header">
        <div class="header-content">
            <a href="index.php" class="logo">🛒 Tech Store</a>
            <nav class="nav-links">
                <a href="index.php">Catálogo</a>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="card" style="max-width: 600px; margin: 64px auto;">
            <div class="card-content text-center" style="padding: 48px;">
                
                <div style="font-size: 80px; color: var(--success); margin-bottom: 24px;">
                    ✓
                </div>
                
                <h1 class="mb-2">Pedido Confirmado!</h1>
                
                <p class="text-large mb-3">
                    Número do Pedido: <strong>#<?php echo $numero_pedido; ?></strong>
                </p>

                <div class="alert alert-success mb-3">
                    Seu pedido foi confirmado com sucesso! 
                    Em breve você receberá um email com os detalhes e o código de rastreamento.
                </div>

                <p class="text-secondary mb-3">
                    Obrigado por comprar na Tech Store! 🎉
                </p>

                <a href="index.php" class="btn btn-primary btn-block">
                    Continuar Comprando
                </a>
            </div>
        </div>
    </div>

</body>
</html>