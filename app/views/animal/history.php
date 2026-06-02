<?php $title = "Histórico de Peso"; ?>

<section class="page-section active">

  <h1>Histórico de Peso</h1>

  <div class="chart-box">

    <div class="fake-chart">

      <?php if (!empty($historico)): ?>
        <?php foreach ($historico as $h): ?>
          <div class="bar" style="height: <?= $h['peso'] / 5 ?>%;"></div>
        <?php endforeach; ?>
      <?php endif; ?>

    </div>

  </div>

</section>