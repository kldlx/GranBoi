<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <title>Editar Animal</title>
   <link rel="stylesheet" href="../../../public/assets/css/global/style.css">
</head>

<body>

<div class="form-container">

  <h1>Editar Animal</h1>

  <form action="/animal/atualizar" method="POST">

    <input type="hidden" name="id" value="<?= $animal['id'] ?>">

    <label>Brinco</label>
    <input type="text" name="brinco" value="<?= $animal['brinco_identificador'] ?>">

    <label>Sexo</label>
    <select name="sexo">
      <option value="Macho" <?= $animal['sexo'] == 'Macho' ? 'selected' : '' ?>>Macho</option>
      <option value="Fêmea" <?= $animal['sexo'] == 'Fêmea' ? 'selected' : '' ?>>Fêmea</option>
    </select>

    <label>Peso</label>
    <input type="number" name="peso_entrada" value="<?= $animal['peso_entrada'] ?>">

    <label>Status</label>
    <select name="status">
      <option value="ativo" <?= $animal['status'] == 'ativo' ? 'selected' : '' ?>>Ativo</option>
      <option value="vendido" <?= $animal['status'] == 'vendido' ? 'selected' : '' ?>>Vendido</option>
      <option value="morto" <?= $animal['status'] == 'morto' ? 'selected' : '' ?>>Morto</option>
    </select>

    <button type="submit">Salvar Alterações</button>

  </form>

</div>

</body>
</html>