<?php
$abaAtiva = $_GET['aba'] ?? 'racas';

if (!in_array($abaAtiva, ['racas', 'lotes'])) {
  $abaAtiva = 'racas';
}
?>

<main class="main-content cadastros-page">

  <?php if (!empty($_SESSION['sucesso'])): ?>

    <div class="animal-message animal-message-success">
      <i class="ri-checkbox-circle-line"></i>
      <span><?= $_SESSION['sucesso'] ?></span>
    </div>

    <?php unset($_SESSION['sucesso']); ?>

  <?php endif; ?>

  <?php if (!empty($_SESSION['erro'])): ?>

    <div class="animal-message animal-message-error">
      <i class="ri-error-warning-line"></i>
      <span><?= $_SESSION['erro'] ?></span>
    </div>

    <?php unset($_SESSION['erro']); ?>

  <?php endif; ?>

  <section class="section-header-page cadastros-header">

    <div>
      <h1>Cadastros</h1>
      <p>Cadastre, edite e gerencie as raças e os lotes dos animais da fazenda.</p>
    </div>

  </section>

  <style>
    .cadastros-page {
      max-width: 1200px;
    }

    .cadastros-header {
      margin-bottom: 24px;
    }

    .cadastros-tabs-input {
      display: none;
    }

    .cadastros-tabs-nav {
      display: flex;
      align-items: center;
      gap: 14px;
      background: #ffffff;
      border-radius: 22px;
      padding: 10px;
      margin-bottom: 24px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.04);
      border: 1px solid #eef0ee;
      width: fit-content;
      max-width: 100%;
      flex-wrap: wrap;
    }

    .cadastros-tab-label {
      height: 48px;
      padding: 0 24px;
      border-radius: 16px;
      color: #35543b;
      font-weight: 800;
      display: inline-flex;
      align-items: center;
      gap: 9px;
      cursor: pointer;
      transition: 0.25s;
      white-space: nowrap;
    }

    .cadastros-tab-label i {
      font-size: 19px;
    }

    .cadastros-tab-label:hover {
      background: #f1f7f2;
      color: #0f5a22;
    }

    #tab-racas:checked ~ .cadastros-tabs-nav label[for="tab-racas"],
    #tab-lotes:checked ~ .cadastros-tabs-nav label[for="tab-lotes"] {
      background: #0f5a22;
      color: #ffffff;
      box-shadow: 0 8px 18px rgba(15, 90, 34, 0.22);
    }

    .cadastros-tab-content {
      display: none;
      animation: cadastrosFade 0.2s ease-in-out;
    }

    #tab-racas:checked ~ .cadastros-content-racas {
      display: block;
    }

    #tab-lotes:checked ~ .cadastros-content-lotes {
      display: block;
    }

    @keyframes cadastrosFade {
      from {
        opacity: 0;
        transform: translateY(6px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .cadastros-card {
      background: #ffffff;
      border-radius: 24px;
      padding: 28px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.04);
      border: 1px solid #eef0ee;
    }

    .cadastros-card + .cadastros-card {
      margin-top: 24px;
    }

    .cadastros-card-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
      margin-bottom: 24px;
    }

    .cadastros-card-title {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .cadastros-card-icon {
      width: 46px;
      height: 46px;
      border-radius: 15px;
      background: rgba(15, 90, 34, 0.10);
      color: #0f5a22;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .cadastros-card-icon i {
      font-size: 22px;
    }

    .cadastros-card-title h2 {
      font-size: 22px;
      color: #111;
      margin: 0;
    }

    .cadastros-card-title p {
      font-size: 14px;
      color: #666;
      margin-top: 4px;
    }

    .cadastros-form-grid {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 20px;
      align-items: end;
    }

    .cadastros-form-grid-lote {
      grid-template-columns: 1fr 1.4fr auto;
    }

    .cadastros-field {
      display: flex;
      flex-direction: column;
      gap: 10px;
      min-width: 0;
    }

    .cadastros-field label {
      font-weight: 700;
      color: #222;
      font-size: 14px;
    }

    .cadastros-field input {
      width: 100%;
      height: 52px;
      border: 1px solid #dde3dd;
      border-radius: 16px;
      padding: 0 16px;
      font-size: 15px;
      outline: none;
      transition: 0.25s;
      background: #fff;
    }

    .cadastros-field input:focus {
      border-color: #0f5a22;
      box-shadow: 0 0 0 4px rgba(15,90,34,0.08);
    }

    .cadastros-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      overflow: hidden;
      border-radius: 18px;
    }

    .cadastros-table thead {
      background: #f4f7f4;
    }

    .cadastros-table th {
      padding: 16px;
      font-size: 13px;
      color: #4d5a50;
      text-transform: uppercase;
      letter-spacing: 0.03em;
      border-bottom: 1px solid #e8ece8;
    }

    .cadastros-table td {
      padding: 16px;
      border-bottom: 1px solid #f0f1f0;
      vertical-align: middle;
    }

    .cadastros-table tbody tr:last-child td {
      border-bottom: none;
    }

    .cadastros-table tbody tr:hover {
      background: #fbfdfb;
    }

    .cadastros-name {
      font-weight: 800;
      color: #111;
    }

    .cadastros-description {
      color: #666;
      max-width: 360px;
      white-space: normal;
      line-height: 1.4;
    }

    .cadastros-actions {
      display: flex;
      align-items: center;
      gap: 8px;
      flex-wrap: wrap;
    }

    .cadastros-actions-form {
      display: flex;
      align-items: center;
      gap: 8px;
      flex-wrap: wrap;
    }

    .cadastros-inline-input {
      height: 42px;
      border: 1px solid #dde3dd;
      border-radius: 12px;
      padding: 0 12px;
      outline: none;
      min-width: 180px;
      transition: 0.25s;
    }

    .cadastros-inline-input:focus {
      border-color: #0f5a22;
      box-shadow: 0 0 0 4px rgba(15,90,34,0.08);
    }

    .cadastros-empty {
      text-align: center;
      color: #777;
      padding: 24px !important;
    }

    @media(max-width: 900px) {
      .cadastros-form-grid,
      .cadastros-form-grid-lote {
        grid-template-columns: 1fr;
      }

      .cadastros-tabs-nav {
        width: 100%;
      }

      .cadastros-tab-label {
        flex: 1;
        justify-content: center;
      }

      .cadastros-card {
        padding: 22px;
      }

      .cadastros-card-header {
        align-items: flex-start;
        flex-direction: column;
      }

      .cadastros-actions,
      .cadastros-actions-form {
        flex-direction: column;
        align-items: stretch;
      }

      .cadastros-inline-input,
      .cadastros-actions .action-btn {
        width: 100%;
      }
    }
  </style>

  <input
    type="radio"
    name="cadastros_tabs"
    id="tab-racas"
    class="cadastros-tabs-input"
    <?= $abaAtiva === 'racas' ? 'checked' : '' ?>
  >

  <input
    type="radio"
    name="cadastros_tabs"
    id="tab-lotes"
    class="cadastros-tabs-input"
    <?= $abaAtiva === 'lotes' ? 'checked' : '' ?>
  >

  <div class="cadastros-tabs-nav">

    <label for="tab-racas" class="cadastros-tab-label">
      <i class="ri-git-branch-line"></i>
      <span>Raças</span>
    </label>

    <label for="tab-lotes" class="cadastros-tab-label">
      <i class="ri-stack-line"></i>
      <span>Lotes</span>
    </label>

  </div>

  <div class="cadastros-tab-content cadastros-content-racas">

    <section class="cadastros-card">

      <div class="cadastros-card-header">

        <div class="cadastros-card-title">
          <div class="cadastros-card-icon">
            <i class="ri-git-branch-line"></i>
          </div>

          <div>
            <h2>Cadastrar nova raça</h2>
            <p>Adicione uma raça para usar no cadastro dos animais.</p>
          </div>
        </div>

      </div>

      <form method="POST" action="<?= BASE_URL ?>/racas/salvar">

        <div class="cadastros-form-grid">

          <div class="cadastros-field">
            <label for="nome_raca">Nome da raça</label>
            <input
              type="text"
              id="nome_raca"
              name="nome_raca"
              placeholder="Ex: Nelore"
              required
            >
          </div>

          <button type="submit" class="save-btn">
            Cadastrar Raça
          </button>

        </div>

      </form>

    </section>

    <section class="cadastros-card">

      <div class="cadastros-card-header">

        <div class="cadastros-card-title">
          <div class="cadastros-card-icon">
            <i class="ri-list-check-2"></i>
          </div>

          <div>
            <h2>Raças cadastradas</h2>
            <p>Atualize ou exclua as raças cadastradas no sistema.</p>
          </div>
        </div>

      </div>

      <div class="table-responsive">

        <table class="cadastros-table">

          <thead>

            <tr>
              <th>Nome da raça</th>
              <th>Ações</th>
            </tr>

          </thead>

          <tbody>

            <?php if (!empty($racas)): ?>

              <?php foreach ($racas as $raca): ?>

                <tr>

                  <td>
                    <span class="cadastros-name">
                      <?= htmlspecialchars($raca['nome_raca']) ?>
                    </span>
                  </td>

                  <td>

                    <div class="cadastros-actions">

                      <form
                        method="POST"
                        action="<?= BASE_URL ?>/racas/atualizar"
                        class="cadastros-actions-form"
                      >

                        <input
                          type="hidden"
                          name="id"
                          value="<?= htmlspecialchars($raca['id']) ?>"
                        >

                        <input
                          type="text"
                          name="nome_raca"
                          value="<?= htmlspecialchars($raca['nome_raca']) ?>"
                          required
                          class="cadastros-inline-input"
                        >

                        <button type="submit" class="action-btn">
                          Atualizar
                        </button>

                      </form>

                      <form
                        method="POST"
                        action="<?= BASE_URL ?>/racas/excluir"
                        onsubmit="return confirm('Tem certeza que deseja excluir esta raça?');"
                      >

                        <input
                          type="hidden"
                          name="id"
                          value="<?= htmlspecialchars($raca['id']) ?>"
                        >

                        <button type="submit" class="action-btn btn-danger">
                          Excluir
                        </button>

                      </form>

                    </div>

                  </td>

                </tr>

              <?php endforeach; ?>

            <?php else: ?>

              <tr>
                <td colspan="2" class="cadastros-empty">
                  Nenhuma raça cadastrada.
                </td>
              </tr>

            <?php endif; ?>

          </tbody>

        </table>

      </div>

    </section>

  </div>

  <div class="cadastros-tab-content cadastros-content-lotes">

    <section class="cadastros-card">

      <div class="cadastros-card-header">

        <div class="cadastros-card-title">
          <div class="cadastros-card-icon">
            <i class="ri-stack-line"></i>
          </div>

          <div>
            <h2>Cadastrar novo lote</h2>
            <p>Adicione lotes para organizar os animais da fazenda.</p>
          </div>
        </div>

      </div>

      <form method="POST" action="<?= BASE_URL ?>/lotes/salvar">

        <div class="cadastros-form-grid cadastros-form-grid-lote">

          <div class="cadastros-field">
            <label for="nome_lote">Nome do lote</label>
            <input
              type="text"
              id="nome_lote"
              name="nome_lote"
              placeholder="Ex: Lote A"
              required
            >
          </div>

          <div class="cadastros-field">
            <label for="descricao">Descrição</label>
            <input
              type="text"
              id="descricao"
              name="descricao"
              placeholder="Ex: Animais em fase de engorda"
            >
          </div>

          <button type="submit" class="save-btn">
            Cadastrar Lote
          </button>

        </div>

      </form>

    </section>

    <section class="cadastros-card">

      <div class="cadastros-card-header">

        <div class="cadastros-card-title">
          <div class="cadastros-card-icon">
            <i class="ri-list-check-2"></i>
          </div>

          <div>
            <h2>Lotes cadastrados</h2>
            <p>Atualize ou exclua os lotes cadastrados no sistema.</p>
          </div>
        </div>

      </div>

      <div class="table-responsive">

        <table class="cadastros-table">

          <thead>

            <tr>
              <th>Nome do lote</th>
              <th>Descrição</th>
              <th>Ações</th>
            </tr>

          </thead>

          <tbody>

            <?php if (!empty($lotes)): ?>

              <?php foreach ($lotes as $lote): ?>

                <tr>

                  <td>
                    <span class="cadastros-name">
                      <?= htmlspecialchars($lote['nome_lote']) ?>
                    </span>
                  </td>

                  <td>
                    <span class="cadastros-description">
                      <?= !empty($lote['descricao']) ? htmlspecialchars($lote['descricao']) : '-' ?>
                    </span>
                  </td>

                  <td>

                    <div class="cadastros-actions">

                      <form
                        method="POST"
                        action="<?= BASE_URL ?>/lotes/atualizar"
                        class="cadastros-actions-form"
                      >

                        <input
                          type="hidden"
                          name="id"
                          value="<?= htmlspecialchars($lote['id']) ?>"
                        >

                        <input
                          type="text"
                          name="nome_lote"
                          value="<?= htmlspecialchars($lote['nome_lote']) ?>"
                          required
                          class="cadastros-inline-input"
                        >

                        <input
                          type="text"
                          name="descricao"
                          value="<?= htmlspecialchars($lote['descricao'] ?? '') ?>"
                          placeholder="Descrição"
                          class="cadastros-inline-input"
                        >

                        <button type="submit" class="action-btn">
                          Atualizar
                        </button>

                      </form>

                      <form
                        method="POST"
                        action="<?= BASE_URL ?>/lotes/excluir"
                        onsubmit="return confirm('Tem certeza que deseja excluir este lote?');"
                      >

                        <input
                          type="hidden"
                          name="id"
                          value="<?= htmlspecialchars($lote['id']) ?>"
                        >

                        <button type="submit" class="action-btn btn-danger">
                          Excluir
                        </button>

                      </form>

                    </div>

                  </td>

                </tr>

              <?php endforeach; ?>

            <?php else: ?>

              <tr>
                <td colspan="3" class="cadastros-empty">
                  Nenhum lote cadastrado.
                </td>
              </tr>

            <?php endif; ?>

          </tbody>

        </table>

      </div>

    </section>

  </div>

</main>