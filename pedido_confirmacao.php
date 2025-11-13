<?php
// Inicia a sessão para acessar as variáveis de sessão, como as informações do pedido.

// VERIFICAÇÃO DE SEGURANÇA:
// Checa se a variável de sessão 'pedido_finalizado' foi definida (provavelmente no script de checkout).
// Se não foi, significa que o usuário está tentando acessar esta página diretamente sem ter feito um pedido.
if (!isset($_SESSION['pedido_finalizado'])) {
    // Redireciona o usuário para a página inicial para evitar acesso indevido.
    header('Location: index.php');
    exit;
}

// Pega o número do pedido que foi salvo na sessão.
$numero_pedido = $_SESSION['numero_pedido'];
// LIMPEZA DA SESSÃO:
// Remove a variável 'pedido_finalizado' da sessão.
// Isso é crucial para que o usuário não possa simplesmente recarregar esta página de confirmação várias vezes.
unset($_SESSION['pedido_finalizado']);
?>
<?php require 'header.php'; ?>

    <div class="container">
        <!-- Card centralizado para exibir a mensagem de confirmação -->
        <div class="card" style="max-width: 600px; margin: 64px auto;">
            <div class="card-content text-center" style="padding: 48px;">
                
                <!-- Ícone de sucesso (check) -->
                <div style="font-size: 80px; color: var(--success); margin-bottom: 24px;">
                    ✓
                </div>
                
                <h1 class="mb-2">Pedido Confirmado!</h1>
                
                <!-- Exibe o número do pedido para o cliente -->
                <p class="text-large mb-3">
                    Número do Pedido: <strong>#<?php echo $numero_pedido; ?></strong>
                </p>

                <!-- Mensagem informativa sobre os próximos passos (email, rastreamento) -->
                <div class="alert alert-success mb-3">
                    Seu pedido foi confirmado com sucesso! 
                    Em breve você receberá um email com os detalhes e o código de rastreamento.
                </div>

                <!-- Mensagem de agradecimento -->
                <p class="text-secondary mb-3">
                    Obrigado por comprar na Tech Store! 🎉
                </p>

                <!-- Botão para o usuário voltar ao catálogo e continuar navegando na loja -->
                <a href="index.php" class="btn btn-primary btn-block">
                    Continuar Comprando
                </a>
            </div>
        </div>
    </div>

</body>
</html><?php
// Seria uma boa prática incluir o footer aqui também, como nos outros arquivos.
// require 'footer.php'; 
?>