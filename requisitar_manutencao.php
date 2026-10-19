<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

session_start();

require_once 'conexao.php';

if (!isset($_SESSION["matricula"]) || $_SESSION["perfil"] !== "TEC") {
    header("Location: login.php");
    exit;
}

$id_dispositivo = $_REQUEST['id_dispositivo'] ?? null;

if (!$id_dispositivo) {
    header("Location: mapa.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    function alerta($mensagem) {
        echo "<script>
            window.top.alert(" . json_encode($mensagem) . ");
        </script>";
        exit;
    }

    $descricao_servico = trim($_POST["descricao_servico"] ?? "");
    $tipo = $_POST["tipo"] ?? "";
    $custo_reais = trim($_POST["custo_reais"] ?? "0");
    $proxima_manutencao = isset($_POST["proxima_manutencao"]) ? 1 : 0;
    
    $matricula_requisitante = $_SESSION["matricula"];
    
    if ($descricao_servico === "" || $tipo === "") {
        alerta("Há campos obrigatórios vazios.");
    }

    try {
        $sql = "INSERT
                    INTO Manutencao(descricao_servico, tipo, data_manutencao, custo_reais, proxima_manutencao, matricula_requisitante, id_dispositivo)
                    VALUES (?, ?, CURRENT_DATE, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "sssisi",
            $descricao_servico,
            $tipo,
            $custo_reais,
            $proxima_manutencao,
            $matricula_requisitante,
            $id_dispositivo
        );

        $stmt->execute();

        $stmt->close();
        $conn->close();

        echo "<script>
            window.top.alert('Manutenção requisitada com sucesso!');
        </script>";
        header("Location: mapa.php");
        exit;

    } catch (mysqli_sql_exception $e) {
        //error_log("Erro na requisição de manutenção: " . $e->getMessage());
        //alerta("Não foi possível registrar a manutenção. Verifique os dados.");
        alerta($e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requisitar Manutenção</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div>
        <form action="requisitar_manutencao.php?id_dispositivo=<?= htmlspecialchars($id_dispositivo) ?>" method="POST" target="resposta">

            <input type="hidden" name="id_dispositivo" value="<?= htmlspecialchars($id_dispositivo) ?>">

            <label>Serviço</label>
            <input
                type="text"
                name="descricao_servico"
                placeholder="Descrição do serviço"
                required
            >

            <label>Tipo</label>
            <select name="tipo">
                <option value="preventiva">Preventiva</option>
                <option value="corretiva">Corretiva</option>
            </select>

            <label>Custo (R$)</label>
            <input
                type="number"
                step="0.01"
                name="custo_reais"
                placeholder="Custo em reais (ex: 150.00)"
            >

            <button type="submit">Salvar Manutenção</button>
        </form>

        <iframe
            name="resposta"
            style="display:none;"
            title="Resposta da requisição"
        ></iframe>

        <p>
            <a href="mapa.php">Voltar para Salas</a>
        </p>
    </div>
</body>
</html>
