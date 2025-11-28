<?php

namespace TailwindUI;

/**
 * Composant Tooltip - Info-bulles avec positionnement
 *
 * Exemples d'utilisation :
 * Tooltip::top('Hover me', 'Tooltip text')
 * Tooltip::bottom('Click here', 'Additional info', 'dark')
 */
class Tooltip extends Component
{
    private static bool $scriptIncluded = false;

    /**
     * Tooltip en haut
     */
    public static function top(string $content, string $tooltip, string $theme = 'dark', array $attributes = []): string
    {
        return self::render($content, $tooltip, 'top', $theme, $attributes);
    }

    /**
     * Tooltip en bas
     */
    public static function bottom(string $content, string $tooltip, string $theme = 'dark', array $attributes = []): string
    {
        return self::render($content, $tooltip, 'bottom', $theme, $attributes);
    }

    /**
     * Tooltip à gauche
     */
    public static function left(string $content, string $tooltip, string $theme = 'dark', array $attributes = []): string
    {
        return self::render($content, $tooltip, 'left', $theme, $attributes);
    }

    /**
     * Tooltip à droite
     */
    public static function right(string $content, string $tooltip, string $theme = 'dark', array $attributes = []): string
    {
        return self::render($content, $tooltip, 'right', $theme, $attributes);
    }

    /**
     * Rendu du tooltip
     */
    private static function render(string $content, string $tooltip, string $position, string $theme, array $attributes): string
    {
        $id = 'tooltip-' . uniqid();

        $themeClasses = [
            'dark' => 'bg-gray-900 text-white border-gray-700',
            'light' => 'bg-white text-gray-900 border-gray-200 shadow-xl',
            'primary' => 'bg-blue-600 text-white border-blue-500',
            'success' => 'bg-emerald-600 text-white border-emerald-500',
            'danger' => 'bg-red-600 text-white border-red-500',
        ];

        $themeClass = $themeClasses[$theme] ?? $themeClasses['dark'];

        $positions = [
            'top' => 'bottom-full left-1/2 -translate-x-1/2 mb-2',
            'bottom' => 'top-full left-1/2 -translate-x-1/2 mt-2',
            'left' => 'right-full top-1/2 -translate-y-1/2 mr-2',
            'right' => 'left-full top-1/2 -translate-y-1/2 ml-2',
        ];

        $arrows = [
            'top' => 'top-full left-1/2 -translate-x-1/2 border-t-gray-900',
            'bottom' => 'bottom-full left-1/2 -translate-x-1/2 border-b-gray-900',
            'left' => 'left-full top-1/2 -translate-y-1/2 border-l-gray-900',
            'right' => 'right-full top-1/2 -translate-y-1/2 border-r-gray-900',
        ];

        $positionClass = $positions[$position] ?? $positions['top'];
        $arrowClass = $arrows[$position] ?? $arrows['top'];

        // Adjust arrow color based on theme
        if ($theme === 'light') {
            $arrowClass = str_replace('gray-900', 'white', $arrowClass);
        } elseif ($theme === 'primary') {
            $arrowClass = str_replace('gray-900', 'blue-600', $arrowClass);
        } elseif ($theme === 'success') {
            $arrowClass = str_replace('gray-900', 'emerald-600', $arrowClass);
        } elseif ($theme === 'danger') {
            $arrowClass = str_replace('gray-900', 'red-600', $arrowClass);
        }

        $classes = self::classNames([
            'relative inline-block',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = self::getScript();
        $html .= '<span class="' . $classes . '" data-tooltip-container ' . self::attributes($attributes) . '>';
        $html .= '<span data-tooltip-trigger>' . $content . '</span>';

        // Tooltip bubble
        $html .= '<span class="absolute ' . $positionClass . ' z-50 hidden opacity-0 transition-opacity duration-200 pointer-events-none" data-tooltip-content role="tooltip">';
        $html .= '<span class="' . $themeClass . ' text-sm px-3 py-2 rounded-xl border backdrop-blur-sm whitespace-nowrap block">';
        $html .= self::escape($tooltip);
        $html .= '</span>';

        // Arrow
        $html .= '<span class="absolute ' . $arrowClass . ' w-0 h-0 border-4 border-transparent"></span>';

        $html .= '</span>';
        $html .= '</span>';

        return $html;
    }

    /**
     * Tooltip avec icône
     */
    public static function icon(string $icon, string $tooltip, string $position = 'top', string $theme = 'dark', array $attributes = []): string
    {
        $iconHtml = '<i class="' . self::escape($icon) . ' text-gray-400 hover:text-gray-600 transition-colors cursor-help" aria-hidden="true"></i>';
        return self::render($iconHtml, $tooltip, $position, $theme, $attributes);
    }

    /**
     * Tooltip avec HTML personnalisé
     */
    public static function custom(string $content, string $tooltipContent, string $position = 'top', array $attributes = []): string
    {
        $id = 'tooltip-' . uniqid();

        $positions = [
            'top' => 'bottom-full left-1/2 -translate-x-1/2 mb-2',
            'bottom' => 'top-full left-1/2 -translate-x-1/2 mt-2',
            'left' => 'right-full top-1/2 -translate-y-1/2 mr-2',
            'right' => 'left-full top-1/2 -translate-y-1/2 ml-2',
        ];

        $positionClass = $positions[$position] ?? $positions['top'];

        $html = self::getScript();
        $html .= '<span class="relative inline-block" data-tooltip-container ' . self::attributes($attributes) . '>';
        $html .= '<span data-tooltip-trigger>' . $content . '</span>';

        // Custom tooltip content
        $html .= '<span class="absolute ' . $positionClass . ' z-50 hidden opacity-0 transition-opacity duration-200 pointer-events-none" data-tooltip-content role="tooltip">';
        $html .= $tooltipContent;
        $html .= '</span>';

        $html .= '</span>';

        return $html;
    }

    /**
     * Script JavaScript pour gérer les tooltips
     */
    private static function getScript(): string
    {
        if (self::$scriptIncluded) {
            return '';
        }

        self::$scriptIncluded = true;

        return '<script>
(function() {
    if (window.tooltipInitialized) return;
    window.tooltipInitialized = true;

    // Show tooltip on hover
    document.addEventListener("mouseenter", function(e) {
        var trigger = e.target.closest("[data-tooltip-trigger]");
        if (trigger) {
            var container = trigger.closest("[data-tooltip-container]");
            if (container) {
                var tooltip = container.querySelector("[data-tooltip-content]");
                if (tooltip) {
                    tooltip.classList.remove("hidden");
                    setTimeout(function() {
                        tooltip.classList.add("opacity-100");
                        tooltip.classList.remove("opacity-0");
                    }, 10);
                }
            }
        }
    }, true);

    // Hide tooltip on leave
    document.addEventListener("mouseleave", function(e) {
        var trigger = e.target.closest("[data-tooltip-trigger]");
        if (trigger) {
            var container = trigger.closest("[data-tooltip-container]");
            if (container) {
                var tooltip = container.querySelector("[data-tooltip-content]");
                if (tooltip) {
                    tooltip.classList.add("opacity-0");
                    tooltip.classList.remove("opacity-100");
                    setTimeout(function() {
                        tooltip.classList.add("hidden");
                    }, 200);
                }
            }
        }
    }, true);
})();
</script>';
    }

    /**
     * Réinitialise le flag d'inclusion du script (utile pour les tests)
     */
    public static function resetScriptFlag(): void
    {
        self::$scriptIncluded = false;
    }
}
