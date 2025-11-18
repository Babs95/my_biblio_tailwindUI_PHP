<?php

namespace TailwindUI;

/**
 * Composant Button - Boutons stylisés avec Tailwind CSS
 *
 * Exemples d'utilisation :
 * Button::primary('Enregistrer', ['type' => 'submit'])
 * Button::secondary('Annuler', ['onclick' => 'history.back()'])
 * Button::danger('Supprimer', ['data-confirm' => 'Êtes-vous sûr ?'])
 */
class Button extends Component
{
    /**
     * Classes de base pour tous les boutons
     */
    private const BASE_CLASSES = 'inline-flex items-center justify-center font-semibold rounded-xl transition-all duration-300 ease-out focus:outline-none focus:ring-2 focus:ring-offset-2 transform hover:scale-[1.02] active:scale-[0.98] shadow-sm hover:shadow-md';

    /**
     * Tailles disponibles
     */
    private const SIZES = [
        'sm' => 'px-3.5 py-2 text-sm gap-1.5',
        'md' => 'px-5 py-2.5 text-sm gap-2',
        'lg' => 'px-6 py-3 text-base gap-2.5',
        'xl' => 'px-8 py-4 text-lg gap-3',
    ];

    /**
     * Bouton primaire (bleu)
     */
    public static function primary(string $text, array $attributes = [], string $size = 'md'): string
    {
        return self::render($text, 'primary', $size, $attributes);
    }

    /**
     * Bouton secondaire (gris)
     */
    public static function secondary(string $text, array $attributes = [], string $size = 'md'): string
    {
        return self::render($text, 'secondary', $size, $attributes);
    }

    /**
     * Bouton de succès (vert)
     */
    public static function success(string $text, array $attributes = [], string $size = 'md'): string
    {
        return self::render($text, 'success', $size, $attributes);
    }

    /**
     * Bouton de danger (rouge)
     */
    public static function danger(string $text, array $attributes = [], string $size = 'md'): string
    {
        return self::render($text, 'danger', $size, $attributes);
    }

    /**
     * Bouton d'avertissement (jaune/orange)
     */
    public static function warning(string $text, array $attributes = [], string $size = 'md'): string
    {
        return self::render($text, 'warning', $size, $attributes);
    }

    /**
     * Bouton d'information (bleu clair)
     */
    public static function info(string $text, array $attributes = [], string $size = 'md'): string
    {
        return self::render($text, 'info', $size, $attributes);
    }

    /**
     * Bouton outline (contour uniquement)
     */
    public static function outline(string $text, string $color = 'blue', array $attributes = [], string $size = 'md'): string
    {
        return self::render($text, "outline-{$color}", $size, $attributes);
    }

    /**
     * Bouton avec icône
     */
    public static function withIcon(string $text, string $icon, string $variant = 'primary', array $attributes = [], string $size = 'md'): string
    {
        $iconHtml = sprintf('<i class="%s mr-2"></i>', self::escape($icon));
        return self::render($iconHtml . $text, $variant, $size, $attributes);
    }

    /**
     * Bouton icône uniquement
     */
    public static function icon(string $icon, string $variant = 'primary', array $attributes = [], string $size = 'md'): string
    {
        $iconHtml = sprintf('<i class="%s"></i>', self::escape($icon));
        $attributes['class'] = ($attributes['class'] ?? '') . ' !px-3';
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
            'primary' => 'text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:ring-blue-500 shadow-blue-500/25',
            'secondary' => 'text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 hover:border-gray-300 focus:ring-gray-500',
            'success' => 'text-white bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 focus:ring-emerald-500 shadow-emerald-500/25',
            'danger' => 'text-white bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 focus:ring-red-500 shadow-red-500/25',
            'warning' => 'text-white bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 focus:ring-amber-500 shadow-amber-500/25',
            'info' => 'text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 focus:ring-cyan-500 shadow-cyan-500/25',
            'outline-blue' => 'text-blue-600 bg-transparent border-2 border-blue-600 hover:bg-blue-50 focus:ring-blue-500',
            'outline-gray' => 'text-gray-600 bg-transparent border-2 border-gray-300 hover:bg-gray-50 hover:border-gray-400 focus:ring-gray-500',
            'outline-red' => 'text-red-600 bg-transparent border-2 border-red-600 hover:bg-red-50 focus:ring-red-500',
        ];

        return $variants[$variant] ?? $variants['primary'];
    }

    /**
     * Groupe de boutons
     */
    public static function group(array $buttons): string
    {
        return sprintf(
            '<div class="inline-flex rounded-xl shadow-sm divide-x divide-gray-200" role="group">%s</div>',
            implode('', $buttons)
        );
    }
}
