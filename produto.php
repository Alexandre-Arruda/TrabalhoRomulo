<?php
session_start();
require 'db_conexao.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    header('Location: index.php');
    exit;
}

// Conta itens no carrinho
$total_itens = 0;
if (!empty($_SESSION['carrinho'])) {
    foreach ($_SESSION['carrinho'] as $item) {
        $total_itens += $item['quantidade'];
    }
}

// Calcula parcelamento
$preco = $produto['preco'];
$parcelamento = [];
for ($i = 1; $i <= 12; $i++) {
    $valor_parcela = $preco / $i;
    // Adiciona juros após 6x (exemplo: 2% ao mês)
    if ($i > 6) {
        $juros = 0.02;
        $valor_parcela = $preco * pow(1 + $juros, $i) / $i;
    }
    $parcelamento[$i] = $valor_parcela;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($produto['nome']); ?> - Tech Store</title>
    <link rel="stylesheet" href="css/material.css">
    <style>
        .produto-detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
            margin-bottom: 32px;
        }
        .produto-main-image {
            width: 100%;
            border-radius: 4px;
            box-shadow: var(--shadow-2);
        }
        .produto-thumbnails {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            margin-top: 16px;
        }
        .thumbnail {
            width: 100%;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
            cursor: pointer;
            border: 2px solid transparent;
        }
        .thumbnail:hover {
            border-color: var(--primary);
        }
        .preco-destaque {
            font-size: 36px;
            font-weight: 500;
            color: var(--primary);
            margin: 16px 0;
        }
        @media (max-width: 768px) {
            .produto-detail-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <header class="header">
        <div class="header-content">
            <a href="index.php" class="logo">🛒 Tech Store</a>
            <nav class="nav-links">
                <a href="index.php">Catálogo</a>
                <a href="carrinho.php">
                    Carrinho
                    <?php if ($total_itens > 0): ?>
                        <span class="badge"><?php echo $total_itens; ?></span>
                    <?php endif; ?>
                </a>
            </nav>
        </div>
    </header>

    <div class="container">
        <!-- BREADCRUMB -->
        <div class="breadcrumb">
            <a href="index.php">Catálogo</a>
            <span>/</span>
            <span><?php echo htmlspecialchars($produto['nome']); ?></span>
        </div>

        <!-- GRID PRINCIPAL -->
        <div class="produto-detail-grid">
            <!-- IMAGENS -->
            <div>
                <img src="uploads/<?php echo htmlspecialchars($produto['imagem_url']); ?>" 
                     alt="<?php echo htmlspecialchars($produto['nome']); ?>"
                     class="produto-main-image"
                     id="mainImage">
                
                <!-- THUMBNAILS (exemplo - você pode adicionar mais imagens no BD) -->
                <div class="produto-thumbnails">
                    <img src="uploads/<?php echo htmlspecialchars($produto['imagem_url']); ?>" 
                         class="thumbnail" 
                         onclick="changeImage(this.src)">
                    <img src="uploads/<?php echo htmlspecialchars($produto['imagem_url']); ?>" 
                         class="thumbnail" 
                         onclick="changeImage(this.src)">
                    <img src="uploads/<?php echo htmlspecialchars($produto['imagem_url']); ?>" 
                         class="thumbnail" 
                         onclick="changeImage(this.src)">
                    <img src="uploads/<?php echo htmlspecialchars($produto['imagem_url']); ?>" 
                         class="thumbnail" 
                         onclick="changeImage(this.src)">
                </div>
            </div>

            <!-- INFORMAÇÕES -->
            <div>
                <h1><?php echo htmlspecialchars($produto['nome']); ?></h1>
                
                <div class="preco-destaque">
                    R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                </div>

                <div class="card mb-3">
                    <div class="card-content">
                        <h3 class="card-title">Descrição</h3>
                        <p class="text-secondary">
                            <?php 
                            // Se não houver descrição no BD, mostra um texto padrão
                            echo isset($produto['descricao']) && $produto['descricao'] 
                                ? nl2br(htmlspecialchars($produto['descricao'])) 
                                : 'Produto de alta qualidade. Disponível em estoque para entrega rápida.';
                            ?>
                        </p>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-content">
                        <h3 class="card-title">Parcelamento</h3>
                        <div style="max-height: 200px; overflow-y: auto;">
                            <?php foreach ($parcelamento as $parcelas => $valor): ?>
                                <div class="flex-between mb-1">
                                    <span><?php echo $parcelas; ?>x de</span>
                                    <strong>R$ <?php echo number_format($valor, 2, ',', '.'); ?></strong>
                                    <?php if ($parcelas > 6): ?>
                                        <span class="text-small text-secondary">com juros</span>
                                    <?php else: ?>
                                        <span class="text-small" style="color: var(--success);">sem juros</span>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-content">
                        <h3 class="card-title">Calcular Frete</h3>
                        <form onsubmit="calcularFrete(event)">
                            <div class="flex gap-2">
                                <input type="text" 
                                       class="form-input" 
                                       placeholder="00000-000" 
                                       id="cep"
                                       maxlength="9"
                                       required>
                                <button type="submit" class="btn btn-outlined">Calcular</button>
                            </div>
                        </form>
                        <div id="freteResultado" class="mt-2"></div>
                    </div>
                </div>

                <form action="carrinho_acoes.php" method="POST">
                    <input type="hidden" name="acao" value="adicionar">
                    <input type="hidden" name="id_produto" value="<?php echo $produto['id']; ?>">
                    
                    <div class="form-group">
                        <label class="form-label">Quantidade:</label>
                        <input type="number" 
                               name="quantidade" 
                               class="form-input" 
                               value="1" 
                               min="1" 
                               max="<?php echo $produto['estoque']; ?>"
                               style="width: 100px;">
                        <span class="text-small text-secondary">
                            (<?php echo $produto['estoque']; ?> disponíveis)
                        </span>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block" style="padding: 16px;">
                        Adicionar ao Carrinho
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function changeImage(src) {
            document.getElementById('mainImage').src = src;
        }

        function calcularFrete(e) {
            e.preventDefault();
            const cep = document.getElementById('cep').value;
            const resultado = document.getElementById('freteResultado');
            
            // Simulação de cálculo de frete
            resultado.innerHTML = `
                <div class="alert alert-success">
                    <strong>Frete calculado para CEP ${cep}</strong><br>
                    📦 PAC: R$ 15,00 - Entrega em 7 a 10 dias<br>
                    🚀 SEDEX: R$ 25,00 - Entrega em 3 a 5 dias
                </div>
            `;
        }

        // Máscara para CEP
        document.getElementById('cep').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 5) {
                value = value.substring(0, 5) + '-' + value.substring(5, 8);
            }
            e.target.value = value;
        });
    </script>

</body>
</html>