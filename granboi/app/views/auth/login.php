<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>GranBoi - Login</title>

  <!-- CSS -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/global/style.css">
<link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/auth/login.css">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
    rel="stylesheet">

  <!-- Remix Icons -->
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body>

  <main class="login-container">

    <!-- LEFT SIDE -->
    <section class="login-banner">

      <div class="banner-content">

        <!-- LOGO -->
        <div class="logo">

          <div class="logo-icon">
            <i class="ri-leaf-line"></i>
          </div>

          <div class="logo-text">
            <h2>GranBoi</h2>
            <span>Sistema de Gestão de Gado</span>
          </div>

        </div>

        <!-- TEXT -->
        <div class="banner-text">

          <h1>
            Gerencie seu rebanho com
            <span>eficiência e precisão</span>
          </h1>

          <p>
            Controle completo do seu gado:
            vacinação, pesagem, financeiro
            e relatórios em uma única plataforma.
          </p>

        </div>

        <!-- STATS -->
        <div class="stats">

          <div class="stat-card">
            <h3>+5.000</h3>
            <span>Animais monitorados</span>
          </div>

          <div class="stat-card">
            <h3>98%</h3>
            <span>Satisfação</span>
          </div>

          <div class="stat-card">
            <h3>+200</h3>
            <span>Fazendas ativas</span>
          </div>

        </div>

      </div>

    </section>

    <!-- RIGHT SIDE -->
    <section class="login-form-section">

      <div class="login-box">

        <div class="login-header">

          <h1>Bem-vindo de volta</h1>

          <p>
            Entre com suas credenciais
            para acessar o sistema
          </p>

        </div>

        <!-- ERRO LOGIN -->
        <?php if(isset($_SESSION['erro'])): ?>

          <div class="login-error">
            <?= $_SESSION['erro']; ?>
          </div>

          <?php unset($_SESSION['erro']); ?>

        <?php endif; ?>

        <!-- FORM -->
        <form
          class="login-form"
          method="POST"
          action="<?= BASE_URL ?>/login"
        >

          <!-- EMAIL -->
          <div class="input-group">

            <label>E-mail</label>

            <input
              type="email"
              name="email"
              placeholder="seu@email.com"
              required
            >

          </div>

          <!-- PASSWORD -->
          <div class="input-group">

            <div class="password-label">

              <label>Senha</label>

              <a href="#">
                Esqueceu a senha?
              </a>

            </div>

            <div class="password-input">

              <input
                type="password"
                name="senha"
                id="password"
                placeholder="Digite sua senha"
                required
              >

              <button
                title="Mostrar senha"
                type="button"
                id="togglePassword"
              >
                <i class="ri-eye-line"></i>
              </button>

            </div>

          </div>

          <!-- REMEMBER -->
          <div class="remember">

            <input
              type="checkbox"
              id="remember"
            >

            <label for="remember">
              Manter conectado
            </label>

          </div>

          <!-- BUTTON -->
          <button
            type="submit"
            class="login-btn"
          >
            Entrar
          </button>

        </form>

        <!-- REGISTER -->
        <div class="register-link">

          <p>
            Ainda não tem uma conta?
            <a href="#">
              Solicitar acesso
            </a>
          </p>

        </div>

      </div>

    </section>

  </main>

  <!-- JS -->
  <script src="<?= BASE_URL ?>/public/assets/js/auth/login.js"></script>

</body>

</html>