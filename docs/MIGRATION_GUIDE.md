# Guide de Migration vers la Bibliothèque UI

Ce guide vous aide à migrer vos vues existantes pour utiliser la nouvelle bibliothèque de composants UI.

## 📋 Table des Matières

1. [Avantages de la Migration](#avantages-de-la-migration)
2. [Migration par Composant](#migration-par-composant)
3. [Exemples Avant/Après](#exemples-avantaprès)
4. [Checklist de Migration](#checklist-de-migration)

---

## Avantages de la Migration

### ✅ Avant la Migration (HTML manuel)

```php
<button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
    <i class="fas fa-save mr-2"></i> Enregistrer
</button>
```

**Problèmes** :
- Code répétitif et verbeux
- Difficile à maintenir
- Incohérences de style
- Pas de validation des classes

### ✅ Après la Migration (Bibliothèque UI)

```php
<?= Button::withIcon('Enregistrer', 'fas fa-save', 'primary') ?>
```

**Avantages** :
- Code concis et lisible
- Styles cohérents
- Facile à maintenir
- Typage et validation

---

## Migration par Composant

### 1. Boutons

#### Avant
```php
<button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200">
    <i class="fas fa-sign-in-alt mr-2"></i> Se connecter
</button>
```

#### Après
```php
<?= Button::withIcon('Se connecter', 'fas fa-sign-in-alt', 'primary', ['type' => 'submit', 'class' => 'w-full py-3']) ?>
```

---

### 2. Cartes de Statistiques

#### Avant
```php
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-600">Total tâches</p>
            <p class="text-3xl font-bold text-gray-900"><?= $stats['total'] ?? 0 ?></p>
        </div>
        <div class="bg-blue-100 rounded-full p-3">
            <i class="fas fa-tasks text-blue-600 text-2xl"></i>
        </div>
    </div>
</div>
```

#### Après
```php
<?= Card::stat('Total tâches', $stats['total'] ?? 0, 'fas fa-tasks', 'blue') ?>
```

---

### 3. Formulaires

#### Avant
```php
<div>
    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
        <i class="fas fa-envelope mr-1"></i> Email
    </label>
    <input type="email"
           id="email"
           name="email"
           required
           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
           placeholder="votre.email@example.com">
</div>
```

#### Après
```php
<?= Form::input('email', 'Email', [
    'type' => 'email',
    'required' => true,
    'placeholder' => 'votre.email@example.com'
]) ?>
```

---

### 4. Messages Flash

#### Avant
```php
<?php if ($error): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <?= $error ?>
    </div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        <?= $success ?>
    </div>
<?php endif; ?>
```

#### Après
```php
<?php
$flashes = [
    'error' => Session::getFlash('error'),
    'success' => Session::getFlash('success')
];
echo Alert::flashMessages(array_filter($flashes));
?>
```

---

### 5. Badges de Statut

#### Avant
```php
<span class="px-2 py-1 text-xs rounded-full <?= $task->isDone() ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' ?>">
    <?= $task->getStatusLabel() ?>
</span>
```

#### Après
```php
<?= Badge::status($task->getStatus()) ?>
```

---

### 6. Tableaux

#### Avant
```php
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tâche</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Priorité</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($task->getTitle()) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full <?= $task->getPriorityClass() ?>">
                                <?= $task->getPriorityLabel() ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full">
                                <?= $task->getStatusLabel() ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
```

#### Après
```php
<?php
$headers = ['Tâche', 'Priorité', 'Statut'];
$rows = [];

foreach ($tasks as $task) {
    $rows[] = [
        htmlspecialchars($task->getTitle()),
        Table::priorityCell($task->getPriority()),
        Table::statusCell($task->getStatus())
    ];
}

echo Table::full($headers, $rows);
?>
```

---

## Exemples Avant/Après

### Exemple 1 : Page de Login

#### Avant (views/auth/login.php)
```php
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Mon Application</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-500 to-purple-600 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-lg shadow-2xl p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Connexion</h2>

            <?php if ($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form action="/login" method="POST" class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>
                    <input type="email"
                           id="email"
                           name="email"
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Mot de passe
                    </label>
                    <input type="password"
                           id="password"
                           name="password"
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700">
                    Se connecter
                </button>
            </form>
        </div>
    </div>
</body>
</html>
```

#### Après (Version avec Bibliothèque UI)
```php
<?php
use TailwindUI\Form;
use TailwindUI\Button;
use TailwindUI\Alert;
use App\Utils\Session;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Mon Application</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-500 to-purple-600 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-lg shadow-2xl p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Connexion</h2>

            <?php
            if ($error = Session::getFlash('error')) {
                echo Alert::error($error);
            }
            ?>

            <form action="/login" method="POST" class="space-y-4">
                <?= Form::input('email', 'Email', ['type' => 'email', 'required' => true]) ?>
                <?= Form::input('password', 'Mot de passe', ['type' => 'password', 'required' => true]) ?>
                <?= Button::primary('Se connecter', ['type' => 'submit', 'class' => 'w-full py-3']) ?>
            </form>
        </div>
    </div>
</body>
</html>
```

**Réduction de code : ~40%**

---

### Exemple 2 : Dashboard

#### Avant
```php
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Tableau de bord</h1>
        <a href="/projects/create" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i> Nouveau projet
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total tâches</p>
                    <p class="text-3xl font-bold text-gray-900"><?= $stats['total'] ?? 0 ?></p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <i class="fas fa-tasks text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>
        <!-- Répété 3 fois de plus... -->
    </div>
</div>
```

#### Après
```php
<?php
use TailwindUI\Button;
use TailwindUI\Card;
?>

<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Tableau de bord</h1>
        <?= Button::withIcon('Nouveau projet', 'fas fa-plus', 'primary', ['onclick' => 'window.location="/projects/create"']) ?>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <?= Card::stat('Total tâches', $stats['total'] ?? 0, 'fas fa-tasks', 'blue') ?>
        <?= Card::stat('Terminées', $stats['completed'] ?? 0, 'fas fa-check-circle', 'green') ?>
        <?= Card::stat('En cours', $stats['in_progress'] ?? 0, 'fas fa-spinner', 'orange') ?>
        <?= Card::stat('En retard', $stats['overdue'] ?? 0, 'fas fa-exclamation-triangle', 'red') ?>
    </div>
</div>
```

**Réduction de code : ~60%**

---

## Checklist de Migration

### Par Vue

- [ ] Identifier tous les boutons → Utiliser `Button::*`
- [ ] Identifier toutes les cartes → Utiliser `Card::*`
- [ ] Identifier tous les formulaires → Utiliser `Form::*`
- [ ] Identifier tous les messages → Utiliser `Alert::*`
- [ ] Identifier tous les badges → Utiliser `Badge::*`
- [ ] Identifier tous les tableaux → Utiliser `Table::*`
- [ ] Identifier la navigation → Utiliser `Navigation::*`

### Tests

- [ ] Vérifier l'affichage visuel
- [ ] Vérifier les comportements JavaScript
- [ ] Vérifier la responsivité mobile
- [ ] Vérifier l'accessibilité
- [ ] Tester tous les états (hover, focus, disabled)

### Performance

- [ ] Vérifier qu'il n'y a pas de duplication de CSS
- [ ] Vérifier que Tailwind CSS est bien chargé
- [ ] Vérifier que Font Awesome est bien chargé

---

## Conseils de Migration

### 1. Migrer Progressivement

Ne migrez pas toutes les vues d'un coup. Commencez par :
1. Les composants les plus répétés (boutons)
2. Les nouveaux écrans
3. Les écrans existants un par un

### 2. Créer des Helpers

Si vous avez des patterns spécifiques, créez des helpers :

```php
<?php
// Dans votre BaseController ou helpers.php

function taskStatusBadge($task) {
    return Badge::status($task->getStatus());
}

function deleteButton($url, $confirmMessage = 'Êtes-vous sûr ?') {
    return Button::danger('Supprimer', [
        'onclick' => "return confirm('$confirmMessage')",
        'formaction' => $url
    ]);
}
```

### 3. Documenter les Composants Custom

Si vous créez des variantes custom, documentez-les :

```php
/**
 * Bouton de téléchargement avec icône
 * @param string $url URL du fichier
 * @param string $filename Nom du fichier
 */
function downloadButton($url, $filename) {
    return Button::withIcon(
        'Télécharger ' . $filename,
        'fas fa-download',
        'info',
        ['href' => $url, 'download' => $filename]
    );
}
```

---

## Prochaines Étapes

1. ✅ Lire la documentation complète : `docs/UI_COMPONENTS.md`
2. ✅ Explorer les exemples : `docs/UI_EXAMPLES.php`
3. ✅ Migrer une vue test
4. ✅ Valider avec l'équipe
5. ✅ Migrer progressivement le reste

---

**Besoin d'aide ?** Consultez la documentation ou contactez l'équipe pédagogique.
