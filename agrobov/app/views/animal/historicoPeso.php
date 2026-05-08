<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <title>Histórico de Peso</title>
  <link rel="stylesheet" href="/assets/css/gado/historico-peso.css">
</head>

<body>

<div class="container">

  <h1>Histórico de Peso</h1>

  <h3>Animal #<?= $animal['id'] ?> - Brinco <?= $animal['brinco_identificador'] ?></h3>

  <!-- FORM PARA ADICIONAR PESO -->
  <form action="/animal/adicionarPeso" method="POST">

    <input type="hidden" name="animal_id" value="<?= $animal['id'] ?>">

    <input type="number" name="peso" placeholder="Novo peso (kg)" required>

    <button type="submit">Adicionar Peso</button>

  </form>

  <!-- LISTA HISTÓRICO -->
  <table>

    <thead>
      <tr>
        <th>Peso</th>
        <th>Data</th>
      </tr>
    </thead>

    <tbody>

    <?php if (!empty($historico)): ?>
      <?php foreach ($historico as $item): ?>
        <tr>
          <td><?= $item['peso'] ?> kg</td>
          <td><?= $item['data_registro'] ?></td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="2">Sem registros</td>
      </tr>
    <?php endif; ?>

    </tbody>

  </table>

</div>

<h2>Evolução de Peso</h2>

<canvas id="pesoChart"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('pesoChart');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($datas) ?>,
        datasets: [{
            label: 'Peso (kg)',
            data: <?= json_encode($pesos) ?>,
            borderColor: '#2ecc71',
            backgroundColor: 'rgba(46, 204, 113, 0.2)',
            tension: 0.3,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true
            }
        },
        scales: {
            y: {
                beginAtZero: false
            }
        }
    }
});
</script>

</body>
</html>