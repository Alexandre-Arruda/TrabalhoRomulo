<?php
session_start();

if (!isset($_SESSION['pedido_finalizado'])) {
    header('Location: index.php');
    exit;
}

$numero_pedido = $_SESSION['numero_pedido'];
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