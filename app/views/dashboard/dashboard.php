<main class="main-content">

  <section class="cards">

    <div class="card">

      <div class="card-icon green">
        <i class="ri-bear-smile-line"></i>
      </div>

      <div class="card-info">
        <span>Total de Gado</span>
        <h2><?= htmlspecialchars($totalAnimais ?? 0) ?></h2>
      </div>

    </div>

    <div class="card">

      <div class="card-icon blue">
        <i class="ri-heart-pulse-line"></i>
      </div>

      <div class="card-info">
        <span>Vacinas Pendentes</span>
        <h2><?= htmlspecialchars($vacinasPendentes ?? 0) ?></h2>
      </div>

    </div>

    <div class="card">

      <div class="card-icon orange">
        <i class="ri-scales-3-line"></i>
      </div>

      <div class="card-info">
        <span>Peso Médio</span>
        <h2><?= htmlspecialchars($pesoMedio ?? 0) ?>kg</h2>
      </div>

    </div>

    <div class="card">

      <div class="card-icon red">
        <i class="ri-line-chart-line"></i>
      </div>

      <div class="card-info">
        <span>GMD Médio</span>
        <h2>
          <?= $gmdMedio !== null ? htmlspecialchars($gmdMedio) . 'kg/dia' : '-' ?>
        </h2>
      </div>

    </div>

  </section>

  <section class="content-grid">

    <div class="chart-box">

      <div class="section-header">
        <h2>Status do Rebanho</h2>
      </div>

      <div class="dashboard-status-summary">

        <div class="dashboard-status-item">
          <span>Ativos</span>
          <strong><?= htmlspecialchars($totalAtivos ?? 0) ?></strong>
        </div>

        <div class="dashboard-status-item">
          <span>Vendidos</span>
          <strong><?= htmlspecialchars($totalVendidos ?? 0) ?></strong>
        </div>

        <div class="dashboard-status-item">
          <span>Mortos</span>
          <strong><?= htmlspecialchars($totalMortos ?? 0) ?></strong>
        </div>

      </div>

    </div>

    <div class="table-box">

      <div class="section-header">
        <h2>Últimos Registros</h2>
      </div>

      <div class="table-responsive">

        <table>

          <thead>

            <tr>
              <th>Brinco</th>
              <th>Raça</th>
              <th>Peso</th>
              <th>Status</th>
            </tr>

          </thead>

          <tbody>

            <?php if (!empty($ultimosAnimais)): ?>

              <?php foreach ($ultimosAnimais as $animal): ?>

                <tr>

                  <td>
                    #<?= htmlspecialchars($animal['brinco_identificador']) ?>
                  </td>

                  <td>
                    <?= htmlspecialchars($animal['raca'] ?? '-') ?>
                  </td>

                  <td>
                    <?= htmlspecialchars($animal['peso_atual'] ?? $animal['peso_entrada']) ?>kg
                  </td>

                  <td>
                    <span class="dashboard-status dashboard-status-<?= htmlspecialchars($animal['status']) ?>">
                      <?= ucfirst(htmlspecialchars($animal['status'])) ?>
                    </span>
                  </td>

                </tr>

              <?php endforeach; ?>

            <?php else: ?>

              <tr>
                <td colspan="4">
                  Nenhum animal cadastrado.
                </td>
              </tr>

            <?php endif; ?>

          </tbody>

        </table>

      </div>

    </div>

  </section>

</main>