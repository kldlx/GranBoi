<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>GranBoi - Cadastros dos Gados</title>
  <link rel="stylesheet" href="<?=BASE_URL?>../../public/assets/css/index.css">

</head>
<body>

<header>
  <h1>GranBoi</h1>
</header>

<nav class="nav">
  <a href="homeGranboi.php">Início</a>
  <a href="cadastroBoi.php">Cadastrar Gado</a>
  <a href="verBoi.php" class="active">Gados Cadastrados</a>
  <a href="#">Cadastros dos Funcionários</a>
  <a href="#">Relatórios</a>
</nav>

<div class="container">

  <div class="welcome">
    <h2> Gados Cadastrados</h2>
    <br>
  </div>

  <!-- Estatísticas -->
  <div class="container">

    <div class="stats">
      <div class="stat-card">
        <div>Total de Animais</div>
        <div class="stat-number" id="totalAnimais">0</div>
      </div>
      <div class="stat-card">
        <div>Fêmeas</div>
        <div class="stat-number" id="totalFemeas">0</div>
      </div>
      <div class="stat-card">
        <div>Machos</div>
        <div class="stat-number" id="totalMachos">0</div>
      </div>
    </div>

  <!-- Filtros com botão Procurar -->
  <div class="card">
    <div class="card-header">Filtros</div>
    <div class="form-grid" style="padding-bottom: 1rem;">
      <div>
        <label>Buscar por Brinco ou Nome</label>
        <input type="text" id="filtroBusca" placeholder="Digite brinco ou nome...">
      </div>
      <div>
        <label>Sexo</label>
        <select id="filtroSexo">
          <option value="">Todos os sexos</option>
          <option value="Fêmea">Fêmea</option>
          <option value="Macho">Macho</option>
        </select>
      </div>
    </div>

    <div style="padding: 0 1.5rem 1.5rem;">
      <button class="btn-primary" onclick="procurarAnimais()">
        🔍 Procurar
      </button>
      <button class="btn-danger" onclick="limparFiltros()" style="margin-left: 10px;">
        Limpar Filtros
      </button>
    </div>
  </div>

  <!-- Tabela de Animais -->
  <div class="card">
    <div class="card-header">Animais Cadastrados</div>
    <div id="listaAnimais">
      <div class="empty-message">Nenhum animal cadastrado ainda.</div>
    </div>
  </div>
        
      <!-- Preenchido via JavaScript -->
    </div>
  </div>

</div>
<br><br><br>

<!-- Botão Voltar ao Home - Fixo no final -->
<a href="homeGranboi.html" class="btn-voltar-home-fixo">
  Voltar ao Início
</a>

<script>
// ====================== CONFIGURAÇÃO ======================
const STORAGE_KEY = "pecuaria_animais_2025";
let animais = JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];

// ====================== FUNÇÕES ======================
function calcularIdade(dataNasc) {
  if (!dataNasc) return '-';
  const hoje = new Date();
  const nasc = new Date(dataNasc);
  let idade = hoje.getFullYear() - nasc.getFullYear();
  const mes = hoje.getMonth() - nasc.getMonth();
  if (mes < 0 || (mes === 0 && hoje.getDate() < nasc.getDate())) {
    idade--;
  }
  return idade + (idade === 1 ? ' ano' : ' anos');
}

function atualizarEstatisticas() {
  const total = animais.length;
  const femeas = animais.filter(a => a.sexo === 'Fêmea').length;
  const machos = animais.filter(a => a.sexo === 'Macho').length;

  document.getElementById('totalAnimais').textContent = total;
  document.getElementById('totalFemeas').textContent = femeas;
  document.getElementById('totalMachos').textContent = machos;
}

function excluirAnimal(index) {
  if (!confirm("Deseja realmente excluir este animal?")) return;
  
  animais.splice(index, 1);
  localStorage.setItem(STORAGE_KEY, JSON.stringify(animais));
  renderizarLista();
}

function renderizarTabela(animaisFiltrados) {
  const container = document.getElementById("listaAnimais");
  
  if (animaisFiltrados.length === 0) {
    container.innerHTML = `<div class="empty-message">Nenhum animal encontrado.</div>`;
    document.getElementById('contagemAnimais').textContent = 0;
    return;
  }

  let html = `
    <table>
      <thead>
        <tr>
          <th>Brinco</th>
          <th>Nome</th>
          <th>Sexo</th>
          <th>Raça</th>
          <th>Data de Nascimento</th>
          <th>Peso Inicial (kg)</th>
          <th>Idade</th>
          <th class="actions">Ações</th>
        </tr>
      </thead>
      <tbody>
  `;

  animaisFiltrados.forEach((animal) => {
    const idade = calcularIdade(animal.nascimento);
    const indexOriginal = animais.indexOf(animal);
    
    html += `
      <tr>
        <td><strong>${animal.brinco}</strong></td>
        <td>${animal.nome || '-'}</td>
        <td>${animal.sexo}</td>
        <td>${animal.raca || '-'}</td>
        <td>${animal.nascimento || '-'}</td>
        <td>${animal.peso ? animal.peso + ' kg' : '-'}</td>
        <td>${idade}</td>
        <td class="actions">
          <button class="btn-danger" onclick="excluirAnimal(${indexOriginal})">Excluir</button>
        </td>
      </tr>
    `;
  });

  html += `</tbody></table>`;
  container.innerHTML = html;
  document.getElementById('contagemAnimais').textContent = animaisFiltrados.length;
}

function procurarAnimais() {
  const termo = document.getElementById('filtroBusca').value.toLowerCase().trim();
  const sexoFiltro = document.getElementById('filtroSexo').value;

  let filtrados = animais;

  // Filtro por busca (brinco ou nome)
  if (termo) {
    filtrados = filtrados.filter(a => 
      a.brinco.toLowerCase().includes(termo) || 
      (a.nome && a.nome.toLowerCase().includes(termo))
    );
  }

  // Filtro por sexo
  if (sexoFiltro) {
    filtrados = filtrados.filter(a => a.sexo === sexoFiltro);
  }

  renderizarTabela(filtrados);
}

function limparFiltros() {
  document.getElementById('filtroBusca').value = '';
  document.getElementById('filtroSexo').value = '';
  procurarAnimais(); // Atualiza mostrando todos novamente
}

function excluirAnimal(index) {
  if (!confirm("Deseja realmente excluir este animal?")) return;
  
  animais.splice(index, 1);
  localStorage.setItem(STORAGE_KEY, JSON.stringify(animais));
  
  // Atualiza a tabela com os filtros atuais
  procurarAnimais();
  atualizarEstatisticas();
}

// ====================== INICIALIZAÇÃO ======================
function inicializarPagina() {
  atualizarEstatisticas();
  renderizarTabela(animais);   // Mostra todos os animais ao carregar
}

// Carrega a página
inicializarPagina();
</script>

</body>
</html>