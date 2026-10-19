
<?php
// Mostrar erros durante o desenvolvimento
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Credenciais do banco
require_once 'conexao.php';

// Só executar o cadastro quando o formulário for enviado
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    // Não executar o código de cadastro
} else {

// Verificar conexão
if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}

// Configurar tratamento de erros SQL
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Função para mostrar alertas na página principal
function alerta($mensagem) {
    echo "<script>
        window.top.alert(" . json_encode($mensagem) . ");
    </script>";
    exit;
}

// Receber os dados do formulário
$Nome = trim($_POST["Nome"] ?? "");
$Email = trim($_POST["Email"] ?? "");
$Senha = $_POST["Senha"] ?? "";
$Numero_Matricula = trim($_POST["Numero_Matricula"] ?? "");

// Verificar campos vazios
if (
    $Nome === "" ||
    $Email === "" ||
    $Senha === "" ||
    $Numero_Matricula === ""
) {
    alerta("Preencha todos os campos!");
}

// Criptografar a senha
$senhaHash = password_hash($Senha, PASSWORD_DEFAULT);

// Definir perfil padrão
$perfil = "TEC";

try {
    // Preparar comando SQL
    $sql = "INSERT INTO Usuario
            (matricula, nome, email, hash_senha, perfil)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    // Vincular os valores
    $stmt->bind_param(
        "sssss",
        $Numero_Matricula,
        $Nome,
        $Email,
        $senhaHash,
        $perfil
    );

    // Executar cadastro
    $stmt->execute();

    $stmt->close();
    $conn->close();

    // Avisar e redirecionar a página principal
    echo "<script>
        window.top.alert('Cadastro realizado com sucesso!');
        window.top.location.href = '/FISICA/mapa.php';
    </script>";
    exit;

} catch (mysqli_sql_exception $e) {

    // Registrar o erro para consulta no log do PHP
    error_log("Erro no cadastro: " . $e->getMessage());

    if ($e->getCode() == 1062) {
        alerta("Essa matrícula ou e-mail já está cadastrado!");
    }

 
    alerta("Não foi possível realizar o cadastro. Verifique os dados.");

    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div>
        <form action="cadastro.php" method="POST" target="resposta">

            <input
                type="text"
                name="Nome"
                placeholder="Digite seu nome"
                required
            >

            <input
                type="email"
                name="Email"
                placeholder="Digite seu email"
                required
            >

            <input
                type="password"
                name="Senha"
                placeholder="Digite sua senha"
                required
            >

            <input
                type="text"
                name="Numero_Matricula"
                id="Numero_Matricula"
                placeholder="Digite seu número de matrícula"
                required
            >

            <button type="submit">Cadastrar</button>
        </form>

        <iframe
            name="resposta"
            style="display:none;"
            title="Resposta do cadastro"
        ></iframe>

        <p>
            Já tem uma conta?
            <a href="login.php">Faça login</a>
        </p>
    </div>
</body>
</html>