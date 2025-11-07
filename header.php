<?php
// ============================================
// HEADER.PHP - CABEÇALHO PROFISSIONAL
// ============================================

// Inicia a sessão (necessário para login e carrinho)
session_start();

// Conecta ao banco de dados
require_once 'db_conexao.php';

// Conta itens no carrinho
$total_itens = 0;
if (isset($_SESSION['carrinho']) && is_array($_SESSION['carrinho'])) {
    foreach ($_SESSION['carrinho'] as $item) {
        $total_itens += $item['quantidade'];
    }
}

// Verifica se usuário está logado
$usuario_logado = isset($_SESSION['usuario_id']);
$nome_usuario = $usuario_logado ? $_SESSION['usuario_nome'] : '';

// Pega a primeira palavra do nome
if ($nome_usuario) {
    $nome_partes = explode(' ', $nome_usuario);
    $primeiro_nome = $nome_partes[0];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Store - Loja de Periféricos Gamer</title>
    <link rel="stylesheet" href="css/material.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>

    <!-- HEADER -->
    <header class="header">
        <div class="header-content">
            
            <!-- LOGO -->
            <a href="index.php" class="logo">
                <span class="logo-icon">🎮</span>
                <span class="logo-text">Tech Store</span>
            </a>

            <!-- BARRA DE PESQUISA -->
            <form action="pesquisa.php" method="GET" class="search-form">
                <div class="search-wrapper">
                    <input type="text" 
                           name="busca" 
                           placeholder="Buscar produtos..." 
                           class="search-input"
                           value="<?php echo isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : ''; ?>">
                    <button type="submit" class="search-button">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M9 17A8 8 0 1 0 9 1a8 8 0 0 0 0 16zM19 19l-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>
            </form>

            <!-- NAVEGAÇÃO -->
            <nav class="nav-links">
                <a href="index.php" class="nav-link">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" stroke="currentColor" stroke-width="2"/>
                        <path d="M9 22V12h6v10" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    Início
                </a>

                <a href="carrinho.php" class="nav-link cart-link">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <circle cx="8" cy="18" r="2" stroke="currentColor" stroke-width="2"/>
                        <circle cx="16" cy="18" r="2" stroke="currentColor" stroke-width="2"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    Carrinho
                    <?php if ($total_itens > 0): ?>
                        <span class="cart-badge"><?php echo $total_itens; ?></span>
                    <?php endif; ?>
                </a>

                <?php if ($usuario_logado): ?>
                    <!-- USUÁRIO LOGADO -->
                    <div class="user-menu">
                        <button class="user-button" onclick="toggleUserMenu()">
                            <div class="user-avatar"><?php echo strtoupper(substr($primeiro_nome, 0, 1)); ?></div>
                            <span class="user-name"><?php echo htmlspecialchars($primeiro_nome); ?></span>
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                <path d="M3 4.5L6 7.5L9 4.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </button>
                        <div class="user-dropdown" id="userDropdown">
                            <div class="user-dropdown-header">
                                <div class="user-dropdown-name"><?php echo htmlspecialchars($nome_usuario); ?></div>
                                <div class="user-dropdown-email"><?php echo htmlspecialchars($_SESSION['usuario_email']); ?></div>
                            </div>
                            <div class="user-dropdown-divider"></div>
                            <a href="logout.php" class="user-dropdown-item">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M6 14H3a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h3M11 11l3-3-3-3M14 8H6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                                Sair
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- USUÁRIO NÃO LOGADO -->
                    <a href="login.php" class="btn-login">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <path d="M14 14v-1a3 3 0 0 0-3-3H5a3 3 0 0 0-3 3v1M8 7a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        Entrar
                    </a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <script>
        // Toggle menu do usuário
        function toggleUserMenu() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');
        }

        // Fecha o menu ao clicar fora
        window.addEventListener('click', function(e) {
            if (!e.target.closest('.user-menu')) {
                const dropdown = document.getElementById('userDropdown');
                if (dropdown) {
                    dropdown.classList.remove('show');
                }
            }
        });
    </script>