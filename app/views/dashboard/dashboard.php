<?php
$usuario = $_SESSION['user'] ?? [];
$nomeUsuario = $usuario['name'] ?? 'Usuario';
$papelUsuario = $usuario['papel'] ?? '';

$dashboards = [
  'administrador' => [
    'titulo' => 'Dashboard Administrativo',
    'descricao' => 'Visao geral completa do sistema',
    'fazenda' => 'Controle geral',
    'cards' => [
      ['icone' => 'ri-bear-smile-line', 'cor' => 'green', 'label' => 'Total de Gado', 'valor' => '5.240'],
      ['icone' => 'ri-heart-pulse-line', 'cor' => 'blue', 'label' => 'Vacinas Pendentes', 'valor' => '124'],
      ['icone' => 'ri-scales-3-line', 'cor' => 'orange', 'label' => 'Peso Medio', 'valor' => '412kg'],
      ['icone' => 'ri-money-dollar-circle-line', 'cor' => 'red', 'label' => 'Receita Mensal', 'valor' => 'R$ 82k'],
    ],
  ],
  'gestor' => [
    'titulo' => 'Dashboard do Gestor',
    'descricao' => 'Operacao, financeiro e relatorios',
    'fazenda' => 'Gestao da fazenda',
    'cards' => [
      ['icone' => 'ri-bear-smile-line', 'cor' => 'green', 'label' => 'Animais Ativos', 'valor' => '5.240'],
      ['icone' => 'ri-line-chart-line', 'cor' => 'blue', 'label' => 'Receita Mensal', 'valor' => 'R$ 82k'],
      ['icone' => 'ri-file-chart-line', 'cor' => 'orange', 'label' => 'Relatorios', 'valor' => '18'],
      ['icone' => 'ri-alert-line', 'cor' => 'red', 'label' => 'Alertas', 'valor' => '7'],
    ],
  ],
  'veterinario' => [
    'titulo' => 'Dashboard Veterinario',
    'descricao' => 'Saude, vacinacao e acompanhamento do rebanho',
    'fazenda' => 'Saude animal',
    'cards' => [
      ['icone' => 'ri-heart-pulse-line', 'cor' => 'blue', 'label' => 'Vacinas Pendentes', 'valor' => '124'],
      ['icone' => 'ri-medicine-bottle-line', 'cor' => 'green', 'label' => 'Protocolos Ativos', 'valor' => '12'],
      ['icone' => 'ri-alert-line', 'cor' => 'red', 'label' => 'Animais em Atencao', 'valor' => '7'],
      ['icone' => 'ri-bear-smile-line', 'cor' => 'orange', 'label' => 'Animais Monitorados', 'valor' => '5.240'],
    ],
  ],
  'operador' => [
    'titulo' => 'Dashboard do Operador',
    'descricao' => 'Cadastro e manejo diario do gado',
    'fazenda' => 'Operacao de campo',
    'cards' => [
      ['icone' => 'ri-bear-smile-line', 'cor' => 'green', 'label' => 'Animais Cadastrados', 'valor' => '5.240'],
      ['icone' => 'ri-add-circle-line', 'cor' => 'blue', 'label' => 'Cadastros Hoje', 'valor' => '16'],
      ['icone' => 'ri-scales-3-line', 'cor' => 'orange', 'label' => 'Peso Medio', 'valor' => '412kg'],
      ['icone' => 'ri-checkbox-circle-line', 'cor' => 'red', 'label' => 'Manejos Feitos', 'valor' => '31'],
    ],
  ],
];

$dashboard = $dashboards[$papelUsuario] ?? $dashboards['operador'];
$avatar = strtoupper(substr($nomeUsuario, 0, 1));
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>GranBoi - Dashboard</title>

  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/pages/dashboard/dashboard.css">
   <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/global/style.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">

  <link
    rel="preconnect"
    href="https://fonts.gstatic.com"
    crossorigin
  >

  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
    rel="stylesheet"
  >

  <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"
    rel="stylesheet"
  >

</head>

<body>

  <div class="dashboard-container">

      <div class="card-info">
        <span>Total de Gado</span>
        <h2><?= htmlspecialchars($totalAnimais ?? 0) ?></h2>
      </div>

      <div class="logo">

        <div class="logo-icon">
          <i class="ri-leaf-line"></i>
        </div>

      <div class="card-icon blue">
        <i class="ri-heart-pulse-line"></i>
      </div>

      <div class="card-info">
        <span>Vacinas Pendentes</span>
        <h2>1</h2>
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
        <h2>Evolução do Rebanho</h2>
      </div>

      <div class="fake-chart">

        <div class="bar" style="height: 60%;"></div>
        <div class="bar" style="height: 90%;"></div>
        <div class="bar" style="height: 75%;"></div>
        <div class="bar" style="height: 100%;"></div>
        <div class="bar" style="height: 80%;"></div>
        <div class="bar" style="height: 65%;"></div>

      </div>

      <nav class="menu">

        <a
          href="<?= BASE_URL ?>/dashboard"
          class="menu-item active"
        >
          <i class="ri-dashboard-line"></i>
          <span>Dashboard</span>
        </a>

        <?php if (in_array($papelUsuario, ['administrador', 'gestor', 'veterinario', 'operador'], true)): ?>
          <a
            href="<?= BASE_URL ?>/animal"
            class="menu-item"
          >
            <i class="ri-bear-smile-line"></i>
            <span>Gado</span>
          </a>
        <?php endif; ?>

        <?php if (in_array($papelUsuario, ['administrador', 'veterinario'], true)): ?>
          <a
            href="<?= BASE_URL ?>/vacinas"
            class="menu-item"
          >
            <i class="ri-heart-pulse-line"></i>
            <span>Vacinacao</span>
          </a>
        <?php endif; ?>

        <?php if (in_array($papelUsuario, ['administrador', 'gestor'], true)): ?>
          <a
            href="<?= BASE_URL ?>/financeiro"
            class="menu-item"
          >
            <i class="ri-line-chart-line"></i>
            <span>Financeiro</span>
          </a>
        <?php endif; ?>

        <?php if (in_array($papelUsuario, ['administrador', 'gestor'], true)): ?>
          <a
            href="<?= BASE_URL ?>/relatorios"
            class="menu-item"
          >
            <i class="ri-file-chart-line"></i>
            <span>Relatorios</span>
          </a>
        <?php endif; ?>

        <a
          href="<?= BASE_URL ?>/profile"
          class="menu-item"
        >
          <i class="ri-user-line"></i>
          <span>Perfil</span>
        </a>

      </nav>

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
          <?= htmlspecialchars($animal['status']) ?>
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

      <section class="cards">

        <?php foreach ($dashboard['cards'] as $card): ?>
          <div class="card">

            <div class="card-icon <?= htmlspecialchars($card['cor']) ?>">
              <i class="<?= htmlspecialchars($card['icone']) ?>"></i>
            </div>

            <div class="card-info">
              <span><?= htmlspecialchars($card['label']) ?></span>
              <h2><?= htmlspecialchars($card['valor']) ?></h2>
            </div>

          </div>
        <?php endforeach; ?>

      </section>

      <section class="content-grid">

        <div class="chart-box">

          <div class="section-header">
            <h2>Evolução do Rebanho</h2>
          </div>

          <div class="fake-chart">

            <div class="bar" style="height: 60%;"></div>
            <div class="bar" style="height: 90%;"></div>
            <div class="bar" style="height: 75%;"></div>
            <div class="bar" style="height: 100%;"></div>
            <div class="bar" style="height: 80%;"></div>
            <div class="bar" style="height: 65%;"></div>

          </div>

        </div>

        <div class="table-box">

          <div class="section-header">
            <h2>Últimos Registros</h2>
          </div>

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

              <tr>

                <td>#1023</td>
                <td>Nelore</td>
                <td>410kg</td>

                <td>
                  <span class="status healthy">
                    Saudável
                  </span>
                </td>

              </tr>

              <tr>

                <td>#2045</td>
                <td>Angus</td>
                <td>450kg</td>

                <td>
                  <span class="status vaccine">
                    Vacina
                  </span>
                </td>

              </tr>

              <tr>

                <td>#8741</td>
                <td>Brahman</td>
                <td>390kg</td>

                <td>
                  <span class="status alert">
                    Atenção
                  </span>
                </td>

              </tr>

            </tbody>

          </table>

        </div>

      </section>

    </main>

  </div>

  <script src="<?= BASE_URL ?>/public/assets/js/pages/dashboard/dashboard.js"></script>

</body>

</html>
