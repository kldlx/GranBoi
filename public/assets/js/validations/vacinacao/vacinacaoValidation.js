function validarCadastroVacinacao() {
  const animalId = document.getElementById('animal_id')?.value;
  const vacina = document.getElementById('vacina')?.value.trim();
  const dataAplicacao = document.getElementById('data_aplicacao')?.value;
  const proximaDose = document.getElementById('proxima_dose')?.value;
  const quantidade = document.getElementById('quantidade')?.value.trim();

  if (!animalId || !vacina || !dataAplicacao) {
    return 'Preencha os campos obrigatórios: animal, vacina e data de aplicação.';
  }

  if (!quantidade) {
    return 'Informe a quantidade/dose aplicada.';
  }

  if (isNaN(quantidade) || Number(quantidade) <= 0) {
    return 'Informe uma quantidade/dose maior que zero.';
  }

  const hoje = new Date();
  hoje.setHours(0, 0, 0, 0);

  const dataAplicacaoObj = new Date(dataAplicacao + 'T00:00:00');

  if (dataAplicacaoObj > hoje) {
    return 'A data de aplicação não pode ser futura.';
  }

  if (proximaDose) {
    const proximaDoseObj = new Date(proximaDose + 'T00:00:00');

    if (proximaDoseObj < dataAplicacaoObj) {
      return 'A próxima dose não pode ser anterior à data de aplicação.';
    }
  }

  return null;
}