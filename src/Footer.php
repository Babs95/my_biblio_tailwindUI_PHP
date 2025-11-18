<?php

namespace TailwindUI;

/**
 * Composant Footer - Pieds de page stylisés
 *
 * Exemples d'utilisation :
 * Footer::simple('© 2024 Mon Site')
 * Footer::withLinks($links, $copyright)
 * Footer::withColumns($columns, $copyright)
 * Footer::withNewsletter($columns, $copyright)
 */
class Footer extends Component
{
    /**
     * Footer simple avec copyright
     */
    public static function simple(string $copyright, array $attributes = []): string
    {
        $classes = self::classNames([
            'bg-gray-900 text-white py-8',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<footer class="' . $classes . '" ' . self::attributes($attributes) . '>';
        $html .= '<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">';
        $html .= '<p class="text-gray-400 text-sm">' . self::escape($copyright) . '</p>';
        $html .= '</div>';
        $html .= '</footer>';

        return $html;
    }

    /**
     * Footer avec liens sociaux
     */
    public static function withSocial(string $copyright, array $socialLinks = [], array $attributes = []): string
    {
        $classes = self::classNames([
            'bg-gray-900 text-white py-12',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<footer class="' . $classes . '" ' . self::attributes($attributes) . '>';
        $html .= '<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">';
        $html .= '<div class="flex flex-col md:flex-row justify-between items-center">';

        // Copyright
        $html .= '<p class="text-gray-400 text-sm mb-4 md:mb-0">' . self::escape($copyright) . '</p>';

        // Social links
        if (!empty($socialLinks)) {
            $html .= '<div class="flex space-x-6">';
            foreach ($socialLinks as $social) {
                $html .= sprintf(
                    '<a href="%s" class="text-gray-400 hover:text-white transition-colors duration-200" target="_blank" rel="noopener noreferrer">',
                    self::escape($social['url'])
                );
                $html .= '<i class="' . self::escape($social['icon']) . ' text-xl"></i>';
                $html .= '<span class="sr-only">' . self::escape($social['label'] ?? '') . '</span>';
                $html .= '</a>';
            }
            $html .= '</div>';
        }

        $html .= '</div>';
        $html .= '</div>';
        $html .= '</footer>';

        return $html;
    }

    /**
     * Footer avec colonnes de liens
     */
    public static function withColumns(array $columns, string $copyright, array $attributes = []): string
    {
        $classes = self::classNames([
            'bg-gray-900 text-white',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<footer class="' . $classes . '" ' . self::attributes($attributes) . '>';
        $html .= '<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">';

        // Columns
        $colCount = count($columns);
        $gridCols = $colCount <= 2 ? 'md:grid-cols-2' : ($colCount <= 3 ? 'md:grid-cols-3' : 'md:grid-cols-4');

        $html .= '<div class="grid grid-cols-2 ' . $gridCols . ' gap-8 mb-8">';

        foreach ($columns as $column) {
            $html .= '<div>';
            $html .= '<h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4">';
            $html .= self::escape($column['title']);
            $html .= '</h3>';
            $html .= '<ul class="space-y-3">';

            foreach ($column['links'] as $link) {
                $html .= '<li>';
                $html .= '<a href="' . self::escape($link['url']) . '" class="text-gray-400 hover:text-white text-sm transition-colors duration-200">';
                $html .= self::escape($link['label']);
                $html .= '</a>';
                $html .= '</li>';
            }

            $html .= '</ul>';
            $html .= '</div>';
        }

        $html .= '</div>';

        // Bottom bar
        $html .= '<div class="border-t border-gray-800 pt-8">';
        $html .= '<p class="text-gray-400 text-sm text-center">' . self::escape($copyright) . '</p>';
        $html .= '</div>';

        $html .= '</div>';
        $html .= '</footer>';

        return $html;
    }

    /**
     * Footer avec newsletter
     */
    public static function withNewsletter(string $title, string $description, string $formAction, string $copyright, array $attributes = []): string
    {
        $classes = self::classNames([
            'bg-gray-900 text-white',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<footer class="' . $classes . '" ' . self::attributes($attributes) . '>';
        $html .= '<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">';

        // Newsletter section
        $html .= '<div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl p-8 mb-8">';
        $html .= '<div class="md:flex md:items-center md:justify-between">';

        $html .= '<div class="mb-6 md:mb-0 md:mr-8">';
        $html .= '<h3 class="text-xl font-bold text-white mb-2">' . self::escape($title) . '</h3>';
        $html .= '<p class="text-blue-100 text-sm">' . self::escape($description) . '</p>';
        $html .= '</div>';

        $html .= '<form action="' . self::escape($formAction) . '" method="POST" class="flex-shrink-0">';
        $html .= '<div class="flex">';
        $html .= '<input type="email" name="email" required placeholder="Votre email" class="w-full md:w-64 px-4 py-3 rounded-l-xl bg-white/10 backdrop-blur-sm border border-white/20 text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-white/50">';
        $html .= '<button type="submit" class="px-6 py-3 bg-white text-blue-600 font-semibold rounded-r-xl hover:bg-blue-50 transition-colors duration-200">';
        $html .= "S'inscrire";
        $html .= '</button>';
        $html .= '</div>';
        $html .= '</form>';

        $html .= '</div>';
        $html .= '</div>';

        // Copyright
        $html .= '<div class="text-center">';
        $html .= '<p class="text-gray-400 text-sm">' . self::escape($copyright) . '</p>';
        $html .= '</div>';

        $html .= '</div>';
        $html .= '</footer>';

        return $html;
    }

    /**
     * Footer complet avec logo, colonnes et social
     */
    public static function full(string $logo, array $columns, array $socialLinks, string $copyright, array $attributes = []): string
    {
        $classes = self::classNames([
            'bg-gray-900 text-white',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<footer class="' . $classes . '" ' . self::attributes($attributes) . '>';
        $html .= '<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">';

        // Top section with logo and columns
        $html .= '<div class="grid grid-cols-1 lg:grid-cols-5 gap-8 mb-8">';

        // Logo section
        $html .= '<div class="lg:col-span-2">';
        $html .= '<div class="text-2xl font-bold text-white mb-4">' . $logo . '</div>';
        $html .= '<p class="text-gray-400 text-sm max-w-md">Une solution moderne pour créer des interfaces utilisateur élégantes avec PHP et Tailwind CSS.</p>';
        $html .= '</div>';

        // Columns
        foreach ($columns as $column) {
            $html .= '<div>';
            $html .= '<h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4">';
            $html .= self::escape($column['title']);
            $html .= '</h3>';
            $html .= '<ul class="space-y-3">';

            foreach ($column['links'] as $link) {
                $html .= '<li>';
                $html .= '<a href="' . self::escape($link['url']) . '" class="text-gray-400 hover:text-white text-sm transition-colors duration-200">';
                $html .= self::escape($link['label']);
                $html .= '</a>';
                $html .= '</li>';
            }

            $html .= '</ul>';
            $html .= '</div>';
        }

        $html .= '</div>';

        // Bottom bar
        $html .= '<div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">';
        $html .= '<p class="text-gray-400 text-sm mb-4 md:mb-0">' . self::escape($copyright) . '</p>';

        // Social links
        if (!empty($socialLinks)) {
            $html .= '<div class="flex space-x-6">';
            foreach ($socialLinks as $social) {
                $html .= sprintf(
                    '<a href="%s" class="text-gray-400 hover:text-white transition-colors duration-200" target="_blank" rel="noopener noreferrer">',
                    self::escape($social['url'])
                );
                $html .= '<i class="' . self::escape($social['icon']) . ' text-xl"></i>';
                $html .= '</a>';
            }
            $html .= '</div>';
        }

        $html .= '</div>';

        $html .= '</div>';
        $html .= '</footer>';

        return $html;
    }

    /**
     * Footer clair (light theme)
     */
    public static function light(string $copyright, array $links = [], array $attributes = []): string
    {
        $classes = self::classNames([
            'bg-white border-t border-gray-200 py-8',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<footer class="' . $classes . '" ' . self::attributes($attributes) . '>';
        $html .= '<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">';

        if (!empty($links)) {
            $html .= '<div class="flex flex-wrap justify-center gap-6 mb-4">';
            foreach ($links as $link) {
                $html .= '<a href="' . self::escape($link['url']) . '" class="text-gray-500 hover:text-gray-900 text-sm transition-colors duration-200">';
                $html .= self::escape($link['label']);
                $html .= '</a>';
            }
            $html .= '</div>';
        }

        $html .= '<p class="text-gray-400 text-sm text-center">' . self::escape($copyright) . '</p>';
        $html .= '</div>';
        $html .= '</footer>';

        return $html;
    }
}
