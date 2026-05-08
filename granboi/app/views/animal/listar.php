<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>GranBoi - Listar Gado</title>

   <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/global/style.css">
</head>

<body>

<div class="dashboard-container">

  <!-- SIDEBAR (pode reutilizar igual você já fez) -->
  <aside class="sidebar">
    <div class="logo">
      <h2>GranBoi</h2>
    </div>

    <nav class="menu">
      <a href="<?= BASE_URL ?>/dashboard">Dashboard</a>
      <a href="<?= BASE_URL ?>/animal/listar" class="active">Gado</a>
      <a href="<?= BASE_URL ?>/animal/cadastrar">Cadastrar</a>
    </nav>
  </aside>

  <!-- MAIN -->
  <main class="main-content">

    <header class="topbar">
      <h1>Lista de Gado</h1>
    </header>

    <section class="table-container">

      <table>

        <thead>
          <tr>
            <th>ID</th>
            <th>Brinco</th>
            <th>Sexo</th>
            <th>Peso</th>
            <th>Status</th>
            <th>Ações</th>
          </tr>
        </thead>

        <tbody>

        <?php if (!empty($animais)): ?>
          <?php foreach ($animais as $animal): ?>
            <tr>

              <td><?= $animal['id'] ?></td>
              <td><?= $animal['brinco_identificador'] ?></td>
              <td><?= $animal['sexo'] ?></td>
              <td><?= $animal['peso_entrada'] ?> kg</td>
              <td><?= $animal['status'] ?></td>

              <td>
                <a href="/animal/detalhes?id=<?= $animal['id'] ?>">Ver</a>
                <a href="/animal/editar?id=<?= $animal['id'] ?>">Editar</a>
                <a href="/animal/excluir?id=<?= $animal['id'] ?>">Excluir</a>
              </td>

            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="6">Nenhum animal cadastrado</td>
          </tr>
        <?php endif; ?>

        </tbody>

      </table>

    </section>

  </main>

</div>

</body>
</html>