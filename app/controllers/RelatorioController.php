<?php

class RelatorioController extends Controller
{
    public function index()
    {
        $relatorioModel = $this->model('Relatorio');

        $dataInicio = $_GET['data_inicio'] ?? date('Y-m-01');
        $dataFim    = $_GET['data_fim']    ?? date('Y-m-d');

        if ($dataInicio > $dataFim) {
            $dataInicio = date('Y-m-01');
            $dataFim    = date('Y-m-d');
        }

        // Requisição AJAX para filtro de vacinação
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if ($isAjax) {
            $vacinacoes = $relatorioModel->vacinacoesPorPeriodo($dataInicio, $dataFim);
            $this->json([
                'sucesso' => true,
                'total'   => count($vacinacoes),
                'html'    => $this->renderVacinacoesRows($vacinacoes)
            ]);
        }

        $this->render('relatorios/relatorios', [
            'titulo'             => 'GranBoi - Relatórios',
            'pageCss'            => ['/public/assets/css/pages/relatorios/relatorios.css'],
            'pageJs'             => ['/public/assets/js/pages/relatorios/relatorios.js'],
            'dataInicio'         => $dataInicio,
            'dataFim'            => $dataFim,
            'resumoRebanho'      => $relatorioModel->resumoRebanho(),
            'pesoMedioAtual'     => $relatorioModel->pesoMedioAtual(),
            'animaisPorRaca'     => $relatorioModel->animaisPorRaca(),
            'animaisPorLote'     => $relatorioModel->animaisPorLote(),
            'rankingGanhoPeso'   => $relatorioModel->rankingGanhoPeso(10),
            'vacinacoesPeriodo'  => $relatorioModel->vacinacoesPorPeriodo($dataInicio, $dataFim),
            'vacinasPendentes'   => $relatorioModel->vacinasPendentes(),
            'vacinasAtrasadas'   => $relatorioModel->vacinasAtrasadas(),
            'totalReceitas'      => $relatorioModel->totalReceitas(),
            'totalDespesas'      => $relatorioModel->totalDespesas(),
        ]);
    }

    private function renderVacinacoesRows($vacinacoes)
    {
        if (empty($vacinacoes)) {
            return '<tr><td colspan="8" class="relatorio-empty">Nenhuma vacinação encontrada no período selecionado.</td></tr>';
        }

        $html = '';
        foreach ($vacinacoes as $v) {
            $aplicacao  = !empty($v['data_aplicacao']) ? date('d/m/Y', strtotime($v['data_aplicacao'])) : '-';
            $proxima    = !empty($v['proxima_dose'])   ? date('d/m/Y', strtotime($v['proxima_dose']))   : '-';
            $dose       = !empty($v['quantidade'])     ? number_format((float)$v['quantidade'], 2, ',', '.') . ' ml' : '-';
            $status     = htmlspecialchars($v['status'] ?? '-');
            $statusLabel= ucfirst($status);
            $html .= "<tr>";
            $html .= "<td>#" . htmlspecialchars($v['brinco_identificador'] ?? '-') . "</td>";
            $html .= "<td>" . htmlspecialchars($v['raca'] ?? '-') . "</td>";
            $html .= "<td>" . htmlspecialchars($v['vacina'] ?? '-') . "</td>";
            $html .= "<td>{$dose}</td>";
            $html .= "<td>{$aplicacao}</td>";
            $html .= "<td>{$proxima}</td>";
            $html .= "<td><span class=\"relatorio-status {$status}\">{$statusLabel}</span></td>";
            $html .= "<td>" . htmlspecialchars($v['responsavel'] ?? '-') . "</td>";
            $html .= "</tr>";
        }
        return $html;
    }
}