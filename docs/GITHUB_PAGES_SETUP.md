# Déploiement sur GitHub Pages

Guide pour déployer la documentation TailwindUI PHP sur GitHub Pages.

## 📋 Prérequis

- Un repository GitHub
- Accès aux paramètres du repository (Settings)

## 🚀 Étapes de Déploiement

### 1. Pousser le code sur GitHub

Assurez-vous que tous les fichiers du dossier `docs/` sont dans votre repository :

```bash
git add .
git commit -m "Ajout de la documentation GitHub Pages"
git push origin main
```

### 2. Configurer GitHub Pages

1. Allez dans votre repository sur GitHub
2. Cliquez sur **Settings** (Paramètres)
3. Dans le menu latéral, cliquez sur **Pages**
4. Sous **Source**, sélectionnez :
   - **Branch**: `main` (ou votre branche principale)
   - **Folder**: `/docs`
5. Cliquez sur **Save**

### 3. Attendre le déploiement

GitHub va automatiquement construire et déployer votre site. Cela prend généralement 1-2 minutes.

### 4. Accéder au site

Votre site sera disponible à l'adresse :

```
https://[votre-username].github.io/[nom-du-repo]/
```

Par exemple :
```
https://babs95.github.io/L2_IAGE_PHP_STARTER/
```

## 📁 Structure des Fichiers

```
docs/
├── index.html              # Page d'accueil principale
├── installation.html       # Guide d'installation PHP
├── laravel.html           # Guide d'intégration Laravel
├── UI_COMPONENTS.md       # Documentation complète
├── UI_EXAMPLES.php        # Exemples interactifs (PHP)
├── MIGRATION_GUIDE.md     # Guide de migration
├── GITHUB_PAGES_SETUP.md  # Ce fichier
└── assets/
    ├── css/
    └── js/
```

## 🔧 Configuration Avancée

### Domaine Personnalisé

1. Dans **Settings > Pages**, ajoutez votre domaine personnalisé
2. Créez un fichier `CNAME` dans le dossier `docs/` avec votre domaine :

```
docs.monsite.com
```

3. Configurez les DNS chez votre registrar

### Jekyll (Optionnel)

Si vous voulez utiliser Jekyll pour générer des pages markdown :

1. Créez un fichier `_config.yml` dans `docs/` :

```yaml
theme: jekyll-theme-minimal
title: TailwindUI PHP
description: Bibliothèque de composants UI pour PHP
```

2. Renommez vos fichiers `.md` et ajoutez un front matter YAML

### Désactiver Jekyll

Si vous n'utilisez pas Jekyll (comme dans notre cas avec des fichiers HTML statiques), créez un fichier `.nojekyll` vide dans `docs/` :

```bash
touch docs/.nojekyll
```

## 🔄 Mise à Jour

Pour mettre à jour le site :

1. Modifiez les fichiers dans `docs/`
2. Commitez et poussez :

```bash
git add docs/
git commit -m "Mise à jour de la documentation"
git push origin main
```

3. GitHub Pages se mettra automatiquement à jour

## 🐛 Dépannage

### Le site ne s'affiche pas

- Vérifiez que GitHub Pages est activé dans Settings > Pages
- Attendez quelques minutes après le premier déploiement
- Vérifiez les erreurs dans Actions > Pages Build and Deployment

### Les styles ne s'affichent pas

- Assurez-vous que Tailwind CSS est chargé via CDN
- Vérifiez que les chemins des assets sont relatifs

### 404 sur les pages

- Vérifiez que le fichier existe dans `docs/`
- Assurez-vous que les liens sont corrects (ex: `installation.html` pas `installation`)

## 📊 Analytics (Optionnel)

Pour suivre le trafic, ajoutez Google Analytics dans vos fichiers HTML :

```html
<head>
    <!-- ... autres balises ... -->

    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-XXXXXXXXXX');
    </script>
</head>
```

## 🔗 Liens Utiles

- [Documentation GitHub Pages](https://docs.github.com/en/pages)
- [Jekyll Themes](https://pages.github.com/themes/)
- [Custom Domains](https://docs.github.com/en/pages/configuring-a-custom-domain-for-your-github-pages-site)

---

## Résumé Rapide

1. Poussez le code sur GitHub
2. Settings > Pages > Source: main / docs
3. Attendez ~2 minutes
4. Visitez `https://username.github.io/repo-name/`

**C'est fait !** 🎉
