<?php
require 'header.php';

$termo_busca = isset($_GET['busca']) ? trim($_GET['busca']) : '';
$produtos = [];

if (!empty($termo_busca)) {
    $busca = "%{$termo_busca}%";
    $stmt = $pdo->prepare("
        SELECT * FROM produtos 
        WHERE (nome LIKE ? OR descricao LIKE ?) AND estoque > 0
        ORDER BY nome ASC
    ");
    $stmt->execute([$busca, $busca]);
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="container">
    
    <div class="breadcrumb">
        <a href="index.php">Início</a>
        <span>→</span>
        <span>Busca</span>
    </div>

    <?php if (empty($termo_busca)): ?>
        
        <div class="card" style="padding: 80px 40px; text-align: center;">
            <svg width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto 24px; color: var(--text-secondary);">
                <circle cx="11" cy="11" r="8"/>
                <path d="m21 21-4.35-4.35"/>
            </svg>
            <h2 style="margin-bottom: 16px;">Faça uma busca</h2>
            <p style="color: var(--text-secondary); margin-bottom: 32px;">
                Digite o nome do produto que você procura na barra de pesquisa acima
            </p>
            <a href="index.php" class="btn btn-primary">
                Ver Todos os Produtos
            </a>
        </div>

    <?php elseif (count($produtos) > 0): ?>
        
        <div class="page-header" style="text-align: left;">
            <h1>Resultados para "<?php echo htmlspecialchars($termo_busca); ?>"</h1>
            <p><?php echo count($produtos); ?> produto(s) encontrado(s)</p>
        </div>

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
                            <a href="produto.php?id=<?php echo $produto['id']; ?>" 
                               class="btn btn-outlined" 
                               style="flex: 1;">
                                Ver Detalhes
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

    <?php else: ?>
        
        <div class="card" style="padding: 80px 40px; text-align: center;">
            <div style="font-size: 80px; margin-bottom: 24px;">🔍</div>
            <h2 style="margin-bottom: 16px;">Nenhum resultado encontrado</h2>
            <p style="color: var(--text-secondary); margin-bottom: 32px; max-width: 500px; margin-left: auto; margin-right: auto;">
                Não encontramos produtos com "<strong><?php echo htmlspecialchars($termo_busca); ?></strong>". 
                Tente buscar com outras palavras ou navegue por nosso catálogo completo.
            </p>
            <div style="display: flex; gap: 16px; justify-content: center;">
                <a href="index.php" class="btn btn-primary">
                    Ver Todos os Produtos
                </a>
                <button onclick="document.querySelector('.search-input').focus()" class="btn btn-outlined">
                    Fazer Nova Busca
                </button>
            </div>
        </div>

    <?php endif; ?>

</div>

<?php require 'footer.php'; ?>