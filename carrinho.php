<?php
session_start();
require 'db_conexao.php';

// Calcula total
$total_carrinho = 0;
$total_itens = 0;
if (!empty($_SESSION['carrinho'])) {
    foreach ($_SESSION['carrinho'] as $item) {
        $total_carrinho += $item['preco'] * $item['quantidade'];
        $total_itens += $item['quantidade'];
    }
}
?>
<?php require 'header.php'; ?>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">Catálogo</a>
            <span>/</span>
            <span>Carrinho</span>
        </div>

        <h1 class="mb-3">Meu Carrinho</h1>

        <?php if (empty($_SESSION['carrinho'])): ?>
            
            <div class="card">
                <div class="card-content text-center" style="padding: 64px;">
                    <div style="font-size: 64px; margin-bottom: 16px;">🛒</div>
                    <h2 class="mb-2">Seu carrinho está vazio</h2>
                    <p class="text-secondary mb-3">Adicione produtos para começar suas compras!</p>
                    <a href="index.php" class="btn btn-primary">Ver Produtos</a>
                </div>
            </div>

        <?php else: ?>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
                
                <!-- LISTA DE PRODUTOS -->
                <div>
                    <div class="card">
                        <div class="card-content">
                            <h2 class="card-title">Itens do Carrinho (<?php echo $total_itens; ?>)</h2>
                            
                            <?php foreach ($_SESSION['carrinho'] as $id_produto => $item): 
                                $subtotal = $item['preco'] * $item['quantidade'];
                            ?>
                                
                                <div class="lista-item">
                                    <div class="flex gap-2" style="flex: 1;">
                                        <div>
                                            <h3 class="mb-1"><?php echo htmlspecialchars($item['nome']); ?></h3>
                                            <p class="text-secondary text-small">
                                                R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?> cada
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex gap-2" style="align-items: center;">
                                        <form action="carrinho_acoes.php" method="POST" class="flex gap-1">
                                            <input type="hidden" name="acao" value="atualizar">
                                            <input type="hidden" name="id_produto" value="<?php echo $id_produto; ?>">
                                            <input type="number" 
                                                   name="quantidade" 
                                                   value="<?php echo $item['quantidade']; ?>" 
                                                   min="1"
                                                   class="form-input"
                                                   style="width: 70px;">
                                            <button type="submit" class="btn btn-outlined btn-icon">✓</button>
                                        </form>

                                        <div style="min-width: 100px; text-align: right;">
                                            <strong style="font-size: 18px;">
                                                R$ <?php echo number_format($subtotal, 2, ',', '.'); ?>
                                            </strong>
                                        </div>

                                        <form action="carrinho_acoes.php" method="POST">
                                            <input type="hidden" name="acao" value="remover">
                                            <input type="hidden" name="id_produto" value="<?php echo $id_produto; ?>">
                                            <button type="submit" class="btn btn-text btn-icon" style="color: var(--error);">
                                                🗑️
                                            </button>
                                        </form>
                                    </div>
                                </div>

                            <?php endforeach; ?>
                        </div>
                    </div>

                    <a href="index.php" class="btn btn-text mt-2">
                        ← Continuar Comprando
                    </a>
                </div>

                <!-- RESUMO -->
                <div>
                    <div class="card">
                        <div class="card-content">
                            <h2 class="card-title">Resumo do Pedido</h2>
                            
                            <div class="flex-between mb-2">
                                <span class="text-secondary">Subtotal:</span>
                                <span>R$ <?php echo number_format($total_carrinho, 2, ',', '.'); ?></span>
                            </div>

                            <div class="flex-between mb-2">
                                <span class="text-secondary">Frete:</span>
                                <span class="text-small" style="color: var(--success);">
                                    A calcular
                                </span>
                            </div>

                            <hr style="margin: 16px 0; border: 0; border-top: 1px solid var(--divider);">

                            <div class="flex-between mb-3">
                                <strong style="font-size: 18px;">Total:</strong>
                                <strong style="font-size: 24px; color: var(--primary);">
                                    R$ <?php echo number_format($total_carrinho, 2, ',', '.'); ?>
                                </strong>
                            </div>

                            <a href="checkout.php" class="btn btn-success btn-block" style="padding: 16px;">
                                Finalizar Compra
                            </a>

                            <p class="text-small text-secondary text-center mt-2">
                                Pagamento seguro e protegido
                            </p>
                        </div>
                    </div>

                    <!-- CUPOM -->
                    <div class="card mt-2">
                        <div class="card-content">
                            <h3 class="mb-2">Cupom de Desconto</h3>
                            <form class="flex gap-1">
                                <input type="text" 
                                       class="form-input" 
                                       placeholder="Digite o cupom"
                                       style="flex: 1;">
                                <button type="submit" class="btn btn-outlined">Aplicar</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        <?php endif; ?>
    </div>

</body>
</html>