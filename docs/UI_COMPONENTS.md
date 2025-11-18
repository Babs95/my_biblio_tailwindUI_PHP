# Bibliothèque de Composants UI Tailwind CSS

Documentation complète de la bibliothèque de composants réutilisables TaskCollab.

## 📚 Table des Matières

1. [Installation et Configuration](#installation-et-configuration)
2. [Composants Disponibles](#composants-disponibles)
   - [Button](#button)
   - [Card](#card)
   - [Form](#form)
   - [Alert](#alert)
   - [Badge](#badge)
   - [Table](#table)
   - [Navigation](#navigation)
3. [Exemples d'Utilisation](#exemples-dutilisation)
4. [Personnalisation](#personnalisation)

---

## Installation et Configuration

### Prérequis

- PHP 8.0+
- Tailwind CSS (via CDN ou npm)
- Font Awesome 6+ (pour les icônes)

### Configuration

Les composants utilisent l'autoloading PSR-4. Assurez-vous que le namespace `TailwindUI` est configuré correctement :

```php
<?php
// Dans votre fichier autoload ou controller
use TailwindUI\Button;
use TailwindUI\Card;
use TailwindUI\Form;
use TailwindUI\Alert;
use TailwindUI\Badge;
use TailwindUI\Table;
use TailwindUI\Navigation;
```

---

## Composants Disponibles

## Button

Composant pour créer des boutons stylisés avec différentes variantes.

### Méthodes Disponibles

#### Variantes de Base

```php
// Bouton primaire (bleu)
Button::primary('Enregistrer', ['type' => 'submit']);

// Bouton secondaire (gris)
Button::secondary('Annuler', ['onclick' => 'history.back()']);

// Bouton de succès (vert)
Button::success('Valider');

// Bouton de danger (rouge)
Button::danger('Supprimer', ['data-confirm' => 'Êtes-vous sûr ?']);

// Bouton d'avertissement (orange)
Button::warning('Attention');

// Bouton d'information (bleu clair)
Button::info('En savoir plus');
```

#### Boutons Outline

```php
// Bouton avec contour uniquement
Button::outline('Modifier', 'blue');
Button::outline('Supprimer', 'red');
```

#### Tailles

```php
// Tailles disponibles : 'sm', 'md', 'lg', 'xl'
Button::primary('Petit', [], 'sm');
Button::primary('Moyen', [], 'md');  // Par défaut
Button::primary('Grand', [], 'lg');
Button::primary('Très grand', [], 'xl');
```

#### Boutons avec Icônes

```php
// Bouton avec icône
Button::withIcon('Enregistrer', 'fas fa-save', 'primary');

// Icône uniquement
Button::icon('fas fa-trash', 'danger', ['title' => 'Supprimer']);
```

#### Groupe de Boutons

```php
$buttons = [
    Button::primary('Oui'),
    Button::secondary('Non'),
    Button::danger('Annuler')
];

echo Button::group($buttons);
```

### Exemple Complet

```php
<form method="POST" action="/projects/create">
    <!-- Contenu du formulaire -->

    <div class="flex justify-end space-x-4">
        <?= Button::secondary('Annuler', ['onclick' => 'history.back()']) ?>
        <?= Button::withIcon('Créer le projet', 'fas fa-plus', 'primary', ['type' => 'submit']) ?>
    </div>
</form>
```

---

## Card

Composant pour créer des cartes de contenu.

### Méthodes Disponibles

#### Carte Basique

```php
// Carte simple
Card::basic('<p>Contenu de la carte</p>');
```

#### Carte avec En-tête

```php
// Avec en-tête et footer
Card::withHeader(
    'Titre de la carte',
    '<p>Contenu principal</p>',
    '<button>Action</button>'  // Footer optionnel
);
```

#### Carte de Statistique

```php
// Carte stat
Card::stat('Total Utilisateurs', '1,234', 'fas fa-users', 'blue');
Card::stat('Revenus', '12,500 €', 'fas fa-euro-sign', 'green');
Card::stat('Erreurs', '3', 'fas fa-exclamation-triangle', 'red');
```

Couleurs disponibles : `blue`, `green`, `red`, `orange`, `purple`, `yellow`

#### Carte de Projet

```php
$project = [
    'title' => 'Site E-commerce',
    'description' => 'Développement d\'un site e-commerce complet avec panier et paiement',
    'color' => '#3B82F6',
    'status' => 'active',
    'deadline' => '15/12/2024'
];

echo Card::project($project);
```

#### Carte Vide (Empty State)

```php
Card::empty(
    'fas fa-folder-open',
    'Aucun projet',
    'Commencez par créer votre premier projet',
    Button::primary('Créer un projet', ['href' => '/projects/create'])
);
```

### Exemple Complet

```php
<!-- Grille de statistiques -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <?= Card::stat('Total tâches', '42', 'fas fa-tasks', 'blue') ?>
    <?= Card::stat('Terminées', '28', 'fas fa-check-circle', 'green') ?>
    <?= Card::stat('En cours', '10', 'fas fa-spinner', 'orange') ?>
    <?= Card::stat('En retard', '4', 'fas fa-exclamation-triangle', 'red') ?>
</div>
```

---

## Form

Composant pour créer des éléments de formulaire.

### Méthodes Disponibles

#### Input Text/Email/Password

```php
// Input simple
Form::input('email', 'Adresse Email', ['type' => 'email', 'required' => true]);

// Avec message d'erreur
Form::input('password', 'Mot de passe',
    ['type' => 'password', 'required' => true],
    'Le mot de passe doit contenir au moins 8 caractères'
);

// Avec texte d'aide
Form::input('username', 'Nom d\'utilisateur', [],
    null,
    'Utilisez uniquement des lettres et des chiffres'
);
```

#### Textarea

```php
Form::textarea('description', 'Description', [
    'rows' => 4,
    'placeholder' => 'Décrivez votre projet...'
]);
```

#### Select

```php
$options = [
    'todo' => 'À faire',
    'in_progress' => 'En cours',
    'done' => 'Terminé'
];

Form::select('status', 'Statut', $options, 'todo');
```

#### Checkbox

```php
Form::checkbox('remember', 'Se souvenir de moi', true);
```

#### Radio Buttons

```php
Form::radio('priority', 'low', 'Basse priorité', false);
Form::radio('priority', 'medium', 'Priorité moyenne', true);
Form::radio('priority', 'high', 'Haute priorité', false);
```

#### File Upload

```php
Form::file('avatar', 'Photo de profil', [
    'accept' => 'image/*'
], null, 'JPG, PNG ou GIF (Max 2MB)');
```

#### Color Picker

```php
Form::color('color', 'Couleur du projet', '#3B82F6');
```

#### Date/Time

```php
// Date et heure
Form::datetime('deadline', 'Date limite', 'datetime-local');

// Date uniquement
Form::datetime('date', 'Date', 'date');

// Heure uniquement
Form::datetime('time', 'Heure', 'time');
```

#### Grille de Champs

```php
echo Form::grid([
    Form::input('firstname', 'Prénom', ['required' => true]),
    Form::input('lastname', 'Nom', ['required' => true])
], 2);
```

### Exemple Complet

```php
<form method="POST" action="/projects/create">
    <?= Form::input('title', 'Titre du projet', ['required' => true]) ?>

    <?= Form::textarea('description', 'Description') ?>

    <?= Form::grid([
        Form::color('color', 'Couleur'),
        Form::datetime('deadline', 'Date limite', 'datetime-local')
    ], 2) ?>

    <?= Form::select('priority', 'Priorité', [
        'low' => 'Basse',
        'medium' => 'Moyenne',
        'high' => 'Haute'
    ], 'medium') ?>

    <div class="flex justify-end space-x-4 pt-6 border-t">
        <?= Button::secondary('Annuler') ?>
        <?= Button::withIcon('Créer', 'fas fa-save', 'primary', ['type' => 'submit']) ?>
    </div>
</form>
```

---

## Alert

Composant pour afficher des messages d'alerte et de notification.

### Méthodes Disponibles

#### Alertes de Base

```php
// Succès
Alert::success('Opération réussie !');

// Erreur
Alert::error('Une erreur est survenue');

// Avertissement
Alert::warning('Attention, vérifiez vos données');

// Information
Alert::info('Information importante');
```

#### Alertes Non-Dismissibles

```php
Alert::success('Message permanent', false);
```

#### Messages Flash

```php
// Dans votre controller
use App\Utils\Session;

Session::flash('success', 'Projet créé avec succès !');
Session::flash('error', 'Erreur lors de la suppression');

// Dans votre vue
<?php
$flashes = [
    'success' => Session::getFlash('success'),
    'error' => Session::getFlash('error')
];
?>

<?= Alert::flashMessages(array_filter($flashes)) ?>
```

#### Toast Notifications

```php
// Toast avec durée personnalisée (en ms)
Alert::toast('Enregistrement réussi !', 'success', 3000);
```

### Exemple Complet

```php
<!-- Affichage des messages flash -->
<?php
use App\Utils\Session;

$flashes = [
    'success' => Session::getFlash('success'),
    'error' => Session::getFlash('error'),
    'warning' => Session::getFlash('warning'),
    'info' => Session::getFlash('info')
];

echo Alert::flashMessages(array_filter($flashes));
?>
```

---

## Badge

Composant pour créer des badges et étiquettes.

### Méthodes Disponibles

#### Badges de Couleur

```php
Badge::primary('Nouveau');
Badge::success('Actif');
Badge::danger('Erreur');
Badge::warning('Attention');
Badge::info('Info');
Badge::secondary('Inactif');
```

#### Badges de Statut (Auto-mapping)

```php
// Mapping automatique des couleurs selon le statut
Badge::status('active');        // Vert
Badge::status('inactive');      // Gris
Badge::status('pending');       // Jaune
Badge::status('completed');     // Vert
Badge::status('in_progress');   // Bleu
Badge::status('todo');          // Gris
Badge::status('cancelled');     // Rouge

// Avec label personnalisé
Badge::status('active', 'En ligne');
```

#### Badges de Priorité (Auto-mapping)

```php
Badge::priority('low');         // Gris
Badge::priority('medium');      // Bleu
Badge::priority('high');        // Orange
Badge::priority('urgent');      // Rouge

// Avec label personnalisé
Badge::priority('high', 'Prioritaire');
```

#### Badges avec Icône

```php
Badge::withIcon('5 nouveaux', 'fas fa-bell', 'bg-blue-100 text-blue-800');
```

#### Badges avec Point Indicateur

```php
Badge::withDot('En ligne', 'green');
Badge::withDot('Hors ligne', 'gray');
```

#### Badge de Compteur

```php
Badge::count(42, 'bg-red-100 text-red-800');
```

#### Groupe de Badges

```php
$badges = [
    Badge::primary('Tag 1'),
    Badge::success('Tag 2'),
    Badge::info('Tag 3')
];

echo Badge::group($badges);
```

### Exemple Complet

```php
<!-- Dans un tableau -->
<td>
    <?= Badge::status($task->getStatus()) ?>
</td>
<td>
    <?= Badge::priority($task->getPriority()) ?>
</td>

<!-- Tags multiples -->
<div>
    <?= Badge::group([
        Badge::primary('PHP'),
        Badge::info('MySQL'),
        Badge::success('Tailwind')
    ]) ?>
</div>
```

---

## Table

Composant pour créer des tableaux stylisés.

### Méthodes Disponibles

#### Tables de Base

```php
$headers = ['Nom', 'Email', 'Statut', 'Actions'];
$rows = [
    ['Jean Dupont', 'jean@example.com', Badge::status('active'), '...'],
    ['Marie Martin', 'marie@example.com', Badge::status('inactive'), '...']
];

// Table simple
Table::simple($headers, $rows);

// Table avec lignes alternées
Table::striped($headers, $rows);

// Table avec effet hover
Table::hoverable($headers, $rows);

// Table complète (striped + hover)
Table::full($headers, $rows);

// Table responsive
Table::responsive($headers, $rows);
```

#### Cellules Spéciales

```php
// Cellule de statut
Table::statusCell('active', 'En ligne');

// Cellule de priorité
Table::priorityCell('high', 'Haute');

// Cellule avec icône
Table::iconCell('fas fa-folder', 'Projet Web', 'blue');

// Cellule d'actions
$actions = [
    Table::actionButton('/edit/1', 'fas fa-edit', 'Modifier', 'blue'),
    Table::actionButton('/delete/1', 'fas fa-trash', 'Supprimer', 'red')
];
echo Table::actionsCell($actions);
```

#### Pagination

```php
// Dans votre vue
echo Table::pagination($currentPage, $totalPages, '/projects');
```

### Exemple Complet

```php
<?php
$headers = ['Tâche', 'Priorité', 'Statut', 'Échéance', 'Actions'];
$rows = [];

foreach ($tasks as $task) {
    $rows[] = [
        $task->getTitle(),
        Table::priorityCell($task->getPriority()),
        Table::statusCell($task->getStatus()),
        $task->getDueDate()?->format('d/m/Y') ?? '-',
        Table::actionsCell([
            Table::actionButton('/tasks/' . $task->getId(), 'fas fa-eye', 'Voir', 'blue'),
            Table::actionButton('/tasks/' . $task->getId() . '/edit', 'fas fa-edit', 'Modifier', 'green'),
            Table::actionButton('/tasks/' . $task->getId() . '/delete', 'fas fa-trash', 'Supprimer', 'red')
        ])
    ];
}

echo Table::full($headers, $rows);
?>
```

---

## Navigation

Composant pour créer des éléments de navigation.

### Méthodes Disponibles

#### Navbar

```php
$brand = '<a href="/" class="text-2xl font-bold text-blue-600">
    <i class="fas fa-tasks"></i> TaskCollab
</a>';

$links = [
    Navigation::link('Tableau de bord', '/', true, 'fas fa-home'),
    Navigation::link('Projets', '/projects', false, 'fas fa-folder'),
    Navigation::link('Mes tâches', '/tasks', false, 'fas fa-check-circle')
];

$userMenu = [
    'name' => 'Jean Dupont',
    'actions' => [
        Button::danger('Déconnexion', ['onclick' => 'window.location="/logout"'], 'sm')
    ]
];

echo Navigation::navbar($brand, $links, $userMenu);
```

#### Breadcrumb (Fil d'Ariane)

```php
$breadcrumb = [
    ['label' => 'Accueil', 'url' => '/'],
    ['label' => 'Projets', 'url' => '/projects'],
    ['label' => 'Site E-commerce', 'url' => '']  // Dernier = page actuelle
];

echo Navigation::breadcrumb($breadcrumb);
```

#### Tabs (Onglets)

```php
$tabs = [
    'all' => [
        'label' => 'Toutes',
        'url' => '/tasks?filter=all',
        'icon' => 'fas fa-list',
        'count' => 42
    ],
    'todo' => [
        'label' => 'À faire',
        'url' => '/tasks?filter=todo',
        'count' => 15
    ],
    'completed' => [
        'label' => 'Terminées',
        'url' => '/tasks?filter=completed',
        'count' => 27
    ]
];

echo Navigation::tabs($tabs, 'all');  // 'all' = onglet actif
```

#### Sidebar Menu

```php
$sidebarItems = [
    'dashboard' => [
        'label' => 'Tableau de bord',
        'url' => '/',
        'icon' => 'fas fa-home'
    ],
    'projects' => [
        'label' => 'Projets',
        'url' => '/projects',
        'icon' => 'fas fa-folder',
        'badge' => '3'  // Badge de notification
    ],
    'settings' => [
        'label' => 'Paramètres',
        'url' => '/settings',
        'icon' => 'fas fa-cog'
    ]
];

echo Navigation::sidebar($sidebarItems, 'dashboard');  // 'dashboard' = actif
```

#### Dropdown Menu

```php
$dropdownItems = [
    ['label' => 'Mon profil', 'url' => '/profile', 'icon' => 'fas fa-user'],
    ['label' => 'Paramètres', 'url' => '/settings', 'icon' => 'fas fa-cog'],
    'divider',  // Séparateur
    ['label' => 'Déconnexion', 'url' => '/logout', 'icon' => 'fas fa-sign-out-alt']
];

echo Navigation::dropdown('Mon compte', $dropdownItems);
```

### Exemple Complet

```php
<!-- Layout avec navigation complète -->
<?php
$brand = '<a href="' . APP_URL . '/" class="text-2xl font-bold text-blue-600">
    <i class="fas fa-tasks"></i> TaskCollab
</a>';

$links = [
    Navigation::link('Tableau de bord', APP_URL . '/', $currentRoute === 'dashboard', 'fas fa-home'),
    Navigation::link('Projets', APP_URL . '/projects', $currentRoute === 'projects', 'fas fa-folder'),
    Navigation::link('Mes tâches', APP_URL . '/tasks', $currentRoute === 'tasks', 'fas fa-check-circle')
];

$userMenu = [
    'name' => $currentUser['prenom'] . ' ' . $currentUser['nom'],
    'actions' => [
        Button::danger('Déconnexion', ['onclick' => 'window.location="' . APP_URL . '/logout"'], 'sm')
    ]
];

echo Navigation::navbar($brand, $links, $userMenu);
?>

<!-- Breadcrumb -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
    <?= Navigation::breadcrumb([
        ['label' => 'Accueil', 'url' => '/'],
        ['label' => 'Projets', 'url' => '/projects'],
        ['label' => $project->getTitle(), 'url' => '']
    ]) ?>
</div>
```

---

## Exemples d'Utilisation

### Formulaire de Création de Projet Complet

```php
<div class="max-w-2xl mx-auto">
    <?= Card::withHeader(
        'Nouveau Projet',
        '
        <form method="POST" action="/projects/create">
            ' . Form::input('title', 'Titre du projet', ['required' => true]) . '
            ' . Form::textarea('description', 'Description', ['rows' => 4]) . '
            ' . Form::grid([
                Form::color('color', 'Couleur', '#3B82F6'),
                Form::datetime('deadline', 'Date limite', 'datetime-local')
            ], 2) . '
            ' . Form::select('priority', 'Priorité', [
                'low' => 'Basse',
                'medium' => 'Moyenne',
                'high' => 'Haute'
            ], 'medium') . '
        </form>
        ',
        '
        <div class="flex justify-end space-x-4">
            ' . Button::secondary('Annuler', ['onclick' => 'history.back()']) . '
            ' . Button::withIcon('Créer', 'fas fa-save', 'primary', ['type' => 'submit', 'form' => 'createProject']) . '
        </div>
        '
    ) ?>
</div>
```

### Dashboard avec Statistiques

```php
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <?= Card::stat('Total Projets', '12', 'fas fa-folder', 'blue') ?>
    <?= Card::stat('Tâches Terminées', '87', 'fas fa-check-circle', 'green') ?>
    <?= Card::stat('En cours', '23', 'fas fa-spinner', 'orange') ?>
    <?= Card::stat('En retard', '5', 'fas fa-exclamation-triangle', 'red') ?>
</div>

<!-- Recent Tasks Table -->
<?= Card::withHeader(
    'Tâches Récentes',
    Table::full($headers, $rows),
    Navigation::pagination($currentPage, $totalPages, '/tasks')
) ?>
```

### Liste de Projets avec Empty State

```php
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <?php if (empty($projects)): ?>
        <div class="col-span-3">
            <?= Card::empty(
                'fas fa-folder-open',
                'Aucun projet',
                'Commencez par créer votre premier projet',
                Button::withIcon('Créer un projet', 'fas fa-plus', 'primary', ['onclick' => 'window.location="/projects/create"'])
            ) ?>
        </div>
    <?php else: ?>
        <?php foreach ($projects as $project): ?>
            <?= Card::project([
                'title' => $project->getTitle(),
                'description' => $project->getDescription(),
                'color' => $project->getColor(),
                'status' => $project->getStatus(),
                'deadline' => $project->getDeadline()?->format('d/m/Y')
            ]) ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
```

---

## Personnalisation

### Ajouter des Classes Personnalisées

Tous les composants acceptent un tableau `$attributes` où vous pouvez ajouter des classes personnalisées :

```php
Button::primary('Mon bouton', ['class' => 'custom-class']);
Card::basic('Contenu', ['class' => 'my-card-class']);
```

### Créer Vos Propres Variantes

Vous pouvez étendre les classes de composants pour créer vos propres variantes :

```php
<?php
namespace TailwindUI;

class MyButton extends Button
{
    public static function brand(string $text, array $attributes = []): string
    {
        $customClasses = 'bg-gradient-to-r from-purple-500 to-pink-500 text-white hover:from-purple-600 hover:to-pink-600';
        // Utilisez les méthodes protégées de la classe parente
        return parent::render($text, $customClasses, 'md', $attributes);
    }
}
```

### Thèmes

Pour modifier les couleurs globalement, vous pouvez utiliser la configuration Tailwind CSS :

```javascript
// tailwind.config.js
module.exports = {
    theme: {
        extend: {
            colors: {
                primary: '#your-color',
                // ...
            }
        }
    }
}
```

---

## Support et Contribution

Pour toute question ou suggestion d'amélioration, veuillez contacter l'équipe de développement TaskCollab.

**Projet pédagogique IAGE Formation L2**

---

*Dernière mise à jour : 2024*
