<?php
// Inclui o arquivo de cabeçalho, que geralmente contém o início do HTML, metatags, links de CSS e o menu de navegação.
require 'header.php';

// Obtém o termo de busca da URL (via método GET). A função trim() remove espaços em branco no início e no fim.
// Se o parâmetro 'busca' não existir, a variável $termo_busca fica vazia.
$termo_busca = isset($_GET['busca']) ? trim($_GET['busca']) : '';
// Inicializa um array vazio para armazenar os produtos encontrados na busca.
$produtos = [];

// Verifica se um termo de busca foi fornecido. O código dentro deste 'if' só executa se o usuário digitou algo para buscar.
if (!empty($termo_busca)) {
    // Prepara o termo de busca para uma consulta SQL com 'LIKE', adicionando '%' antes e depois.
    // Isso permite encontrar resultados que contenham o termo em qualquer parte do texto.
    $busca = "%{$termo_busca}%";
    // Prepara uma consulta SQL para buscar produtos no banco de dados.
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE (nome LIKE ? OR descricao LIKE ?) AND estoque > 0 ORDER BY nome ASC");
    // Executa a consulta, passando o termo de busca para os dois placeholders (?) na query (um para 'nome' e outro para 'descricao').
    $stmt->execute([$busca, $busca]);
    // Armazena todos os resultados encontrados em forma de um array associativo na variável $produtos.
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="container">
    
    <div class="breadcrumb">
        <!-- Navegação 'breadcrumb' para indicar a localização do usuário no site -->
        <a href="index.php">Início</a>
        <span>→</span>
        <span>Busca</span>
    </div>

    <?php if (empty($termo_busca)): ?>
        <!-- Se nenhum termo de busca foi inserido, exibe uma mensagem para o usuário fazer uma busca. -->
        
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
        <!-- Se a busca retornou um ou mais produtos, exibe os resultados. -->
        
        <div class="page-header" style="text-align: left;">
            <!-- Exibe o termo que foi buscado e a quantidade de produtos encontrados. -->
            <h1>Resultados para "<?php echo htmlspecialchars($termo_busca); ?>"</h1>
            <p><?php echo count($produtos); ?> produto(s) encontrado(s)</p>
        </div>

        <div class="grid grid-3">
            <!-- Itera sobre o array de produtos e exibe um card para cada um. -->
            <?php foreach ($produtos as $produto): ?>
                <div class="produto-card">
                    <!-- Exibe a imagem do produto. 'htmlspecialchars' previne ataques XSS. -->
                    <img src="uploads/<?php echo htmlspecialchars($produto['imagem_url']); ?>" 
                         alt="<?php echo htmlspecialchars($produto['nome']); ?>"
                         class="produto-image">
                    
                    <div class="produto-info">
                        <h3 class="produto-nome"><?php echo htmlspecialchars($produto['nome']); ?></h3>
                        <p class="produto-preco">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                        <!-- Formata o preço para o padrão brasileiro. -->

                        <div class="flex gap-1">
                            <!-- Link para a página de detalhes do produto. -->
                            <a href="produto.php?id=<?php echo $produto['id']; ?>" 
                               class="btn btn-outlined" 
                               style="flex: 1;">
                                Ver Detalhes
                            </a>
                            
                            <!-- Formulário para adicionar o produto ao carrinho. -->
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
        <!-- Se a busca foi feita mas nenhum produto foi encontrado, exibe uma mensagem de "nenhum resultado". -->
        
        <div class="card" style="padding: 80px 40px; text-align: center;">
            <div style="font-size: 80px; margin-bottom: 24px;">🔍</div>
            <h2 style="margin-bottom: 16px;">Nenhum resultado encontrado</h2>
            <p style="color: var(--text-secondary); margin-bottom: 32px; max-width: 500px; margin-left: auto; margin-right: auto;">
                Não encontramos produtos com "<strong><?php echo htmlspecialchars($termo_busca); ?></strong>". 
                Tente buscar com outras palavras ou navegue por nosso catálogo completo.
            </p>
            <div style="display: flex; gap: 16px; justify-content: center;">
                <!-- Botão para voltar à página inicial e ver todos os produtos. -->
                <a href="index.php" class="btn btn-primary">
                    Ver Todos os Produtos
                </a>
                <!-- Botão que, ao ser clicado, coloca o foco no campo de busca no cabeçalho. -->
                <button onclick="document.querySelector('.search-input').focus()" class="btn btn-outlined">
                    Fazer Nova Busca
                </button>
            </div>
        </div>

    <?php endif; ?>

</div>

<?php
// Inclui o arquivo de rodapé, que geralmente contém o fechamento da tag <body> e <html>, e scripts JS.
require 'footer.php'; ?>