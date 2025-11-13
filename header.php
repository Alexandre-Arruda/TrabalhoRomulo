<?php
// ============================================
// HEADER.PHP - CABEÇALHO DO SITE
// ============================================
// Este arquivo é incluído no topo de TODAS as páginas
// Ele contém: sessão, conexão BD, cabeçalho HTML e menu de navegação



// CONECTA AO BANCO DE DADOS
// O arquivo db_conexao.php cria a variável $pdo que usamos para consultas SQL
require_once 'db_conexao.php';

// ============================================
// CONTA QUANTOS ITENS TEM NO CARRINHO
// ============================================
// Começamos com zero
$total_itens = 0;

// Verifica se existe carrinho na sessão E se é um array válido
if (isset($_SESSION['carrinho']) && is_array($_SESSION['carrinho'])) {
    
    // Loop: percorre cada item do carrinho
    foreach ($_SESSION['carrinho'] as $item) {
        // Soma a quantidade de cada item ao total
        $total_itens += $item['quantidade'];
    }
}

// ============================================
// VERIFICA SE O USUÁRIO ESTÁ LOGADO
// ============================================
// Se existe 'usuario_id' na sessão, o usuário fez login
$usuario_logado = isset($_SESSION['usuario_id']);

// Pega o nome do usuário (se estiver logado) ou deixa vazio
$nome_usuario = $usuario_logado ? $_SESSION['usuario_nome'] : '';

// Pega apenas o PRIMEIRO NOME do usuário
// Exemplo: "João da Silva" vira apenas "João"
if ($nome_usuario) {
    // explode: divide o texto nos espaços
    $nome_partes = explode(' ', $nome_usuario);
    // Pega a primeira parte [0]
    $primeiro_nome = $nome_partes[0];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <!-- viewport: faz o site funcionar bem em celulares -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Store - Loja de Periféricos Gamer</title>
    
    <!-- INCLUI O ARQUIVO CSS -->
    <link rel="stylesheet" href="css/material.css">
    
    <!-- FONTE DO GOOGLE: Roboto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>

    <!-- ============================================ -->
    <!-- CABEÇALHO DO SITE (HEADER) -->
    <!-- ============================================ -->
    <header class="header">
        <div class="header-content">
            
            <!-- ============================================ -->
            <!-- LOGO DA LOJA -->
            <!-- ============================================ -->
            <a href="index.php" class="logo">
                <!-- Emoji do ícone -->

                <!-- Nome da loja -->
                <span class="logo-text">Tech Store</span>
            </a>

            <!-- ============================================ -->
            <!-- BARRA DE PESQUISA -->
            <!-- ============================================ -->
            <!-- Formulário que envia para pesquisa.php -->
            <!-- method="GET": dados vão pela URL (ex: pesquisa.php?busca=mouse) -->
            <form action="pesquisa.php" method="GET" class="search-form">
                <div class="search-wrapper">
                    
                    <!-- CAMPO DE TEXTO PARA DIGITAR A BUSCA -->
                    <!-- name="busca": o texto digitado será enviado como $_GET['busca'] -->
                    <input type="text" 
                           name="busca" 
                           placeholder="Buscar produtos..." 
                           class="search-input"
                           value="<?php echo isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : ''; ?>">
                    
                    <!-- BOTÃO DE BUSCAR (com ícone SVG de lupa) -->
                    <button type="submit" class="search-button">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M9 17A8 8 0 1 0 9 1a8 8 0 0 0 0 16zM19 19l-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>
            </form>

            <!-- ============================================ -->
            <!-- MENU DE NAVEGAÇÃO -->
            <!-- ============================================ -->
            <nav class="nav-links">
                
                <!-- LINK PARA A PÁGINA INICIAL -->
                <a href="index.php" class="nav-link">
                    <!-- Ícone SVG de casa -->
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" stroke="currentColor" stroke-width="2"/>
                        <path d="M9 22V12h6v10" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    Início
                </a>

                <!-- LINK PARA O CARRINHO -->
                <a href="carrinho.php" class="nav-link cart-link">
                    <!-- Ícone SVG de carrinho de compras -->
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <circle cx="8" cy="18" r="2" stroke="currentColor" stroke-width="2"/>
                        <circle cx="16" cy="18" r="2" stroke="currentColor" stroke-width="2"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    Carrinho
                    
                    <!-- SE tiver itens no carrinho, mostra um badge com o número -->
                    <?php if ($total_itens > 0): ?>
                        <span class="cart-badge"><?php echo $total_itens; ?></span>
                    <?php endif; ?>
                </a>

                <!-- ============================================ -->
                <!-- MENU DO USUÁRIO (muda se está logado ou não) -->
                <!-- ============================================ -->
                <?php if ($usuario_logado): ?>
                    <!-- ======================================== -->
                    <!-- USUÁRIO ESTÁ LOGADO -->
                    <!-- ======================================== -->
                    <div class="user-menu">
                        
                        <!-- BOTÃO COM FOTO/INICIAL DO USUÁRIO -->
                        <!-- onclick: chama função JavaScript ao clicar -->
                        <button class="user-button" onclick="toggleUserMenu()">
                            
                            <!-- AVATAR: círculo com primeira letra do nome -->
                            <!-- strtoupper: transforma em maiúscula -->
                            <!-- substr(..., 0, 1): pega primeira letra -->
                            <div class="user-avatar">
                                <?php echo strtoupper(substr($primeiro_nome, 0, 1)); ?>
                            </div>
                            
                            <!-- NOME DO USUÁRIO -->
                            <span class="user-name">
                                <?php echo htmlspecialchars($primeiro_nome); ?>
                            </span>
                            
                            <!-- SETA PARA BAIXO (indicando menu dropdown) -->
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                <path d="M3 4.5L6 7.5L9 4.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </button>
                        
                        <!-- MENU DROPDOWN (aparece ao clicar no botão) -->
                        <!-- A classe 'show' é adicionada/removida via JavaScript -->
                        <div class="user-dropdown" id="userDropdown">
                            
                            <!-- CABEÇALHO DO MENU: informações do usuário -->
                            <div class="user-dropdown-header">
                                <!-- Nome completo -->
                                <div class="user-dropdown-name">
                                    <?php echo htmlspecialchars($nome_usuario); ?>
                                </div>
                                <!-- Email -->
                                <div class="user-dropdown-email">
                                    <?php echo htmlspecialchars($_SESSION['usuario_email']); ?>
                                </div>
                            </div>
                            
                            <!-- LINHA DIVISÓRIA -->
                            <div class="user-dropdown-divider"></div>
                            
                            <!-- LINK PARA FAZER LOGOUT (SAIR) -->
                            <a href="logout.php" class="user-dropdown-item">
                                <!-- Ícone SVG de sair -->
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M6 14H3a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h3M11 11l3-3-3-3M14 8H6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                                Sair
                            </a>
                        </div>
                    </div>
                    
                <?php else: ?>
                    <!-- ======================================== -->
                    <!-- USUÁRIO NÃO ESTÁ LOGADO -->
                    <!-- ======================================== -->
                    
                    <!-- BOTÃO PARA FAZER LOGIN -->
                    <a href="login.php" class="btn-login">
                        <!-- Ícone SVG de pessoa -->
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <path d="M14 14v-1a3 3 0 0 0-3-3H5a3 3 0 0 0-3 3v1M8 7a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        Entrar
                    </a>
                    
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <!-- ============================================ -->
    <!-- JAVASCRIPT PARA O MENU DO USUÁRIO -->
    <!-- ============================================ -->
    <script>
        // FUNÇÃO: Abre/fecha o menu dropdown do usuário
        function toggleUserMenu() {
            // Pega o elemento do menu
            const dropdown = document.getElementById('userDropdown');
            // toggle: adiciona a classe 'show' se não tiver, remove se tiver
            dropdown.classList.toggle('show');
        }

        // FECHA O MENU se clicar FORA dele
        window.addEventListener('click', function(e) {
            // Verifica se o clique NÃO foi dentro do .user-menu
            if (!e.target.closest('.user-menu')) {
                const dropdown = document.getElementById('userDropdown');
                if (dropdown) {
                    // Remove a classe 'show' (fecha o menu)
                    dropdown.classList.remove('show');
                }
            }
        });
    </script>
    
    <!-- DAQUI PARA BAIXO VEM O CONTEÚDO DE CADA PÁGINA -->