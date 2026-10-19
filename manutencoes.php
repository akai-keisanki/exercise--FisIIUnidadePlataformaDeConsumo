<?php
    require_once 'conexao.php';

$sql = "";

$id_dispositivo = $_GET['id_dispositivo'] ?? null; 

if ($id_dispositivo !== null && $id_dispositivo !== '') {
    $sql = "SELECT * FROM Manutencao
            WHERE id_dispositivo = ? 
            ORDER BY data_manutencao DESC";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_dispositivo);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
} else {
    $sql = "SELECT * FROM Manutencao ORDER BY data_manutencao";
    $resultado = mysqli_query($conn, $sql);
}

$manus = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

foreach ($manus as &$manu) {
    $stmt2 = mysqli_prepare($conn, "SELECT * FROM Alocacao WHERE id_dispositivo = ? ORDER BY data_instalacao DESC");
    mysqli_stmt_bind_param($stmt2, "i", $manu["id_dispositivo"]);
    mysqli_stmt_execute($stmt2);
    $resultado2 = mysqli_stmt_get_result($stmt2);

    $alocs = mysqli_fetch_all($resultado2, MYSQLI_ASSOC);

    $manu["cod_sala"] = $alocs[0]["cod_sala"];
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    body {
        font-family: sans-serif;
        margin: 0;
        padding: 15px;
        background: #f5f5f5;
    }
</style>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Manutenções</h1>

    <p>
        <a href="mapa.php">Voltar para Salas</a>
    </p>

    <table>
        <tr>
            <th>ID</th>
            <th>Data de Requisição</th>
            <th>ID do Dispositivo</th>
            <th>Tipo</th>
            <th>Custo</th>
            <th>Descrição do Serviço</th>
            <th>Código da Sala</th>
            <th>Matricula d@ Requisitante</th>
        </tr>
        <?php foreach ($manus as $manu): ?>
            <tr>
                <td><?= htmlspecialchars($manu['id_manutencao']) ?></td>
                <td><?= htmlspecialchars($manu['data_manutencao']) ?></td>
                <td><?= htmlspecialchars($manu['id_dispositivo']) ?></td>
                <td><?= htmlspecialchars($manu['tipo']) ?></td>
                <td>R$<?= htmlspecialchars($manu['custo']) ?></td>
                <td><?= htmlspecialchars($manu['descricao_servico']) ?></td>
                <td><a href="dispositivos.php?cod_sala=<?= htmlspecialchars($manu['cod_sala']) ?>"><?= htmlspecialchars($manu['cod_sala']) ?></a></td>
                <td><?= htmlspecialchars($manu['matricula_requisitante']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>


