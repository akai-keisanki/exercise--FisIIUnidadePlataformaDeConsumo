<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div>
        <form action="cadastro.php" method="POST" target="resposta">
            <input type="text" name="Nome" placeholder="Digite seu nome" required>
            <input type="email" name="Email" placeholder="Digite seu email" required>
            <input type="password" name="Senha" placeholder="Digite sua senha" required>
            <input type="text" name= "Numero_Matricula" id= "Numero_Matricula" placeholder= "Digite seu número de matrícula" required>
            
            <button type="submit">Cadastrar</button>
        </form>

        <iframe name="resposta" style="display:none;"></iframe>

        <p>Já tem uma conta?
            <a href="login.php">Faça login</a>
        </p>
    </div>
</body>
</html>

<?php
//credenciais
    $servidor = "localhost";
    $usuario = "root";
    $senha = "";
    $banco = "fisica_bd";

//Criando conexão
    $conn = mysqli_connect($servidor, $usuario, $senha, $banco);

//verificar conexão
    if(!$conn){
        die("Falha na conexão: " . mysqli_connect_error());
    }


    $Nome = $_POST["Nome"] ?? "";   
    $Email = $_POST["Email"] ?? "";
    $Senha = $_POST["Senha"] ?? "";
    $Numero_Matricula = $_POST["Numero_Matricula"] ?? "";


    function alerta($mensagem) {
    echo "<script>alert(" . json_encode($mensagem) . "); 
    window.history.back();</script>";
    exit;
    }

// Verificar se os campos foram enviados
    if (
    $Nome === ""      || 
    $Email === ""     || 
    $Senha === ""     || 
    $Numero_Matricula === "") {
    echo "<script>alert('Preencha todos os campos!');</script>";
    exit;
    }

// Criptografar a senha
$senhaHash = password_hash($Senha, PASSWORD_DEFAULT);

$perfil = "TEC";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try{ 
    // Preparar o comando SQL
$sql = "INSERT INTO Usuario
        (matricula, nome, email, hash_senha, perfil)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);


$stmt->bind_param(
    "sssss",
    $Numero_Matricula,
    $Nome,
    $Email,
    $senhaHash,
    $perfil
);

// Executar o cadastro
if ($stmt->execute()) {
    $stmt->close();
    $conn->close();

    echo "<script>
        alert('Cadastro realizado com sucesso!');
        window.top.location.href = '/FISICA/mapa.php';
    </script>";
    exit;
}

$stmt->close();

} catch (mysqli_sql_exception $e) {

    error_log("Erro no cadastro: " . $e->getMessage());

    echo "<script>
        alert('Não foi possível realizar o cadastro. Verifique se a matrícula ou o e-mail já estão cadastrados.');
        window.history.back();
    </script>";
    exit;
}
?>
