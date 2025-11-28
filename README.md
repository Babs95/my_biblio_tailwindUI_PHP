# TailwindUI PHP

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.0+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.0+">
  <img src="https://img.shields.io/badge/Tailwind_CSS-3.0+-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="License MIT">
</p>

<p align="center">
  <strong>Bibliothèque de composants UI réutilisables pour PHP avec Tailwind CSS</strong><br>
  Concentrez-vous sur votre logique métier, pas sur le CSS !
</p>

<p align="center">
  <a href="https://babs95.github.io/my_biblio_tailwindUI_PHP/">📚 Documentation</a> •
  <a href="#installation">⚡ Installation</a> •
  <a href="#composants">🧩 Composants</a> •
  <a href="#exemples">💡 Exemples</a>
</p>

---

## ✨ Fonctionnalités

- **13+ composants** prêts à l'emploi : Button, Card, Form, Alert, Badge, Table, Navigation, Modal, Tooltip, Progress, Skeleton, et plus
- **150+ méthodes** pour tous vos besoins UI
- **Effets modernes** : Gradients, glassmorphism, animations fluides, néon
- **60% moins de code** par rapport au HTML manuel
- **Sécurisé** : Échappement HTML automatique (protection XSS)
- **Accessible** : Support ARIA et navigation au clavier
- **Personnalisable** : Ajoutez vos propres classes CSS
- **Compatible Laravel** : Fonctionne avec Blade out-of-the-box

---

## 🚀 Installation

### Via Composer (Recommandé)

```bash
composer require tailwindui/php
```

### Installation Manuelle

1. Téléchargez le dossier `src/`
2. Configurez l'autoload PSR-4 :

```json
{
    "autoload": {
        "psr-4": {
            "TailwindUI\\": "path/to/src/"
        }
    }
}
```

3. Incluez Tailwind CSS et Font Awesome dans votre HTML :

```html
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
```

---

## 🧩 Composants

### Button

```php
use TailwindUI\Button;

// Variantes de base
echo Button::primary('Enregistrer');
echo Button::secondary('Annuler');
echo Button::success('Valider');
echo Button::danger('Supprimer');

// Nouveaux effets modernes
echo Button::gradientAnimated('Gradient Animé');
echo Button::neon('Néon', 'cyan');
echo Button::threed('3D Effect', 'blue');
echo Button::dark('Dark Mode');
echo Button::ghost('Ghost');
echo Button::glass('Glassmorphism');

// État de chargement
echo Button::loading('Chargement...', true, 'primary');

// Avec badge de notification
echo Button::withBadge('Messages', 'fas fa-envelope', '5', 'primary');

// Avec icône
echo Button::withIcon('Enregistrer', 'fas fa-save', 'primary');

// Tailles : 'xs', 'sm', 'md', 'lg', 'xl'
echo Button::primary('Petit', [], 'sm');
```

### Card

```php
use TailwindUI\Card;

// Carte de statistique
echo Card::stat('Projets', '42', 'fas fa-folder', 'blue');

// Carte avec en-tête
echo Card::withHeader('Titre', '<p>Contenu</p>', Button::primary('Action'));

// Empty state
echo Card::empty('fas fa-inbox', 'Aucun élément', 'Commencez maintenant');
```

### Form

```php
use TailwindUI\Form;

// Input
echo Form::input('email', 'Email', ['type' => 'email', 'required' => true]);

// Textarea
echo Form::textarea('description', 'Description', ['rows' => 4]);

// Select
echo Form::select('status', 'Statut', [
    'active' => 'Actif',
    'inactive' => 'Inactif'
], 'active');

// Checkbox
echo Form::checkbox('remember', 'Se souvenir de moi', true);

// Grille 2 colonnes
echo Form::grid([
    Form::input('firstname', 'Prénom'),
    Form::input('lastname', 'Nom')
], 2);
```

### Alert

```php
use TailwindUI\Alert;

echo Alert::success('Opération réussie !');
echo Alert::error('Une erreur est survenue');
echo Alert::warning('Attention !');
echo Alert::info('Information');

// Toast notification
echo Alert::toast('Enregistré !', 'success', 3000);
```

### Badge

```php
use TailwindUI\Badge;

// Couleurs
echo Badge::primary('Nouveau');
echo Badge::success('Actif');
echo Badge::danger('Erreur');

// Auto-mapping statut
echo Badge::status('active');      // → Vert "Actif"
echo Badge::status('pending');     // → Jaune "En attente"
echo Badge::status('completed');   // → Vert "Terminé"

// Auto-mapping priorité
echo Badge::priority('high');      // → Orange "Haute"
echo Badge::priority('urgent');    // → Rouge "Urgente"
```

### Table

```php
use TailwindUI\Table;

$headers = ['Nom', 'Statut', 'Actions'];
$rows = [
    ['Projet A', Badge::status('active'), Table::actionsCell([...])],
    ['Projet B', Badge::status('pending'), Table::actionsCell([...])]
];

echo Table::full($headers, $rows);
echo Table::pagination($currentPage, $totalPages, '/projects');
```

### Navigation

```php
use TailwindUI\Navigation;

// Breadcrumb
echo Navigation::breadcrumb([
    ['label' => 'Accueil', 'url' => '/'],
    ['label' => 'Projets', 'url' => '/projects'],
    ['label' => 'Mon Projet', 'url' => '']
]);

// Tabs
echo Navigation::tabs([
    'all' => ['label' => 'Tous', 'url' => '/tasks', 'count' => 42],
    'active' => ['label' => 'Actifs', 'url' => '/tasks?status=active']
], 'all');
```

### Modal

```php
use TailwindUI\Modal;

// Modal basique
echo Modal::basic('mon-modal', 'Titre', 'Contenu de la modal', $footer);

// Bouton pour ouvrir la modal
echo Modal::trigger('mon-modal', 'Ouvrir la modal', 'primary');

// Modal de confirmation
echo Modal::confirm('confirm', 'Supprimer', 'Êtes-vous sûr ?');

// Modal glassmorphism
echo Modal::glass('glass-modal', 'Effet Verre', 'Contenu élégant');

// Drawer depuis la droite
echo Modal::drawer('drawer', 'Menu', 'Contenu du drawer', 'right');
```

### Tooltip

```php
use TailwindUI\Tooltip;

// Tooltip en haut
echo Tooltip::top('Survolez-moi', 'Texte de l\'info-bulle');

// Différentes positions
echo Tooltip::bottom('Texte', 'Info-bulle en bas');
echo Tooltip::left('Texte', 'Info-bulle à gauche');
echo Tooltip::right('Texte', 'Info-bulle à droite');

// Tooltip avec icône
echo Tooltip::icon('fas fa-info-circle', 'Information complémentaire');

// Thèmes : dark, light, primary, success, danger
echo Tooltip::top('Texte', 'Info-bulle claire', 'light');
```

### Progress

```php
use TailwindUI\Progress;

// Barre de progression
echo Progress::bar(75, 'blue', 'Téléchargement');

// Progress circulaire
echo Progress::circle(60, 'green', 'Complet');

// Spinner de chargement
echo Progress::spinner('blue', [], 'md');

// Dots animés
echo Progress::dots('purple');

// Progression par étapes
echo Progress::steps(['Étape 1', 'Étape 2', 'Étape 3'], 2);
```

### Skeleton

```php
use TailwindUI\Skeleton;

// Texte skeleton
echo Skeleton::text(3); // 3 lignes

// Carte skeleton
echo Skeleton::card(true, 3); // avec image, 3 lignes

// Liste skeleton
echo Skeleton::list(5, true); // 5 items avec avatars

// Table skeleton
echo Skeleton::table(5, 4); // 5 lignes, 4 colonnes

// Grid de cards
echo Skeleton::grid(6, 3); // 6 items, 3 colonnes
```

---

## 💡 Exemples

### Formulaire Complet

```php
<?php
use TailwindUI\Form;
use TailwindUI\Button;
use TailwindUI\Card;
?>

<?= Card::withHeader('Nouveau Projet', '
    <form method="POST" action="/projects">
        ' . Form::input('title', 'Titre', ['required' => true]) . '
        ' . Form::textarea('description', 'Description') . '
        ' . Form::grid([
            Form::select('priority', 'Priorité', [
                'low' => 'Basse',
                'medium' => 'Moyenne',
                'high' => 'Haute'
            ]),
            Form::datetime('deadline', 'Date limite', 'date')
        ], 2) . '
        <div class="flex justify-end space-x-4 pt-4">
            ' . Button::secondary('Annuler') . '
            ' . Button::withIcon('Créer', 'fas fa-save', 'primary', ['type' => 'submit']) . '
        </div>
    </form>
') ?>
```

### Dashboard avec Stats

```php
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <?= Card::stat('Projets', '12', 'fas fa-folder', 'blue') ?>
    <?= Card::stat('Tâches', '48', 'fas fa-tasks', 'green') ?>
    <?= Card::stat('Terminées', '35', 'fas fa-check-circle', 'purple') ?>
    <?= Card::stat('En retard', '3', 'fas fa-exclamation-triangle', 'red') ?>
</div>
```

### Utilisation avec Laravel

```blade
{{-- resources/views/dashboard.blade.php --}}

@php use TailwindUI\Alert; use TailwindUI\Card; @endphp

@if(session('success'))
    {!! Alert::success(session('success')) !!}
@endif

<div class="grid grid-cols-4 gap-6">
    {!! Card::stat('Utilisateurs', $userCount, 'fas fa-users', 'blue') !!}
</div>
```

---

## 📊 Comparaison

### Avant (HTML manuel)

```html
<button class="inline-flex items-center px-4 py-2 border border-transparent
    text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700
    focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
    <i class="fas fa-save mr-2"></i> Enregistrer
</button>
```

### Après (TailwindUI PHP)

```php
<?= Button::withIcon('Enregistrer', 'fas fa-save', 'primary') ?>
```

**Résultat : 1 ligne au lieu de 5 !**

---

## 📖 Documentation

Consultez la documentation complète avec tous les exemples interactifs :

👉 **[https://babs95.github.io/my_biblio_tailwindUI_PHP/](https://babs95.github.io/my_biblio_tailwindUI_PHP/)**

---

## 🤝 Contribution

Les contributions sont les bienvenues ! N'hésitez pas à :

1. Fork le projet
2. Créer une branche (`git checkout -b feature/AmazingFeature`)
3. Commit vos changements (`git commit -m 'Add AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request

---

## 📝 License

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

---

## 🙏 Remerciements

- [Tailwind CSS](https://tailwindcss.com/) pour le framework CSS
- [Font Awesome](https://fontawesome.com/) pour les icônes
- Projet pédagogique IAGE Formation L2

---

<p align="center">
  Made with ❤️ by <a href="https://github.com/Babs95">Babs95</a>
</p>
