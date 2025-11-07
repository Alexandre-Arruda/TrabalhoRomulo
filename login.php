<?php
require 'header.php';

// Redireciona se já estiver logado
if (isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

$mensagem = '';
$tipo_mensagem = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    if (empty($email) || empty($senha)) {
        $mensagem = 'Por favor, preencha todos os campos.';
        $tipo_mensagem = 'error';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_email'] = $usuario['email'];
            
            header('Location: index.php');
            exit;
        } else {
            $mensagem = 'Email ou senha incorretos.';
            $tipo_mensagem = 'error';
        }
    }
}
?>

<div class="container">
    <div class="page-header">
        <h1>Bem-vindo de volta! 👋</h1>
        <p>Entre com sua conta para continuar comprando</p>
    </div>

    <div class="form-container">
        <?php if ($mensagem): ?>
            <div class="alert alert-<?php echo $tipo_mensagem; ?>">
                <?php echo $mensagem; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" class="form-login">
            <div class="form-group">
                <label class="form-label">📧 Email</label>
                <input type="email" 
                       name="email" 
                       class="form-input" 
                       placeholder="seu@email.com"
                       value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>"
                       required 
                       autofocus>
            </div>

            <div class="form-group">
                <label class="form-label">🔒 Senha</label>
                <input type="password" 
                       name="senha" 
                       class="form-input" 
                       placeholder="Digite sua senha"
                       required>
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3"/>
                </svg>
                Entrar
            </button>

            <div style="text-align: center; margin-top: 24px; padding-top: 24px; border-top: 1px solid var(--divider);">
                <p style="color: var(--text-secondary); margin-bottom: 12px;">
                    Ainda não tem uma conta?
                </p>
                <a href="cadastro.php" class="btn btn-outlined btn-block">
                    Criar Nova Conta
                </a>
            </div>
        </form>

        <!-- DICA PARA TESTE -->
        <div class="alert alert-info" style="margin-top: 24px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="16" x2="12" y2="12"/>
                <line x1="12" y1="8" x2="12.01" y2="8"/>
            </svg>
            <div>
                <strong>Para testar o sistema:</strong><br>
                Email: teste@email.com<br>
                Senha: 123456
            </div>
        </div>
    </div>
</div>

<?php require 'footer.php'; ?>