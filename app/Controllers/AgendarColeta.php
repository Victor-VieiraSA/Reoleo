<?php

namespace App\Controllers;

use App\Models\AgendamentoModel;
use CodeIgniter\HTTP\RedirectResponse;
use Throwable;

class AgendarColeta extends BaseController
{
    protected $helpers = ['auth', 'formato'];

    private const DIAS_A_FRENTE = 14;

    private const TURNOS = [
        'manha' => 'Manhã',
        'tarde' => 'Tarde',
    ];

    private const VOLUMES = [
        'ate-20'  => 'Até 20 Litros',
        '20-50'   => '20 a 50 Litros',
        '50-100'  => '50 a 100 Litros',
        '100-mais' => 'Mais de 100 Litros',
    ];

    public function index()
    {
        return $this->formulario(base_url('Agendar'), false, $this->datasDisponiveis());
    }

    public function salvar(): RedirectResponse
    {
        [$dados, $erros] = $this->lerEValidar();

        if ($erros !== []) {
            return redirect()->to(base_url('Agendar'))
                ->with('erros_agendar', $erros)
                ->with('antigo', $dados);
        }

        try {
            model(AgendamentoModel::class)->insert($this->paraBanco($dados) + [
                'usuario_id' => (int) usuario_logado()['id'],
                'status'     => 'Pendente',
            ]);
        } catch (Throwable $e) {
            log_message('error', 'Falha ao agendar coleta: ' . $e->getMessage());

            return redirect()->to(base_url('Agendar'))
                ->with('erros_agendar', ['Não foi possível salvar o agendamento agora. Tente novamente.'])
                ->with('antigo', $dados);
        }

        return redirect()->to(base_url('inicioPontoColeta'))
            ->with('sucesso', 'Coleta agendada para ' . date('d/m/Y', strtotime($dados['data_coleta']))
                . ', turno da ' . mb_strtolower(self::TURNOS[$dados['turno']]) . '. Ela aparece abaixo como Pendente.');
    }

    public function editar(int $id)
    {
        $agendamento = $this->editavel($id);

        if ($agendamento === null) {
            return $this->naoEditavel();
        }

        return $this->formulario(
            base_url('Agendar/editar/' . $id),
            true,
            $this->datasDisponiveis($agendamento['data_coleta']),
            [
                'data_coleta'     => $agendamento['data_coleta'],
                'turno'           => array_search($agendamento['turno'], self::TURNOS, true) ?: 'manha',
                'volume_estimado' => array_search($agendamento['volume_estimado'], self::VOLUMES, true) ?: '20-50',
                'observacoes'     => (string) ($agendamento['observacoes'] ?? ''),
            ]
        );
    }

    public function atualizar(int $id): RedirectResponse
    {
        $agendamento = $this->editavel($id);

        if ($agendamento === null) {
            return $this->naoEditavel();
        }

        [$dados, $erros] = $this->lerEValidar($agendamento['data_coleta']);

        if ($erros !== []) {
            return redirect()->to(base_url('Agendar/editar/' . $id))
                ->with('erros_agendar', $erros)
                ->with('antigo', $dados);
        }

        try {
            $ok = model(AgendamentoModel::class)->editar($id, (int) usuario_logado()['id'], $this->paraBanco($dados));
        } catch (Throwable $e) {
            log_message('error', 'Falha ao editar coleta: ' . $e->getMessage());
            $ok = false;
        }

        if (! $ok) {
            return redirect()->to(base_url('Agendar/editar/' . $id))
                ->with('erros_agendar', ['Não foi possível salvar as alterações agora. Tente novamente.'])
                ->with('antigo', $dados);
        }

        return redirect()->to(base_url('inicioPontoColeta'))
            ->with('sucesso', 'Agendamento atualizado para ' . date('d/m/Y', strtotime($dados['data_coleta']))
                . ', turno da ' . mb_strtolower(self::TURNOS[$dados['turno']]) . '.');
    }

    private function formulario(string $acao, bool $editando, array $datas, array $antigoPadrao = [])
    {
        $sessao = session();

        return view('agendarColeta/agendarColeta', [
            'datas'    => $datas,
            'volumes'  => self::VOLUMES,
            'erros'    => $sessao->getFlashdata('erros_agendar') ?? [],
            'antigo'   => $sessao->getFlashdata('antigo') ?? $antigoPadrao,
            'acao'     => $acao,
            'editando' => $editando,
        ]);
    }

    private function editavel(int $id): ?array
    {
        $agendamento = model(AgendamentoModel::class)->doUsuarioPorId($id, (int) usuario_logado()['id']);

        if ($agendamento === null || $agendamento['status'] !== 'Pendente' || $agendamento['coletor_id'] !== null) {
            return null;
        }

        return $agendamento;
    }

    private function naoEditavel(): RedirectResponse
    {
        return redirect()->to(base_url('inicioPontoColeta'))
            ->with('erro', 'Esse agendamento não pode mais ser editado (já foi aceito por um coletor ou não existe).');
    }

    /**
     *
     *
     * @return array{0: array<string,string>, 1: list<string>} [dados, erros]
     */
    private function lerEValidar(?string $dataAtual = null): array
    {
        $post = $this->request->getPost();

        $dados = [
            'data_coleta'     => (string) ($post['data_coleta'] ?? ''),
            'turno'           => (string) ($post['turno'] ?? ''),
            'volume_estimado' => (string) ($post['volume_estimado'] ?? ''),
            'observacoes'     => trim((string) ($post['observacoes'] ?? '')),
        ];

        $datas = array_column($this->datasDisponiveis($dataAtual), 'valor');

        $regras = [
            'data_coleta'     => 'required|in_list[' . implode(',', $datas) . ']',
            'turno'           => 'required|in_list[' . implode(',', array_keys(self::TURNOS)) . ']',
            'volume_estimado' => 'required|in_list[' . implode(',', array_keys(self::VOLUMES)) . ']',
            'observacoes'     => 'permit_empty|max_length[500]',
        ];

        $mensagens = [
            'data_coleta'     => ['required' => 'Escolha a data da coleta.', 'in_list' => 'Escolha uma data disponível.'],
            'turno'           => ['required' => 'Escolha o turno.', 'in_list' => 'Turno inválido.'],
            'volume_estimado' => ['required' => 'Escolha o volume estimado.', 'in_list' => 'Volume estimado inválido.'],
            'observacoes'     => ['max_length' => 'As observações devem ter no máximo 500 caracteres.'],
        ];

        if (! $this->validateData($dados, $regras, $mensagens)) {
            return [$dados, array_values($this->validator->getErrors())];
        }

        return [$dados, []];
    }

    
    private function paraBanco(array $dados): array
    {
        return [
            'data_coleta'     => $dados['data_coleta'],
            'turno'           => self::TURNOS[$dados['turno']],
            'volume_estimado' => self::VOLUMES[$dados['volume_estimado']],
            'observacoes'     => $dados['observacoes'] !== '' ? $dados['observacoes'] : null,
        ];
    }

    /**
     * 
     *
     * @return list<array{valor:string,rotulo:string}>
     */
    private function datasDisponiveis(?string $incluir = null): array
    {
        $datas = [];

        for ($i = 1; $i <= self::DIAS_A_FRENTE; $i++) {
            $ts = strtotime("+{$i} day");

            if ((int) date('w', $ts) === 0) {
                continue;
            }

            $ymd     = date('Y-m-d', $ts);
            $datas[] = ['valor' => $ymd, 'rotulo' => dia_semana_abrev($ymd) . ' ' . date('d/m/Y', $ts)];
        }

        if ($incluir !== null && ! in_array($incluir, array_column($datas, 'valor'), true)) {
            array_unshift($datas, [
                'valor'  => $incluir,
                'rotulo' => dia_semana_abrev($incluir) . ' ' . date('d/m/Y', strtotime($incluir)) . ' (atual)',
            ]);
            usort($datas, static fn (array $a, array $b): int => strcmp($a['valor'], $b['valor']));
        }

        return $datas;
    }
}
