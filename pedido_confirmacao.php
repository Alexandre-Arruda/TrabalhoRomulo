<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica se existe um pedido finalizado na sessão. Se não, redireciona.
if (!isset($_SESSION['pedido_finalizado'])) {
    header('Location: index.php');
    exit;
}

// Pega os dados do pedido da sessão para exibir na página.
$pedido = $_SESSION['pedido_finalizado'];

// Limpa os dados da sessão para que a página não possa ser recarregada com os mesmos dados.
unset($_SESSION['pedido_finalizado']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Confirmado - Tech Store</title>
    <link rel="stylesheet" href="css/material.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>

    <header class="header">
        <div class="header-content">
            <a href="index.php" class="logo">🛒 Tech Store</a>
            <nav class="nav-links">
                <a href="index.php" class="nav-link">Ver Produtos</a>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="card" style="max-width: 700px; margin: 48px auto;">
            <div class="card-content text-center" style="padding: 48px;">
                <div style="width: 80px; height: 80px; background: var(--success-light); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--success)" stroke-width="2.5">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
                
                <h1 class="mb-2">Pedido Confirmado!</h1>
                
                <p class="text-large mb-3">
                    Obrigado por sua compra, <strong><?php echo htmlspecialchars(explode(' ', $pedido['cliente']['nome'])[0]); ?></strong>!
                </p>

                <div class="alert alert-success mb-3">
                    Um email de confirmação foi enviado para <strong><?php echo htmlspecialchars($pedido['cliente']['email']); ?></strong> com todos os detalhes.
                </div>

                <div class="card" style="background: var(--background); text-align: left; margin-bottom: 24px;">
                    <div class="card-content">
                        <h3 class="card-title" style="text-align: center; margin-bottom: 16px;">Resumo do Pedido</h3>
                        <div class="flex-between mb-1">
                            <span class="text-secondary">Nº do Pedido:</span>
                            <strong>#<?php echo $pedido['numero_pedido']; ?></strong>
                        </div>
                        <div class="flex-between mb-2">
                            <span class="text-secondary">Data:</span>
                            <span><?php echo $pedido['data']; ?></span>
                        </div>

                        <hr class="divider">

                        <p class="text-secondary" style="margin-top: 16px; margin-bottom: 8px;">Itens:</p>
                        <?php foreach ($pedido['itens'] as $item): ?>
                            <div class="flex-between mb-1">
                                <span class="text-small">
                                    <?php echo htmlspecialchars($item['nome']); ?>
                                    <span class="text-secondary">x<?php echo $item['quantidade']; ?></span>
                                </span>
                                <span class="text-small">
                                    R$ <?php echo number_format($item['preco'] * $item['quantidade'], 2, ',', '.'); ?>
                                </span>
                            </div>
                        <?php endforeach; ?>

                        <hr class="divider">

                        <div class="flex-between" style="margin-top: 16px; font-size: 18px;">
                            <strong>Total Pago:</strong>
                            <strong style="color: var(--primary);">
                                R$ <?php echo number_format($pedido['total'] + 15, 2, ',', '.'); // Adicionando o frete fixo ?>
                            </strong>
                        </div>
                    </div>
                </div>

                <a href="index.php" class="btn btn-primary btn-block">
                    Continuar Comprando
                </a>
            </div>
        </div>
    </div>

</body>
</html>