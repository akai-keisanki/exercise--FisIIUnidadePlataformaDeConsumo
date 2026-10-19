<?php
    require_once 'conexao.php';

$sql = "SELECT * FROM Dispositivo ";

$cod_sala = $_GET['cod_sala'] ?? null; 

if ($cod_sala !== null) {
    $sql = $sql . "INNER JOIN Alocacao ON Dispositivo.id_dispositivo = Alocacao.id_dispositivo WHERE Alocacao.cod_sala = ? "
}

$sql = $sql . "ORDER BY id_dispositivo";

$stmt = mysqli_prepare($conn, $sql);

if ($cod_sala !== null) {
    mysqli_stmt_bind_param($stmt, "i", $cod_sala);
}

$resultado = mysqli_stmt_execute($stmt);

$disps = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
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
    <h1>Dispositivos</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Status</th>
            <th>marca</th>
            <th>Nº de Série</th>
            <th>Modelo</th>
            <th>Capacidade</th>
            <th>Tensão</th>
            <th>Potência</th>
            <th>Tipo</th>
        </tr>
        <?php foreach ($disps as $disp): ?>
            <tr>
                <td><?= htmlspecialchars($sala['id_dispositivo']) ?></td>
                <td><?= htmlspecialchars($sala['status']) ?></td>
                <td><?= htmlspecialchars($sala['marca']) ?></td>
                <td><?= htmlspecialchars($sala['nr_serie']) ?></td>
                <td><?= htmlspecialchars($sala['modelo']) ?></td>
                <td><?= htmlspecialchars($sala['capacidade_btu']) ?>BTU</td>
                <td><?= htmlspecialchars($sala['tensao_v']) ?>V</td>
                <td><?= htmlspecialchars($sala['potencia_w']) ?>W</td>
                <td><?= htmlspecialchars($sala['tipo_dispositivo']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>


