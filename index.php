<?php
// index.php
session_start(); // INICIA A SESSÃO. Essencial para o carrinho.
require 'db_conexao.php'; // Inclui a conexão com o BD

// Busca todos os produtos no banco
$stmt = $pdo->query("SELECT * FROM produtos WHERE estoque > 0 ORDER BY nome ASC");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja de Periféricos</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="container">
        <h1>Nosso Catálogo</h1>

        <div class="catalogo">
            <?php foreach ($produtos as $produto): ?>
                
                <div class="produto-card">
                    <img src="uploads/<?php echo htmlspecialchars($produto['imagem_url']); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>">
                    
                    <div class="produto-info">
                        <h3><?php echo htmlspecialchars($produto['nome']); ?></h3>
                        <p>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                        </div>

                    <form action="carrinho_acoes.php" method="POST">
                        <input type="hidden" name="acao" value="adicionar">
                        <input type="hidden" name="id_produto" value="<?php echo $produto['id']; ?>">
                        <label for="qtd-<?php echo $produto['id']; ?>">Qtd:</label>
                        <input type="number" id="qtd-<?php echo $produto['id']; ?>" name="quantidade" value="1" min="1">
                        <button type="submit">Adicionar ao Carrinho</button>
                    </form>
                </div>

            <?php endforeach; ?>
        </div>

        <hr>

        <div class="carrinho">
            <h2>Meu Carrinho</h2>
            
            <?php
            if (empty($_SESSION['carrinho']) || !is_array($_SESSION['carrinho'])):
                echo "<p>Seu carrinho está vazio.</p>";
            else:
                $total_carrinho = 0;
            ?>
                <ul>
                    <?php
                    foreach ($_SESSION['carrinho'] as $id_produto => $item):
                        // Calcula o subtotal e o total
                        $subtotal = $item['preco'] * $item['quantidade'];
                        $total_carrinho += $subtotal;
                    ?>
                        
                        <li>
                            <div class="carrinho-item-info">
                                <?php echo htmlspecialchars($item['nome']); ?>
                                <span>(R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?>)</span>
                            </div>
                            
                            <div class="carrinho-acoes">
                                
                                <form action="carrinho_acoes.php" method="POST" class="form-atualizar">
                                    <input type="hidden" name="acao" value="atualizar">
                                    <input type="hidden" name="id_produto" value="<?php echo $id_produto; ?>">
                                    <input type="number" name="quantidade" value="<?php echo $item['quantidade']; ?>" min="1">
                                    <button type="submit">Atualizar</button>
                                </form>

                                <form action="carrinho_acoes.php" method="POST" class="form-remover">
                                    <input type="hidden" name="acao" value="remover">
                                    <input type="hidden" name="id_produto" value="<?php echo $id_produto; ?>">
                                    <button type="submit">Remover</button>
                                </form>
                            </div>
                        </li>

                    <?php endforeach; ?>
                </ul>

                <h3>Total: R$ <?php echo number_format($total_carrinho, 2, ',', '.'); ?></h3>

            <?php endif; ?>
        </div> </div> </body>
</html>