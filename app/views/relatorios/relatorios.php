<main class="main-content relatorios-page">

  <header class="topbar">

    <button
      class="menu-toggle"
      id="menuToggle"
    >
      <i class="ri-menu-line"></i>
    </button>

    <div class="topbar-title">

      <h1>Relatórios</h1>

      <p>
        Consulte informações consolidadas da fazenda
      </p>

    </div>

    <div class="profile">

      <div class="profile-info">
        <h3><?= htmlspecialchars($_SESSION['usuario']['nome'] ?? 'Usuário') ?></h3>
        <span><?= htmlspecialchars($_SESSION['usuario']['papel_nome'] ?? 'Perfil') ?></span>
      </div>

      <div class="profile-avatar">
        <?= strtoupper(substr($_SESSION['usuario']['nome'] ?? 'U', 0, 1)) ?>
      </div>

    </div>

  </header>

  <?php if (!empty($_SESSION['erro'])): ?>

    <div class="relatorio-message relatorio-message-error">
      <i class="ri-error-warning-line"></i>
      <span><?= $_SESSION['erro'] ?></span>
    </div>

    <?php unset($_SESSION['erro']); ?>

  <?php endif; ?>

  <section class="relatorios-page-actions">

    <div>
      <h2>Relatórios Gerenciais</h2>
      <p>
        Acompanhe rebanho, evolução de peso, vacinação e alertas sanitários.
      </p>
    </div>

    <button
      type="button"
      class="print-report-btn"
      onclick="window.print()"
    >
      <i class="ri-printer-line"></i>
      <span>Imprimir Relatório</span>
    </button>

  </section>

  <section class="relatorio-summary-grid">

    <div class="relatorio-summary-card">
      <span>Total de Animais</span>
      <strong><?= htmlspecialchars($resumoRebanho['total'] ?? 0) ?></strong>
    </div>

    <div class="relatorio-summary-card">
      <span>Ativos</span>
      <strong><?= htmlspecialchars($resumoRebanho['ativos'] ?? 0) ?></strong>
    </div>

    <div class="relatorio-summary-card">
      <span>Vendidos</span>
      <strong><?= htmlspecialchars($resumoRebanho['vendidos'] ?? 0) ?></strong>
    </div>

    <div class="relatorio-summary-card">
      <span>Abatidos</span>
      <strong><?= htmlspecialchars($resumoRebanho['abatidos'] ?? 0) ?></strong>
    </div>

    <div class="relatorio-summary-card">
      <span>Peso Médio Atual</span>
      <strong><?= number_format((float) ($pesoMedioAtual ?? 0), 2, ',', '.') ?> kg</strong>
    </div>

    <div class="relatorio-summary-card">
      <span>Vacinas Pendentes</span>
      <strong><?= !empty($vacinasPendentes) ? count($vacinasPendentes) : 0 ?></strong>
    </div>

    <div class="relatorio-summary-card">
      <span>Vacinas Atrasadas</span>
      <strong><?= !empty($vacinasAtrasadas) ? count($vacinasAtrasadas) : 0 ?></strong>
    </div>

  </section>

  <section class="relatorio-two-columns">

    <div class="relatorios-table-card">

      <div class="section-header">

        <div>
          <h2>Animais por Raça</h2>
          <p>Distribuição atual do rebanho por raça.</p>
        </div>

      </div>

      <table class="relatorios-table">

        <thead>
          <tr>
            <th>Raça</th>
            <th>Total</th>
          </tr>
        </thead>

        <tbody>

          <?php if (!empty($animaisPorRaca)): ?>

            <?php foreach ($animaisPorRaca as $item): ?>

              <tr>
                <td><?= htmlspecialchars($item['raca'] ?? '-') ?></td>
                <td><?= htmlspecialchars($item['total'] ?? 0) ?></td>
              </tr>

            <?php endforeach; ?>

          <?php else: ?>

            <tr>
              <td colspan="2" class="relatorio-empty">
                Nenhum dado de raça encontrado.
              </td>
            </tr>

          <?php endif; ?>

        </tbody>

      </table>

    </div>

    <div class="relatorios-table-card">

      <div class="section-header">

        <div>
          <h2>Animais por Lote</h2>
          <p>Distribuição atual do rebanho por lote.</p>
        </div>

      </div>

      <table class="relatorios-table">

        <thead>
          <tr>
            <th>Lote</th>
            <th>Total</th>
          </tr>
        </thead>

        <tbody>

          <?php if (!empty($animaisPorLote)): ?>

            <?php foreach ($animaisPorLote as $item): ?>

              <tr>
                <td><?= htmlspecialchars($item['lote'] ?? '-') ?></td>
                <td><?= htmlspecialchars($item['total'] ?? 0) ?></td>
              </tr>

            <?php endforeach; ?>

          <?php else: ?>

            <tr>
              <td colspan="2" class="relatorio-empty">
                Nenhum dado de lote encontrado.
              </td>
            </tr>

          <?php endif; ?>

        </tbody>

      </table>

    </div>

  </section>

  <section class="relatorios-table-card">

    <div class="section-header">

      <div>
        <h2>Ranking de Ganho de Peso</h2>
        <p>
          Animais com maior ganho registrado entre a primeira e a última pesagem.
        </p>
      </div>

    </div>

    <table class="relatorios-table">

      <thead>

        <tr>
          <th>Animal</th>
          <th>Raça</th>
          <th>Lote</th>
          <th>Peso Inicial</th>
          <th>Peso Atual</th>
          <th>Ganho Total</th>
          <th>GMD</th>
        </tr>

      </thead>

      <tbody>

        <?php if (!empty($rankingGanhoPeso)): ?>

          <?php foreach ($rankingGanhoPeso as $item): ?>

            <tr>
              <td>#<?= htmlspecialchars($item['brinco_identificador'] ?? '-') ?></td>
              <td><?= htmlspecialchars($item['raca'] ?? '-') ?></td>
              <td><?= htmlspecialchars($item['lote'] ?? '-') ?></td>
              <td><?= number_format((float) ($item['peso_inicial'] ?? 0), 2, ',', '.') ?> kg</td>
              <td><?= number_format((float) ($item['peso_atual'] ?? 0), 2, ',', '.') ?> kg</td>
              <td>
                <span class="relatorio-status disponivel">
                  <?= number_format((float) ($item['ganho_total'] ?? 0), 2, ',', '.') ?> kg
                </span>
              </td>
              <td><?= number_format((float) ($item['gmd'] ?? 0), 2, ',', '.') ?> kg/dia</td>
            </tr>

          <?php endforeach; ?>

        <?php else: ?>

          <tr>
            <td colspan="7" class="relatorio-empty">
              Ainda não há pesagens suficientes para calcular ganho de peso.
            </td>
          </tr>

        <?php endif; ?>

      </tbody>

    </table>

  </section>

  <section class="relatorios-table-card">

    <div class="section-header relatorio-filter-header">

      <div>
        <h2>Vacinações por Período</h2>
        <p>
          Filtre as vacinações aplicadas entre duas datas.
        </p>
      </div>

      <form
        method="GET"
        action="<?= BASE_URL ?>/relatorios"
        class="relatorio-filter-form"
      >

        <div>
          <label for="data_inicio">Início</label>
          <input
            type="date"
            id="data_inicio"
            name="data_inicio"
            value="<?= htmlspecialchars($dataInicio ?? date('Y-m-01')) ?>"
          >
        </div>

        <div>
          <label for="data_fim">Fim</label>
          <input
            type="date"
            id="data_fim"
            name="data_fim"
            value="<?= htmlspecialchars($dataFim ?? date('Y-m-d')) ?>"
          >
        </div>

        <button type="submit">
          <i class="ri-filter-3-line"></i>
          <span>Filtrar</span>
        </button>

      </form>

    </div>

    <table class="relatorios-table">

      <thead>

        <tr>
          <th>Animal</th>
          <th>Raça</th>
          <th>Vacina</th>
          <th>Dose</th>
          <th>Aplicação</th>
          <th>Próxima Dose</th>
          <th>Status</th>
          <th>Responsável</th>
        </tr>

      </thead>

      <tbody>

        <?php if (!empty($vacinacoesPeriodo)): ?>

          <?php foreach ($vacinacoesPeriodo as $vacinacao): ?>

            <tr>
              <td>#<?= htmlspecialchars($vacinacao['brinco_identificador'] ?? '-') ?></td>
              <td><?= htmlspecialchars($vacinacao['raca'] ?? '-') ?></td>
              <td><?= htmlspecialchars($vacinacao['vacina'] ?? '-') ?></td>
              <td>
                <?= !empty($vacinacao['quantidade']) ? number_format((float) $vacinacao['quantidade'], 2, ',', '.') . ' ml' : '-' ?>
              </td>
              <td>
                <?= !empty($vacinacao['data_aplicacao']) ? date('d/m/Y', strtotime($vacinacao['data_aplicacao'])) : '-' ?>
              </td>
              <td>
                <?= !empty($vacinacao['proxima_dose']) ? date('d/m/Y', strtotime($vacinacao['proxima_dose'])) : '-' ?>
              </td>
              <td>
                <span class="relatorio-status <?= htmlspecialchars($vacinacao['status'] ?? '') ?>">
                  <?= ucfirst(htmlspecialchars($vacinacao['status'] ?? '-')) ?>
                </span>
              </td>
              <td><?= htmlspecialchars($vacinacao['responsavel'] ?? '-') ?></td>
            </tr>

          <?php endforeach; ?>

        <?php else: ?>

          <tr>
            <td colspan="8" class="relatorio-empty">
              Nenhuma vacinação encontrada no período selecionado.
            </td>
          </tr>

        <?php endif; ?>

      </tbody>

    </table>

  </section>

  <section class="relatorio-two-columns">

    <div class="relatorios-table-card">

      <div class="section-header">

        <div>
          <h2>Vacinas Pendentes Hoje</h2>
          <p>Doses com próxima aplicação marcada para hoje.</p>
        </div>

      </div>

      <table class="relatorios-table">

        <thead>
          <tr>
            <th>Animal</th>
            <th>Vacina</th>
            <th>Próxima Dose</th>
          </tr>
        </thead>

        <tbody>

          <?php if (!empty($vacinasPendentes)): ?>

            <?php foreach ($vacinasPendentes as $vacina): ?>

              <tr>
                <td>#<?= htmlspecialchars($vacina['brinco_identificador'] ?? '-') ?></td>
                <td><?= htmlspecialchars($vacina['vacina'] ?? '-') ?></td>
                <td><?= !empty($vacina['proxima_dose']) ? date('d/m/Y', strtotime($vacina['proxima_dose'])) : '-' ?></td>
              </tr>

            <?php endforeach; ?>

          <?php else: ?>

            <tr>
              <td colspan="3" class="relatorio-empty">
                Nenhuma vacina pendente para hoje.
              </td>
            </tr>

          <?php endif; ?>

        </tbody>

      </table>

    </div>

    <div class="relatorios-table-card">

      <div class="section-header">

        <div>
          <h2>Vacinas Atrasadas</h2>
          <p>Doses vencidas que precisam de atenção.</p>
        </div>

      </div>

      <table class="relatorios-table">

        <thead>
          <tr>
            <th>Animal</th>
            <th>Vacina</th>
            <th>Atraso</th>
          </tr>
        </thead>

        <tbody>

          <?php if (!empty($vacinasAtrasadas)): ?>

            <?php foreach ($vacinasAtrasadas as $vacina): ?>

              <tr>
                <td>#<?= htmlspecialchars($vacina['brinco_identificador'] ?? '-') ?></td>
                <td><?= htmlspecialchars($vacina['vacina'] ?? '-') ?></td>
                <td>
                  <span class="relatorio-status atrasada">
                    <?= htmlspecialchars($vacina['dias_atraso'] ?? 0) ?> dia(s)
                  </span>
                </td>
              </tr>

            <?php endforeach; ?>

          <?php else: ?>

            <tr>
              <td colspan="3" class="relatorio-empty">
                Nenhuma vacina atrasada.
              </td>
            </tr>

          <?php endif; ?>

        </tbody>

      </table>

    </div>

  </section>

</main>