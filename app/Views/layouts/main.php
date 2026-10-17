<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($titulo ?? 'Reoleo') ?> | Reoleo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <?= $this->renderSection('head') ?>
</head>
<body>
    <?php if ($mostrarMenu ?? true): ?>
        <?= $this->include('partials/header') ?>
    <?php endif; ?>

    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <script src="<?= base_url('js/main.js') ?>"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>