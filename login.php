<?php
// ============================================
// LOGIN.PHP - PÁGINA DE LOGIN
// ============================================
// Esta página permite o usuário entrar no sistema

// INICIA A SESSÃO E CONEXÃO COM O BANCO
// session_start() precisa vir antes de qualquer HTML
require 'db_conexao.php';

// ============================================
// REDIRECIONA SE JÁ ESTIVER LOGADO
// ============================================
// Se o usuário já fez login, não precisa ver a página de login
if (isset($_SESSION['usuario_id'])) {
    // header: redireciona para a página inicial
    header('Location: index.php');
    // exit: para a execução do código (importante após redirect)
    exit;
}

// ============================================
// VARIÁVEIS PARA MENSAGENS
// ============================================
$mensagem = '';           // Texto da mensagem (sucesso ou erro)
$tipo_mensagem = '';      // Tipo: 'error' ou 'success'

// ============================================
// VERIFICA SE O FORMULÁRIO FOI ENVIADO
// ============================================
// $_SERVER['REQUEST_METHOD']: tipo de requisição (GET, POST, etc)
// Se for POST, significa que o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // ========================================
    // PEGA OS DADOS DO FORMULÁRIO
    // ========================================
    // $_POST: array com os dados enviados do formulário
    // trim: remove espaços no início e fim
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    // ========================================
    // VALIDAÇÃO BÁSICA
    // ========================================
    // empty: verifica se está vazio
    if (empty($email) || empty($senha)) {
        // Define mensagem de erro
        $mensagem = 'Por favor, preencha todos os campos.';
        $tipo_mensagem = 'error';
    }
    // Se os campos foram preenchidos...
    else {
        
        // ====================================
        // BUSCA O USUÁRIO NO BANCO DE DADOS
        // ====================================
        // prepare: prepara uma consulta SQL segura (previne SQL Injection)
        // ? é um placeholder que será substituído pelo email
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        
        // execute: executa a consulta, substituindo ? pelo email
        $stmt->execute([$email]);
        
        // fetch: pega UMA linha do resultado
        // FETCH_ASSOC: retorna como array associativo (podemos usar $usuario['nome'])
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // ====================================
        // VERIFICA SE ENCONTROU O USUÁRIO
        // ====================================
        if ($usuario) {
            // Usuario existe no banco
            
            // ================================
            // VERIFICA SE A SENHA ESTÁ CORRETA
            // ================================
            // password_verify: compara a senha digitada com a hash do banco
            // Retorna true se a senha estiver correta
            if (password_verify($senha, $usuario['senha'])) {
                
                // ============================
                // SENHA CORRETA! FAZER LOGIN
                // ============================
                
                // Guarda as informações do usuário na sessão
                // Essas informações ficarão disponíveis em todas as páginas
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                $_SESSION['usuario_email'] = $usuario['email'];
                
                // Redireciona para a página inicial
                header('Location: index.php');
                exit;
                
            } else {
                // SENHA INCORRETA
                $mensagem = 'Email ou senha incorretos.';
                $tipo_mensagem = 'error';
            }
            
        } else {
            // USUÁRIO NÃO ENCONTRADO
            // Por segurança, mostramos a mesma mensagem (não revelamos se o email existe)
            $mensagem = 'Email ou senha incorretos.';
            $tipo_mensagem = 'error';
        }
    }
}
?>
<?php
// ============================================
// AGORA QUE A LÓGICA TERMINOU, INCLUI O HTML
// ============================================
require 'header.php'; ?>

<!-- ============================================ -->
<!-- HTML DA PÁGINA -->
<!-- ============================================ -->

<div class="container">
    
    <!-- CABEÇALHO DA PÁGINA -->
    <div class="page-header">
        <h1>Bem-vindo de volta! 👋</h1>
        <p>Entre com sua conta para continuar comprando</p>
    </div>

    <!-- CONTAINER DO FORMULÁRIO -->
    <div class="form-container">
        
        <!-- ======================================== -->
        <!-- MENSAGEM DE ERRO/SUCESSO -->
        <!-- ======================================== -->
        <!-- Só aparece SE tiver mensagem -->
        <?php if ($mensagem): ?>
            <div class="alert alert-<?php echo $tipo_mensagem; ?>">
                <?php echo $mensagem; ?>
            </div>
        <?php endif; ?>

        <!-- ======================================== -->
        <!-- FORMULÁRIO DE LOGIN -->
        <!-- ======================================== -->
        <!-- method="POST": envia dados de forma segura (não aparece na URL) -->
        <!-- action="": envia para a mesma página (login.php) -->
        <form method="POST" action="" class="form-login">
            
            <!-- CAMPO: EMAIL -->
            <div class="form-group">
                <label class="form-label">📧 Email</label>
                <!-- type="email": valida se é um email válido -->
                <!-- required: campo obrigatório (não pode enviar vazio) -->
                <!-- autofocus: cursor começa neste campo -->
                <!-- value: mantém o valor digitado se houver erro -->
                <input type="email" 
                       name="email" 
                       class="form-input" 
                       placeholder="seu@email.com"
                       value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>"
                       required 
                       autofocus>
            </div>

            <!-- CAMPO: SENHA -->
            <div class="form-group">
                <label class="form-label">🔒 Senha</label>
                <!-- type="password": esconde os caracteres digitados -->
                <input type="password" 
                       name="senha" 
                       class="form-input" 
                       placeholder="Digite sua senha"
                       required>
            </div>

            <!-- BOTÃO DE SUBMIT -->
            <button type="submit" class="btn btn-primary btn-block">
                <!-- Ícone SVG de "entrar" -->
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3"/>
                </svg>
                Entrar
            </button>

            <!-- ======================================== -->
            <!-- LINK PARA CADASTRO -->
            <!-- ======================================== -->
            <!-- Para quem ainda não tem conta -->
            <div style="text-align: center; margin-top: 24px; padding-top: 24px; border-top: 1px solid var(--divider);">
                <p style="color: var(--text-secondary); margin-bottom: 12px;">
                    Ainda não tem uma conta?
                </p>
                <a href="cadastro.php" class="btn btn-outlined btn-block">
                    Criar Nova Conta
                </a>
            </div>
        </form>

    </div>
</div>

<?php
// INCLUI O RODAPÉ
require 'footer.php';
?>