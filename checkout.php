<?php
// Inclui o arquivo de conexão com o banco de dados para poder realizar consultas.
require 'db_conexao.php';

// Redireciona o usuário para a página inicial caso o carrinho esteja vazio.
if (empty($_SESSION['carrinho'])) {
    header('Location: index.php');
    exit;
}

// Inicializa as variáveis para armazenar o total do carrinho e a quantidade de itens.
$total_carrinho = 0;
$total_itens = 0;
// Percorre cada item no carrinho para calcular o total.
foreach ($_SESSION['carrinho'] as $item) {
    // Calcula o subtotal de cada item (preço * quantidade) e adiciona ao total do carrinho.
    $total_carrinho += $item['preco'] * $item['quantidade'];
    // Adiciona a quantidade de cada item ao total de itens no carrinho.
    $total_itens += $item['quantidade'];
}

// Processa o pedido quando o formulário é enviado.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['finalizar'])) {
    // *** Aqui você salvaria os dados do pedido no banco de dados ***
    //
    // 1. Coletar os dados do formulário (nome, email, endereço, etc.)
    // 2. Inserir os dados na tabela de pedidos
    // 3. Para cada item no carrinho, inserir na tabela de itens do pedido
    // 4. Limpar o carrinho após o pedido ser finalizado
    //
    // Por enquanto, o código apenas simula a finalização do pedido,
    // definindo variáveis de sessão e redirecionando para a página de confirmação.
    
    // Define a variável de sessão para indicar que o pedido foi finalizado.
    $_SESSION['pedido_finalizado'] = true;
    // Gera um número de pedido aleatório (simulação).
    $_SESSION['numero_pedido'] = rand(10000, 99999);
    // Limpa o carrinho removendo todos os itens.
    $_SESSION['carrinho'] = [];
    
    header('Location: pedido_confirmado.php');
    exit;
}
?>
<!DOCTYPE html>

<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Tech Store</title>
    <link rel="stylesheet" href="css/material.css">
</head>
<body>


    <header class="header">
        <div class="header-content">
            <a href="index.php" class="logo"> Tech Store</a>
            <nav class="nav-links">
                <a href="index.php">Catálogo</a>
                <a href="carrinho.php">Carrinho</a>
            </nav>
        </div>
    </header>


    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">Catálogo</a>
            <span>/</span>
            <a href="carrinho.php">Carrinho</a>
            <span>/</span>
            <span>Checkout</span>
        </div>

        <!-- Título da página -->
        <h1 class="mb-3">Finalizar Compra</h1>

        <!-- Formulário para finalizar a compra -->
        <form method="POST" action="">
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
                
                <div> <!-- Coluna da esquerda: formulários de dados pessoais, endereço e pagamento -->
                    
                    <!-- DADOS PESSOAIS -->
                    <div class="card mb-3">
                        <div class="card-content">
                            <h2 class="card-title">1. Dados Pessoais</h2>
                            
                            <div class="form-group">
                                <!-- Campo para o nome completo -->
                                <label class="form-label">Nome Completo *</label>
                                <input type="text" name="nome" class="form-input" required>
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                                <!-- Container para os campos de email e telefone -->
                                <div class="form-group">
                                    <label class="form-label">Email *</label>
                                    <input type="email" name="email" class="form-input" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Telefone *</label>
                                    <input type="tel" name="telefone" class="form-input" required>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="form-label">CPF *</label>
                                <input type="text" name="cpf" class="form-input" maxlength="14" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENDEREÇO -->

                    <div class="card mb-3">
                        <div class="card-content">
                            <h2 class="card-title">2. Endereço de Entrega</h2>
                            
                            <div class="form-group">
                                <!-- Campo para o CEP -->
                                <label class="form-label">CEP *</label>
                                <input type="text" name="cep" class="form-input" maxlength="9" required 
                                       onblur="buscarCEP(this.value)">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Rua *</label>
                                <input type="text" name="rua" id="rua" class="form-input" required>
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 16px;">
                                <!-- Container para os campos de número e complemento -->
                                <div class="form-group">
                                    <label class="form-label">Número *</label>
                                    <input type="text" name="numero" class="form-input" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Complemento</label>
                                    <input type="text" name="complemento" class="form-input">
                                </div>
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px;">
                                <!-- Container para os campos de bairro, cidade e estado -->
                                <div class="form-group">
                                    <label class="form-label">Bairro *</label>
                                    <input type="text" name="bairro" id="bairro" class="form-input" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Cidade *</label>
                                    <input type="text" name="cidade" id="cidade" class="form-input" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Estado *</label>
                                    <input type="text" name="estado" id="estado" class="form-input" maxlength="2" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PAGAMENTO -->

                    <div class="card mb-3">
                        <div class="card-content">
                            <h2 class="card-title">3. Forma de Pagamento</h2>
                            
                            <div class="form-group">
                                <!-- Seletor para o método de pagamento -->
                                <label class="form-label">Método de Pagamento *</label>
                                <select name="metodo_pagamento" class="form-select" onchange="mostrarPagamento(this.value)" required>
                                    <option value="">Selecione...</option>
                                    <option value="cartao">Cartão de Crédito</option>
                                    <option value="pix">PIX</option>
                                    <option value="boleto">Boleto Bancário</option>
                                </select>
                            </div>

                            <!-- CARTÃO -->

                            <div id="pagamento-cartao" style="display: none;">
                                <div class="form-group">
                                    <label class="form-label">Número do Cartão</label>
                                    <input type="text" name="numero_cartao" class="form-input" maxlength="19">
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Nome no Cartão</label>
                                    <input type="text" name="nome_cartao" class="form-input">
                                </div>

                                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px;">
                                    <!-- Container para os campos de validade, CVV e parcelas -->
                                    <div class="form-group">
                                        <label class="form-label">Validade</label>
                                        <input type="text" name="validade" class="form-input" placeholder="MM/AA" maxlength="5">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">CVV</label>
                                        <input type="text" name="cvv" class="form-input" maxlength="3">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Parcelas</label>
                                        <select name="parcelas" class="form-select">
                                            <option value="1">1x sem juros</option>
                                            <option value="2">2x sem juros</option>
                                            <option value="3">3x sem juros</option>
                                            <option value="6">6x sem juros</option>
                                            <option value="12">12x com juros</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- PIX -->

                            <div id="pagamento-pix" style="display: none;">
                                <div class="alert alert-success">
                                    Após confirmar o pedido, você receberá o código PIX para pagamento.
                                    O prazo para pagamento é de 30 minutos.
                                </div>
                            </div>

                            <!-- BOLETO -->

                            <div id="pagamento-boleto" style="display: none;">
                                <div class="alert alert-warning">
                                    O boleto será gerado após a confirmação do pedido.
                                    Prazo de pagamento: 3 dias úteis.
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div> <!-- Coluna da direita: resumo do pedido -->
                    
                    <div class="card" style="position: sticky; top: 80px;">
                        <div class="card-content">
                            <h2 class="card-title">Resumo do Pedido</h2>
                            
                            <div class="mb-3">
                                <!-- Loop para exibir os itens do carrinho no resumo -->
                                <?php foreach ($_SESSION['carrinho'] as $item): ?>
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
                            </div>

                            <hr style="margin: 16px 0; border: 0; border-top: 1px solid var(--divider);">


                            <div class="flex-between mb-1">
                                <span class="text-secondary">Subtotal:</span>
                                <span>R$ <?php echo number_format($total_carrinho, 2, ',', '.'); ?></span>
                            </div>

                            <div class="flex-between mb-1">

                                <span class="text-secondary">Frete:</span>
                                <span>R$ 15,00</span>
                            </div>

                            <hr style="margin: 16px 0; border: 0; border-top: 1px solid var(--divider);">

                            <div class="flex-between mb-3">

                                <strong style="font-size: 18px;">Total:</strong>
                                <strong style="font-size: 24px; color: var(--primary);">
                                    R$ <?php echo number_format($total_carrinho + 15, 2, ',', '.'); ?>
                                </strong>
                            </div>

                            <button type="submit" name="finalizar" class="btn btn-success btn-block" style="padding: 16px;">
                                Confirmar Pedido

                            </button>

                            <a href="carrinho.php" class="btn btn-text btn-block mt-2">
                                ← Voltar ao Carrinho
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>


    <script>
        function mostrarPagamento(metodo) {
            document.getElementById('pagamento-cartao').style.display = 'none';
            document.getElementById('pagamento-pix').style.display = 'none';
            document.getElementById('pagamento-boleto').style.display = 'none';
            
            if (metodo === 'cartao') {
                document.getElementById('pagamento-cartao').style.display = 'block';
            } else if (metodo === 'pix') {
                document.getElementById('pagamento-pix').style.display = 'block';
            } else if (metodo === 'boleto') {
                document.getElementById('pagamento-boleto').style.display = 'block';
            }
        }


        async function buscarCEP(cep) {
            cep = cep.replace(/\D/g, '');
            if (cep.length !== 8) return;

            try {
                const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
                const data = await response.json();
                
                if (!data.erro) {
                    document.getElementById('rua').value = data.logradouro;
                    document.getElementById('bairro').value = data.bairro;
                    document.getElementById('cidade').value = data.localidade;
                    document.getElementById('estado').value = data.uf;
                }
            } catch (error) {
                console.error('Erro ao buscar CEP:', error);
            }
        }


        // Máscaras
        document.querySelector('input[name="cpf"]').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 11) value = value.substring(0, 11);
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            e.target.value = value;
        });


        document.querySelector('input[name="cep"]').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 8) value = value.substring(0, 8);
            if (value.length > 5) {
                value = value.substring(0, 5) + '-' + value.substring(5);
            }
            e.target.value = value;
        });


        document.querySelector('input[name="telefone"]').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 11) value = value.substring(0, 11);
            value = value.replace(/(\d{2})(\d)/, '($1) $2');
            value = value.replace(/(\d{5})(\d)/, '$1-$2');
            e.target.value = value;
        });


        const numeroCartao = document.querySelector('input[name="numero_cartao"]');
        if (numeroCartao) {
            numeroCartao.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 16) value = value.substring(0, 16);
                value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
                e.target.value = value;
            });
        }
    </script>


</body>
</html>