<main class="main-content">

  <header class="topbar">

    <button
      class="menu-toggle"
      id="menuToggle"
    >
      <i class="ri-menu-line"></i>
    </button>

    <div class="topbar-title">

      <h1>Dashboard</h1>

      <p>
        Visão geral do sistema
      </p>

    </div>

    <div class="profile">

      <div class="profile-info">
        <h3><?= $_SESSION['usuario']['nome'] ?? 'Usuário' ?></h3>
        <span><?= $_SESSION['usuario']['papel_nome'] ?? 'Perfil' ?></span>
      </div>

      <div class="profile-avatar">
        <?= strtoupper(substr($_SESSION['usuario']['nome'] ?? 'U', 0, 1)) ?>
      </div>

    </div>

  </header>

  <section class="cards">

    <div class="card">

      <div class="card-icon green">
        <i class="ri-bear-smile-line"></i>
      </div>

      <div class="card-info">
        <span>Total de Gado</span>
        <h2>3</h2>
      </div>

    </div>

    <div class="card">

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
        <h2>416kg</h2>
      </div>

    </div>

    <div class="card">

      <div class="card-icon red">
        <i class="ri-line-chart-line"></i>
      </div>

      <div class="card-info">
        <span>GMD Médio</span>
        <h2>0,83kg/dia</h2>
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