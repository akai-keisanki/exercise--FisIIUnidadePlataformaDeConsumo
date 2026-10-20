<?php
    require_once 'conexao.php';

$sql = "";

$cod_sala = $_GET['cod_sala'] ?? null; 

if ($cod_sala !== null && $cod_sala !== '') {
    $sql = "SELECT Dispositivo.* FROM Dispositivo 
            INNER JOIN Alocacao ON Dispositivo.id_dispositivo = Alocacao.id_dispositivo 
            WHERE Alocacao.cod_sala = ? 
            ORDER BY Dispositivo.id_dispositivo";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $cod_sala);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
} else {
    $sql = "SELECT * FROM Dispositivo ORDER BY id_dispositivo";
    $resultado = mysqli_query($conn, $sql);
}

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

    <p>
        <a href="mapa.php">Voltar para Salas</a>
    </p>

    <?php if ($cod_sala !== null) {
        echo '<p>' .
            'Código da sala: ' . '<a href="dispositivos.php?cod_sala=' . $cod_sala . '">' . $cod_sala . '</a>' .
        '</p>';
    } ?>


    <table>
        <tr>
            <th>Tipo</th>
            <th>Status</th>
            <th>ID</th>
            <th>Modelo</th>
            <th>marca</th>
            <th>Nº de Série</th>
            <th>Capacidade</th>
            <th>Tensão</th>
            <th>Potência</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($disps as $disp): ?>
            <tr>
                <td><?= htmlspecialchars($disp['tipo_dispositivo']) ?></td>
                <td><?= htmlspecialchars($disp['status']) ?></td>
                <td><?= htmlspecialchars($disp['id_dispositivo']) ?></td>
                <td><?= htmlspecialchars($disp['modelo']) ?></td>
                <td><?= htmlspecialchars($disp['marca']) ?></td>
                <td><?= htmlspecialchars($disp['nr_serie']) ?></td>
                <td><?= htmlspecialchars($disp['capacidade_btu']) ?>BTU</td>
                <td><?= htmlspecialchars($disp['tensao_v']) ?>V</td>
                <td><?= htmlspecialchars($disp['potencia_w']) ?>W</td>
                <td>
                    <a href="requisitar_manutencao.php?id_dispositivo=<?= htmlspecialchars($disp['id_dispositivo']) ?>"><button>requisitar manutenção</button></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>


