<?php

namespace TailwindUI;

/**
 * Composant Card - Cartes modernes avec effets visuels avancés
 *
 * Exemples d'utilisation :
 * Card::basic('Contenu de la carte')
 * Card::glass('Contenu avec effet verre')
 * Card::feature('Titre', 'Description', 'icon')
 */
class Card extends Component
{
    /**
     * Carte basique avec hover élégant
     */
    public static function basic(string $content, array $attributes = []): string
    {
        $classes = self::classNames([
            'bg-white rounded-3xl shadow-sm border border-gray-100/50 p-6 transition-all duration-500 hover:shadow-xl hover:shadow-gray-200/50 hover:-translate-y-1',
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
     * Carte avec en-tête gradient
     */
    public static function withHeader(string $title, string $content, ?string $footer = null, array $attributes = []): string
    {
        $classes = self::classNames([
            'bg-white rounded-3xl shadow-sm border border-gray-100/50 overflow-hidden transition-all duration-500 hover:shadow-xl hover:shadow-gray-200/50',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<div class="' . $classes . '" ' . self::attributes($attributes) . '>';

        // En-tête avec gradient subtil
        $html .= '<div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50/80 via-white to-gray-50/80">';
        $html .= '<h3 class="text-lg font-bold text-gray-900">' . self::escape($title) . '</h3>';
        $html .= '</div>';

        // Contenu
        $html .= '<div class="p-6">' . $content . '</div>';

        // Footer optionnel
        if ($footer) {
            $html .= '<div class="px-6 py-4 bg-gradient-to-r from-gray-50/50 to-gray-100/50 border-t border-gray-100">';
            $html .= $footer;
            $html .= '</div>';
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Carte glassmorphism
     */
    public static function glass(string $content, array $attributes = []): string
    {
        $classes = self::classNames([
            'backdrop-blur-xl bg-white/70 rounded-3xl shadow-lg border border-white/20 p-6 transition-all duration-500 hover:bg-white/80 hover:shadow-xl',
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
     * Carte de statistique avec glow
     */
    public static function stat(string $label, string $value, string $icon = '', string $color = 'blue', ?string $trend = null, array $attributes = []): string
    {
        $colors = [
            'blue' => ['bg' => 'bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-700', 'shadow' => 'shadow-blue-500/30', 'ring' => 'ring-blue-400/30'],
            'green' => ['bg' => 'bg-gradient-to-br from-emerald-400 via-emerald-500 to-teal-600', 'shadow' => 'shadow-emerald-500/30', 'ring' => 'ring-emerald-400/30'],
            'red' => ['bg' => 'bg-gradient-to-br from-red-500 via-red-600 to-rose-700', 'shadow' => 'shadow-red-500/30', 'ring' => 'ring-red-400/30'],
            'orange' => ['bg' => 'bg-gradient-to-br from-amber-400 via-orange-500 to-red-500', 'shadow' => 'shadow-orange-500/30', 'ring' => 'ring-orange-400/30'],
            'purple' => ['bg' => 'bg-gradient-to-br from-purple-500 via-purple-600 to-indigo-700', 'shadow' => 'shadow-purple-500/30', 'ring' => 'ring-purple-400/30'],
            'pink' => ['bg' => 'bg-gradient-to-br from-pink-500 via-rose-500 to-red-500', 'shadow' => 'shadow-pink-500/30', 'ring' => 'ring-pink-400/30'],
            'cyan' => ['bg' => 'bg-gradient-to-br from-cyan-400 via-cyan-500 to-blue-600', 'shadow' => 'shadow-cyan-500/30', 'ring' => 'ring-cyan-400/30'],
        ];

        $colorClasses = $colors[$color] ?? $colors['blue'];

        $classes = self::classNames([
            $colorClasses['bg'] . ' ' . $colorClasses['shadow'] . ' rounded-3xl shadow-xl p-6 transition-all duration-500 hover:shadow-2xl hover:-translate-y-1 hover:scale-[1.02]',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<div class="' . $classes . '" ' . self::attributes($attributes) . '>';
        $html .= '<div class="flex items-center justify-between">';
        $html .= '<div>';
        $html .= '<p class="text-sm font-medium text-white/80">' . self::escape($label) . '</p>';
        $html .= '<p class="text-4xl font-bold text-white mt-2 tracking-tight">' . self::escape($value) . '</p>';

        // Trend indicator
        if ($trend) {
            $trendUp = strpos($trend, '+') === 0;
            $trendColor = $trendUp ? 'text-emerald-200' : 'text-red-200';
            $trendIcon = $trendUp ? 'M5 10l7-7m0 0l7 7m-7-7v18' : 'M19 14l-7 7m0 0l-7-7m7 7V3';
            $html .= '<div class="flex items-center mt-2 ' . $trendColor . '">';
            $html .= '<svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="' . $trendIcon . '"/></svg>';
            $html .= '<span class="text-sm font-medium">' . self::escape($trend) . '</span>';
            $html .= '</div>';
        }

        $html .= '</div>';

        if ($icon) {
            $html .= '<div class="bg-white/20 rounded-2xl p-4 backdrop-blur-sm ring-1 ' . $colorClasses['ring'] . '">';
            $html .= '<i class="' . self::escape($icon) . ' text-white text-2xl" aria-hidden="true"></i>';
            $html .= '</div>';
        }

        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Carte feature avec icône
     */
    public static function feature(string $title, string $description, string $icon, string $color = 'blue', array $attributes = []): string
    {
        $colors = [
            'blue' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'ring' => 'ring-blue-500/20'],
            'green' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'ring' => 'ring-emerald-500/20'],
            'purple' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-600', 'ring' => 'ring-purple-500/20'],
            'pink' => ['bg' => 'bg-pink-50', 'text' => 'text-pink-600', 'ring' => 'ring-pink-500/20'],
            'orange' => ['bg' => 'bg-orange-50', 'text' => 'text-orange-600', 'ring' => 'ring-orange-500/20'],
            'cyan' => ['bg' => 'bg-cyan-50', 'text' => 'text-cyan-600', 'ring' => 'ring-cyan-500/20'],
        ];

        $colorClasses = $colors[$color] ?? $colors['blue'];

        $classes = self::classNames([
            'bg-white rounded-3xl shadow-sm border border-gray-100/50 p-8 transition-all duration-500 hover:shadow-xl hover:shadow-gray-200/50 hover:-translate-y-1 group',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<div class="' . $classes . '" ' . self::attributes($attributes) . '>';

        // Icon container
        $html .= '<div class="' . $colorClasses['bg'] . ' rounded-2xl p-4 w-fit ring-1 ' . $colorClasses['ring'] . ' mb-6 group-hover:scale-110 transition-transform duration-300">';
        $html .= '<i class="' . self::escape($icon) . ' ' . $colorClasses['text'] . ' text-2xl" aria-hidden="true"></i>';
        $html .= '</div>';

        // Title
        $html .= '<h3 class="text-xl font-bold text-gray-900 mb-3">' . self::escape($title) . '</h3>';

        // Description
        $html .= '<p class="text-gray-500 leading-relaxed">' . self::escape($description) . '</p>';

        $html .= '</div>';

        return $html;
    }

    /**
     * Carte pricing
     */
    public static function pricing(string $name, string $price, string $period, array $features, bool $popular = false, ?string $action = null, array $attributes = []): string
    {
        $baseClasses = $popular
            ? 'bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 text-white rounded-3xl shadow-xl shadow-blue-500/30 p-8 transition-all duration-500 hover:shadow-2xl hover:-translate-y-2 ring-4 ring-blue-500/20'
            : 'bg-white rounded-3xl shadow-sm border border-gray-100/50 p-8 transition-all duration-500 hover:shadow-xl hover:shadow-gray-200/50 hover:-translate-y-1';

        $classes = self::classNames([
            $baseClasses,
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<div class="' . $classes . '" ' . self::attributes($attributes) . '>';

        // Popular badge
        if ($popular) {
            $html .= '<div class="bg-white/20 backdrop-blur-sm text-white text-xs font-bold px-3 py-1 rounded-full w-fit mb-6">Plus populaire</div>';
        }

        // Plan name
        $html .= '<h3 class="text-xl font-bold ' . ($popular ? 'text-white' : 'text-gray-900') . ' mb-2">' . self::escape($name) . '</h3>';

        // Price
        $html .= '<div class="mb-6">';
        $html .= '<span class="text-5xl font-bold ' . ($popular ? 'text-white' : 'text-gray-900') . '">' . self::escape($price) . '</span>';
        $html .= '<span class="' . ($popular ? 'text-white/70' : 'text-gray-500') . '">/' . self::escape($period) . '</span>';
        $html .= '</div>';

        // Features
        $html .= '<ul class="space-y-4 mb-8">';
        foreach ($features as $feature) {
            $html .= '<li class="flex items-center">';
            $html .= '<svg class="w-5 h-5 ' . ($popular ? 'text-emerald-300' : 'text-emerald-500') . ' mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>';
            $html .= '<span class="' . ($popular ? 'text-white/90' : 'text-gray-600') . '">' . self::escape($feature) . '</span>';
            $html .= '</li>';
        }
        $html .= '</ul>';

        // Action button
        if ($action) {
            $html .= $action;
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Carte de projet améliorée
     */
    public static function project(array $project, array $attributes = []): string
    {
        $classes = self::classNames([
            'bg-white rounded-3xl shadow-sm border border-gray-100/50 hover:shadow-xl hover:shadow-gray-200/50 transition-all duration-500 hover:-translate-y-1 group overflow-hidden',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<div class="' . $classes . '" ' . self::attributes($attributes) . '>';

        // Color bar at top
        $html .= '<div class="h-1.5 w-full" style="background: linear-gradient(90deg, ' . self::escape($project['color'] ?? '#3B82F6') . ', ' . self::escape($project['color'] ?? '#3B82F6') . '88)"></div>';

        $html .= '<div class="p-6">';

        // Status badge
        if (isset($project['status'])) {
            $statusClasses = [
                'active' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-500/20',
                'pending' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-500/20',
                'completed' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-500/20',
                'archived' => 'bg-gray-50 text-gray-600 ring-1 ring-gray-500/20',
            ];
            $statusClass = $statusClasses[$project['status']] ?? $statusClasses['pending'];
            $html .= '<span class="inline-flex items-center text-xs font-semibold px-2.5 py-1 rounded-lg ' . $statusClass . ' mb-4">';
            $html .= self::escape(ucfirst($project['status']));
            $html .= '</span>';
        }

        // Titre
        $html .= '<h3 class="font-bold text-xl text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">';
        $html .= self::escape($project['title'] ?? '');
        $html .= '</h3>';

        // Description
        if (isset($project['description'])) {
            $description = substr($project['description'], 0, 120);
            $html .= '<p class="text-sm text-gray-500 mb-4 leading-relaxed">';
            $html .= self::escape($description);
            $html .= strlen($project['description']) > 120 ? '...' : '';
            $html .= '</p>';
        }

        // Footer avec meta
        $html .= '<div class="flex items-center justify-between pt-4 border-t border-gray-100">';

        // Date limite
        if (isset($project['deadline'])) {
            $html .= '<div class="flex items-center text-sm text-gray-400">';
            $html .= '<svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>';
            $html .= '<span>' . self::escape($project['deadline']) . '</span>';
            $html .= '</div>';
        }

        // Team avatars
        if (isset($project['team']) && is_array($project['team'])) {
            $html .= '<div class="flex -space-x-2">';
            foreach (array_slice($project['team'], 0, 3) as $member) {
                $html .= '<div class="w-7 h-7 rounded-full bg-gradient-to-br from-gray-200 to-gray-300 ring-2 ring-white flex items-center justify-center text-xs font-medium text-gray-600">';
                $html .= self::escape(substr($member, 0, 1));
                $html .= '</div>';
            }
            if (count($project['team']) > 3) {
                $html .= '<div class="w-7 h-7 rounded-full bg-gray-100 ring-2 ring-white flex items-center justify-center text-xs font-medium text-gray-500">';
                $html .= '+' . (count($project['team']) - 3);
                $html .= '</div>';
            }
            $html .= '</div>';
        }

        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Carte vide (empty state) améliorée
     */
    public static function empty(string $icon, string $title, string $message, ?string $action = null, array $attributes = []): string
    {
        $classes = self::classNames([
            'bg-gradient-to-b from-white to-gray-50/50 rounded-3xl shadow-sm border border-gray-100/50 p-12 text-center',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<div class="' . $classes . '" ' . self::attributes($attributes) . '>';
        $html .= '<div class="bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl w-20 h-20 flex items-center justify-center mx-auto mb-6">';
        $html .= '<i class="' . self::escape($icon) . ' text-gray-400 text-3xl" aria-hidden="true"></i>';
        $html .= '</div>';
        $html .= '<h3 class="text-xl font-bold text-gray-900 mb-2">' . self::escape($title) . '</h3>';
        $html .= '<p class="text-gray-500 mb-8 max-w-sm mx-auto leading-relaxed">' . self::escape($message) . '</p>';

        if ($action) {
            $html .= $action;
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Carte testimonial
     */
    public static function testimonial(string $content, string $author, string $role, ?string $avatar = null, array $attributes = []): string
    {
        $classes = self::classNames([
            'bg-white rounded-3xl shadow-sm border border-gray-100/50 p-8 transition-all duration-500 hover:shadow-xl hover:shadow-gray-200/50',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<div class="' . $classes . '" ' . self::attributes($attributes) . '>';

        // Quote icon
        $html .= '<svg class="w-10 h-10 text-blue-100 mb-4" fill="currentColor" viewBox="0 0 32 32"><path d="M10 8c-3.3 0-6 2.7-6 6v10h10V14H6c0-2.2 1.8-4 4-4V8zm18 0c-3.3 0-6 2.7-6 6v10h10V14h-8c0-2.2 1.8-4 4-4V8z"/></svg>';

        // Content
        $html .= '<p class="text-gray-600 leading-relaxed mb-6">' . self::escape($content) . '</p>';

        // Author
        $html .= '<div class="flex items-center">';
        if ($avatar) {
            $html .= '<img src="' . self::escape($avatar) . '" alt="' . self::escape($author) . '" class="w-12 h-12 rounded-full ring-2 ring-gray-100">';
        } else {
            $html .= '<div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold">';
            $html .= self::escape(substr($author, 0, 1));
            $html .= '</div>';
        }
        $html .= '<div class="ml-4">';
        $html .= '<p class="font-semibold text-gray-900">' . self::escape($author) . '</p>';
        $html .= '<p class="text-sm text-gray-500">' . self::escape($role) . '</p>';
        $html .= '</div>';
        $html .= '</div>';

        $html .= '</div>';

        return $html;
    }
}
