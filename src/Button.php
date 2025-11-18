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
    private const BASE_CLASSES = 'inline-flex items-center px-4 py-2 border font-medium rounded-lg transition duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2';

    /**
     * Tailles disponibles
     */
    private const SIZES = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-base',
        'lg' => 'px-6 py-3 text-lg',
        'xl' => 'px-8 py-4 text-xl',
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
            'primary' => 'border-transparent text-white bg-blue-600 hover:bg-blue-700 focus:ring-blue-500',
            'secondary' => 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50 focus:ring-gray-500',
            'success' => 'border-transparent text-white bg-green-600 hover:bg-green-700 focus:ring-green-500',
            'danger' => 'border-transparent text-white bg-red-600 hover:bg-red-700 focus:ring-red-500',
            'warning' => 'border-transparent text-white bg-orange-600 hover:bg-orange-700 focus:ring-orange-500',
            'info' => 'border-transparent text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-cyan-500',
            'outline-blue' => 'border-blue-600 text-blue-600 bg-transparent hover:bg-blue-50 focus:ring-blue-500',
            'outline-gray' => 'border-gray-600 text-gray-600 bg-transparent hover:bg-gray-50 focus:ring-gray-500',
            'outline-red' => 'border-red-600 text-red-600 bg-transparent hover:bg-red-50 focus:ring-red-500',
        ];

        return $variants[$variant] ?? $variants['primary'];
    }

    /**
     * Groupe de boutons
     */
    public static function group(array $buttons): string
    {
        return sprintf(
            '<div class="inline-flex rounded-lg shadow-sm" role="group">%s</div>',
            implode('', $buttons)
        );
    }
}
