<main class="main-content profile-page">

  <header class="topbar">

    <button
      class="menu-toggle"
      id="menuToggle"
    >
      <i class="ri-menu-line"></i>
    </button>

    <div class="topbar-title">

      <h1>Meu Perfil</h1>

      <p>
        Consulte suas informações de acesso ao sistema
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

  <?php
    $usuarioPerfil = $usuarioPerfil ?? [];
    $papelUsuario = strtolower(trim($_SESSION['usuario']['papel'] ?? ''));
    $podeGerenciarUsuarios = in_array($papelUsuario, ['administrador', 'gestor'], true);

    $nomeCompleto = $usuarioPerfil['nome_completo'] ?? $_SESSION['usuario']['nome'] ?? '-';
    $nomeSocial = $usuarioPerfil['nome_social'] ?? null;
    $email = $usuarioPerfil['email'] ?? $_SESSION['usuario']['email'] ?? '-';
    $papelNome = $usuarioPerfil['papel_nome'] ?? $_SESSION['usuario']['papel_nome'] ?? '-';
    $status = $usuarioPerfil['status'] ?? $_SESSION['usuario']['status'] ?? '-';
    $cpf = $usuarioPerfil['cpf'] ?? null;
    $telefone = $usuarioPerfil['telefone_movel'] ?? null;
    $senhaTesteAtual = '123456';

    $formatarCpf = function ($valor) {
        $limpo = preg_replace('/\D/', '', (string) $valor);

        if (strlen($limpo) !== 11) {
            return $valor ?: '-';
        }

        return substr($limpo, 0, 3) . '.' .
            substr($limpo, 3, 3) . '.' .
            substr($limpo, 6, 3) . '-' .
            substr($limpo, 9, 2);
    };

    $formatarTelefone = function ($valor) {
        $limpo = preg_replace('/\D/', '', (string) $valor);

        if (strlen($limpo) === 13) {
            return '+' . substr($limpo, 0, 2) . ' (' . substr($limpo, 2, 2) . ') ' .
                substr($limpo, 4, 5) . '-' . substr($limpo, 9);
        }

        if (strlen($limpo) === 11) {
            return '(' . substr($limpo, 0, 2) . ') ' . substr($limpo, 2, 5) . '-' . substr($limpo, 7);
        }

        return $valor ?: '-';
    };

  ?>

  <section class="profile-card">

    <div class="profile-header">

      <div class="profile-avatar-large">
        <?= strtoupper(substr($_SESSION['usuario']['nome'] ?? 'U', 0, 1)) ?>
      </div>

      <div class="profile-info-main">

        <h2>
          <?= htmlspecialchars($nomeCompleto) ?>
        </h2>

        <p>
          <?= htmlspecialchars($papelNome) ?> • GranBoi
        </p>

      </div>

    </div>

    <div class="profile-details-grid">

      <div class="profile-detail-item">
        <span>Nome Completo</span>
        <strong><?= htmlspecialchars($nomeCompleto) ?></strong>
      </div>

      <div class="profile-detail-item">
        <span>Nome Social</span>
        <strong><?= htmlspecialchars(!empty($nomeSocial) ? $nomeSocial : '-') ?></strong>
      </div>

      <div class="profile-detail-item">
        <span>E-mail</span>
        <strong><?= htmlspecialchars($email) ?></strong>
      </div>

      <div class="profile-detail-item">
        <span>Telefone</span>
        <strong><?= htmlspecialchars($formatarTelefone($telefone)) ?></strong>
      </div>

      <div class="profile-detail-item">
        <span>CPF</span>
        <strong><?= htmlspecialchars($formatarCpf($cpf)) ?></strong>
      </div>

      <div class="profile-detail-item">
        <span>Função no Sistema</span>
        <strong><?= htmlspecialchars($papelNome) ?></strong>
      </div>

      <div class="profile-detail-item">
        <span>Status</span>
        <strong><?= htmlspecialchars(ucfirst($status)) ?></strong>
      </div>

      <div class="profile-detail-item">
        <span>Senha</span>
        <div class="profile-password-field">
          <input
            type="password"
            value="<?= htmlspecialchars($senhaTesteAtual) ?>"
            id="profilePassword"
            readonly
            aria-label="Senha do usuário"
          >
          <button
            type="button"
            id="toggleProfilePassword"
            class="profile-password-toggle"
            title="Mostrar senha"
            aria-label="Mostrar senha"
          >
            <i class="ri-eye-line"></i>
          </button>
        </div>
      </div>

    </div>

    <div class="profile-alert">

      <i class="ri-information-line"></i>

      <div>
        <strong>Informações do perfil</strong>
        <?php if ($podeGerenciarUsuarios): ?>
          <p>
            Seu perfil tem permissão para alterar dados pessoais, senha e função de acesso dos usuários.
          </p>
          <a class="profile-action-link" href="<?= BASE_URL ?>/funcionarios">
            <i class="ri-user-settings-line"></i>
            Gerenciar usuários
          </a>
        <?php else: ?>
          <p>
            Para alterar dados pessoais, senha ou função de acesso, solicite a alteração a um administrador ou gestor do sistema.
          </p>
        <?php endif; ?>
      </div>

    </div>

  </section>

</main>
