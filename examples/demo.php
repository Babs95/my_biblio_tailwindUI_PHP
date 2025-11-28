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
use TailwindUI\Modal;
use TailwindUI\Tooltip;
use TailwindUI\Progress;
use TailwindUI\Skeleton;

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

    <!-- New Button Variants -->
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">Nouveaux Boutons</h2>
        <?= Card::basic('
            <div class="space-y-4">
                <div>
                    <h3 class="text-sm font-semibold mb-3">Boutons avec effets spéciaux</h3>
                    <div class="flex flex-wrap gap-3">
                        ' . Button::gradientAnimated('Gradient Animé') . '
                        ' . Button::neon('Néon Cyan', 'cyan') . '
                        ' . Button::threed('3D Effect', 'blue') . '
                        ' . Button::dark('Dark Mode') . '
                        ' . Button::ghost('Ghost') . '
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-semibold mb-3">États de chargement</h3>
                    <div class="flex flex-wrap gap-3">
                        ' . Button::loading('Chargement...', true, 'primary') . '
                        ' . Button::loading('Terminé', false, 'success') . '
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-semibold mb-3">Avec badge de notification</h3>
                    ' . Button::withBadge('Messages', 'fas fa-envelope', '3', 'primary') . '
                </div>
            </div>
        ') ?>
    </section>

    <!-- Progress -->
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">Indicateurs de Progression</h2>
        <?= Card::basic('
            <div class="space-y-6">
                <div>
                    <h3 class="text-sm font-semibold mb-3">Barres de progression</h3>
                    ' . Progress::bar(75, 'blue', 'Téléchargement') . '
                    <div class="mt-4">
                        ' . Progress::bar(45, 'green', 'Installation') . '
                    </div>
                    <div class="mt-4">
                        ' . Progress::bar(90, 'orange', 'Traitement') . '
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-semibold mb-3">Indicateurs circulaires</h3>
                    <div class="flex gap-8">
                        ' . Progress::circle(75, 'blue', 'Complet') . '
                        ' . Progress::circle(50, 'green', 'En cours') . '
                        ' . Progress::circle(25, 'red', 'Faible') . '
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-semibold mb-3">Spinners et dots</h3>
                    <div class="flex items-center gap-6">
                        ' . Progress::spinner('blue', [], 'md') . '
                        ' . Progress::spinner('green', [], 'lg') . '
                        ' . Progress::dots('purple') . '
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-semibold mb-3">Progression par étapes</h3>
                    ' . Progress::steps(['Commande', 'Paiement', 'Livraison', 'Terminé'], 2) . '
                </div>
            </div>
        ') ?>
    </section>

    <!-- Skeleton -->
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">Skeleton Loaders</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-sm font-semibold mb-3">Carte avec skeleton</h3>
                <?= Skeleton::card(true, 3) ?>
            </div>
            <div>
                <h3 class="text-sm font-semibold mb-3">Liste avec skeleton</h3>
                <?= Skeleton::list(4, true) ?>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">Modals</h2>
        <?= Card::basic('
            <div class="flex flex-wrap gap-4">
                ' . Modal::trigger('modal-basic', 'Modal Basique', 'primary') . '
                ' . Modal::trigger('modal-confirm', 'Modal de Confirmation', 'danger') . '
                ' . Modal::trigger('modal-glass', 'Modal Glass', 'info') . '
                ' . Modal::trigger('modal-drawer', 'Drawer', 'secondary') . '
            </div>
        ') ?>

        <?= Modal::basic('modal-basic', 'Titre de la Modal', '
            <p class="text-gray-600 mb-4">Ceci est le contenu de la modal. Vous pouvez y mettre n\'importe quel contenu HTML.</p>
            <p class="text-gray-600">Les modals sont animées et accessibles avec support du clavier (Escape pour fermer).</p>
        ', '
            <div class="flex justify-end space-x-3">
                ' . Button::secondary('Annuler', ['data-modal-close' => true]) . '
                ' . Button::primary('Confirmer') . '
            </div>
        ') ?>

        <?= Modal::confirm('modal-confirm', 'Confirmer la suppression', 'Êtes-vous sûr de vouloir supprimer cet élément ? Cette action est irréversible.') ?>

        <?= Modal::glass('modal-glass', 'Modal Glassmorphism', '
            <p class="text-gray-600 mb-4">Cette modal utilise un effet de verre (glassmorphism) moderne.</p>
            <p class="text-gray-600">L\'arrière-plan est flouté avec un effet de transparence élégant.</p>
        ') ?>

        <?= Modal::drawer('modal-drawer', 'Drawer depuis la droite', '
            <div class="space-y-4">
                <p class="text-gray-600">Les drawers glissent depuis le côté de l\'écran.</p>
                <p class="text-gray-600">Parfait pour les menus de navigation ou les formulaires.</p>
                ' . Form::input('name', 'Nom', ['placeholder' => 'Entrez votre nom']) . '
                ' . Form::input('email', 'Email', ['type' => 'email', 'placeholder' => 'votre@email.com']) . '
                ' . Button::primary('Enregistrer', ['class' => 'w-full']) . '
            </div>
        ') ?>
    </section>

    <!-- Tooltips -->
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">Tooltips</h2>
        <?= Card::basic('
            <div class="space-y-4">
                <div>
                    <h3 class="text-sm font-semibold mb-3">Positions</h3>
                    <div class="flex justify-center gap-8">
                        ' . Tooltip::top(Button::secondary('En haut'), 'Tooltip en haut') . '
                        ' . Tooltip::bottom(Button::secondary('En bas'), 'Tooltip en bas') . '
                        ' . Tooltip::left(Button::secondary('À gauche'), 'Tooltip à gauche') . '
                        ' . Tooltip::right(Button::secondary('À droite'), 'Tooltip à droite') . '
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-semibold mb-3">Thèmes</h3>
                    <div class="flex justify-center gap-4">
                        ' . Tooltip::top(Button::primary('Dark'), 'Thème sombre', 'dark') . '
                        ' . Tooltip::top(Button::secondary('Light'), 'Thème clair', 'light') . '
                        ' . Tooltip::top(Button::success('Success'), 'Succès !', 'success') . '
                        ' . Tooltip::top(Button::danger('Danger'), 'Attention !', 'danger') . '
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-semibold mb-3">Avec icône</h3>
                    <p class="text-gray-600">
                        Ceci est un texte avec une info-bulle ' . Tooltip::icon('fas fa-info-circle', 'Information complémentaire') . ' au milieu.
                    </p>
                </div>
            </div>
        ') ?>
    </section>

    <!-- Advanced Cards -->
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">Cartes Avancées</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?= Card::feature('Performance', 'Optimisé pour la vitesse avec des animations fluides et un temps de chargement minimal', 'fas fa-rocket', 'blue') ?>
            <?= Card::glass('<div class="space-y-4"><h3 class="text-lg font-bold">Glassmorphism</h3><p class="text-gray-600">Effet de verre moderne avec flou et transparence</p></div>') ?>
            <?= Card::pricing('Pro', '29€', 'mois', ['Utilisateurs illimités', 'Support 24/7', 'API avancée', 'Analyses détaillées'], true, Button::primary('Commencer', ['class' => 'w-full'])) ?>
        </div>

        <div class="mt-6">
            <?= Card::testimonial('Cette bibliothèque m\'a fait gagner énormément de temps ! Les composants sont magnifiques et faciles à utiliser.', 'Jean Dupont', 'Développeur Full Stack') ?>
        </div>
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
