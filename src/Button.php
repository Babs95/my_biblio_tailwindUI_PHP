<?php

namespace TailwindUI;

/**
 * Composant Button - Boutons modernes avec effets visuels avancés
 *
 * Exemples d'utilisation :
 * Button::primary('Enregistrer', ['type' => 'submit'])
 * Button::glass('Action', ['onclick' => '...'])
 * Button::glow('Highlight', 'purple')
 */
class Button extends Component
{
    /**
     * Classes de base pour tous les boutons
     */
    private const BASE_CLASSES = 'inline-flex items-center justify-center font-semibold rounded-2xl transition-all duration-300 ease-out focus:outline-none focus:ring-2 focus:ring-offset-2 transform hover:-translate-y-0.5 hover:scale-[1.02] active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none';

    /**
     * Tailles disponibles
     */
    private const SIZES = [
        'xs' => 'px-3 py-1.5 text-xs gap-1',
        'sm' => 'px-4 py-2 text-sm gap-1.5',
        'md' => 'px-5 py-2.5 text-sm gap-2',
        'lg' => 'px-6 py-3 text-base gap-2.5',
        'xl' => 'px-8 py-4 text-lg gap-3',
    ];

    /**
     * Bouton primaire (bleu avec glow)
     */
    public static function primary(string $text, array $attributes = [], string $size = 'md'): string
    {
        return self::render($text, 'primary', $size, $attributes);
    }

    /**
     * Bouton secondaire (élégant et subtil)
     */
    public static function secondary(string $text, array $attributes = [], string $size = 'md'): string
    {
        return self::render($text, 'secondary', $size, $attributes);
    }

    /**
     * Bouton de succès (vert vibrant)
     */
    public static function success(string $text, array $attributes = [], string $size = 'md'): string
    {
        return self::render($text, 'success', $size, $attributes);
    }

    /**
     * Bouton de danger (rouge intense)
     */
    public static function danger(string $text, array $attributes = [], string $size = 'md'): string
    {
        return self::render($text, 'danger', $size, $attributes);
    }

    /**
     * Bouton d'avertissement (gradient chaud)
     */
    public static function warning(string $text, array $attributes = [], string $size = 'md'): string
    {
        return self::render($text, 'warning', $size, $attributes);
    }

    /**
     * Bouton d'information (cyan moderne)
     */
    public static function info(string $text, array $attributes = [], string $size = 'md'): string
    {
        return self::render($text, 'info', $size, $attributes);
    }

    /**
     * Bouton glass (effet glassmorphism)
     */
    public static function glass(string $text, array $attributes = [], string $size = 'md'): string
    {
        return self::render($text, 'glass', $size, $attributes);
    }

    /**
     * Bouton avec effet glow
     */
    public static function glow(string $text, string $color = 'purple', array $attributes = [], string $size = 'md'): string
    {
        return self::render($text, "glow-{$color}", $size, $attributes);
    }

    /**
     * Bouton outline moderne
     */
    public static function outline(string $text, string $color = 'blue', array $attributes = [], string $size = 'md'): string
    {
        return self::render($text, "outline-{$color}", $size, $attributes);
    }

    /**
     * Bouton soft (couleurs douces)
     */
    public static function soft(string $text, string $color = 'blue', array $attributes = [], string $size = 'md'): string
    {
        return self::render($text, "soft-{$color}", $size, $attributes);
    }

    /**
     * Bouton avec icône
     */
    public static function withIcon(string $text, string $icon, string $variant = 'primary', array $attributes = [], string $size = 'md'): string
    {
        $iconHtml = sprintf('<i class="%s" aria-hidden="true"></i>', self::escape($icon));
        return self::render($iconHtml . '<span>' . self::escape($text) . '</span>', $variant, $size, $attributes);
    }

    /**
     * Bouton icône uniquement
     */
    public static function icon(string $icon, string $variant = 'primary', array $attributes = [], string $size = 'md'): string
    {
        $iconHtml = sprintf('<i class="%s" aria-hidden="true"></i>', self::escape($icon));
        $iconSizes = [
            'xs' => '!p-1.5',
            'sm' => '!p-2',
            'md' => '!p-2.5',
            'lg' => '!p-3',
            'xl' => '!p-4',
        ];
        $attributes['class'] = ($attributes['class'] ?? '') . ' ' . ($iconSizes[$size] ?? $iconSizes['md']) . ' aspect-square';
        return self::render($iconHtml, $variant, $size, $attributes);
    }

    /**
     * Rendu du bouton
     */
    private static function render(string $content, string $variant, string $size, array $attributes): string
    {
        $classes = self::classNames([
            self::BASE_CLASSES,
            self::SIZES[$size] ?? self::SIZES['md'],
            self::getVariantClasses($variant),
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $type = $attributes['type'] ?? 'button';
        $attributes['type'] = $type;

        return sprintf(
            '<button class="%s" %s>%s</button>',
            $classes,
            self::attributes($attributes),
            $content
        );
    }

    /**
     * Obtient les classes CSS pour une variante donnée
     */
    private static function getVariantClasses(string $variant): string
    {
        $variants = [
            // Boutons pleins avec gradients et ombres colorées
            'primary' => 'text-white bg-gradient-to-br from-blue-500 via-blue-600 to-blue-700 hover:from-blue-600 hover:via-blue-700 hover:to-blue-800 focus:ring-blue-500 shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40',
            'secondary' => 'text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 hover:border-gray-300 focus:ring-gray-400 shadow-lg shadow-gray-200/50 hover:shadow-xl',
            'success' => 'text-white bg-gradient-to-br from-emerald-400 via-emerald-500 to-emerald-600 hover:from-emerald-500 hover:via-emerald-600 hover:to-emerald-700 focus:ring-emerald-500 shadow-lg shadow-emerald-500/30 hover:shadow-xl hover:shadow-emerald-500/40',
            'danger' => 'text-white bg-gradient-to-br from-red-500 via-red-600 to-red-700 hover:from-red-600 hover:via-red-700 hover:to-red-800 focus:ring-red-500 shadow-lg shadow-red-500/30 hover:shadow-xl hover:shadow-red-500/40',
            'warning' => 'text-white bg-gradient-to-br from-amber-400 via-orange-500 to-orange-600 hover:from-amber-500 hover:via-orange-600 hover:to-orange-700 focus:ring-orange-500 shadow-lg shadow-orange-500/30 hover:shadow-xl hover:shadow-orange-500/40',
            'info' => 'text-white bg-gradient-to-br from-cyan-400 via-cyan-500 to-blue-600 hover:from-cyan-500 hover:via-cyan-600 hover:to-blue-700 focus:ring-cyan-500 shadow-lg shadow-cyan-500/30 hover:shadow-xl hover:shadow-cyan-500/40',

            // Glassmorphism
            'glass' => 'text-white bg-white/10 backdrop-blur-md border border-white/20 hover:bg-white/20 focus:ring-white/50 shadow-lg',

            // Boutons glow
            'glow-purple' => 'text-white bg-gradient-to-br from-purple-500 via-purple-600 to-indigo-700 hover:from-purple-600 hover:via-purple-700 hover:to-indigo-800 focus:ring-purple-500 shadow-lg shadow-purple-500/50 hover:shadow-xl hover:shadow-purple-500/60',
            'glow-pink' => 'text-white bg-gradient-to-br from-pink-500 via-rose-500 to-rose-600 hover:from-pink-600 hover:via-rose-600 hover:to-rose-700 focus:ring-pink-500 shadow-lg shadow-pink-500/50 hover:shadow-xl hover:shadow-pink-500/60',
            'glow-indigo' => 'text-white bg-gradient-to-br from-indigo-500 via-indigo-600 to-purple-700 hover:from-indigo-600 hover:via-indigo-700 hover:to-purple-800 focus:ring-indigo-500 shadow-lg shadow-indigo-500/50 hover:shadow-xl hover:shadow-indigo-500/60',

            // Outline avec hover fill
            'outline-blue' => 'text-blue-600 bg-transparent border-2 border-blue-500 hover:bg-blue-500 hover:text-white focus:ring-blue-500',
            'outline-gray' => 'text-gray-600 bg-transparent border-2 border-gray-300 hover:bg-gray-100 hover:border-gray-400 focus:ring-gray-400',
            'outline-red' => 'text-red-600 bg-transparent border-2 border-red-500 hover:bg-red-500 hover:text-white focus:ring-red-500',
            'outline-green' => 'text-emerald-600 bg-transparent border-2 border-emerald-500 hover:bg-emerald-500 hover:text-white focus:ring-emerald-500',

            // Soft (couleurs pastel)
            'soft-blue' => 'text-blue-700 bg-blue-50 hover:bg-blue-100 focus:ring-blue-500 border border-blue-100',
            'soft-red' => 'text-red-700 bg-red-50 hover:bg-red-100 focus:ring-red-500 border border-red-100',
            'soft-green' => 'text-emerald-700 bg-emerald-50 hover:bg-emerald-100 focus:ring-emerald-500 border border-emerald-100',
            'soft-purple' => 'text-purple-700 bg-purple-50 hover:bg-purple-100 focus:ring-purple-500 border border-purple-100',
            'soft-amber' => 'text-amber-700 bg-amber-50 hover:bg-amber-100 focus:ring-amber-500 border border-amber-100',
        ];

        return $variants[$variant] ?? $variants['primary'];
    }

    /**
     * Groupe de boutons
     */
    public static function group(array $buttons): string
    {
        return sprintf(
            '<div class="inline-flex rounded-2xl shadow-lg overflow-hidden divide-x divide-white/20" role="group">%s</div>',
            implode('', $buttons)
        );
    }

    /**
     * Lien stylisé comme un bouton
     */
    public static function link(string $text, string $url, string $variant = 'primary', array $attributes = [], string $size = 'md'): string
    {
        $classes = self::classNames([
            self::BASE_CLASSES,
            self::SIZES[$size] ?? self::SIZES['md'],
            self::getVariantClasses($variant),
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);
        $attributes['href'] = $url;

        return sprintf(
            '<a class="%s" %s>%s</a>',
            $classes,
            self::attributes($attributes),
            self::escape($text)
        );
    }
}
