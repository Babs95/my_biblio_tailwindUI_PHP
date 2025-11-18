<?php
/**
 * TailwindUI PHP - Exemple de démonstration
 *
 * Ce fichier montre comment utiliser la bibliothèque de composants UI.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use TailwindUI\Button;
use TailwindUI\Card;
use TailwindUI\Form;
use TailwindUI\Alert;
use TailwindUI\Badge;
use TailwindUI\Table;
use TailwindUI\Navigation;

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TailwindUI PHP - Démo</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">

<div class="max-w-4xl mx-auto py-8 px-4">

    <!-- Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">
            <i class="fas fa-cube text-purple-600"></i> TailwindUI PHP
        </h1>
        <p class="text-lg text-gray-600">
            Démonstration des composants UI
        </p>
    </div>

    <!-- Alert -->
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">Alertes</h2>
        <?= Alert::success('Bienvenue ! Cette bibliothèque va vous faire gagner du temps.') ?>
        <?= Alert::info('Les composants sont 100% personnalisables.') ?>
    </section>

    <!-- Stats Cards -->
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">Cartes de Statistiques</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <?= Card::stat('Composants', '7', 'fas fa-puzzle-piece', 'blue') ?>
            <?= Card::stat('Méthodes', '100+', 'fas fa-code', 'green') ?>
            <?= Card::stat('Moins de code', '60%', 'fas fa-bolt', 'purple') ?>
            <?= Card::stat('Sécurisé', '100%', 'fas fa-shield-alt', 'orange') ?>
        </div>
    </section>

    <!-- Buttons -->
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">Boutons</h2>
        <?= Card::basic('
            <div class="space-y-4">
                <div class="flex flex-wrap gap-3">
                    ' . Button::primary('Primary') . '
                    ' . Button::secondary('Secondary') . '
                    ' . Button::success('Success') . '
                    ' . Button::danger('Danger') . '
                    ' . Button::warning('Warning') . '
                    ' . Button::info('Info') . '
                </div>
                <div class="flex flex-wrap gap-3">
                    ' . Button::withIcon('Enregistrer', 'fas fa-save', 'primary') . '
                    ' . Button::withIcon('Supprimer', 'fas fa-trash', 'danger') . '
                    ' . Button::withIcon('Télécharger', 'fas fa-download', 'success') . '
                </div>
            </div>
        ') ?>
    </section>

    <!-- Badges -->
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">Badges</h2>
        <?= Card::basic('
            <div class="space-y-4">
                <div>
                    <h3 class="text-sm font-semibold mb-2">Statuts (auto-mapping)</h3>
                    <div class="flex flex-wrap gap-2">
                        ' . Badge::status('active') . '
                        ' . Badge::status('pending') . '
                        ' . Badge::status('completed') . '
                        ' . Badge::status('in_progress') . '
                        ' . Badge::status('cancelled') . '
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-semibold mb-2">Priorités (auto-mapping)</h3>
                    <div class="flex flex-wrap gap-2">
                        ' . Badge::priority('low') . '
                        ' . Badge::priority('medium') . '
                        ' . Badge::priority('high') . '
                        ' . Badge::priority('urgent') . '
                    </div>
                </div>
            </div>
        ') ?>
    </section>

    <!-- Form -->
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">Formulaire</h2>
        <?= Card::withHeader('Nouveau Projet', '
            <form>
                ' . Form::input('title', 'Titre du projet', ['required' => true, 'placeholder' => 'Mon super projet']) . '
                ' . Form::textarea('description', 'Description', ['rows' => 3, 'placeholder' => 'Décrivez votre projet...']) . '
                ' . Form::grid([
                    Form::select('priority', 'Priorité', [
                        'low' => 'Basse',
                        'medium' => 'Moyenne',
                        'high' => 'Haute'
                    ], 'medium'),
                    Form::datetime('deadline', 'Date limite', 'date')
                ], 2) . '
                ' . Form::checkbox('notifications', 'Recevoir des notifications', true) . '
                <div class="flex justify-end space-x-4 pt-4 border-t">
                    ' . Button::secondary('Annuler') . '
                    ' . Button::withIcon('Créer', 'fas fa-save', 'primary', ['type' => 'submit']) . '
                </div>
            </form>
        ') ?>
    </section>

    <!-- Table -->
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">Tableau</h2>
        <?php
        $headers = ['Projet', 'Statut', 'Priorité', 'Actions'];
        $rows = [
            [
                'Site E-commerce',
                Badge::status('in_progress'),
                Badge::priority('high'),
                Table::actionsCell([
                    Table::actionButton('#', 'fas fa-eye', 'Voir', 'blue'),
                    Table::actionButton('#', 'fas fa-edit', 'Modifier', 'green'),
                    Table::actionButton('#', 'fas fa-trash', 'Supprimer', 'red')
                ])
            ],
            [
                'Application Mobile',
                Badge::status('pending'),
                Badge::priority('medium'),
                Table::actionsCell([
                    Table::actionButton('#', 'fas fa-eye', 'Voir', 'blue'),
                    Table::actionButton('#', 'fas fa-edit', 'Modifier', 'green')
                ])
            ],
            [
                'API REST',
                Badge::status('completed'),
                Badge::priority('low'),
                Table::actionsCell([
                    Table::actionButton('#', 'fas fa-eye', 'Voir', 'blue')
                ])
            ]
        ];

        echo Table::full($headers, $rows);
        ?>
    </section>

    <!-- Navigation -->
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">Navigation</h2>
        <?= Card::basic('
            <div class="space-y-6">
                <div>
                    <h3 class="text-sm font-semibold mb-2">Breadcrumb</h3>
                    ' . Navigation::breadcrumb([
                        ['label' => 'Accueil', 'url' => '#'],
                        ['label' => 'Projets', 'url' => '#'],
                        ['label' => 'Mon Projet', 'url' => '']
                    ]) . '
                </div>
                <div>
                    <h3 class="text-sm font-semibold mb-2">Tabs</h3>
                    ' . Navigation::tabs([
                        'all' => ['label' => 'Tous', 'url' => '#', 'icon' => 'fas fa-list', 'count' => 15],
                        'active' => ['label' => 'Actifs', 'url' => '#', 'count' => 8],
                        'completed' => ['label' => 'Terminés', 'url' => '#', 'count' => 7]
                    ], 'all') . '
                </div>
            </div>
        ') ?>
    </section>

    <!-- Footer -->
    <footer class="text-center text-gray-500 text-sm mt-12 pt-8 border-t">
        <p>TailwindUI PHP - Bibliothèque de composants UI</p>
        <p class="mt-2">
            <a href="https://github.com/Babs95/my_biblio_tailwindUI_PHP" class="text-purple-600 hover:text-purple-800">
                <i class="fab fa-github"></i> GitHub
            </a>
        </p>
    </footer>

</div>

</body>
</html>
