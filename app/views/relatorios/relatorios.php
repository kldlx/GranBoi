<main class="main-content relatorios-page">

  <header class="topbar">
    <button class="menu-toggle" id="menuToggle"><i class="ri-menu-line"></i></button>
    <div class="topbar-title">
      <h1>Relatórios</h1>
      <p>Consulte informações consolidadas da fazenda</p>
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

  <!-- HEADER -->
  <section class="relatorios-page-actions">
    <div>
      <h2>Relatórios Gerenciais</h2>
      <p>Rebanho, pesagem, vacinação e resultados financeiros da fazenda.</p>
    </div>
    <button type="button" class="print-report-btn" onclick="window.print()">
      <i class="ri-printer-line"></i>
      <span>Imprimir</span>
    </button>
  </section>

  <!-- CARDS DE RESUMO -->
  <section class="relatorio-summary-grid">

    <div class="relatorio-summary-card relatorio-card-green">
      <div class="relatorio-card-icon"><i class="ri-open-arm-line"></i></div>
      <div>
        <span>Total do Rebanho</span>
        <strong><?= htmlspecialchars($resumoRebanho['total'] ?? 0) ?></strong>
      </div>
    </div>

    <div class="relatorio-summary-card relatorio-card-teal">
      <div class="relatorio-card-icon"><i class="ri-checkbox-circle-line"></i></div>
      <div>
        <span>Ativos</span>
        <strong><?= htmlspecialchars($resumoRebanho['ativos'] ?? 0) ?></strong>
      </div>
    </div>

    <div class="relatorio-summary-card relatorio-card-blue">
      <div class="relatorio-card-icon"><i class="ri-money-dollar-circle-line"></i></div>
      <div>
        <span>Vendidos</span>
        <strong><?= htmlspecialchars($resumoRebanho['vendidos'] ?? 0) ?></strong>
      </div>
    </div>

    <div class="relatorio-summary-card relatorio-card-red">
      <div class="relatorio-card-icon"><i class="ri-heart-pulse-line"></i></div>
      <div>
        <span>Perdas</span>
        <strong><?= htmlspecialchars($resumoRebanho['perdas'] ?? 0) ?></strong>
      </div>
    </div>

    <div class="relatorio-summary-card relatorio-card-orange">
      <div class="relatorio-card-icon"><i class="ri-scales-3-line"></i></div>
      <div>
        <span>Peso Médio</span>
        <strong><?= number_format((float)($pesoMedioAtual ?? 0), 1, ',', '.') ?> kg</strong>
      </div>
    </div>

    <div class="relatorio-summary-card relatorio-card-yellow">
      <div class="relatorio-card-icon"><i class="ri-syringe-line"></i></div>
      <div>
        <span>Vacinas Pendentes</span>
        <strong><?= count($vacinasPendentes ?? []) ?></strong>
      </div>
    </div>

    <div class="relatorio-summary-card relatorio-card-red">
      <div class="relatorio-card-icon"><i class="ri-alarm-warning-line"></i></div>
      <div>
        <span>Vacinas Atrasadas</span>
        <strong><?= count($vacinasAtrasadas ?? []) ?></strong>
      </div>
    </div>

    <div class="relatorio-summary-card relatorio-card-green">
      <div class="relatorio-card-icon"><i class="ri-line-chart-line"></i></div>
      <div>
        <span>Receitas (Vendas)</span>
        <strong>R$ <?= number_format((float)($totalReceitas ?? 0), 0, ',', '.') ?></strong>
      </div>
    </div>

  </section>

  <!-- ABAS -->
  <div class="relatorio-tabs-bar">
    <button class="relatorio-tab active" data-tab="rebanho">
      <i class="ri-open-arm-line"></i> Rebanho
    </button>
    <button class="relatorio-tab" data-tab="peso">
      <i class="ri-scales-3-line"></i> Pesagem
    </button>
    <button class="relatorio-tab" data-tab="vacinacao">
      <i class="ri-syringe-line"></i> Vacinação
    </button>
    <button class="relatorio-tab" data-tab="alertas">
      <i class="ri-alarm-warning-line"></i> Alertas
      <?php if (count($vacinasAtrasadas ?? []) + count($vacinasPendentes ?? []) > 0): ?>
        <span class="relatorio-tab-badge"><?= count($vacinasAtrasadas ?? []) + count($vacinasPendentes ?? []) ?></span>
      <?php endif; ?>
    </button>
  </div>

  <!-- ABA: REBANHO -->
  <div class="relatorio-tab-content active" id="tab-rebanho">

    <div class="relatorio-two-columns">

      <div class="relatorios-table-card">
        <div class="section-header">
          <div>
            <h2>Animais por Raça</h2>
            <p>Distribuição do rebanho por raça</p>
          </div>
        </div>
        <table class="relatorios-table">
          <thead><tr><th>Raça</th><th>Total</th><th>%</th></tr></thead>
          <tbody>
            <?php
              $totalRaca = array_sum(array_column($animaisPorRaca ?? [], 'total'));
            ?>
            <?php if (!empty($animaisPorRaca)): ?>
              <?php foreach ($animaisPorRaca as $item): ?>
                <tr>
                  <td><?= htmlspecialchars($item['raca'] ?? '-') ?></td>
                  <td><strong><?= $item['total'] ?></strong></td>
                  <td>
                    <div class="relatorio-bar-wrap">
                      <div class="relatorio-bar" style="width:<?= $totalRaca > 0 ? round($item['total']/$totalRaca*100) : 0 ?>%"></div>
                      <span><?= $totalRaca > 0 ? round($item['total']/$totalRaca*100) : 0 ?>%</span>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="3" class="relatorio-empty">Nenhum dado encontrado.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <div class="relatorios-table-card">
        <div class="section-header">
          <div>
            <h2>Animais por Lote</h2>
            <p>Distribuição do rebanho por lote</p>
          </div>
        </div>
        <table class="relatorios-table">
          <thead><tr><th>Lote</th><th>Total</th><th>%</th></tr></thead>
          <tbody>
            <?php
              $totalLote = array_sum(array_column($animaisPorLote ?? [], 'total'));
            ?>
            <?php if (!empty($animaisPorLote)): ?>
              <?php foreach ($animaisPorLote as $item): ?>
                <tr>
                  <td><?= htmlspecialchars($item['lote'] ?? '-') ?></td>
                  <td><strong><?= $item['total'] ?></strong></td>
                  <td>
                    <div class="relatorio-bar-wrap">
                      <div class="relatorio-bar" style="width:<?= $totalLote > 0 ? round($item['total']/$totalLote*100) : 0 ?>%"></div>
                      <span><?= $totalLote > 0 ? round($item['total']/$totalLote*100) : 0 ?>%</span>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="3" class="relatorio-empty">Nenhum dado encontrado.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

    </div>

  </div>

  <!-- ABA: PESAGEM -->
  <div class="relatorio-tab-content" id="tab-peso">

    <div class="relatorios-table-card">
      <div class="section-header">
        <div>
          <h2>Ranking de Ganho de Peso</h2>
          <p>Top 10 animais com maior ganho entre a primeira e última pesagem</p>
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
            <?php foreach ($rankingGanhoPeso as $i => $item): ?>
              <tr>
                <td>
                  <?php if ($i < 3): ?>
                    <span class="relatorio-rank relatorio-rank-<?= $i+1 ?>"><?= $i+1 ?>º</span>
                  <?php endif; ?>
                  #<?= htmlspecialchars($item['brinco_identificador'] ?? '-') ?>
                </td>
                <td><?= htmlspecialchars($item['raca'] ?? '-') ?></td>
                <td><?= htmlspecialchars($item['lote'] ?? '-') ?></td>
                <td><?= number_format((float)($item['peso_inicial'] ?? 0), 2, ',', '.') ?> kg</td>
                <td><?= number_format((float)($item['peso_atual'] ?? 0), 2, ',', '.') ?> kg</td>
                <td><span class="relatorio-status disponivel">+<?= number_format((float)($item['ganho_total'] ?? 0), 2, ',', '.') ?> kg</span></td>
                <td><?= number_format((float)($item['gmd'] ?? 0), 3, ',', '.') ?> kg/dia</td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="7" class="relatorio-empty">Não há pesagens suficientes para calcular ganho de peso.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </div>

  <!-- ABA: VACINAÇÃO -->
  <div class="relatorio-tab-content" id="tab-vacinacao">

    <div class="relatorios-table-card">
      <div class="section-header relatorio-filter-header">
        <div>
          <h2>Vacinações por Período</h2>
          <p id="vacinacaoContador">
            <?= count($vacinacoesPeriodo ?? []) ?> registro<?= count($vacinacoesPeriodo ?? []) !== 1 ? 's' : '' ?> encontrado<?= count($vacinacoesPeriodo ?? []) !== 1 ? 's' : '' ?>
          </p>
        </div>
        <div class="relatorio-filter-form">
          <div>
            <label for="data_inicio">Início</label>
            <input type="date" id="data_inicio" name="data_inicio" value="<?= htmlspecialchars($dataInicio ?? date('Y-m-01')) ?>">
          </div>
          <div>
            <label for="data_fim">Fim</label>
            <input type="date" id="data_fim" name="data_fim" value="<?= htmlspecialchars($dataFim ?? date('Y-m-d')) ?>">
          </div>
          <button type="button" id="btnFiltrarVacinacao">
            <i class="ri-filter-3-line"></i>
            <span>Filtrar</span>
          </button>
        </div>
      </div>

      <div id="vacinacaoFiltroMsg" class="relatorio-filtro-msg" hidden></div>

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
        <tbody id="vacinacaoTableBody">
          <?php if (!empty($vacinacoesPeriodo)): ?>
            <?php foreach ($vacinacoesPeriodo as $v): ?>
              <tr>
                <td>#<?= htmlspecialchars($v['brinco_identificador'] ?? '-') ?></td>
                <td><?= htmlspecialchars($v['raca'] ?? '-') ?></td>
                <td><?= htmlspecialchars($v['vacina'] ?? '-') ?></td>
                <td><?= !empty($v['quantidade']) ? number_format((float)$v['quantidade'], 2, ',', '.') . ' ml' : '-' ?></td>
                <td><?= !empty($v['data_aplicacao']) ? date('d/m/Y', strtotime($v['data_aplicacao'])) : '-' ?></td>
                <td><?= !empty($v['proxima_dose']) ? date('d/m/Y', strtotime($v['proxima_dose'])) : '-' ?></td>
                <td><span class="relatorio-status <?= htmlspecialchars($v['status'] ?? '') ?>"><?= ucfirst(htmlspecialchars($v['status'] ?? '-')) ?></span></td>
                <td><?= htmlspecialchars($v['responsavel'] ?? '-') ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="8" class="relatorio-empty">Nenhuma vacinação encontrada no período selecionado.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </div>

  <!-- ABA: ALERTAS -->
  <div class="relatorio-tab-content" id="tab-alertas">

    <div class="relatorio-two-columns">

      <div class="relatorios-table-card">
        <div class="section-header">
          <div>
            <h2>Vacinas Pendentes Hoje</h2>
            <p>Doses com próxima aplicação marcada para hoje</p>
          </div>
          <?php if (!empty($vacinasPendentes)): ?>
            <span class="relatorio-badge relatorio-badge-orange"><?= count($vacinasPendentes) ?></span>
          <?php endif; ?>
        </div>
        <table class="relatorios-table">
          <thead><tr><th>Animal</th><th>Raça</th><th>Vacina</th><th>Próxima Dose</th></tr></thead>
          <tbody>
            <?php if (!empty($vacinasPendentes)): ?>
              <?php foreach ($vacinasPendentes as $vacina): ?>
                <tr>
                  <td>#<?= htmlspecialchars($vacina['brinco_identificador'] ?? '-') ?></td>
                  <td><?= htmlspecialchars($vacina['raca'] ?? '-') ?></td>
                  <td><?= htmlspecialchars($vacina['vacina'] ?? '-') ?></td>
                  <td><span class="relatorio-status pendente"><?= !empty($vacina['proxima_dose']) ? date('d/m/Y', strtotime($vacina['proxima_dose'])) : '-' ?></span></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="4" class="relatorio-empty">Nenhuma vacina pendente para hoje.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <div class="relatorios-table-card">
        <div class="section-header">
          <div>
            <h2>Vacinas Atrasadas</h2>
            <p>Doses vencidas que precisam de atenção imediata</p>
          </div>
          <?php if (!empty($vacinasAtrasadas)): ?>
            <span class="relatorio-badge relatorio-badge-red"><?= count($vacinasAtrasadas) ?></span>
          <?php endif; ?>
        </div>
        <table class="relatorios-table">
          <thead><tr><th>Animal</th><th>Raça</th><th>Vacina</th><th>Vencida há</th></tr></thead>
          <tbody>
            <?php if (!empty($vacinasAtrasadas)): ?>
              <?php foreach ($vacinasAtrasadas as $vacina): ?>
                <tr>
                  <td>#<?= htmlspecialchars($vacina['brinco_identificador'] ?? '-') ?></td>
                  <td><?= htmlspecialchars($vacina['raca'] ?? '-') ?></td>
                  <td><?= htmlspecialchars($vacina['vacina'] ?? '-') ?></td>
                  <td><span class="relatorio-status atrasada"><?= htmlspecialchars($vacina['dias_atraso'] ?? 0) ?> dia(s)</span></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="4" class="relatorio-empty">Nenhuma vacina atrasada.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

    </div>

  </div>

  <input type="hidden" id="relatorioBaseUrl" value="<?= BASE_URL ?>">

</main>
