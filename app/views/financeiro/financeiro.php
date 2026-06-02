<main class="main-content financeiro-page">

  <header class="topbar">
    <button class="menu-toggle" id="menuToggle"><i class="ri-menu-line"></i></button>
    <div class="topbar-title">
      <h1>Financeiro</h1>
      <p>Acompanhe custos, receitas e resultados da fazenda</p>
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

  <?php if (!empty($_SESSION['sucesso'])): ?>
    <div class="financeiro-message financeiro-message-success">
      <i class="ri-checkbox-circle-line"></i>
      <span><?= $_SESSION['sucesso'] ?></span>
    </div>
    <?php unset($_SESSION['sucesso']); ?>
  <?php endif; ?>

  <?php if (!empty($_SESSION['erro'])): ?>
    <div class="financeiro-message financeiro-message-error">
      <i class="ri-error-warning-line"></i>
      <span><?= $_SESSION['erro'] ?></span>
    </div>
    <?php unset($_SESSION['erro']); ?>
  <?php endif; ?>

  <section class="financeiro-page-actions">
    <div>
      <h2>Resumo Financeiro</h2>
      <p>Controle econômico baseado nos dados registrados no sistema.</p>
    </div>
  </section>

  <p class="financeiro-section-label">Visão Geral</p>

  <section class="financeiro-summary-grid">

    <div class="financeiro-summary-card">
      <div class="financeiro-summary-icon green"><i class="ri-money-dollar-circle-line"></i></div>
      <div>
        <span>Receitas (Vendas)</span>
        <strong>R$ <?= number_format($totalReceitas, 2, ',', '.') ?></strong>
        <p>Total arrecadado com venda de animais.</p>
      </div>
    </div>

    <div class="financeiro-summary-card">
      <div class="financeiro-summary-icon red"><i class="ri-bank-card-line"></i></div>
      <div>
        <span>Total de Despesas</span>
        <strong>R$ <?= number_format($totalDespesas, 2, ',', '.') ?></strong>
        <p>Sanitário, manejo, pasto e operacional somados.</p>
      </div>
    </div>

    <div class="financeiro-summary-card financeiro-summary-card--resultado">
      <div class="financeiro-summary-icon"><i class="ri-line-chart-line"></i></div>
      <div>
        <span>Resultado Financeiro</span>
        <strong>R$ <?= number_format($resultado, 2, ',', '.') ?></strong>
        <p>Receitas menos total de despesas.</p>
      </div>
    </div>

  </section>

  <hr class="financeiro-divider">

  <p class="financeiro-section-label">Detalhamento de Despesas</p>

  <section class="financeiro-custos-grid">

    <div class="financeiro-summary-card">
      <div class="financeiro-summary-icon red"><i class="ri-syringe-line"></i></div>
      <div>
        <span>Custos Sanitários</span>
        <strong>R$ <?= number_format($totalSanitario, 2, ',', '.') ?></strong>
        <p>Soma dos custos de vacinação registrados.</p>
      </div>
    </div>

    <div class="financeiro-summary-card">
      <div class="financeiro-summary-icon orange"><i class="ri-route-line"></i></div>
      <div>
        <span>Custos de Manejo</span>
        <strong>R$ <?= number_format($totalManejo, 2, ',', '.') ?></strong>
        <p>Soma dos custos de manejo de lotes.</p>
      </div>
    </div>

    <div class="financeiro-summary-card">
      <div class="financeiro-summary-icon blue"><i class="ri-plant-line"></i></div>
      <div>
        <span>Custos de Pasto</span>
        <strong>R$ <?= number_format($totalPasto, 2, ',', '.') ?></strong>
        <p>Soma dos custos mensais dos pastos cadastrados.</p>
      </div>
    </div>

    <div class="financeiro-summary-card">
      <div class="financeiro-summary-icon orange"><i class="ri-file-list-3-line"></i></div>
      <div>
        <span>Despesas Operacionais</span>
        <strong>R$ <?= number_format($totalOperacional, 2, ',', '.') ?></strong>
        <p>Ração, medicamentos, mão de obra, transporte e outros.</p>
      </div>
    </div>

  </section>

  <hr class="financeiro-divider">

  <p class="financeiro-section-label">Despesas Operacionais</p>

  <!-- Nova Despesa -->
  <div class="financeiro-table-card financeiro-mb">
    <div class="section-header">
      <div>
        <h2>Nova Despesa</h2>
        <p>Registre custos de ração, medicamentos, mão de obra, transporte e outros</p>
      </div>
    </div>

    <div class="financeiro-form-message" id="despesaFormMessage" hidden></div>

    <form id="formDespesa" action="<?= BASE_URL ?>/financeiro/salvar-despesa" method="POST">
      <div class="financeiro-form-grid">

        <div class="financeiro-form-group financeiro-form-group--full">
          <label for="despesa_descricao">Descrição *</label>
          <input type="text" id="despesa_descricao" name="descricao" placeholder="Ex: Compra de ração concentrada" required>
        </div>

        <div class="financeiro-form-group">
          <label for="despesa_categoria">Categoria *</label>
          <select id="despesa_categoria" name="categoria" required>
            <option value="">Selecione</option>
            <option value="Alimentação">Alimentação</option>
            <option value="Sanidade">Sanidade</option>
            <option value="Mão de obra">Mão de obra</option>
            <option value="Equipamento">Equipamento</option>
            <option value="Transporte">Transporte</option>
            <option value="Manutenção">Manutenção</option>
            <option value="Outros">Outros</option>
          </select>
        </div>

        <div class="financeiro-form-group">
          <label for="despesa_valor">Valor (R$) *</label>
          <input type="number" id="despesa_valor" name="valor" step="0.01" min="0.01" placeholder="Ex: 1500.00" required>
        </div>

        <div class="financeiro-form-group">
          <label for="despesa_data">Data *</label>
          <input type="date" id="despesa_data" name="data_despesa" value="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>" required>
        </div>

        <div class="financeiro-form-group">
          <label for="despesa_lote">Lote (opcional)</label>
          <select id="despesa_lote" name="lote_id">
            <option value="">Nenhum</option>
            <?php foreach ($lotes as $lote): ?>
              <option value="<?= htmlspecialchars($lote['id']) ?>"><?= htmlspecialchars($lote['nome_lote']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="financeiro-form-group financeiro-form-group--full">
          <label for="despesa_observacao">Observação</label>
          <textarea id="despesa_observacao" name="observacao" placeholder="Detalhes adicionais sobre a despesa..."></textarea>
        </div>

      </div>
      <button type="submit" class="financeiro-submit-btn">
        <i class="ri-save-line"></i> Registrar Despesa
      </button>
    </form>
  </div>

  <!-- Despesas Registradas -->
  <div class="financeiro-table-card financeiro-mb">
    <div class="section-header">
      <div>
        <h2>Despesas Registradas</h2>
        <p id="despesaContador"><?= count($ultimasDespesas) ?> registro<?= count($ultimasDespesas) !== 1 ? 's' : '' ?></p>
      </div>
      <input type="text" id="filtroDespesa" class="financeiro-filtro-input" placeholder="Buscar despesa...">
    </div>

    <div class="financeiro-table-scroll">
      <table class="financeiro-table" id="tabelaDespesas">
        <thead>
          <tr>
            <th>Data</th>
            <th>Descrição</th>
            <th>Categoria</th>
            <th>Lote</th>
            <th>Valor</th>
            <th></th>
          </tr>
        </thead>
        <tbody id="tabelaDespesasBody">
          <?php if (!empty($ultimasDespesas)): ?>
            <?php foreach ($ultimasDespesas as $despesa): ?>
              <tr>
                <td><?= date('d/m/Y', strtotime($despesa['data_despesa'])) ?></td>
                <td class="financeiro-td-descricao" title="<?= htmlspecialchars($despesa['descricao']) ?>"><?= htmlspecialchars($despesa['descricao']) ?></td>
                <td><span class="financeiro-categoria-badge"><?= htmlspecialchars($despesa['categoria']) ?></span></td>
                <td><?= htmlspecialchars($despesa['nome_lote'] ?? '-') ?></td>
                <td class="financeiro-negativo">R$ <?= number_format((float) $despesa['valor'], 2, ',', '.') ?></td>
                <td class="financeiro-td-acoes">
                  <button class="financeiro-btn-acao financeiro-btn-editar" title="Editar"
                    data-id="<?= $despesa['id'] ?>"
                    data-descricao="<?= htmlspecialchars($despesa['descricao']) ?>"
                    data-categoria="<?= htmlspecialchars($despesa['categoria']) ?>"
                    data-valor="<?= $despesa['valor'] ?>"
                    data-data="<?= $despesa['data_despesa'] ?>"
                    data-observacao="<?= htmlspecialchars($despesa['observacao'] ?? '') ?>"
                    data-lote="<?= $despesa['lote_id'] ?? '' ?>"
                  ><i class="ri-pencil-line"></i></button>
                  <button class="financeiro-btn-acao financeiro-btn-excluir" title="Excluir"
                    data-id="<?= $despesa['id'] ?>"
                    data-descricao="<?= htmlspecialchars($despesa['descricao']) ?>"
                  ><i class="ri-delete-bin-line"></i></button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="6" class="financeiro-empty">Nenhuma despesa operacional registrada.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <div class="financeiro-paginacao" id="paginacaoWrap">
      <span id="paginacaoInfo" class="financeiro-paginacao-info"></span>
      <div class="financeiro-paginacao-btns">
        <button id="paginacaoAnterior" class="fin-btn fin-btn-cancel"><i class="ri-arrow-left-s-line"></i> Anterior</button>
        <button id="paginacaoProximo" class="fin-btn fin-btn-cancel">Próximo <i class="ri-arrow-right-s-line"></i></button>
      </div>
    </div>
  </div>

  <hr class="financeiro-divider">

  <!-- Últimas Vendas -->
  <p class="financeiro-section-label">Últimas Vendas</p>

  <div class="financeiro-table-card financeiro-mb">
    <div class="section-header">
      <div>
        <h2>Últimas Vendas</h2>
        <p>Animais vendidos com valor registrado</p>
      </div>
    </div>
    <table class="financeiro-table">
      <thead>
        <tr>
          <th>Brinco</th>
          <th>Raça</th>
          <th>Peso Saída (kg)</th>
          <th>Valor de Venda</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($ultimasVendas)): ?>
          <?php foreach ($ultimasVendas as $venda): ?>
            <tr>
              <td>#<?= htmlspecialchars($venda['brinco_identificador']) ?></td>
              <td><?= htmlspecialchars($venda['raca'] ?? '-') ?></td>
              <td><?= $venda['peso_saida'] > 0 ? number_format((float) $venda['peso_saida'], 3, ',', '.') : '-' ?></td>
              <td class="financeiro-positivo">R$ <?= number_format((float) $venda['valor_venda'], 2, ',', '.') ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="4" class="financeiro-empty">Nenhuma venda registrada.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Custos Sanitários -->
  <p class="financeiro-section-label">Custos Sanitários</p>

  <div class="financeiro-table-card">
    <div class="section-header">
      <div>
        <h2>Últimos Custos Sanitários</h2>
        <p>Vacinações com custo registrado</p>
      </div>
    </div>
    <table class="financeiro-table">
      <thead>
        <tr>
          <th>Data</th>
          <th>Animal</th>
          <th>Vacina</th>
          <th>Custo</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($ultimosCustosSanitarios)): ?>
          <?php foreach ($ultimosCustosSanitarios as $custo): ?>
            <tr>
              <td><?= date('d/m/Y', strtotime($custo['data_aplicacao'])) ?></td>
              <td>#<?= htmlspecialchars($custo['brinco_identificador']) ?></td>
              <td><?= htmlspecialchars($custo['vacina']) ?></td>
              <td class="financeiro-negativo">R$ <?= number_format((float) $custo['preco_custo_sanitario'], 2, ',', '.') ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="4" class="financeiro-empty">Nenhum custo sanitário registrado.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</main>

<!-- Modal Editar Despesa -->
<div class="fin-modal" id="modalEditarDespesa" hidden>
  <div class="fin-modal-overlay" id="overlayEditarDespesa"></div>
  <div class="fin-modal-container">
    <div class="fin-modal-header">
      <h2><i class="ri-pencil-line"></i> Editar Despesa</h2>
      <button class="fin-modal-close" id="fecharEditarDespesa"><i class="ri-close-line"></i></button>
    </div>
    <div class="fin-modal-body">
      <div class="financeiro-form-message" id="editarFormMessage" hidden></div>
      <form id="formEditarDespesa" action="<?= BASE_URL ?>/financeiro/editar-despesa" method="POST">
        <input type="hidden" name="id" id="editar_id">
        <div class="financeiro-form-grid">
          <div class="financeiro-form-group financeiro-form-group--full">
            <label>Descrição *</label>
            <input type="text" name="descricao" id="editar_descricao" required>
          </div>
          <div class="financeiro-form-group">
            <label>Categoria *</label>
            <select name="categoria" id="editar_categoria" required>
              <option value="">Selecione</option>
              <option value="Alimentação">Alimentação</option>
              <option value="Sanidade">Sanidade</option>
              <option value="Mão de obra">Mão de obra</option>
              <option value="Equipamento">Equipamento</option>
              <option value="Transporte">Transporte</option>
              <option value="Manutenção">Manutenção</option>
              <option value="Outros">Outros</option>
            </select>
          </div>
          <div class="financeiro-form-group">
            <label>Valor (R$) *</label>
            <input type="number" name="valor" id="editar_valor" step="0.01" min="0.01" required>
          </div>
          <div class="financeiro-form-group">
            <label>Data *</label>
            <input type="date" name="data_despesa" id="editar_data" max="<?= date('Y-m-d') ?>" required>
          </div>
          <div class="financeiro-form-group">
            <label>Lote (opcional)</label>
            <select name="lote_id" id="editar_lote">
              <option value="">Nenhum</option>
              <?php foreach ($lotes as $lote): ?>
                <option value="<?= htmlspecialchars($lote['id']) ?>"><?= htmlspecialchars($lote['nome_lote']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="financeiro-form-group financeiro-form-group--full">
            <label>Observação</label>
            <textarea name="observacao" id="editar_observacao" placeholder="Detalhes adicionais..."></textarea>
          </div>
        </div>
        <div class="fin-modal-footer">
          <button type="button" class="fin-btn fin-btn-cancel" id="cancelarEditarDespesa">Cancelar</button>
          <button type="submit" class="fin-btn fin-btn-save"><i class="ri-save-line"></i> Salvar alterações</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Excluir Despesa -->
<div class="fin-modal" id="modalExcluirDespesa" hidden>
  <div class="fin-modal-overlay" id="overlayExcluirDespesa"></div>
  <div class="fin-modal-container fin-modal-container--sm">
    <div class="fin-modal-header">
      <h2><i class="ri-delete-bin-line"></i> Excluir Despesa</h2>
      <button class="fin-modal-close" id="fecharExcluirDespesa"><i class="ri-close-line"></i></button>
    </div>
    <div class="fin-modal-body">
      <p class="fin-modal-confirm-text">Tem certeza que deseja excluir a despesa <strong id="excluir_descricao_texto"></strong>? Esta ação não pode ser desfeita.</p>
    </div>
    <div class="fin-modal-footer">
      <button type="button" class="fin-btn fin-btn-cancel" id="cancelarExcluirDespesa">Cancelar</button>
      <button type="button" class="fin-btn fin-btn-danger" id="confirmarExcluirDespesa"><i class="ri-delete-bin-line"></i> Excluir</button>
    </div>
  </div>
</div>
