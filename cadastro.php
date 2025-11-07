<?php
require 'header.php';

$mensagem = '';
$tipo_mensagem = '';
$form_data = ['nome' => '', 'email' => '', 'telefone' => ''];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = trim(htmlspecialchars($_POST['nome']));
    $email = trim(htmlspecialchars($_POST['email']));
    $senha = $_POST['senha'];
    $confirma_senha = $_POST['confirma_senha'];
    $telefone = trim(htmlspecialchars($_POST['telefone']));

    // Salva dados do formulário
    $form_data = ['nome' => $nome, 'email' => $email, 'telefone' => $telefone];

    if (empty($nome) || empty($email) || empty($senha)) {
        $mensagem = 'Por favor, preencha todos os campos obrigatórios.';
        $tipo_mensagem = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagem = 'Por favor, digite um email válido.';
        $tipo_mensagem = 'error';
    } elseif ($senha !== $confirma_senha) {
        $mensagem = 'As senhas não coincidem. Digite a mesma senha nos dois campos.';
        $tipo_mensagem = 'error';
    } elseif (strlen($senha) < 6) {
        $mensagem = 'A senha deve ter no mínimo 6 caracteres.';
        $tipo_mensagem = 'error';
    } else {
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->fetch()) {
            $mensagem = 'Este email já está cadastrado. Tente fazer login.';
            $tipo_mensagem = 'error';
        } else {
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
            
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, telefone) VALUES (?, ?, ?, ?)");
            
            if ($stmt->execute([$nome, $email, $senha_hash, $telefone])) {
                $mensagem = 'Cadastro realizado com sucesso! Redirecionando...';
                $tipo_mensagem = 'success';
                
                // Faz login automaticamente
                $_SESSION['usuario_id'] = $pdo->lastInsertId();
                $_SESSION['usuario_nome'] = $nome;
                $_SESSION['usuario_email'] = $email;
                
                echo '<script>setTimeout(function(){ window.location.href = "index.php"; }, 2000);</script>';
            } else {
                $mensagem = 'Erro ao cadastrar. Tente novamente.';
                $tipo_mensagem = 'error';
            }
        }
    }
}
?>

<div class="container">
    <div class="page-header">
        <h1>Criar sua Conta 🚀</h1>
        <p>Cadastre-se gratuitamente e aproveite nossas ofertas</p>
    </div>

    <div class="form-container">
        <?php if ($mensagem): ?>
            <div class="alert alert-<?php echo $tipo_mensagem; ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <?php if ($tipo_mensagem == 'success'): ?>
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    <?php else: ?>
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="15" y1="9" x2="9" y2="15"/>
                        <line x1="9" y1="9" x2="15" y2="15"/>
                    <?php endif; ?>
                </svg>
                <div><?php echo $mensagem; ?></div>
            </div>
        <?php endif; ?>

        <form method="POST" action="" class="form-cadastro">
            <div class="form-group">
                <label class="form-label">👤 Nome Completo *</label>
                <input type="text" 
                       name="nome" 
                       class="form-input" 
                       placeholder="João da Silva"
                       value="<?php echo htmlspecialchars($form_data['nome']); ?>"
                       required>
            </div>

            <div class="form-group">
                <label class="form-label">📧 Email *</label>
                <input type="email" 
                       name="email" 
                       class="form-input" 
                       placeholder="seu@email.com"
                       value="<?php echo htmlspecialchars($form_data['email']); ?>"
                       required>
                <small style="color: var(--text-secondary); font-size: 13px;">
                    Usaremos este email para login
                </small>
            </div>

            <div class="form-group">
                <label class="form-label">📱 Telefone</label>
                <input type="tel" 
                       name="telefone" 
                       class="form-input" 
                       placeholder="(11) 99999-9999"
                       value="<?php echo htmlspecialchars($form_data['telefone']); ?>">
            </div>

            <div class="form-group">
                <label class="form-label">🔒 Senha * (mínimo 6 caracteres)</label>
                <input type="password" 
                       name="senha" 
                       class="form-input" 
                       placeholder="Digite uma senha forte"
                       minlength="6"
                       required>
            </div>

            <div class="form-group">
                <label class="form-label">🔒 Confirmar Senha *</label>
                <input type="password" 
                       name="confirma_senha" 
                       class="form-input" 
                       placeholder="Digite a senha novamente"
                       minlength="6"
                       required>
            </div>

            <button type="submit" class="btn btn-success btn-block">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="8.5" cy="7" r="4"/>
                    <line x1="20" y1="8" x2="20" y2="14"/>
                    <line x1="23" y1="11" x2="17" y2="11"/>
                </svg>
                Criar Minha Conta
            </button>

            <div style="text-align: center; margin-top: 24px; padding-top: 24px; border-top: 1px solid var(--divider);">
                <p style="color: var(--text-secondary); margin-bottom: 12px;">
                    Já tem uma conta?
                </p>
                <a href="login.php" class="btn btn-outlined btn-block">
                    Fazer Login
                </a>
            </div>
        </form>

        <div style="margin-top: 24px; padding: 16px; background: var(--background); border-radius: 8px; font-size: 13px; color: var(--text-secondary); text-align: center;">
            Ao criar uma conta, você concorda com nossos 
            <a href="#" style="color: var(--primary);">Termos de Uso</a> e 
            <a href="#" style="color: var(--primary);">Política de Privacidade</a>
        </div>
    </div>
</div>

<?php require 'footer.php'; ?>