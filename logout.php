<?php
// Inicia a sessão apenas se não houver uma ativa.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Destrói todas as variáveis de sessão.
session_unset();

// Destrói a sessão.
session_destroy();

// Redireciona o usuário para a página inicial.
header('Location: index.php');
exit; // Garante que o script pare de executar após o redirecionamento.
?>