<?php
/**
 * Page de test pour tous les composants TailwindUI PHP
 */

// Autoload
spl_autoload_register(function ($class) {
    $prefix = 'TailwindUI\\';
    $base_dir = __DIR__ . '/src/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

use TailwindUI\Button;
use TailwindUI\Card;
use TailwindUI\Alert;
use TailwindUI\Badge;
use TailwindUI\Form;
use TailwindUI\Table;
use TailwindUI\Navigation;
use TailwindUI\Header;
use TailwindUI\Footer;
use TailwindUI\FlyoutMenu;
use TailwindUI\Banner;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test des Composants - TailwindUI PHP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">

<!-- Banner Test -->
<?= Banner::announcement('Bienvenue sur la page de test !', null, true) ?>

<div class="max-w-6xl mx-auto px-4 py-8">

    <h1 class="text-3xl font-bold text-gray-900 mb-8">Test des Composants</h1>

    <!-- FlyoutMenu Test -->
    <section class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-bold mb-4">FlyoutMenu</h2>
        <div class="flex gap-4 flex-wrap">
            <?= FlyoutMenu::simple('Menu Simple', [
                ['label' => 'Option 1', 'url' => '#', 'icon' => 'fas fa-home'],
                ['label' => 'Option 2', 'url' => '#', 'icon' => 'fas fa-cog'],
                'divider',
                ['label' => 'Option 3', 'url' => '#', 'icon' => 'fas fa-sign-out-alt']
            ]) ?>

            <?= FlyoutMenu::withDescriptions('Avec Descriptions', [
                [
                    'label' => 'Analytics',
                    'description' => 'Analysez vos données',
                    'url' => '#',
                    'icon' => 'fas fa-chart-bar'
                ],
                [
                    'label' => 'Reports',
                    'description' => 'Générez des rapports',
                    'url' => '#',
                    'icon' => 'fas fa-file-alt'
                ]
            ]) ?>
        </div>
    </section>

    <!-- Button Test -->
    <section class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-bold mb-4">Buttons</h2>
        <div class="flex gap-3 flex-wrap">
            <?= Button::primary('Primary') ?>
            <?= Button::secondary('Secondary') ?>
            <?= Button::success('Success') ?>
            <?= Button::danger('Danger') ?>
            <?= Button::warning('Warning') ?>
            <?= Button::info('Info') ?>
        </div>
        <div class="flex gap-3 flex-wrap mt-4">
            <?= Button::withIcon('Enregistrer', 'fas fa-save', 'primary') ?>
            <?= Button::withIcon('Supprimer', 'fas fa-trash', 'danger') ?>
            <?= Button::outline('Outline', 'blue') ?>
        </div>
    </section>

    <!-- Alert Test -->
    <section class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-bold mb-4">Alerts</h2>
        <?= Alert::success('Opération réussie !') ?>
        <?= Alert::error('Une erreur est survenue.') ?>
        <?= Alert::warning('Attention, vérifiez vos données.') ?>
        <?= Alert::info('Information importante.') ?>
    </section>

    <!-- Badge Test -->
    <section class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-bold mb-4">Badges</h2>
        <div class="flex gap-2 flex-wrap mb-4">
            <?= Badge::primary('Primary') ?>
            <?= Badge::success('Success') ?>
            <?= Badge::danger('Danger') ?>
            <?= Badge::warning('Warning') ?>
            <?= Badge::info('Info') ?>
        </div>
        <div class="flex gap-2 flex-wrap">
            <?= Badge::status('active') ?>
            <?= Badge::status('pending') ?>
            <?= Badge::status('completed') ?>
            <?= Badge::priority('high') ?>
            <?= Badge::priority('medium') ?>
            <?= Badge::priority('low') ?>
        </div>
    </section>

    <!-- Card Test -->
    <section class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-bold mb-4">Cards</h2>
        <div class="grid md:grid-cols-3 gap-4">
            <?= Card::stat('Total Projets', '42', 'fas fa-folder', 'blue') ?>
            <?= Card::stat('Revenus', '12,500 €', 'fas fa-euro-sign', 'green') ?>
            <?= Card::stat('Erreurs', '3', 'fas fa-exclamation-triangle', 'red') ?>
        </div>
    </section>

    <!-- Form Test -->
    <section class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-bold mb-4">Form Elements</h2>
        <div class="max-w-md space-y-4">
            <?= Form::input('email', 'Email', ['type' => 'email', 'placeholder' => 'votre@email.com']) ?>
            <?= Form::select('status', 'Statut', ['todo' => 'À faire', 'in_progress' => 'En cours', 'done' => 'Terminé'], 'todo') ?>
            <?= Form::textarea('description', 'Description', ['rows' => 3, 'placeholder' => 'Décrivez...']) ?>
            <?= Form::checkbox('remember', 'Se souvenir de moi', false) ?>
        </div>
    </section>

    <!-- Navigation Test -->
    <section class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-bold mb-4">Navigation</h2>
        <?= Navigation::breadcrumb([
            ['label' => 'Accueil', 'url' => '#'],
            ['label' => 'Projets', 'url' => '#'],
            ['label' => 'Configuration', 'url' => '']
        ]) ?>

        <div class="mt-4">
            <?= Navigation::tabs([
                'all' => ['label' => 'Toutes', 'url' => '#', 'icon' => 'fas fa-list', 'count' => 42],
                'active' => ['label' => 'Actives', 'url' => '#', 'count' => 8],
                'completed' => ['label' => 'Terminées', 'url' => '#', 'count' => 34]
            ], 'all') ?>
        </div>
    </section>

    <!-- Table Test -->
    <section class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-bold mb-4">Table</h2>
        <?php
        $headers = ['Tâche', 'Statut', 'Priorité'];
        $rows = [
            ['Développer API', Badge::status('in_progress'), Badge::priority('high')],
            ['Tests unitaires', Badge::status('pending'), Badge::priority('medium')],
            ['Documentation', Badge::status('completed'), Badge::priority('low')]
        ];
        echo Table::striped($headers, $rows);
        ?>
    </section>

    <!-- Header Test -->
    <section class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-bold mb-4">Header (Section)</h2>
        <?= Header::section('Titre de Section', 'Description de la section') ?>
    </section>

    <!-- Banner Alert Test -->
    <section class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-bold mb-4">Banner Alerts</h2>
        <div class="space-y-4">
            <?= Banner::alert('info', 'Information importante') ?>
            <?= Banner::alert('success', 'Opération réussie') ?>
            <?= Banner::alert('warning', 'Attention requise') ?>
            <?= Banner::alert('error', 'Une erreur est survenue') ?>
        </div>
    </section>

</div>

<!-- Footer Test -->
<?= Footer::withSocial('© 2024 TailwindUI PHP - Page de Test', [
    ['url' => '#', 'icon' => 'fab fa-github', 'label' => 'GitHub'],
    ['url' => '#', 'icon' => 'fab fa-twitter', 'label' => 'Twitter']
]) ?>

</body>
</html>
