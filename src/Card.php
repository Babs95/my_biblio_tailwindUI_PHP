<?php

namespace TailwindUI;

/**
 * Composant Card - Cartes stylisées pour afficher du contenu
 *
 * Exemples d'utilisation :
 * Card::basic('Contenu de la carte')
 * Card::withHeader('Titre', 'Contenu')
 * Card::stat('Total', '1,234', 'fas fa-users', 'blue')
 */
class Card extends Component
{
    /**
     * Carte basique
     */
    public static function basic(string $content, array $attributes = []): string
    {
        $classes = self::classNames([
            'bg-white rounded-lg shadow p-6',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        return sprintf(
            '<div class="%s" %s>%s</div>',
            $classes,
            self::attributes($attributes),
            $content
        );
    }

    /**
     * Carte avec en-tête
     */
    public static function withHeader(string $title, string $content, ?string $footer = null, array $attributes = []): string
    {
        $classes = self::classNames([
            'bg-white rounded-lg shadow overflow-hidden',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<div class="' . $classes . '" ' . self::attributes($attributes) . '>';

        // En-tête
        $html .= '<div class="px-6 py-4 border-b border-gray-200">';
        $html .= '<h3 class="text-lg font-semibold text-gray-900">' . self::escape($title) . '</h3>';
        $html .= '</div>';

        // Contenu
        $html .= '<div class="p-6">' . $content . '</div>';

        // Footer optionnel
        if ($footer) {
            $html .= '<div class="px-6 py-4 bg-gray-50 border-t border-gray-200">';
            $html .= $footer;
            $html .= '</div>';
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Carte de statistique
     */
    public static function stat(string $label, string $value, string $icon = '', string $color = 'blue', array $attributes = []): string
    {
        $colors = [
            'blue' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-600'],
            'green' => ['bg' => 'bg-green-100', 'text' => 'text-green-600'],
            'red' => ['bg' => 'bg-red-100', 'text' => 'text-red-600'],
            'orange' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-600'],
            'purple' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-600'],
            'yellow' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-600'],
        ];

        $colorClasses = $colors[$color] ?? $colors['blue'];

        $classes = self::classNames([
            'bg-white rounded-lg shadow p-6',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<div class="' . $classes . '" ' . self::attributes($attributes) . '>';
        $html .= '<div class="flex items-center justify-between">';
        $html .= '<div>';
        $html .= '<p class="text-sm text-gray-600">' . self::escape($label) . '</p>';
        $html .= '<p class="text-3xl font-bold text-gray-900 mt-1">' . self::escape($value) . '</p>';
        $html .= '</div>';

        if ($icon) {
            $html .= '<div class="' . $colorClasses['bg'] . ' rounded-full p-3">';
            $html .= '<i class="' . self::escape($icon) . ' ' . $colorClasses['text'] . ' text-2xl"></i>';
            $html .= '</div>';
        }

        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Carte de projet
     */
    public static function project(array $project, array $attributes = []): string
    {
        $classes = self::classNames([
            'bg-white rounded-lg shadow hover:shadow-lg transition-shadow',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<div class="' . $classes . '" ' . self::attributes($attributes) . '>';
        $html .= '<div class="p-6">';

        // Color indicator et status
        $html .= '<div class="flex items-center justify-between mb-4">';
        $html .= '<div class="w-6 h-6 rounded-full" style="background-color: ' . self::escape($project['color'] ?? '#3B82F6') . '"></div>';

        if (isset($project['status'])) {
            $statusClass = $project['status'] === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800';
            $html .= '<span class="text-xs px-2 py-1 rounded-full ' . $statusClass . '">';
            $html .= self::escape(ucfirst($project['status']));
            $html .= '</span>';
        }
        $html .= '</div>';

        // Titre
        $html .= '<h3 class="font-bold text-xl text-gray-900 mb-2">';
        $html .= self::escape($project['title'] ?? '');
        $html .= '</h3>';

        // Description
        if (isset($project['description'])) {
            $description = substr($project['description'], 0, 100);
            $html .= '<p class="text-sm text-gray-600 mb-4">';
            $html .= self::escape($description);
            $html .= strlen($project['description']) > 100 ? '...' : '';
            $html .= '</p>';
        }

        // Date limite
        if (isset($project['deadline'])) {
            $html .= '<div class="flex items-center text-sm text-gray-500">';
            $html .= '<i class="far fa-calendar mr-2"></i>';
            $html .= '<span>' . self::escape($project['deadline']) . '</span>';
            $html .= '</div>';
        }

        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Carte vide (empty state)
     */
    public static function empty(string $icon, string $title, string $message, ?string $action = null, array $attributes = []): string
    {
        $classes = self::classNames([
            'bg-white rounded-lg shadow p-12 text-center',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<div class="' . $classes . '" ' . self::attributes($attributes) . '>';
        $html .= '<i class="' . self::escape($icon) . ' text-gray-400 text-6xl mb-4"></i>';
        $html .= '<h3 class="text-xl font-semibold text-gray-700 mb-2">' . self::escape($title) . '</h3>';
        $html .= '<p class="text-gray-500 mb-6">' . self::escape($message) . '</p>';

        if ($action) {
            $html .= $action;
        }

        $html .= '</div>';

        return $html;
    }
}
