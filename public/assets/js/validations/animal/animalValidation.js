function validarDataNascimento(dataNascimento) {
  if (!dataNascimento) {
    return null;
  }

  const hoje = new Date();
  hoje.setHours(0, 0, 0, 0);

  const dataInformada =
    new Date(dataNascimento + 'T00:00:00');

  if (dataInformada > hoje) {
    return 'A data de nascimento não pode ser uma data futura.';
  }

  return null;
}

function validarPesoAnimal(peso) {
  if (!peso) {
    return 'O peso é obrigatório.';
  }

  if (Number(peso) <= 0) {
    return 'O peso de entrada deve ser maior que zero.';
  }

  return null;
}

function validarCadastroAnimal() {
  const brinco =
    document.getElementById('brinco')?.value.trim();

  const sexo =
    document.getElementById('sexo')?.value;

  const peso =
    document.getElementById('peso_entrada')?.value;

  const dataNascimento =
    document.getElementById('data_nascimento')?.value;

  if (!brinco || !sexo || !peso) {
    return 'Preencha os campos obrigatórios: brinco, sexo e peso.';
  }

  const erroPeso =
    validarPesoAnimal(peso);

  if (erroPeso) {
    return erroPeso;
  }

  const erroData =
    validarDataNascimento(dataNascimento);

  if (erroData) {
    return erroData;
  }

  return null;
}

function validarEdicaoAnimal() {
  const brinco =
    document.getElementById('editar_brinco_hidden')?.value.trim();

  const sexo =
    document.getElementById('editar_sexo')?.value;

  const peso =
  document.getElementById('editar_peso_entrada_hidden')?.value;

  const status =
    document.getElementById('editar_status')?.value;

  const dataNascimento =
    document.getElementById('editar_data_nascimento')?.value;

  if (!brinco || !sexo || !peso || !status) {
    return 'Preencha os campos obrigatórios: brinco, sexo, peso e status.';
  }

  const erroPeso =
    validarPesoAnimal(peso);

  if (erroPeso) {
    return erroPeso;
  }

  const erroData =
    validarDataNascimento(dataNascimento);

  if (erroData) {
    return erroData;
  }

  return null;
}