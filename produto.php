<?php
// Inclui o arquivo de conexão com o banco de dados, que disponibiliza a variável $pdo.
require 'db_conexao.php';

// Pega o ID do produto da URL (ex: produto.php?id=5).
// (int) converte o valor para um número inteiro por segurança, e o operador ternário define 0 se o ID não for passado.
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Prepara e executa uma consulta SQL para buscar o produto com o ID fornecido.
$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
// fetch() busca apenas um resultado e o armazena como um array associativo.
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

// Se o produto não for encontrado no banco de dados, redireciona o usuário para a página inicial.
if (!$produto) {
    header('Location: index.php');
    exit; // Encerra a execução do script para garantir que o redirecionamento ocorra.
}

// CONTA ITENS NO CARRINHO (similar ao que já é feito no header.php, mas pode ser útil se o header não for usado)
// Conta itens no carrinho
$total_itens = 0;
if (!empty($_SESSION['carrinho'])) {
    foreach ($_SESSION['carrinho'] as $item) {
        $total_itens += $item['quantidade'];
    }
}

// CALCULA AS OPÇÕES DE PARCELAMENTO
$preco = $produto['preco'];
$parcelamento = [];
// Loop de 1 a 12 para criar as parcelas.
for ($i = 1; $i <= 12; $i++) {
    $valor_parcela = $preco / $i;
    // Exemplo de regra de negócio: Adiciona juros a partir da 7ª parcela.
    if ($i > 6) {
        // Define a taxa de juros (ex: 2% ao mês).
        $juros = 0.02;
        // Fórmula de juros compostos para calcular o valor da parcela.
        $valor_parcela = $preco * pow(1 + $juros, $i) / $i;
    }
    $parcelamento[$i] = $valor_parcela;
}
?>
<?php require 'header.php'; ?>

    <div class="container">
        <!-- BREADCRUMB -->
        <div class="breadcrumb"> <!-- Navegação para mostrar o caminho até a página atual -->
            <a href="index.php">Catálogo</a>
            <span>/</span>
            <span><?php echo htmlspecialchars($produto['nome']); ?></span>
        </div>

        <!-- GRID PRINCIPAL -->
        <div class="produto-detail-grid">
            <!-- IMAGENS -->
            <div>
                <!-- Imagem principal do produto -->
                <img src="uploads/<?php echo htmlspecialchars($produto['imagem_url']); ?>" 
                     alt="<?php echo htmlspecialchars($produto['nome']); ?>"
                     class="produto-main-image"
                     id="mainImage">
                
                <!-- THUMBNAILS (miniaturas de imagem) -->
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
                <!-- Nome do produto -->
                <h1><?php echo htmlspecialchars($produto['nome']); ?></h1>
                
                <!-- Preço formatado para o padrão brasileiro -->
                <div class="preco-destaque">
                    R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                </div>

                <div class="card mb-3">
                    <div class="card-content">
                        <h3 class="card-title">Descrição</h3> <!-- Descrição do produto -->
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
                        <h3 class="card-title">Parcelamento</h3> <!-- Tabela de parcelas -->
                        <div style="max-height: 200px; overflow-y: auto;">
                            <!-- Loop para exibir cada opção de parcelamento calculada anteriormente -->
                            <?php foreach ($parcelamento as $parcelas => $valor): ?>
                                <div class="flex-between mb-1">
                                    <span><?php echo $parcelas; ?>x de</span>
                                    <strong>R$ <?php echo number_format($valor, 2, ',', '.'); ?></strong>
                                    <!-- Mostra se a parcela tem juros ou não -->
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
                        <h3 class="card-title">Calcular Frete</h3> <!-- Formulário de cálculo de frete -->
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
                        <!-- Div onde o resultado do frete será exibido pelo JavaScript -->
                        <div id="freteResultado" class="mt-2"></div>
                    </div>
                </div>

                <!-- Formulário para adicionar o produto ao carrinho -->
                <form action="carrinho_acoes.php" method="POST">
                    <input type="hidden" name="acao" value="adicionar">
                    <input type="hidden" name="id_produto" value="<?php echo $produto['id']; ?>"> <!-- ID do produto a ser adicionado -->
                    
                    <div class="form-group">
                        <label class="form-label">Quantidade:</label>
                        <input type="number" 
                               name="quantidade" 
                               class="form-input" 
                               value="1" 
                               min="1"  // Quantidade mínima é 1
                               // A quantidade máxima é o estoque disponível
                               max="<?php echo $produto['estoque']; ?>"
                               style="width: 100px;">
                        <span class="text-small text-secondary">
                            (<?php echo $produto['estoque']; ?> disponíveis)
                        </span>
                    </div> <!-- Campo para o usuário escolher a quantidade -->

                    <button type="submit" class="btn btn-primary btn-block" style="padding: 16px;">
                        Adicionar ao Carrinho
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Função para trocar a imagem principal quando uma miniatura é clicada.
        function changeImage(src) {
            document.getElementById('mainImage').src = src;
        }

        // Função para simular o cálculo de frete.
        function calcularFrete(e) {
            // Previne o comportamento padrão do formulário (que seria recarregar a página).
            e.preventDefault();
            const cep = document.getElementById('cep').value;
            const resultado = document.getElementById('freteResultado');
            
            // Simulação de uma resposta de API de frete.
            resultado.innerHTML = `
                <div class="alert alert-success">
                    <strong>Frete calculado para CEP ${cep}</strong><br>
                    📦 PAC: R$ 15,00 - Entrega em 7 a 10 dias<br>
                    🚀 SEDEX: R$ 25,00 - Entrega em 3 a 5 dias
                </div>
            `;
        }

        // Adiciona um listener ao campo de CEP para aplicar uma máscara (formato 00000-000).
        document.getElementById('cep').addEventListener('input', function(e) {
            // Remove tudo que não for dígito.
            let value = e.target.value.replace(/\D/g, '');
            // Adiciona o hífen após o quinto dígito.
            if (value.length > 5) {
                value = value.substring(0, 5) + '-' + value.substring(5, 8);
            }
            e.target.value = value;
        });
    </script>

</body>
</html>