<?php

namespace TailwindUI;

/**
 * Composant Header - En-têtes et sections hero
 *
 * Exemples d'utilisation :
 * Header::hero('Titre', 'Description')
 * Header::page('Titre de la page')
 * Header::centered('Titre', 'Sous-titre')
 */
class Header extends Component
{
    /**
     * Hero section simple
     */
    public static function hero(string $title, string $description, ?string $action = null, array $attributes = []): string
    {
        $classes = self::classNames([
            'bg-gradient-to-br from-blue-600 via-blue-700 to-purple-700 text-white py-24',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<header class="' . $classes . '" ' . self::attributes($attributes) . '>';
        $html .= '<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">';

        $html .= '<h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">';
        $html .= self::escape($title);
        $html .= '</h1>';

        $html .= '<p class="text-xl md:text-2xl text-blue-100 mb-8 max-w-3xl mx-auto leading-relaxed">';
        $html .= self::escape($description);
        $html .= '</p>';

        if ($action) {
            $html .= '<div class="flex flex-col sm:flex-row gap-4 justify-center">';
            $html .= $action;
            $html .= '</div>';
        }

        $html .= '</div>';
        $html .= '</header>';

        return $html;
    }

    /**
     * Hero avec image de fond
     */
    public static function heroWithBackground(string $title, string $description, string $backgroundImage, ?string $action = null, array $attributes = []): string
    {
        $classes = self::classNames([
            'relative bg-cover bg-center bg-no-repeat py-32',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<header class="' . $classes . '" style="background-image: url(\'' . self::escape($backgroundImage) . '\')" ' . self::attributes($attributes) . '>';

        // Overlay
        $html .= '<div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>';

        // Content
        $html .= '<div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">';

        $html .= '<h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">';
        $html .= self::escape($title);
        $html .= '</h1>';

        $html .= '<p class="text-xl text-gray-200 mb-8 max-w-3xl mx-auto">';
        $html .= self::escape($description);
        $html .= '</p>';

        if ($action) {
            $html .= '<div class="flex flex-col sm:flex-row gap-4 justify-center">';
            $html .= $action;
            $html .= '</div>';
        }

        $html .= '</div>';
        $html .= '</header>';

        return $html;
    }

    /**
     * Hero avec deux colonnes (texte + image)
     */
    public static function heroSplit(string $title, string $description, string $image, ?string $action = null, array $attributes = []): string
    {
        $classes = self::classNames([
            'bg-white py-16 lg:py-24',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<header class="' . $classes . '" ' . self::attributes($attributes) . '>';
        $html .= '<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">';
        $html .= '<div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">';

        // Text content
        $html .= '<div class="mb-12 lg:mb-0">';
        $html .= '<h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">';
        $html .= self::escape($title);
        $html .= '</h1>';
        $html .= '<p class="text-xl text-gray-600 mb-8 leading-relaxed">';
        $html .= self::escape($description);
        $html .= '</p>';

        if ($action) {
            $html .= '<div class="flex flex-col sm:flex-row gap-4">';
            $html .= $action;
            $html .= '</div>';
        }

        $html .= '</div>';

        // Image
        $html .= '<div class="relative">';
        $html .= '<img src="' . self::escape($image) . '" alt="" class="rounded-2xl shadow-2xl w-full">';
        $html .= '<div class="absolute -inset-4 bg-gradient-to-r from-blue-500 to-purple-500 rounded-2xl -z-10 opacity-20 blur-xl"></div>';
        $html .= '</div>';

        $html .= '</div>';
        $html .= '</div>';
        $html .= '</header>';

        return $html;
    }

    /**
     * En-tête de page simple
     */
    public static function page(string $title, ?string $description = null, ?string $action = null, array $attributes = []): string
    {
        $classes = self::classNames([
            'bg-white border-b border-gray-200 py-8',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<header class="' . $classes . '" ' . self::attributes($attributes) . '>';
        $html .= '<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">';
        $html .= '<div class="md:flex md:items-center md:justify-between">';

        $html .= '<div class="flex-1 min-w-0">';
        $html .= '<h1 class="text-2xl md:text-3xl font-bold text-gray-900">';
        $html .= self::escape($title);
        $html .= '</h1>';

        if ($description) {
            $html .= '<p class="mt-1 text-gray-500">' . self::escape($description) . '</p>';
        }

        $html .= '</div>';

        if ($action) {
            $html .= '<div class="mt-4 md:mt-0 md:ml-4">';
            $html .= $action;
            $html .= '</div>';
        }

        $html .= '</div>';
        $html .= '</div>';
        $html .= '</header>';

        return $html;
    }

    /**
     * En-tête de page avec breadcrumb
     */
    public static function pageWithBreadcrumb(string $title, array $breadcrumb, ?string $action = null, array $attributes = []): string
    {
        $classes = self::classNames([
            'bg-white border-b border-gray-200 py-8',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<header class="' . $classes . '" ' . self::attributes($attributes) . '>';
        $html .= '<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">';

        // Breadcrumb
        $html .= Navigation::breadcrumb($breadcrumb);

        // Title and action
        $html .= '<div class="mt-4 md:flex md:items-center md:justify-between">';

        $html .= '<h1 class="text-2xl md:text-3xl font-bold text-gray-900">';
        $html .= self::escape($title);
        $html .= '</h1>';

        if ($action) {
            $html .= '<div class="mt-4 md:mt-0 md:ml-4">';
            $html .= $action;
            $html .= '</div>';
        }

        $html .= '</div>';
        $html .= '</div>';
        $html .= '</header>';

        return $html;
    }

    /**
     * Section centré avec statistiques
     */
    public static function centered(string $title, string $description, ?array $stats = null, array $attributes = []): string
    {
        $classes = self::classNames([
            'bg-gray-50 py-16',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<header class="' . $classes . '" ' . self::attributes($attributes) . '>';
        $html .= '<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">';

        $html .= '<h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">';
        $html .= self::escape($title);
        $html .= '</h2>';

        $html .= '<p class="text-xl text-gray-600 max-w-2xl mx-auto mb-12">';
        $html .= self::escape($description);
        $html .= '</p>';

        // Stats
        if ($stats) {
            $html .= '<div class="grid grid-cols-2 md:grid-cols-4 gap-8">';
            foreach ($stats as $stat) {
                $html .= '<div>';
                $html .= '<div class="text-3xl md:text-4xl font-bold text-blue-600 mb-2">';
                $html .= self::escape($stat['value']);
                $html .= '</div>';
                $html .= '<div class="text-sm text-gray-500 uppercase tracking-wider">';
                $html .= self::escape($stat['label']);
                $html .= '</div>';
                $html .= '</div>';
            }
            $html .= '</div>';
        }

        $html .= '</div>';
        $html .= '</header>';

        return $html;
    }

    /**
     * Hero avec dégradé personnalisé
     */
    public static function gradient(string $title, string $description, string $gradientFrom, string $gradientTo, ?string $action = null, array $attributes = []): string
    {
        $gradient = 'from-' . $gradientFrom . ' to-' . $gradientTo;

        $classes = self::classNames([
            'bg-gradient-to-br ' . $gradient . ' text-white py-24',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<header class="' . $classes . '" ' . self::attributes($attributes) . '>';
        $html .= '<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">';

        $html .= '<h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">';
        $html .= self::escape($title);
        $html .= '</h1>';

        $html .= '<p class="text-xl text-white/80 mb-8 max-w-3xl mx-auto">';
        $html .= self::escape($description);
        $html .= '</p>';

        if ($action) {
            $html .= '<div class="flex flex-col sm:flex-row gap-4 justify-center">';
            $html .= $action;
            $html .= '</div>';
        }

        $html .= '</div>';
        $html .= '</header>';

        return $html;
    }

    /**
     * En-tête de section
     */
    public static function section(string $title, ?string $description = null, array $attributes = []): string
    {
        $classes = self::classNames([
            'mb-8',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<header class="' . $classes . '" ' . self::attributes($attributes) . '>';

        $html .= '<h2 class="text-2xl font-bold text-gray-900">';
        $html .= self::escape($title);
        $html .= '</h2>';

        if ($description) {
            $html .= '<p class="mt-2 text-gray-600">' . self::escape($description) . '</p>';
        }

        $html .= '</header>';

        return $html;
    }
}
