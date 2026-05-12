<?php $title = "Detalhes"; ?>

<section class="page-section active">

  <h1><?= $animal['nome'] ?></h1>

  <p>Brinco: <?= $animal['brinco_identificador'] ?></p>
  <p>Peso: <?= $animal['peso_entrada'] ?>kg</p>

<a href="<?= BASE_URL ?>/animal/historicoPeso?id=<?= $animal['id'] ?>">
    Ver histórico de peso
  </a>

</section>