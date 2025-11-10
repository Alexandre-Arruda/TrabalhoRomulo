<?php
require 'db_conexao.php';

// Busca produtos
$stmt = $pdo->query("SELECT * FROM produtos WHERE estoque > 0 ORDER BY nome ASC");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Conta itens no carrinho
$total_itens = 0;
if (!empty($_SESSION['carrinho'])) {
    foreach ($_SESSION['carrinho'] as $item) {
        $total_itens += $item['quantidade'];
    }
}
?>
<?php require 'header.php'; ?>


    <!-- CONTEÚDO -->
    <div class="container">
        <h1 class="mb-3">Nossos Produtos</h1>

        <div class="grid grid-3">
            <?php foreach ($produtos as $produto): ?>
                <div class="produto-card">
                    <img src="uploads/<?php echo htmlspecialchars($produto['imagem_url']); ?>" 
                         alt="<?php echo htmlspecialchars($produto['nome']); ?>"
                         class="produto-image">
                    
                    <div class="produto-info">
                        <h3 class="produto-nome"><?php echo htmlspecialchars($produto['nome']); ?></h3>
                        <p class="produto-preco">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                        
                        <div class="flex gap-1">
                            <a href="produto.php?id=<?php echo $produto['id']; ?>" class="btn btn-outlined" style="flex: 1;">
                                Detalhes
                            </a>
                            
                            <form action="carrinho_acoes.php" method="POST" style="flex: 1;">
                                <input type="hidden" name="acao" value="adicionar">
                                <input type="hidden" name="id_produto" value="<?php echo $produto['id']; ?>">
                                <input type="hidden" name="quantidade" value="1">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Adicionar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>
<?php require 'footer.php'; ?>

</body>
</html>