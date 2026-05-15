<main class="main-content financeiro-page">

  <header class="topbar">

    <button
      class="menu-toggle"
      id="menuToggle"
    >
      <i class="ri-menu-line"></i>
    </button>

    <div class="topbar-title">

      <h1>Financeiro</h1>

      <p>
        Acompanhe custos, receitas e resultados da fazenda
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

  <section class="financeiro-page-actions">

    <div>
      <h2>Resumo Financeiro</h2>
      <p>
        Área administrativa para controle econômico da propriedade.
      </p>
    </div>

  </section>

  <section class="financeiro-summary-grid">

    <div class="financeiro-summary-card">

      <div class="financeiro-summary-icon green">
        <i class="ri-money-dollar-circle-line"></i>
      </div>

      <div>
        <span>Receitas Registradas</span>
        <strong>Em estruturação</strong>
        <p>Base futura: vendas de animais e movimentações financeiras.</p>
      </div>

    </div>

    <div class="financeiro-summary-card">

      <div class="financeiro-summary-icon red">
        <i class="ri-bank-card-line"></i>
      </div>

      <div>
        <span>Custos Sanitários</span>
        <strong>Em estruturação</strong>
        <p>Base futura: vacinas aplicadas e custos cadastrados.</p>
      </div>

    </div>

    <div class="financeiro-summary-card">

      <div class="financeiro-summary-icon blue">
        <i class="ri-line-chart-line"></i>
      </div>

      <div>
        <span>Resultado Financeiro</span>
        <strong>Em estruturação</strong>
        <p>Base futura: receitas menos despesas operacionais.</p>
      </div>

    </div>

  </section>

  <section class="financeiro-info-grid">

    <div class="financeiro-table-card">

      <div class="section-header">

        <div>
          <h2>Fontes de Dados Financeiros</h2>
          <p>
            Informações do sistema que podem alimentar o financeiro.
          </p>
        </div>

      </div>

      <table class="financeiro-table">

        <thead>

          <tr>
            <th>Origem</th>
            <th>Dados disponíveis</th>
            <th>Situação</th>
          </tr>

        </thead>

        <tbody>

          <tr>
            <td>Animais</td>
            <td>Peso de entrada, peso de saída, valor de venda e status.</td>
            <td>
              <span class="financeiro-status planejamento">
                Base disponível
              </span>
            </td>
          </tr>

          <tr>
            <td>Vacinação</td>
            <td>Histórico sanitário, doses aplicadas e custo da vacina.</td>
            <td>
              <span class="financeiro-status planejamento">
                Base disponível
              </span>
            </td>
          </tr>

          <tr>
            <td>Pesagem</td>
            <td>Histórico de peso e evolução dos animais.</td>
            <td>
              <span class="financeiro-status apoio">
                Apoio gerencial
              </span>
            </td>
          </tr>

          <tr>
            <td>Manejo/Pasto</td>
            <td>Estrutura prevista no banco para custos de manejo e pasto.</td>
            <td>
              <span class="financeiro-status futuro">
                Futuro
              </span>
            </td>
          </tr>

        </tbody>

      </table>

    </div>

    <div class="financeiro-note-card">

      <div class="financeiro-note-icon">
        <i class="ri-information-line"></i>
      </div>

      <div>
        <h2>Observação</h2>

        <p>
          Esta área está reservada para a gestão financeira do GranBoi. Como o foco atual do sistema está no manejo do rebanho, pesagem, vacinação e controle de funcionários, o financeiro permanece como módulo administrativo em evolução.
        </p>

        <p>
          Para evitar dados fictícios, os valores financeiros serão exibidos somente quando as regras de receitas, despesas e vendas estiverem completamente definidas.
        </p>
      </div>

    </div>

  </section>

</main>