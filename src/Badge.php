<?php

namespace TailwindUI;

/**
 * Composant Badge - Badges et étiquettes
 *
 * Exemples d'utilisation :
 * Badge::primary('Nouveau')
 * Badge::success('Actif')
 * Badge::status('completed', 'Terminé')
 * Badge::priority('high', 'Haute')
 */
class Badge extends Component
{
    /**
     * Classes de base pour tous les badges
     */
    private const BASE_CLASSES = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium';

    /**
     * Badge primaire (bleu)
     */
    public static function primary(string $text, array $attributes = []): string
    {
        return self::render($text, 'bg-blue-100 text-blue-800', $attributes);
    }

    /**
     * Badge de succès (vert)
     */
    public static function success(string $text, array $attributes = []): string
    {
        return self::render($text, 'bg-green-100 text-green-800', $attributes);
    }

    /**
     * Badge d'erreur (rouge)
     */
    public static function danger(string $text, array $attributes = []): string
    {
        return self::render($text, 'bg-red-100 text-red-800', $attributes);
    }

    /**
     * Badge d'avertissement (orange)
     */
    public static function warning(string $text, array $attributes = []): string
    {
        return self::render($text, 'bg-orange-100 text-orange-800', $attributes);
    }

    /**
     * Badge d'information (cyan)
     */
    public static function info(string $text, array $attributes = []): string
    {
        return self::render($text, 'bg-cyan-100 text-cyan-800', $attributes);
    }

    /**
     * Badge neutre (gris)
     */
    public static function secondary(string $text, array $attributes = []): string
    {
        return self::render($text, 'bg-gray-100 text-gray-800', $attributes);
    }

    /**
     * Badge de statut (avec mapping automatique)
     */
    public static function status(string $status, ?string $label = null): string
    {
        $statusMap = [
            'active' => ['class' => 'bg-green-100 text-green-800', 'label' => 'Actif'],
            'inactive' => ['class' => 'bg-gray-100 text-gray-800', 'label' => 'Inactif'],
            'pending' => ['class' => 'bg-yellow-100 text-yellow-800', 'label' => 'En attente'],
            'completed' => ['class' => 'bg-green-100 text-green-800', 'label' => 'Terminé'],
            'done' => ['class' => 'bg-green-100 text-green-800', 'label' => 'Terminé'],
            'in_progress' => ['class' => 'bg-blue-100 text-blue-800', 'label' => 'En cours'],
            'todo' => ['class' => 'bg-gray-100 text-gray-800', 'label' => 'À faire'],
            'cancelled' => ['class' => 'bg-red-100 text-red-800', 'label' => 'Annulé'],
            'archived' => ['class' => 'bg-gray-100 text-gray-800', 'label' => 'Archivé'],
        ];

        $config = $statusMap[strtolower($status)] ?? ['class' => 'bg-gray-100 text-gray-800', 'label' => ucfirst($status)];
        $text = $label ?? $config['label'];

        return self::render($text, $config['class']);
    }

    /**
     * Badge de priorité (avec mapping automatique)
     */
    public static function priority(string $priority, ?string $label = null): string
    {
        $priorityMap = [
            'low' => ['class' => 'bg-gray-100 text-gray-800', 'label' => 'Basse'],
            'medium' => ['class' => 'bg-blue-100 text-blue-800', 'label' => 'Moyenne'],
            'high' => ['class' => 'bg-orange-100 text-orange-800', 'label' => 'Haute'],
            'urgent' => ['class' => 'bg-red-100 text-red-800', 'label' => 'Urgente'],
        ];

        $config = $priorityMap[strtolower($priority)] ?? ['class' => 'bg-gray-100 text-gray-800', 'label' => ucfirst($priority)];
        $text = $label ?? $config['label'];

        return self::render($text, $config['class']);
    }

    /**
     * Badge avec icône
     */
    public static function withIcon(string $text, string $icon, string $colorClass = 'bg-blue-100 text-blue-800', array $attributes = []): string
    {
        $iconHtml = sprintf('<i class="%s mr-1"></i>', self::escape($icon));
        return self::render($iconHtml . $text, $colorClass, $attributes);
    }

    /**
     * Badge avec point (indicator)
     */
    public static function withDot(string $text, string $color = 'blue', array $attributes = []): string
    {
        $colorMap = [
            'blue' => 'bg-blue-400',
            'green' => 'bg-green-400',
            'red' => 'bg-red-400',
            'yellow' => 'bg-yellow-400',
            'gray' => 'bg-gray-400',
        ];

        $dotColor = $colorMap[$color] ?? $colorMap['blue'];
        $dotHtml = '<span class="w-2 h-2 rounded-full ' . $dotColor . ' mr-1.5"></span>';

        $badgeColor = 'bg-' . $color . '-100 text-' . $color . '-800';

        return self::render($dotHtml . $text, $badgeColor, $attributes);
    }

    /**
     * Badge avec compteur
     */
    public static function count(int $count, string $colorClass = 'bg-blue-100 text-blue-800', array $attributes = []): string
    {
        return self::render((string)$count, $colorClass, $attributes);
    }

    /**
     * Rendu du badge
     */
    private static function render(string $content, string $colorClass, array $attributes = []): string
    {
        $classes = self::classNames([
            self::BASE_CLASSES,
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
