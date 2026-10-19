<?php
    require_once 'conexao.php';

$sql = "SELECT * FROM Sala ORDER BY cod_sala";

$resultado = mysqli_query($conn, $sql);

$salas = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
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

    .grade {
        display: flex;
        flex-wrap: wrap;
        flex-direction: row;
        grid-template-columns: repeat(auto-fill, minmax(auto-fill, 1fr));
        gap: 20px;

    }

    .sala {
        flex: 1 1 330px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px;
    }

    .sala h2 {
        margin: 0 0 8px;
        font-size: 1rem;
    }

    .sala ul {
        margin: 0;
        padding-left: 18px;
        font-size: 0.9rem;
    }
</style>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Salas</h1>

    <table>
        <tr>
            <th>Código</th>
            <th>Nome</th>
            <th>Ambiente</th>
            <th>Capacidade (Pessoas)</th>
            <th>Bloco</th>
            <th>Andar</th>
            <th>Area (m²)</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($salas as $sala): ?>
            <tr>
                <td><?= htmlspecialchars($sala['cod_sala']) ?></td>
                <td><?= htmlspecialchars($sala['nome']) ?></td>
                <td><?= htmlspecialchars($sala['tipo_ambiente']) ?></td>
                <td><?= htmlspecialchars($sala['capacidade_pessoas']) ?></td>
                <td><?= htmlspecialchars($sala['bloco']) ?></td>
                <td><?= htmlspecialchars($sala['andar']) ?></td>
                <td><?= htmlspecialchars($sala['area_m2']) ?></td>
                <td>
                    <a href="dispositivos.php?cod_sala=<?= htmlspecialchars($sala['area_m2']) ?>"><button>ver dispositivos</button></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>

