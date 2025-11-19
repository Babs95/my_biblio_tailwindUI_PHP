<?php

namespace TailwindUI;

/**
 * Composant Badge - Badges modernes avec effets visuels
 *
 * Exemples d'utilisation :
 * Badge::primary('Nouveau')
 * Badge::gradient('Premium', 'purple')
 * Badge::pulse('Live')
 */
class Badge extends Component
{
    /**
     * Classes de base pour tous les badges
     */
    private const BASE_CLASSES = 'inline-flex items-center font-semibold tracking-wide transition-all duration-200';

    /**
     * Tailles disponibles
     */
    private const SIZES = [
        'sm' => 'px-2 py-0.5 text-[10px] rounded-md',
        'md' => 'px-2.5 py-1 text-xs rounded-lg',
        'lg' => 'px-3 py-1.5 text-sm rounded-xl',
    ];

    /**
     * Badge primaire (bleu)
     */
    public static function primary(string $text, string $size = 'md', array $attributes = []): string
    {
        return self::render($text, 'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-600/20', $size, $attributes);
    }

    /**
     * Badge de succès (vert)
     */
    public static function success(string $text, string $size = 'md', array $attributes = []): string
    {
        return self::render($text, 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20', $size, $attributes);
    }

    /**
     * Badge d'erreur (rouge)
     */
    public static function danger(string $text, string $size = 'md', array $attributes = []): string
    {
        return self::render($text, 'bg-red-50 text-red-700 ring-1 ring-inset ring-red-600/20', $size, $attributes);
    }

    /**
     * Badge d'avertissement (orange)
     */
    public static function warning(string $text, string $size = 'md', array $attributes = []): string
    {
        return self::render($text, 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20', $size, $attributes);
    }

    /**
     * Badge d'information (cyan)
     */
    public static function info(string $text, string $size = 'md', array $attributes = []): string
    {
        return self::render($text, 'bg-cyan-50 text-cyan-700 ring-1 ring-inset ring-cyan-600/20', $size, $attributes);
    }

    /**
     * Badge neutre (gris)
     */
    public static function secondary(string $text, string $size = 'md', array $attributes = []): string
    {
        return self::render($text, 'bg-gray-50 text-gray-600 ring-1 ring-inset ring-gray-500/20', $size, $attributes);
    }

    /**
     * Badge avec gradient
     */
    public static function gradient(string $text, string $color = 'purple', string $size = 'md', array $attributes = []): string
    {
        $gradients = [
            'purple' => 'bg-gradient-to-r from-purple-500 to-indigo-500 text-white shadow-lg shadow-purple-500/30',
            'blue' => 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg shadow-blue-500/30',
            'pink' => 'bg-gradient-to-r from-pink-500 to-rose-500 text-white shadow-lg shadow-pink-500/30',
            'orange' => 'bg-gradient-to-r from-orange-500 to-red-500 text-white shadow-lg shadow-orange-500/30',
            'green' => 'bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-lg shadow-emerald-500/30',
        ];

        return self::render($text, $gradients[$color] ?? $gradients['purple'], $size, $attributes);
    }

    /**
     * Badge avec animation pulse (pour live/notifications)
     */
    public static function pulse(string $text, string $color = 'red', string $size = 'md', array $attributes = []): string
    {
        $colors = [
            'red' => ['bg' => 'bg-red-50 text-red-700 ring-1 ring-inset ring-red-600/20', 'dot' => 'bg-red-500'],
            'green' => ['bg' => 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20', 'dot' => 'bg-emerald-500'],
            'blue' => ['bg' => 'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-600/20', 'dot' => 'bg-blue-500'],
        ];

        $config = $colors[$color] ?? $colors['red'];

        $dotHtml = '<span class="relative flex h-2 w-2 mr-1.5">';
        $dotHtml .= '<span class="animate-ping absolute inline-flex h-full w-full rounded-full ' . $config['dot'] . ' opacity-75"></span>';
        $dotHtml .= '<span class="relative inline-flex rounded-full h-2 w-2 ' . $config['dot'] . '"></span>';
        $dotHtml .= '</span>';

        return self::render($dotHtml . self::escape($text), $config['bg'], $size, $attributes);
    }

    /**
     * Badge outline
     */
    public static function outline(string $text, string $color = 'blue', string $size = 'md', array $attributes = []): string
    {
        $colors = [
            'blue' => 'text-blue-600 ring-2 ring-blue-500 bg-transparent',
            'green' => 'text-emerald-600 ring-2 ring-emerald-500 bg-transparent',
            'red' => 'text-red-600 ring-2 ring-red-500 bg-transparent',
            'purple' => 'text-purple-600 ring-2 ring-purple-500 bg-transparent',
            'gray' => 'text-gray-600 ring-2 ring-gray-400 bg-transparent',
        ];

        return self::render($text, $colors[$color] ?? $colors['blue'], $size, $attributes);
    }

    /**
     * Badge de statut (avec mapping automatique)
     */
    public static function status(string $status, ?string $label = null, string $size = 'md'): string
    {
        $statusMap = [
            'active' => ['class' => 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20', 'label' => 'Actif'],
            'inactive' => ['class' => 'bg-gray-50 text-gray-600 ring-1 ring-inset ring-gray-500/20', 'label' => 'Inactif'],
            'pending' => ['class' => 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20', 'label' => 'En attente'],
            'completed' => ['class' => 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20', 'label' => 'Terminé'],
            'done' => ['class' => 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20', 'label' => 'Terminé'],
            'in_progress' => ['class' => 'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-600/20', 'label' => 'En cours'],
            'todo' => ['class' => 'bg-gray-50 text-gray-600 ring-1 ring-inset ring-gray-500/20', 'label' => 'À faire'],
            'cancelled' => ['class' => 'bg-red-50 text-red-700 ring-1 ring-inset ring-red-600/20', 'label' => 'Annulé'],
            'archived' => ['class' => 'bg-gray-50 text-gray-600 ring-1 ring-inset ring-gray-500/20', 'label' => 'Archivé'],
        ];

        $config = $statusMap[strtolower($status)] ?? ['class' => 'bg-gray-50 text-gray-600 ring-1 ring-inset ring-gray-500/20', 'label' => ucfirst($status)];
        $text = $label ?? $config['label'];

        return self::render($text, $config['class'], $size);
    }

    /**
     * Badge de priorité (avec mapping automatique)
     */
    public static function priority(string $priority, ?string $label = null, string $size = 'md'): string
    {
        $priorityMap = [
            'low' => ['class' => 'bg-gray-50 text-gray-600 ring-1 ring-inset ring-gray-500/20', 'label' => 'Basse'],
            'medium' => ['class' => 'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-600/20', 'label' => 'Moyenne'],
            'high' => ['class' => 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20', 'label' => 'Haute'],
            'urgent' => ['class' => 'bg-red-50 text-red-700 ring-1 ring-inset ring-red-600/20', 'label' => 'Urgente'],
            'critical' => ['class' => 'bg-gradient-to-r from-red-500 to-rose-500 text-white shadow-lg shadow-red-500/30', 'label' => 'Critique'],
        ];

        $config = $priorityMap[strtolower($priority)] ?? ['class' => 'bg-gray-50 text-gray-600 ring-1 ring-inset ring-gray-500/20', 'label' => ucfirst($priority)];
        $text = $label ?? $config['label'];

        return self::render($text, $config['class'], $size);
    }

    /**
     * Badge avec icône
     */
    public static function withIcon(string $text, string $icon, string $colorClass = 'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-600/20', string $size = 'md', array $attributes = []): string
    {
        $iconHtml = sprintf('<i class="%s mr-1.5 text-[0.7em]" aria-hidden="true"></i>', self::escape($icon));
        return self::render($iconHtml . self::escape($text), $colorClass, $size, $attributes);
    }

    /**
     * Badge avec point (indicator)
     */
    public static function withDot(string $text, string $color = 'blue', string $size = 'md', array $attributes = []): string
    {
        $colorMap = [
            'blue' => ['dot' => 'bg-blue-500', 'badge' => 'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-600/20'],
            'green' => ['dot' => 'bg-emerald-500', 'badge' => 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20'],
            'red' => ['dot' => 'bg-red-500', 'badge' => 'bg-red-50 text-red-700 ring-1 ring-inset ring-red-600/20'],
            'yellow' => ['dot' => 'bg-amber-500', 'badge' => 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20'],
            'gray' => ['dot' => 'bg-gray-500', 'badge' => 'bg-gray-50 text-gray-600 ring-1 ring-inset ring-gray-500/20'],
        ];

        $config = $colorMap[$color] ?? $colorMap['blue'];
        $dotHtml = '<span class="w-1.5 h-1.5 rounded-full ' . $config['dot'] . ' mr-1.5"></span>';

        return self::render($dotHtml . self::escape($text), $config['badge'], $size, $attributes);
    }

    /**
     * Badge compteur (notification)
     */
    public static function count(int $count, string $color = 'red', string $size = 'sm', array $attributes = []): string
    {
        $colors = [
            'red' => 'bg-red-500 text-white shadow-lg shadow-red-500/30',
            'blue' => 'bg-blue-500 text-white shadow-lg shadow-blue-500/30',
            'green' => 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/30',
            'gray' => 'bg-gray-500 text-white',
        ];

        $displayCount = $count > 99 ? '99+' : (string)$count;
        $attributes['class'] = ($attributes['class'] ?? '') . ' !px-1.5 min-w-[1.25rem] justify-center';

        return self::render($displayCount, $colors[$color] ?? $colors['red'], $size, $attributes);
    }

    /**
     * Rendu du badge
     */
    private static function render(string $content, string $colorClass, string $size = 'md', array $attributes = []): string
    {
        $classes = self::classNames([
            self::BASE_CLASSES,
            self::SIZES[$size] ?? self::SIZES['md'],
            $colorClass,
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        return sprintf(
            '<span class="%s" %s>%s</span>',
            $classes,
            self::attributes($attributes),
            $content
        );
    }

    /**
     * Groupe de badges
     */
    public static function group(array $badges): string
    {
        return '<div class="flex flex-wrap gap-2">' . implode('', $badges) . '</div>';
    }
}
