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
            'bg-white rounded-2xl shadow-sm border border-gray-100 p-6 transition-all duration-300 hover:shadow-md',
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
            'bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<div class="' . $classes . '" ' . self::attributes($attributes) . '>';

        // En-tête
        $html .= '<div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">';
        $html .= '<h3 class="text-lg font-bold text-gray-900">' . self::escape($title) . '</h3>';
        $html .= '</div>';

        // Contenu
        $html .= '<div class="p-6">' . $content . '</div>';

        // Footer optionnel
        if ($footer) {
            $html .= '<div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100">';
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
            'blue' => ['bg' => 'bg-gradient-to-br from-blue-500 to-blue-600', 'text' => 'text-white', 'icon_bg' => 'bg-white/20'],
            'green' => ['bg' => 'bg-gradient-to-br from-emerald-500 to-emerald-600', 'text' => 'text-white', 'icon_bg' => 'bg-white/20'],
            'red' => ['bg' => 'bg-gradient-to-br from-red-500 to-red-600', 'text' => 'text-white', 'icon_bg' => 'bg-white/20'],
            'orange' => ['bg' => 'bg-gradient-to-br from-amber-500 to-orange-500', 'text' => 'text-white', 'icon_bg' => 'bg-white/20'],
            'purple' => ['bg' => 'bg-gradient-to-br from-purple-500 to-purple-600', 'text' => 'text-white', 'icon_bg' => 'bg-white/20'],
            'yellow' => ['bg' => 'bg-gradient-to-br from-yellow-400 to-amber-500', 'text' => 'text-white', 'icon_bg' => 'bg-white/20'],
        ];

        $colorClasses = $colors[$color] ?? $colors['blue'];

        $classes = self::classNames([
            $colorClasses['bg'] . ' rounded-2xl shadow-lg p-6 transition-all duration-300 hover:shadow-xl hover:scale-[1.02]',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<div class="' . $classes . '" ' . self::attributes($attributes) . '>';
        $html .= '<div class="flex items-center justify-between">';
        $html .= '<div>';
        $html .= '<p class="text-sm font-medium ' . $colorClasses['text'] . ' opacity-80">' . self::escape($label) . '</p>';
        $html .= '<p class="text-3xl font-bold ' . $colorClasses['text'] . ' mt-2">' . self::escape($value) . '</p>';
        $html .= '</div>';

        if ($icon) {
            $html .= '<div class="' . $colorClasses['icon_bg'] . ' rounded-xl p-3 backdrop-blur-sm">';
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
            'bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 hover:scale-[1.01] group',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<div class="' . $classes . '" ' . self::attributes($attributes) . '>';
        $html .= '<div class="p-6">';

        // Color indicator et status
        $html .= '<div class="flex items-center justify-between mb-4">';
        $html .= '<div class="w-3 h-3 rounded-full ring-4 ring-opacity-20" style="background-color: ' . self::escape($project['color'] ?? '#3B82F6') . '"></div>';

        if (isset($project['status'])) {
            $statusClass = $project['status'] === 'active' ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20' : 'bg-gray-50 text-gray-600 ring-1 ring-gray-500/20';
            $html .= '<span class="text-xs font-medium px-2.5 py-1 rounded-lg ' . $statusClass . '">';
            $html .= self::escape(ucfirst($project['status']));
            $html .= '</span>';
        }
        $html .= '</div>';

        // Titre
        $html .= '<h3 class="font-bold text-xl text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">';
        $html .= self::escape($project['title'] ?? '');
        $html .= '</h3>';

        // Description
        if (isset($project['description'])) {
            $description = substr($project['description'], 0, 100);
            $html .= '<p class="text-sm text-gray-500 mb-4 leading-relaxed">';
            $html .= self::escape($description);
            $html .= strlen($project['description']) > 100 ? '...' : '';
            $html .= '</p>';
        }

        // Date limite
        if (isset($project['deadline'])) {
            $html .= '<div class="flex items-center text-sm text-gray-400 pt-4 border-t border-gray-100">';
            $html .= '<i class="far fa-calendar-alt mr-2"></i>';
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
            'bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<div class="' . $classes . '" ' . self::attributes($attributes) . '>';
        $html .= '<div class="bg-gray-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">';
        $html .= '<i class="' . self::escape($icon) . ' text-gray-400 text-3xl"></i>';
        $html .= '</div>';
        $html .= '<h3 class="text-xl font-bold text-gray-900 mb-2">' . self::escape($title) . '</h3>';
        $html .= '<p class="text-gray-500 mb-8 max-w-sm mx-auto">' . self::escape($message) . '</p>';

        if ($action) {
            $html .= $action;
        }

        $html .= '</div>';

        return $html;
    }
}
