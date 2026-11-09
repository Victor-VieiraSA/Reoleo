
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Entrar | Reoleo</title>
    <meta name="description" content="Acesse a plataforma Reoleo Baixada Santista.">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="<?= base_url('css/header.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/login.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/footer.css') ?>">
</head>

<body>

<?= $this->include('layouts/header') ?>

<main class="login-main">

    <div class="login-brand-identification">
        <div class="brand-symbol">
            <i class="bi bi-droplet"></i>
        </div>

        <strong>Reoleo</strong>

        <span class="region-label">BAIXADA SANTISTA</span>
    </div>

    <section class="login-container">

        <aside class="login-information">
            <div class="information-content">

                <h1>
                    Preservando a orla e o estuário da Baixada Santista.
                </h1>

                <p>
                    Conectamos geradores gastronômicos, condomínios e usinas
                    em conformidade com as metas ambientais do litoral paulista.
                </p>

                <div class="ods-card">

                    <div class="ods-title">
                        <span class="ods-symbol">🌎</span>
                        <strong>ODS</strong>
                    </div>

                    <p>
                        Alinhado às diretrizes metropolitanas e aos Objetivos
                        de Desenvolvimento Sustentável (ODS).
                    </p>

                </div>
            </div>
        </aside>

        <section class="login-form-area">

            <div class="login-form-content">

                <div class="login-tabs" role="tablist" aria-label="Acesso à plataforma">

                    <button
                        type="button"
                        class="login-tab active"
                        id="tab-login"
                        role="tab"
                        aria-controls="login-panel"
                        aria-selected="true">

                        <i class="bi bi-box-arrow-in-right"></i>
                        Entrar
                    </button>

                    <button
                        type="button"
                        class="login-tab"
                        id="tab-register"
                        role="tab"
                        aria-controls="register-panel"
                        aria-selected="false">

                        <i class="bi bi-person-plus"></i>
                        Criar conta
                    </button>

                </div>

                <div class="form-panel active" id="login-panel" role="tabpanel" aria-labelledby="tab-login">

                    <h2>Acesse seu painel</h2>

                    <p class="form-subtitle">
                        E gerencie seus agendamentos
                    </p>

                    <form class="reoleo-form" id="login-form">

                        <div class="form-field">

                            <label for="login-email">
                                E-mail institucional ou corporativo
                                <span>*</span>
                            </label>

                            <div class="input-wrapper">
                                <i class="bi bi-envelope"></i>

                                <input
                                    type="email"
                                    id="login-email"
                                    placeholder="contato@restaurante.com.br"
                                    autocomplete="email"
                                    required>
                            </div>

                        </div>

                        <div class="form-field">

                            <div class="password-label">
                                <label for="login-password">
                                    Senha de acesso <span>*</span>
                                </label>

                                <a href="<?= base_url('recuperar-senha') ?>">
                                    Esqueci minha senha
                                </a>
                            </div>

                            <div class="input-wrapper">
                                <i class="bi bi-lock"></i>

                                <input
                                    type="password"
                                    id="login-password"
                                    placeholder="Digite sua senha"
                                    autocomplete="current-password"
                                    required>

                                <button
                                    type="button"
                                    class="password-toggle"
                                    data-password="login-password"
                                    aria-label="Mostrar senha">

                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>

                        </div>

                        <button type="submit" class="submit-button">
                            Entrar na plataforma
                            <i class="bi bi-arrow-right"></i>
                        </button>

                        <p class="form-feedback" id="login-feedback" role="status" aria-live="polite"></p>

                    </form>

                </div>

                <div class="form-panel" id="register-panel" role="tabpanel" aria-labelledby="tab-register" hidden>

                    <h2>Crie sua conta</h2>

                    <p class="form-subtitle">
                        Faça parte da rede sustentável Reoleo
                    </p>

                    <form class="reoleo-form register-form" id="register-form">

                        <div class="register-profile-title">
                            Tipo de perfil <span>*</span>
                        </div>

                        <div class="register-profile-options">

                            <div class="profile-option">
                                <input
                                    type="radio"
                                    name="profile"
                                    id="profile-generator"
                                    value="gerador"
                                    checked
                                    required>

                                <label for="profile-generator">
                                    <i class="bi bi-shop"></i>

                                    <h3>Gerador</h3>

                                    <p>
                                        Restaurante, condomínio ou estabelecimento
                                        que gera óleo usado.
                                    </p>

                                    <i class="bi bi-check-circle-fill profile-check"></i>
                                </label>
                            </div>

                            <div class="profile-option">
                                <input
                                    type="radio"
                                    name="profile"
                                    id="profile-collector"
                                    value="coletor"
                                    required>

                                <label for="profile-collector">
                                    <i class="bi bi-truck"></i>

                                    <h3>Coletor</h3>

                                    <p>
                                        Empresa responsável pela coleta e destinação
                                        adequada do óleo.
                                    </p>

                                    <i class="bi bi-circle profile-check"></i>
                                </label>
                            </div>

                        </div>

                        <div class="register-fields">

                            <div class="form-field full-width">
                                <label for="register-name">
                                    Nome completo ou razão social <span>*</span>
                                </label>

                                <div class="input-wrapper">
                                    <i class="bi bi-person"></i>

                                    <input
                                        type="text"
                                        id="register-name"
                                        placeholder="Digite seu nome ou empresa"
                                        autocomplete="name"
                                        required>
                                </div>
                            </div>

                            <div class="form-field">
                                <label for="register-document">
                                    CPF / CNPJ <span>*</span>
                                </label>

                                <div class="input-wrapper">
                                    <i class="bi bi-card-text"></i>

                                    <input
                                        type="text"
                                        id="register-document"
                                        placeholder="000.000.000-00"
                                        required>
                                </div>
                            </div>

                            <div class="form-field">
                                <label for="register-phone">
                                    Telefone <span>*</span>
                                </label>

                                <div class="input-wrapper">
                                    <i class="bi bi-telephone"></i>

                                    <input
                                        type="tel"
                                        id="register-phone"
                                        placeholder="(13) 99999-9999"
                                        autocomplete="tel"
                                        required>
                                </div>
                            </div>

                            <div class="form-field full-width">
                                <label for="register-email">
                                    E-mail <span>*</span>
                                </label>

                                <div class="input-wrapper">
                                    <i class="bi bi-envelope"></i>

                                    <input
                                        type="email"
                                        id="register-email"
                                        placeholder="seuemail@exemplo.com"
                                        autocomplete="email"
                                        required>
                                </div>
                            </div>

                            <div class="form-field full-width">
                                <label for="register-password">
                                    Crie uma senha <span>*</span>
                                </label>

                                <div class="input-wrapper">
                                    <i class="bi bi-lock"></i>

                                    <input
                                        type="password"
                                        id="register-password"
                                        placeholder="Crie uma senha"
                                        autocomplete="new-password"
                                        required>

                                    <button
                                        type="button"
                                        class="password-toggle"
                                        data-password="register-password"
                                        aria-label="Mostrar senha">

                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                        </div>

                        <div class="register-address">

                            <h3>
                                <i class="bi bi-geo-alt"></i>
                                Endereço da instituição
                            </h3>

                            <div class="address-grid">

                                <div class="form-field">
                                    <label for="register-cep">
                                        CEP <span>*</span>
                                    </label>

                                    <div class="input-wrapper">
                                        <i class="bi bi-mailbox"></i>

                                        <input
                                            type="text"
                                            id="register-cep"
                                            placeholder="00000-000"
                                            required>
                                    </div>
                                </div>

                                <div class="form-field">
                                    <label for="register-number">
                                        Número <span>*</span>
                                    </label>

                                    <div class="input-wrapper">
                                        <i class="bi bi-hash"></i>

                                        <input
                                            type="text"
                                            id="register-number"
                                            placeholder="Nº"
                                            required>
                                    </div>
                                </div>

                                <div class="form-field address-full">
                                    <label for="register-street">
                                        Rua / Avenida <span>*</span>
                                    </label>

                                    <div class="input-wrapper">
                                        <i class="bi bi-signpost"></i>

                                        <input
                                            type="text"
                                            id="register-street"
                                            placeholder="Nome da rua ou avenida"
                                            required>
                                    </div>
                                </div>

                                <div class="form-field">
                                    <label for="register-neighborhood">
                                        Bairro <span>*</span>
                                    </label>

                                    <div class="input-wrapper">
                                        <i class="bi bi-geo"></i>

                                        <input
                                            type="text"
                                            id="register-neighborhood"
                                            placeholder="Seu bairro"
                                            required>
                                    </div>
                                </div>

                                <div class="form-field">
                                    <label for="register-city">
                                        Município <span>*</span>
                                    </label>

                                    <div class="input-wrapper">
                                        <i class="bi bi-building"></i>

                                        <input
                                            type="text"
                                            id="register-city"
                                            placeholder="Seu município"
                                            required>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="register-terms">
                            <input
                                type="checkbox"
                                id="register-terms"
                                required>

                            <label for="register-terms">
                                Li e concordo com os
                                <a href="<?= base_url('termos') ?>">
                                    Termos de Uso
                                </a>
                                e a
                                <a href="<?= base_url('privacidade') ?>">
                                    Política de Privacidade
                                </a>.
                            </label>
                        </div>

                        <button type="submit" class="submit-button register-submit">
                            Criar minha conta
                            <i class="bi bi-arrow-right"></i>
                        </button>

                        <p class="form-feedback" id="register-feedback" role="status" aria-live="polite"></p>

                    </form>

                    <p class="register-footer-link">
                        Já possui uma conta?
                        <a href="#" id="back-to-login">
                            Entrar na plataforma
                        </a>
                    </p>

                </div>

                <div class="privacy-notice">
                    <i class="bi bi-shield-lock-fill"></i>

                    <p>
                        Seus dados estão em conformidade com a LGPD
                        (Lei Geral de Proteção de Dados).
                    </p>
                </div>

            </div>

        </section>

    </section>

</main>

<?= $this->include('layouts/footer') ?>

<script>
    const loginPanel = document.getElementById('login-panel');
    const registerPanel = document.getElementById('register-panel');

    const loginTab = document.getElementById('tab-login');
    const registerTab = document.getElementById('tab-register');

    function showLoginTab(tab) {
        const showLogin = tab === 'login';

        loginPanel.classList.toggle('active', showLogin);
        registerPanel.classList.toggle('active', !showLogin);

        loginPanel.hidden = !showLogin;
        registerPanel.hidden = showLogin;

        loginTab.classList.toggle('active', showLogin);
        registerTab.classList.toggle('active', !showLogin);

        loginTab.setAttribute('aria-selected', String(showLogin));
        registerTab.setAttribute('aria-selected', String(!showLogin));
    }

    loginTab.addEventListener('click', () => showLoginTab('login'));
    registerTab.addEventListener('click', () => showLoginTab('register'));

    document.getElementById('back-to-login').addEventListener('click', (event) => {
        event.preventDefault();
        showLoginTab('login');
    });

    document.querySelectorAll('.password-toggle').forEach((button) => {
        button.addEventListener('click', () => {
            const input = document.getElementById(button.dataset.password);
            const icon = button.querySelector('i');

            const showPassword = input.type === 'password';

            input.type = showPassword ? 'text' : 'password';

            icon.classList.toggle('bi-eye', !showPassword);
            icon.classList.toggle('bi-eye-slash', showPassword);

            button.setAttribute(
                'aria-label',
                showPassword ? 'Ocultar senha' : 'Mostrar senha'
            );
        });
    });

    const profileOptions = document.querySelectorAll('.profile-option');

    function updateProfileSelection() {
        profileOptions.forEach((option) => {
            const radio = option.querySelector('input[type="radio"]');
            const checkIcon = option.querySelector('.profile-check');

            const selected = radio.checked;

            option.classList.toggle('active', selected);

            checkIcon.classList.toggle('bi-check-circle-fill', selected);
            checkIcon.classList.toggle('bi-circle', !selected);
        });
    }

    profileOptions.forEach((option) => {
        const radio = option.querySelector('input[type="radio"]');

        radio.addEventListener('change', updateProfileSelection);
    });

    updateProfileSelection();

    document.getElementById('login-form').addEventListener('submit', (event) => {
        event.preventDefault();

        const feedback = document.getElementById('login-feedback');

        feedback.textContent = 'Validação concluída. O login será conectado ao sistema na etapa de integração.';
        feedback.classList.add('visible');
        feedback.classList.remove('error');
    });

    document.getElementById('register-form').addEventListener('submit', (event) => {
        event.preventDefault();

        const feedback = document.getElementById('register-feedback');

        feedback.textContent = 'Validação concluída. O cadastro será conectado ao sistema na etapa de integração.';
        feedback.classList.add('visible');
        feedback.classList.remove('error');
    });

    document.querySelectorAll('.reoleo-form input').forEach((input) => {
        input.addEventListener('input', () => {
            const form = input.closest('form');
            const feedback = form.querySelector('.form-feedback');

            feedback.textContent = '';
            feedback.classList.remove('visible', 'error');
        });
    });
</script>

</body>
</html>
