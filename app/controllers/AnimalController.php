<?php

class AnimalController extends Controller
{
    public function listar()
    {
        $model = $this->model('Animal');
        $racaModel = $this->model('Raca');
        $loteModel = $this->model('Lote');

        $dados = [
            'titulo' => 'GranBoi - Gado',
            'pageCss' => [
                '/public/assets/css/components/modal.css',
                '/public/assets/css/components/animal/animalModal.css',
                '/public/assets/css/pages/animal/animal.css',
                '/public/assets/css/pages/animal/listar.css'
            ],
            'pageJs' => [
                '/public/assets/js/validations/animal/animalValidation.js',
                '/public/assets/js/modals/animal/cadastrarAnimalModal.js',
                '/public/assets/js/modals/animal/editarAnimalModal.js',
                '/public/assets/js/modals/animal/excluirAnimalModal.js',
                '/public/assets/js/modals/animal/detalhesAnimalModal.js',
                '/public/assets/js/pages/animal/animalPage.js'
            ],
            'animais' => $model->listarTodos(),
            'racas' => $racaModel->listarTodos(),
            'lotes' => $loteModel->listarTodos()
        ];

        $this->render('animal/listar', $dados);
    }

    public function cadastrar()
    {
        $this->redirect('/animal');
    }

    public function salvar()
    {
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => 'Requisição inválida.'
                ], 405);
            }

            $this->redirect('/animal');
        }

        $dados = [
            'brinco' => trim($_POST['brinco'] ?? ''),
            'raca' => trim($_POST['raca'] ?? ''),
            'lote' => trim($_POST['lote'] ?? ''),
            'data_nascimento' => $_POST['data_nascimento'] ?? null,
            'sexo' => $this->normalizarSexo($_POST['sexo'] ?? ''),
            'peso_entrada' => $_POST['peso_entrada'] ?? '',
            'chip' => trim($_POST['chip'] ?? ''),
            'data_compra'  => $_POST['data_compra']  ?? null,
            'valor_compra' => trim($_POST['valor_compra'] ?? '')
        ];

        $erro = null;

        if (
            empty($dados['brinco']) ||
            empty($dados['sexo']) ||
            empty($dados['peso_entrada'])
        ) {
            $erro = 'Preencha os campos obrigatórios: brinco, sexo e peso.';
        }

        if (!$erro && (!is_numeric($dados['peso_entrada']) || $dados['peso_entrada'] <= 0)) {
            $erro = 'O peso de entrada deve ser maior que zero.';
        }

        if (!$erro && !in_array($dados['sexo'], ['M', 'F'])) {
            $erro = 'Selecione um sexo válido.';
        }

        if (!$erro && !empty($dados['raca']) && !ctype_digit((string) $dados['raca'])) {
            $erro = 'Selecione uma raça válida.';
        }

        if (!$erro && !empty($dados['lote']) && !ctype_digit((string) $dados['lote'])) {
            $erro = 'Selecione um lote válido.';
        }

        if (!$erro && !empty($dados['data_nascimento'])) {
            $hoje = date('Y-m-d');

            if ($dados['data_nascimento'] > $hoje) {
                $erro = 'A data de nascimento não pode ser uma data futura.';
            }
        }

        if (empty($dados['data_nascimento'])) {
            $dados['data_nascimento'] = null;
        }

        if (!empty($dados['valor_compra'])) {
            $valorCompra = $this->normalizarValorMonetario($dados['valor_compra']);
            $dados['valor_compra'] = ($valorCompra !== null && $valorCompra >= 0) ? $valorCompra : null;
        } else {
            $dados['valor_compra'] = null;
        }

        $model = $this->model('Animal');

        if (!$erro && $model->brincoExiste($dados['brinco'])) {
            $erro = 'Este brinco já pertence a outro animal registrado no sistema, mesmo que ele esteja ativo, vendido, com perda ou excluído. O brinco é único e não pode ser reutilizado.';
        }

        if ($erro) {
            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => $erro
                ], 422);
            }

            $_SESSION['erro'] = $erro;
            $this->redirect('/animal');
        }

        try {
            $animalId = $model->salvar($dados);

            $model->adicionarPeso(
                $animalId,
                $dados['peso_entrada'],
                'Peso inicial registrado no cadastro do animal.'
            );

            if ($isAjax) {
                $this->json([
                    'sucesso' => true,
                    'mensagem' => 'Animal cadastrado com sucesso.'
                ]);
            }

            $_SESSION['sucesso'] = 'Animal cadastrado com sucesso.';
            $this->redirect('/animal');

        } catch (PDOException $e) {
            $mensagem = $this->mensagemErroCadastroAnimal($e);

            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => $mensagem
                ], 500);
            }

            $_SESSION['erro'] = $mensagem;
            $this->redirect('/animal');

        } catch (Exception $e) {
            $mensagem = $e->getMessage();

            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => $mensagem
                ], 500);
            }

            $_SESSION['erro'] = $mensagem;
            $this->redirect('/animal');
        }
    }

    public function editar()
    {
        $this->redirect('/animal');
    }

    public function atualizar()
    {
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => 'Requisição inválida.'
                ], 405);
            }

            $this->redirect('/animal');
        }

        $dados = [
            'id' => $_POST['id'] ?? '',
            'brinco' => trim($_POST['brinco'] ?? ''),
            'raca' => trim($_POST['raca'] ?? ''),
            'lote' => trim($_POST['lote'] ?? ''),
            'data_nascimento' => $_POST['data_nascimento'] ?? null,
            'sexo' => $this->normalizarSexo($_POST['sexo'] ?? ''),
            'status' => $this->normalizarStatus($_POST['status'] ?? 'ativo'),
            'chip' => trim($_POST['chip'] ?? ''),
            'peso_saida' => trim($_POST['peso_saida'] ?? ''),
            'valor_venda' => trim($_POST['valor_venda'] ?? ''),
            'data_compra'  => $_POST['data_compra']  ?? null,
            'valor_compra' => trim($_POST['valor_compra'] ?? ''),
            'data_venda'   => $_POST['data_venda']   ?? null
        ];

        $erro = null;

        if (
            empty($dados['id']) ||
            empty($dados['brinco']) ||
            empty($dados['sexo']) ||
            empty($dados['status'])
        ) {
            $erro = 'Preencha os campos obrigatórios: brinco, sexo e status.';
        }

        if (!$erro && !in_array($dados['sexo'], ['M', 'F'])) {
            $erro = 'Selecione um sexo válido.';
        }

        if (!$erro && !in_array($dados['status'], ['Ativo', 'Vendido', 'Perda'])) {
            $erro = 'Selecione um status válido.';
        }

        if (!$erro && $dados['status'] === 'Vendido') {
            if (empty($dados['peso_saida']) || !is_numeric($dados['peso_saida']) || (float) $dados['peso_saida'] <= 0) {
                $erro = 'Informe o peso de saída do animal vendido.';
            }

            if (!$erro) {
                $valorNormalizado = $this->normalizarValorMonetario($dados['valor_venda']);

                if ($valorNormalizado === null || $valorNormalizado <= 0) {
                    $erro = 'Informe um valor de venda válido e maior que zero.';
                } else {
                    $dados['valor_venda'] = $valorNormalizado;
                }
            }
        }

        if (!$erro && !empty($dados['valor_compra'])) {
            $valorCompra = $this->normalizarValorMonetario($dados['valor_compra']);
            if ($valorCompra === null || $valorCompra < 0) {
                $erro = 'Informe um valor de compra válido.';
            } else {
                $dados['valor_compra'] = $valorCompra;
            }
        } else {
            $dados['valor_compra'] = null;
        }

        if (!$erro && !empty($dados['raca']) && !ctype_digit((string) $dados['raca'])) {
            $erro = 'Selecione uma raça válida.';
        }

        if (!$erro && !empty($dados['lote']) && !ctype_digit((string) $dados['lote'])) {
            $erro = 'Selecione um lote válido.';
        }

        if (!$erro && !empty($dados['data_nascimento'])) {
            $hoje = date('Y-m-d');

            if ($dados['data_nascimento'] > $hoje) {
                $erro = 'A data de nascimento não pode ser uma data futura.';
            }
        }

        if (empty($dados['data_nascimento'])) {
            $dados['data_nascimento'] = null;
        }

        if ($erro) {
            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => $erro
                ], 422);
            }

            $_SESSION['erro'] = $erro;
            $this->redirect('/animal');
        }

        $model = $this->model('Animal');

        try {
            $model->atualizar($dados);

            if ($isAjax) {
                $this->json([
                    'sucesso' => true,
                    'mensagem' => 'Animal atualizado com sucesso.'
                ]);
            }

            $_SESSION['sucesso'] = 'Animal atualizado com sucesso.';
            $this->redirect('/animal');

        } catch (PDOException $e) {
            $mensagem = $this->mensagemErroAtualizarAnimal($e);

            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => $mensagem
                ], 500);
            }

            $_SESSION['erro'] = $mensagem;
            $this->redirect('/animal');
        }
    }

    public function excluir()
    {
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => 'Requisição inválida.'
                ], 405);
            }

            $this->redirect('/animal');
        }

        $id = $_POST['id'] ?? null;

        if (empty($id)) {
            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => 'Animal não informado.'
                ], 422);
            }

            $_SESSION['erro'] = 'Animal não informado.';
            $this->redirect('/animal');
        }

        $model = $this->model('Animal');

        $animal = $model->buscarPorId($id);

        if (!$animal) {
            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => 'Animal não encontrado.'
                ], 404);
            }

            $_SESSION['erro'] = 'Animal não encontrado.';
            $this->redirect('/animal');
        }

        try {
            $model->softDelete($id);

            if ($isAjax) {
                $this->json([
                    'sucesso' => true,
                    'mensagem' => 'Animal excluído com sucesso.'
                ]);
            }

            $_SESSION['sucesso'] = 'Animal excluído com sucesso.';
            $this->redirect('/animal');

        } catch (PDOException $e) {
            $mensagem = 'Erro ao excluir animal. Tente novamente.';

            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => $mensagem
                ], 500);
            }

            $_SESSION['erro'] = $mensagem;
            $this->redirect('/animal');
        }
    }

    public function detalhes()
    {
        $this->redirect('/animal');
    }

    public function historicoPeso()
    {
        $id = $_GET['id'] ?? $_GET['animal_id'] ?? null;

        if ($id) {
            $this->redirect('/peso?animal_id=' . $id);
        }

        $this->redirect('/peso');
    }

    private function normalizarValorMonetario($valor)
    {
        if ($valor === null || $valor === '') {
            return null;
        }

        $valor = trim((string) $valor);

        // Formato BR: 1.234,56 ou 1.234 (ponto como milhar, vírgula como decimal)
        if (strpos($valor, ',') !== false) {
            $valor = str_replace('.', '', $valor); // remove pontos de milhar
            $valor = str_replace(',', '.', $valor); // vírgula vira decimal
        }
        // Formato US com ponto decimal: 1234.56 — mantém como está
        // Mas se houver mais de um ponto (ex: 1.234.567), remove todos exceto o último
        elseif (substr_count($valor, '.') > 1) {
            $partes = explode('.', $valor);
            $decimal = array_pop($partes);
            $valor = implode('', $partes) . '.' . $decimal;
        }

        if (!is_numeric($valor)) {
            return null;
        }

        return (float) $valor;
    }

    private function normalizarSexo($sexo)
    {
        $sexo = trim($sexo);

        if ($sexo === 'M' || $sexo === 'Macho' || $sexo === 'macho') {
            return 'M';
        }

        if ($sexo === 'F' || $sexo === 'Fêmea' || $sexo === 'Femea' || $sexo === 'fêmea' || $sexo === 'femea') {
            return 'F';
        }

        return $sexo;
    }

    private function normalizarStatus($status)
    {
        $mapa = [
            'ativo'   => 'Ativo',  'ativa'   => 'Ativo',
            'vendido' => 'Vendido','vendida' => 'Vendido',
            'morto'   => 'Perda',  'morta'   => 'Perda',
            'perda'   => 'Perda',
        ];

        $normalizado = mb_strtolower(trim($status), 'UTF-8');

        return $mapa[$normalizado] ?? $status;
    }

    private function mensagemErroCadastroAnimal(PDOException $e)
    {
        if ($this->erroBrincoDuplicado($e)) {
            return 'Este brinco já pertence a outro animal registrado no sistema, mesmo que ele esteja ativo, vendido, com perda ou excluído. O brinco é único e não pode ser reutilizado.';
        }

        if ($this->erroChaveEstrangeira($e)) {
            return 'Não foi possível cadastrar o animal. Verifique se a raça, o lote e o usuário responsável pela pesagem existem no banco de dados.';
        }

        return 'Erro ao cadastrar animal. Verifique os dados e tente novamente.';
    }

    private function mensagemErroAtualizarAnimal(PDOException $e)
    {
        if ($this->erroBrincoDuplicado($e)) {
            return 'Este brinco já pertence a outro animal registrado no sistema, mesmo que ele esteja ativo, vendido, com perda ou excluído. O brinco é único e não pode ser reutilizado.';
        }

        if ($this->erroChaveEstrangeira($e)) {
            return 'Não foi possível atualizar o animal. Verifique se a raça e o lote existem no banco de dados.';
        }

        return 'Erro ao atualizar animal. Verifique os dados e tente novamente.';
    }

    private function erroBrincoDuplicado(PDOException $e)
    {
        $mensagem = $e->getMessage();

        return strpos($mensagem, '1062') !== false ||
            strpos($mensagem, 'Duplicate entry') !== false ||
            strpos($mensagem, 'brinco_UNIQUE') !== false ||
            (
                strpos($mensagem, 'brinco_identificador') !== false &&
                strpos($mensagem, 'Duplicate') !== false
            );
    }

    private function erroChaveEstrangeira(PDOException $e)
    {
        $mensagem = $e->getMessage();

        return strpos($mensagem, '1452') !== false ||
            strpos($mensagem, 'foreign key constraint fails') !== false ||
            strpos($mensagem, 'Cannot add or update a child row') !== false;
    }
}