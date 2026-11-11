<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\HTTP\RedirectResponse;
use Throwable;

class Login extends BaseController
{
    /** Valor do formulário => valor do ENUM `usuarios.perfil`. */
    private const PERFIS = [
        'gerador' => 'ponto_coleta',
        'coletor' => 'coletor_licenciado',
    ];

    /** Campos do cadastro que podem voltar preenchidos (nunca a senha). */
    private const CAMPOS_REPOSTOS = [
        'perfil', 'razao_social', 'cpf_cnpj', 'telefone', 'email',
        'cep', 'numero', 'endereco', 'bairro', 'municipio',
    ];

    public function index()
    {
        $usuario = usuario_logado();

        if ($usuario !== null) {
            return redirect()->to(base_url(rota_inicial($usuario['perfil'])));
        }

        $sessao = session();

        return view('login/login', [
            'aba'           => $sessao->getFlashdata('aba') ?? 'login',
            'errosLogin'    => $sessao->getFlashdata('erros_login') ?? [],
            'errosCadastro' => $sessao->getFlashdata('erros_cadastro') ?? [],
            'sucesso'       => $sessao->getFlashdata('sucesso') ?? '',
            'antigo'        => $sessao->getFlashdata('antigo') ?? [],
        ]);
    }

    public function autenticar(): RedirectResponse
    {
        $limite = service('throttler')->check('login_' . md5($this->request->getIPAddress()), 5, MINUTE);

        if ($limite === false) {
            return $this->voltar('login', ['Muitas tentativas de acesso. Aguarde um minuto e tente novamente.']);
        }

        $email = mb_strtolower(trim((string) $this->request->getPost('email')));
        $senha = (string) $this->request->getPost('senha');

        if ($email === '' || $senha === '') {
            return $this->voltar('login', ['Informe e-mail e senha.'], ['email' => $email]);
        }

        $modelo  = model(UsuarioModel::class);
        $usuario = $modelo->where('email', $email)->first();

        // Faz o mesmo trabalho de hash mesmo quando o e-mail não existe,
        // para o tempo de resposta não revelar quais e-mails estão cadastrados.
        $confere = $usuario !== null
            ? password_verify($senha, $usuario['senha'])
            : (password_hash($senha, PASSWORD_DEFAULT) === '');

        if ($usuario === null || ! $confere) {
            return $this->voltar('login', ['E-mail ou senha incorretos.'], ['email' => $email]);
        }

        if (password_needs_rehash($usuario['senha'], PASSWORD_DEFAULT)) {
            $modelo->update($usuario['id'], ['senha' => password_hash($senha, PASSWORD_DEFAULT)]);
        }

        $sessao = session();
        $sessao->regenerate(true); // evita fixação de sessão
        $sessao->set('usuario', array_diff_key($usuario, ['senha' => true]));

        return redirect()->to(base_url(rota_inicial($usuario['perfil'])));
    }

    public function cadastrar(): RedirectResponse
    {
        $limite = service('throttler')->check('cadastro_' . md5($this->request->getIPAddress()), 10, HOUR);

        if ($limite === false) {
            return $this->voltar('cadastro', ['Muitos cadastros a partir desta conexão. Tente novamente mais tarde.']);
        }

        $post = $this->request->getPost();

        $dados = [
            'perfil'       => (string) ($post['perfil'] ?? ''),
            'razao_social' => trim((string) ($post['razao_social'] ?? '')),
            'cpf_cnpj'     => preg_replace('/\D/', '', (string) ($post['cpf_cnpj'] ?? '')),
            'telefone'     => preg_replace('/\D/', '', (string) ($post['telefone'] ?? '')),
            'email'        => mb_strtolower(trim((string) ($post['email'] ?? ''))),
            'senha'        => (string) ($post['senha'] ?? ''),
            'cep'          => preg_replace('/\D/', '', (string) ($post['cep'] ?? '')),
            'numero'       => trim((string) ($post['numero'] ?? '')),
            'endereco'     => trim((string) ($post['endereco'] ?? '')),
            'bairro'       => trim((string) ($post['bairro'] ?? '')),
            'municipio'    => trim((string) ($post['municipio'] ?? '')),
            'termos'       => (string) ($post['termos'] ?? ''),
        ];

        $regras = [
            'perfil'       => 'required|in_list[gerador,coletor]',
            'razao_social' => 'required|min_length[3]|max_length[300]',
            'cpf_cnpj'     => 'required|is_unique[usuarios.cpf_cnpj]',
            'telefone'     => 'required|regex_match[/^\d{10,11}$/]',
            'email'        => 'required|valid_email|max_length[150]|is_unique[usuarios.email]',
            'senha'        => 'required|min_length[8]|max_length[72]',
            'cep'          => 'required|exact_length[8]',
            'numero'       => 'required|max_length[20]',
            'endereco'     => 'required|max_length[255]',
            'bairro'       => 'required|max_length[100]',
            'municipio'    => 'required|max_length[100]',
            'termos'       => 'required',
        ];

        $mensagens = [
            'perfil'       => ['required' => 'Escolha o tipo de perfil.', 'in_list' => 'Tipo de perfil inválido.'],
            'razao_social' => [
                'required'   => 'Informe o nome completo ou a razão social.',
                'min_length' => 'O nome deve ter pelo menos 3 caracteres.',
                'max_length' => 'O nome deve ter no máximo 300 caracteres.',
            ],
            'cpf_cnpj'     => ['required' => 'Informe o CPF ou CNPJ.', 'is_unique' => 'Este CPF/CNPJ já está cadastrado.'],
            'telefone'     => ['required' => 'Informe o telefone.', 'regex_match' => 'Informe um telefone válido, com DDD.'],
            'email'        => [
                'required'    => 'Informe o e-mail.',
                'valid_email' => 'Informe um e-mail válido.',
                'max_length'  => 'O e-mail deve ter no máximo 150 caracteres.',
                'is_unique'   => 'Este e-mail já está cadastrado.',
            ],
            'senha'        => [
                'required'   => 'Crie uma senha.',
                'min_length' => 'A senha deve ter pelo menos 8 caracteres.',
                'max_length' => 'A senha deve ter no máximo 72 caracteres.',
            ],
            'cep'          => ['required' => 'Informe o CEP.', 'exact_length' => 'Informe um CEP válido, com 8 dígitos.'],
            'numero'       => ['required' => 'Informe o número.', 'max_length' => 'O número deve ter no máximo 20 caracteres.'],
            'endereco'     => ['required' => 'Informe a rua ou avenida.', 'max_length' => 'A rua deve ter no máximo 255 caracteres.'],
            'bairro'       => ['required' => 'Informe o bairro.', 'max_length' => 'O bairro deve ter no máximo 100 caracteres.'],
            'municipio'    => ['required' => 'Informe o município.', 'max_length' => 'O município deve ter no máximo 100 caracteres.'],
            'termos'       => ['required' => 'É preciso aceitar os Termos de Uso e a Política de Privacidade.'],
        ];

        $erros = $this->validateData($dados, $regras, $mensagens)
            ? []
            : array_values($this->validator->getErrors());

        if ($dados['cpf_cnpj'] !== '' && ! documento_valido($dados['cpf_cnpj'])) {
            $erros[] = 'Informe um CPF ou CNPJ válido.';
        }

        $reposto = array_intersect_key($post, array_flip(self::CAMPOS_REPOSTOS));

        if ($erros !== []) {
            return $this->voltar('cadastro', $erros, $reposto);
        }

        try {
            model(UsuarioModel::class)->insert([
                'perfil'       => self::PERFIS[$dados['perfil']],
                'razao_social' => $dados['razao_social'],
                'cpf_cnpj'     => $dados['cpf_cnpj'],
                'telefone'     => $dados['telefone'],
                'email'        => $dados['email'],
                'senha'        => password_hash($dados['senha'], PASSWORD_DEFAULT),
                'endereco'     => $dados['endereco'],
                'numero'       => $dados['numero'],
                'bairro'       => $dados['bairro'],
                'municipio'    => $dados['municipio'],
                'cep'          => substr($dados['cep'], 0, 5) . '-' . substr($dados['cep'], 5),
            ]);
        } catch (Throwable $e) {
            log_message('error', 'Falha ao cadastrar usuário: ' . $e->getMessage());

            return $this->voltar('cadastro', ['Não foi possível concluir o cadastro agora. Tente novamente.'], $reposto);
        }

        return redirect()->to(base_url('entrar'))
            ->with('aba', 'login')
            ->with('sucesso', 'Conta criada com sucesso! Entre com seu e-mail e senha.')
            ->with('antigo', ['email' => $dados['email']]);
    }

    public function sair(): RedirectResponse
    {
        session()->destroy();

        return redirect()->to(base_url('entrar'));
    }

    /**
     *
     *
     * @param list<string>         $erros
     * @param array<string,string> $antigo
     */
    private function voltar(string $aba, array $erros, array $antigo = []): RedirectResponse
    {
        return redirect()->to(base_url('entrar'))
            ->with('aba', $aba)
            ->with($aba === 'cadastro' ? 'erros_cadastro' : 'erros_login', $erros)
            ->with('antigo', $antigo);
    }
}
