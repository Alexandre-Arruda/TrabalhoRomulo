<?php
// ============================================
// DB_CONEXAO.PHP - CONEXÃO COM BANCO DE DADOS
// ============================================
// Este arquivo cria a conexão com o MySQL
// É incluído em TODAS as páginas que precisam do banco

// ============================================
// CONFIGURAÇÕES DO BANCO DE DADOS
// ============================================
// Essas variáveis guardam as informações de conexão

// HOST: onde o MySQL está rodando
// 'localhost' = no mesmo computador
$host = 'localhost';

// NOME DO BANCO: qual banco queremos usar
$db_name = 'loja_perifericos';

// USUÁRIO: nome do usuário do MySQL
// 'root' é o usuário padrão do XAMPP
$username = 'root';

// SENHA: senha do usuário
// Vazia ('') é a senha padrão do XAMPP
// EM PRODUÇÃO: sempre use uma senha forte!
$password = '';

// ============================================
// CRIA A CONEXÃO COM O BANCO
// ============================================
// Usamos try/catch para capturar erros

try {
    // ========================================
    // PDO: PHP Data Objects
    // ========================================
    // É a forma MODERNA e SEGURA de conectar ao banco
    // Previne SQL Injection automaticamente
    
    // PARÂMETROS:
    // 1. DSN (Data Source Name): string de conexão
    //    mysql:host=localhost;dbname=loja_perifericos;charset=utf8
    // 2. Usuário
    // 3. Senha
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db_name;charset=utf8", 
        $username, 
        $password
    );
    
    // ========================================
    // CONFIGURA O PDO
    // ========================================
    // setAttribute: define configurações do PDO
    
    // ERRMODE_EXCEPTION: faz o PDO lançar exceções em caso de erro
    // Isso nos permite capturar erros com try/catch
    // Se não configurar isso, erros podem passar despercebidos
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // ========================================
    // SUCESSO!
    // ========================================
    // Se chegou aqui, a conexão foi bem-sucedida
    // A variável $pdo está pronta para ser usada
    // Exemplo de uso:
    // $stmt = $pdo->prepare("SELECT * FROM produtos");
    // $stmt->execute();
    
} catch(PDOException $e) {
    // ========================================
    // ERRO NA CONEXÃO
    // ========================================
    // Se algo der errado, cai aqui
    
    // PDOException $e: objeto com informações do erro
    // $e->getMessage(): pega a mensagem de erro
    
    // die(): para a execução e exibe a mensagem
    // EM PRODUÇÃO: NÃO exiba detalhes do erro ao usuário!
    // Em vez disso, grave em log e mostre mensagem genérica
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
    
    // EXEMPLO PARA PRODUÇÃO:
    // error_log("Erro de conexão: " . $e->getMessage());
    // die("Erro no sistema. Tente novamente mais tarde.");
}

// ============================================
// AGORA O $pdo ESTÁ DISPONÍVEL
// ============================================
// Qualquer arquivo que incluir db_conexao.php
// terá acesso à variável $pdo

// EXEMPLOS DE USO:
/*

// 1. BUSCAR DADOS
$stmt = $pdo->query("SELECT * FROM produtos");
$produtos = $stmt->fetchAll();

// 2. BUSCAR COM SEGURANÇA (Prepared Statement)
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->execute([$email]);
$usuario = $stmt->fetch();

// 3. INSERIR DADOS
$stmt = $pdo->prepare("INSERT INTO usuarios (nome, email) VALUES (?, ?)");
$stmt->execute([$nome, $email]);

// 4. ATUALIZAR DADOS
$stmt = $pdo->prepare("UPDATE produtos SET preco = ? WHERE id = ?");
$stmt->execute([$novo_preco, $id]);

// 5. DELETAR DADOS
$stmt = $pdo->prepare("DELETE FROM produtos WHERE id = ?");
$stmt->execute([$id]);

*/

// ============================================
// NOTAS IMPORTANTES:
// ============================================
// 1. SEMPRE use Prepared Statements (prepare + execute)
//    NUNCA concatene variáveis diretamente no SQL
//    Isso previne SQL Injection!
//
// 2. O PDO fecha a conexão automaticamente
//    quando o script termina de executar
//
// 3. Uma conexão serve para múltiplas consultas
//    Não precisa criar várias conexões
//
// 4. charset=utf8 garante que caracteres especiais
//    (acentos, ç, etc) funcionem corretamente
?>