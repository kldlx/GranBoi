function validarCadastroVacinacao() {
  const animalId = document.getElementById('animal_id')?.value;
  const vacina = document.getElementById('vacina')?.value.trim();
  const dataAplicacao = document.getElementById('data_aplicacao')?.value;
  const proximaDose = document.getElementById('proxima_dose')?.value;
  const viaAplicacao = document.getElementById('via_aplicacao')?.value;

  if (!animalId || !vacina || !dataAplicacao) {
    return 'Preencha os campos obrigatórios: animal, vacina e data de aplicação.';
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

  if (
    viaAplicacao &&
    !['subcutanea', 'intramuscular', 'oral'].includes(viaAplicacao)
  ) {
    return 'Selecione uma via de aplicação válida.';
  }

  return null;
}