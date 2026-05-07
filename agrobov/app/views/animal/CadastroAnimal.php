<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>GranBoi</title>
  <link rel="stylesheet" href="<?=BASE_URL?>../../public/assets/css/index.css">
</head>
<body>

<header>
  <h1>GranBoi</h1>
</header>
<div class="container">

  <div class="card">
    <div class="card-header">Cadastrar Animal</div>
    <div class="form-grid">
      <div>
        <label>Brinco / Identificação</label>
        <input type="text" id="brinco" placeholder="Ex: 456A" required>
      </div>
      <div>
        <label>Nome / Apelido (opcional)</label>
        <input type="text" id="nome" placeholder="Ex: Mimosa">
      </div>
      <div>
        <label>Sexo</label>
        <select id="sexo" required>
          <option value="">Selecione...</option>
          <option value="Fêmea">Fêmea</option>
          <option value="Macho">Macho</option>
        </select>
      </div>
      <div>
        <label>Raça</label>
        <input type="text" id="raca" placeholder="Ex: Nelore, Angus...">
      </div>
      <div>
        <label>Data de Nascimento</label>
        <input type="date" id="nascimento">
      </div>
      <div>
        <label>Peso De Inicio (kg)</label>
        <input type="number" id="peso" placeholder="Ex: 420" min="0" step="0.1">
      </div>
    </div>

    <div style="padding: 0 1.5rem 1.5rem;">
      <button class="btn-primary" a href="granboiCadastrosGados.html" onclick="salvarAnimal()" >Cadastrar Animal</button>
    </div>
  </div>

</div>
<br>

<!-- Botão Voltar ao Home - Fixo no final -->
<a href="homeGranboi.html" class="btn-voltar-home-fixo">
  Voltar ao Início
</a>

<script>
const STORAGE_KEY = "pecuaria_animais_2025";
let animais = JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];

function renderizarLista() {
  const container = document.getElementById("listaAnimais");
  if (animais.length === 0) {
    container.innerHTML = `<div class="empty-message">Nenhum animal cadastrado ainda.</div>`;
  } else {
    let html = `
      <table>
        <thead>
          <tr>
            <th>Brinco</th>
            <th>Nome</th>
            <th>Sexo</th>
            <th>Raça</th>
            <th>Nascimento</th>
            <th>Peso Inicial (kg)</th>
            <th>Idade</th>
            <th class="actions">Ações</th>
          </tr>
        </thead>
        <tbody>
    `;

    animais.forEach((animal, index) => {
      const idade = calcularIdade(animal.nascimento);
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
            <button class="btn-danger" onclick="excluirAnimal(${index})">Excluir</button>
          </td>
        </tr>
      `;
    });

    html += `</tbody></table>`;
    container.innerHTML = html;
  }

  atualizarEstatisticas();
}

function salvarAnimal() {
  const brinco    = document.getElementById('brinco').value.trim();
  const nome      = document.getElementById('nome').value.trim();
  const sexo      = document.getElementById('sexo').value;
  const raca      = document.getElementById('raca').value.trim();
  const nascimento = document.getElementById('nascimento').value;
  const peso      = document.getElementById('peso').value;

  if (!brinco || !sexo) {
    alert("Preencha Todos Os Campos");
    return;
  }

  // Verifica brinco duplicado
  if (animais.some(a => a.brinco === brinco)) {
    alert("Já existe um animal com este brinco!");
    return;
  }

  const novoAnimal = {
    brinco,
    nome,
    sexo,
    raca,
    nascimento,
    peso: peso ? Number(peso) : null
  };

  animais.push(novoAnimal);
  localStorage.setItem(STORAGE_KEY, JSON.stringify(animais));

  limparFormulario();
  renderizarLista();
}

function limparFormulario() {
  document.getElementById('brinco').value = '';
  document.getElementById('nome').value = '';
  document.getElementById('sexo').value = '';
  document.getElementById('raca').value = '';
  document.getElementById('nascimento').value = '';
  document.getElementById('peso').value = '';
}

// Inicialização
renderizarLista();
</script>



</body>
</html>