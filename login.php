<?php
session_start();

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "fisica_bd"
);

if (!$conn) {
    die("Falha na conexão com o banco de dados.");
}

mysqli_set_charset($conn, "utf8mb4");

$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $identificador = trim($_POST["identificador"] ?? "");
    $senha = $_POST["senha"] ?? "";

    $sql = "SELECT matricula, nome, email, hash_senha, perfil
            FROM Usuario
            WHERE matricula = ? OR email = ?
            LIMIT 1";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ss",
        $identificador,
        $identificador
    );

    $stmt->execute();

    $resultado = $stmt->get_result();
    $dados = $resultado->fetch_assoc();

    if ($dados && password_verify(
        $senha,
        $dados["hash_senha"]
    )) {
        session_regenerate_id(true);

        $_SESSION["matricula"] = $dados["matricula"];
        $_SESSION["nome"] = $dados["nome"];
        $_SESSION["perfil"] = $dados["perfil"];

        $stmt->close();
        $conn->close();

        header("Location: mapa.php");
        exit;

    } else {
        $erro = "Matrícula/e-mail ou senha incorretos!";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div>

        <?php if ($erro !== ""): ?>
            <p style="color: red;">
                <?= htmlspecialchars($erro) ?>
            </p>
        <?php endif; ?>

        <form action="login.php" method="POST">

            <input
                type="text"
                name="identificador"
                placeholder="Digite sua matrícula ou e-mail"
                autocomplete="username"
                required
            >

            <input
                type="password"
                name="senha"
                placeholder="Digite sua senha"
                autocomplete="current-password"
                required
            >

            <button type="submit">Entrar</button>

        </form>

        <p>
            Não tem uma conta?
            <a href="cadastro.php"> Cadastre-se </a>
        </p>
    </div>
</body>
</html>