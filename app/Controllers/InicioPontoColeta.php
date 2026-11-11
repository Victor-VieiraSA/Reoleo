<?php

namespace App\Controllers;

use App\Models\AgendamentoModel;
use CodeIgniter\HTTP\RedirectResponse;

class InicioPontoColeta extends BaseController
{
    protected $helpers = ['auth', 'formato'];

    public function index()
    {
        $modelo    = model(AgendamentoModel::class);
        $usuarioId = (int) usuario_logado()['id'];
        $filtros   = filtros_historico($this->request->getGet());
        $sessao    = session();
        $agendamentos = $modelo->doUsuario($usuarioId, $filtros);
        $concluidas   = array_filter(
            $modelo->doUsuario($usuarioId),
            static fn (array $a): bool => $a['status'] === 'Concluído'
        );

        return view('inicioPontoColeta/inicioPontoColeta', [
            'agendamentos' => $agendamentos,
            'filtros'      => $filtros,
            'realizadas'   => count($concluidas),
            'litros'       => total_litros($concluidas),
            'sucesso'      => $sessao->getFlashdata('sucesso') ?? '',
            'erro'         => $sessao->getFlashdata('erro') ?? '',
        ]);
    }
    public function aceitar(int $id): RedirectResponse
    {
        $ok = model(AgendamentoModel::class)->aceitarColetor($id, (int) usuario_logado()['id']);

        return $this->voltar($ok, 'Coletor aceito. A coleta passou para Confirmado.', 'Não há solicitação de coletor pendente para esse agendamento.');
    }

    public function recusar(int $id): RedirectResponse
    {
        $ok = model(AgendamentoModel::class)->recusarColetor($id, (int) usuario_logado()['id']);

        return $this->voltar($ok, 'Coletor recusado. O agendamento voltou para a lista de pontos disponíveis.', 'Não há solicitação de coletor pendente para esse agendamento.');
    }

    public function excluir(int $id): RedirectResponse
    {
        $modelo    = model(AgendamentoModel::class);
        $usuarioId = (int) usuario_logado()['id'];

        if ($modelo->excluir($id, $usuarioId)) {
            return $this->voltar(true, 'Agendamento excluído.', '');
        }

        if ($modelo->cancelar($id, $usuarioId)) {
            return $this->voltar(true, 'Agendamento cancelado. O coletor verá essa coleta como Cancelada.', '');
        }

        return $this->voltar(false, '', 'Esse agendamento não pode mais ser excluído.');
    }

    private function voltar(bool $ok, string $sucesso, string $erro): RedirectResponse
    {
        return redirect()->to(base_url('inicioPontoColeta'))->with($ok ? 'sucesso' : 'erro', $ok ? $sucesso : $erro);
    }
}
