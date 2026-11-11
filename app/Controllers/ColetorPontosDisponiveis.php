<?php

namespace App\Controllers;

use App\Models\AgendamentoModel;
use CodeIgniter\HTTP\RedirectResponse;

class ColetorPontosDisponiveis extends BaseController
{
    protected $helpers = ['auth', 'formato'];

    public function index()
    {
        $sessao = session();

        return view('coletorPontosDisponiveis/coletorPontosDisponiveis', [
            'pontos'  => model(AgendamentoModel::class)->disponiveis(),
            'sucesso' => $sessao->getFlashdata('sucesso') ?? '',
            'erro'    => $sessao->getFlashdata('erro') ?? '',
        ]);
    }

    public function solicitar(int $id): RedirectResponse
    {
        $coletorId = (int) usuario_logado()['id'];

        if (model(AgendamentoModel::class)->solicitar($id, $coletorId)) {
            return redirect()->to(base_url('inicioColetor'))
                ->with('sucesso', 'Solicitação enviada! A coleta aparece abaixo como Pendente até o ponto de coleta aceitar.');
        }

        $destino = $this->request->getPost('origem') === 'mapa' ? 'mapa' : 'coletorPontosDisponiveis';

        return redirect()->to(base_url($destino))
            ->with('erro', 'Não foi possível solicitar: essa coleta já foi solicitada por outro coletor ou não está mais disponível.');
    }
}
