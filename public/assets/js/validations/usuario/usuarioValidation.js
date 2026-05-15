function limparNumeros(valor) {
  return String(valor || '').replace(/\D/g, '');
}

function validarEmailFuncionario(email) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  if (!emailRegex.test(email)) {
    return 'Informe um e-mail válido.';
  }

  return null;
}

function validarCpfFuncionario(cpf) {
  const cpfLimpo = limparNumeros(cpf);

  if (cpfLimpo.length !== 11) {
    return 'Informe um CPF válido com 11 dígitos.';
  }

  return null;
}

function validarTelefoneFuncionario(telefone) {
  const telefoneLimpo = limparNumeros(telefone);

  if (telefoneLimpo.length < 10 || telefoneLimpo.length > 11) {
    return 'Informe um telefone válido.';
  }

  return null;
}

function validarSenhaFuncionario(senha, confirmacao, obrigatoria = true) {
  if (!obrigatoria && !senha && !confirmacao) {
    return null;
  }

  if (!senha || !confirmacao) {
    return 'Informe e confirme a senha.';
  }

  if (senha.length < 6) {
    return 'A senha deve ter pelo menos 6 caracteres.';
  }

  if (senha !== confirmacao) {
    return 'A confirmação de senha não confere.';
  }

  return null;
}

function validarCadastroFuncionario() {
  const nomeCompleto = document.getElementById('nome_completo')?.value.trim();
  const cpf = document.getElementById('cpf')?.value.trim();
  const telefone = document.getElementById('telefone')?.value.trim();
  const email = document.getElementById('email')?.value.trim();
  const papelId = document.getElementById('papel_id')?.value;
  const senha = document.getElementById('senha')?.value;
  const senhaConfirmacao = document.getElementById('senha_confirmacao')?.value;

  if (!nomeCompleto || !cpf || !telefone || !email || !papelId) {
    return 'Preencha os campos obrigatórios: nome, CPF, telefone, e-mail e função.';
  }

  const erroCpf = validarCpfFuncionario(cpf);

  if (erroCpf) {
    return erroCpf;
  }

  const erroTelefone = validarTelefoneFuncionario(telefone);

  if (erroTelefone) {
    return erroTelefone;
  }

  const erroEmail = validarEmailFuncionario(email);

  if (erroEmail) {
    return erroEmail;
  }

  const erroSenha = validarSenhaFuncionario(
    senha,
    senhaConfirmacao,
    true
  );

  if (erroSenha) {
    return erroSenha;
  }

  return null;
}

function validarEdicaoFuncionario() {
  const nomeCompleto = document.getElementById('editar_nome_completo')?.value.trim();
  const cpf = document.getElementById('editar_cpf')?.value.trim();
  const telefone = document.getElementById('editar_telefone')?.value.trim();
  const email = document.getElementById('editar_email')?.value.trim();
  const papelId = document.getElementById('editar_papel_id')?.value;
  const status = document.getElementById('editar_status')?.value;
  const senha = document.getElementById('editar_senha')?.value;
  const senhaConfirmacao = document.getElementById('editar_senha_confirmacao')?.value;

  if (!nomeCompleto || !cpf || !telefone || !email || !papelId || !status) {
    return 'Preencha os campos obrigatórios: nome, CPF, telefone, e-mail, função e status.';
  }

  const erroCpf = validarCpfFuncionario(cpf);

  if (erroCpf) {
    return erroCpf;
  }

  const erroTelefone = validarTelefoneFuncionario(telefone);

  if (erroTelefone) {
    return erroTelefone;
  }

  const erroEmail = validarEmailFuncionario(email);

  if (erroEmail) {
    return erroEmail;
  }

  const erroSenha = validarSenhaFuncionario(
    senha,
    senhaConfirmacao,
    false
  );

  if (erroSenha) {
    return erroSenha;
  }

  return null;
}