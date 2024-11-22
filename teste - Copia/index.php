<?php
session_start();
include 'conexao.php';

// Adicionar registro
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['adicionar'])) {
    $data = $_POST['data'];
    $descricao = $_POST['descricao'];
    $tipo = $_POST['tipo'];
    $valor = $_POST['valor'];

    $sql = "INSERT INTO extrato (data, descricao, tipo, valor) VALUES ('$data', '$descricao', '$tipo', $valor)";
    $conn->query($sql);
}

// Excluir registro
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM extrato WHERE id=$id");
}

// Obter registros
$result = $conn->query("SELECT * FROM extrato");

// Calcular totais
$totalEntrada = $conn->query("SELECT SUM(valor) AS total FROM extrato WHERE tipo='Entrada'")->fetch_assoc()['total'] ?? 0;
$totalSaida = $conn->query("SELECT SUM(valor) AS total FROM extrato WHERE tipo='Saída'")->fetch_assoc()['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Extrato Financeiro</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid black; }
        th, td { text-align: center; padding: 8px; }
    </style>
</head>
<body>
    <h1>Extrato Financeiro</h1>

    <!-- Formulário para adicionar registro -->
    <form method="post" action="">
        <label for="data">Data:</label>
        <input type="date" id="data" name="data" required>
        
        <label for="descricao">Descrição:</label>
        <input type="text" id="descricao" name="descricao" required>
        
        <label for="tipo">Tipo:</label>
        <select id="tipo" name="tipo" required>
            <option value="Entrada">Entrada</option>
            <option value="Saída">Saída</option>
        </select>
        
        <label for="valor">Valor:</label>
        <input type="number" id="valor" name="valor" step="0.01" required>
        
        <button type="submit" name="adicionar">Adicionar</button>
    </form>

    <!-- Tabela de registros -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Data</th>
                <th>Descrição</th>
                <th>Tipo</th>
                <th>Valor</th>
                <th>Açã</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['data']; ?></td>
                <td><?php echo $row['descricao']; ?></td>
                <td><?php echo $row['tipo']; ?></td>
                <td>R$ <?php echo number_format($row['valor'], 2, ',', '.'); ?></td>
                <td>
                    <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Deseja excluir este registro?')">Excluir</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Totais -->
    <h2>Totais</h2>
    <p>Total de Entradas: R$ <?php echo number_format($totalEntrada, 2, ',', '.'); ?></p>
    <p>Total de Saídas: R$ <?php echo number_format($totalSaida, 2, ',', '.'); ?></p>
</body>
</html>
