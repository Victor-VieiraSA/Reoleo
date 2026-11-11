<?php

namespace App\Controllers;

use App\Models\AgendamentoModel;
use CodeIgniter\HTTP\RedirectResponse;

class InicioColetor extends BaseController
{
    protected $helpers = ['auth', 'formato'];

    public function index()
    {
        $modelo    = model(AgendamentoModel::class);
        $coletorId = (int) usuario_logado()['id'];
        $filtros   = filtros_historico($this->request->getGet());

        $coletas    = $modelo->doColetor($coletorId, $filtros);
        $concluidas = array_filter(
            $modelo->doColetor($coletorId),
            static fn (array $c): bool => $c['status'] === 'Concluído'
        );

        $sessao = session();

        return view('inicioColetor/inicioColetor', [
            'coletas'    => $coletas,
            'filtros'    => $filtros,
            'realizadas' => count($concluidas),
            'litros'     => total_litros($concluidas),
            'sucesso'    => $sessao->getFlashdata('sucesso') ?? '',
            'erro'       => $sessao->getFlashdata('erro') ?? '',
        ]);
    }

    public function finalizar(int $id): RedirectResponse
    {
        $ok = model(AgendamentoModel::class)->finalizar($id, (int) usuario_logado()['id']);

        return $this->voltar($ok, 'Coleta finalizada. Ela passou para Concluída.', 'Não foi possível finalizar essa coleta.');
    }

    public function liberar(int $id): RedirectResponse
    {
        $ok = model(AgendamentoModel::class)->liberar($id, (int) usuario_logado()['id']);

        return $this->voltar($ok, 'Você desistiu da coleta. Ela voltou para a lista de pontos disponíveis.', 'Não foi possível desistir dessa coleta.');
    }

    private function voltar(bool $ok, string $sucesso, string $erro): RedirectResponse
    {
        return redirect()->to(base_url('inicioColetor'))->with($ok ? 'sucesso' : 'erro', $ok ? $sucesso : $erro);
    }
}
