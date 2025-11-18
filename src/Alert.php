<?php

namespace TailwindUI;

/**
 * Composant Alert - Messages d'alerte et de notification
 *
 * Exemples d'utilisation :
 * Alert::success('Opération réussie !')
 * Alert::error('Une erreur est survenue')
 * Alert::warning('Attention, vérifiez vos données')
 * Alert::info('Information importante')
 */
class Alert extends Component
{
    /**
     * Classes de base pour toutes les alertes
     */
    private const BASE_CLASSES = 'px-4 py-4 rounded-xl relative mb-4 backdrop-blur-sm';

    /**
     * Alert de succès (vert)
     */
    public static function success(string $message, bool $dismissible = true, array $attributes = []): string
    {
        return self::render($message, 'success', $dismissible, $attributes);
    }

    /**
     * Alert d'erreur (rouge)
     */
    public static function error(string $message, bool $dismissible = true, array $attributes = []): string
    {
        return self::render($message, 'error', $dismissible, $attributes);
    }

    /**
     * Alert d'avertissement (jaune)
     */
    public static function warning(string $message, bool $dismissible = true, array $attributes = []): string
    {
        return self::render($message, 'warning', $dismissible, $attributes);
    }

    /**
     * Alert d'information (bleu)
     */
    public static function info(string $message, bool $dismissible = true, array $attributes = []): string
    {
        return self::render($message, 'info', $dismissible, $attributes);
    }

    /**
     * Rendu de l'alerte
     */
    private static function render(string $message, string $type, bool $dismissible, array $attributes): string
    {
        $colors = self::getTypeColors($type);

        $classes = self::classNames([
            self::BASE_CLASSES,
            $colors,
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $attrs = array_merge([
            'role' => 'alert',
        ], $attributes);

        $html = '<div class="' . $classes . '" ' . self::attributes($attrs) . '>';

        // Icône
        $html .= '<div class="flex items-start">';
        $html .= '<div class="flex-shrink-0">';
        $html .= self::getIcon($type);
        $html .= '</div>';

        // Message
        $html .= '<div class="ml-3 flex-1">';
        $html .= '<span class="block sm:inline">' . self::escape($message) . '</span>';
        $html .= '</div>';

        // Bouton de fermeture
        if ($dismissible) {
            $html .= '<button type="button" class="ml-3 inline-flex text-gray-400 hover:text-gray-600 focus:outline-none transition-colors rounded-lg p-1 hover:bg-gray-100" onclick="this.closest(\'[role=alert]\').remove()">';
            $html .= '<svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">';
            $html .= '<path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>';
            $html .= '</svg>';
            $html .= '</button>';
        }

        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Obtient les classes de couleur pour un type donné
     */
    private static function getTypeColors(string $type): string
    {
        $colors = [
            'success' => 'bg-emerald-50 border border-emerald-200 text-emerald-800',
            'error' => 'bg-red-50 border border-red-200 text-red-800',
            'warning' => 'bg-amber-50 border border-amber-200 text-amber-800',
            'info' => 'bg-blue-50 border border-blue-200 text-blue-800',
        ];

        return $colors[$type] ?? $colors['info'];
    }

    /**
     * Obtient l'icône pour un type donné
     */
    private static function getIcon(string $type): string
    {
        $icons = [
            'success' => '<i class="fas fa-check-circle text-xl text-emerald-500"></i>',
            'error' => '<i class="fas fa-exclamation-circle text-xl text-red-500"></i>',
            'warning' => '<i class="fas fa-exclamation-triangle text-xl text-amber-500"></i>',
            'info' => '<i class="fas fa-info-circle text-xl text-blue-500"></i>',
        ];

        return $icons[$type] ?? $icons['info'];
    }

    /**
     * Affiche les messages flash de session
     */
    public static function flashMessages(array $flashes): string
    {
        if (empty($flashes)) {
            return '';
        }

        $html = '<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">';

        foreach ($flashes as $type => $message) {
            $method = method_exists(self::class, $type) ? $type : 'info';
            $html .= self::$method($message);
        }

        $html .= '</div>';

        // Script pour masquer automatiquement après 5 secondes
        $html .= '<script>';
        $html .= 'setTimeout(() => {';
        $html .= '  const alerts = document.querySelectorAll(\'[role="alert"]\');';
        $html .= '  alerts.forEach(alert => {';
        $html .= '    alert.style.transition = "opacity 0.5s";';
        $html .= '    alert.style.opacity = "0";';
        $html .= '    setTimeout(() => alert.remove(), 500);';
        $html .= '  });';
        $html .= '}, 5000);';
        $html .= '</script>';

        return $html;
    }

    /**
     * Toast notification (position fixe en haut à droite)
     */
    public static function toast(string $message, string $type = 'info', int $duration = 3000): string
    {
        $colors = self::getTypeColors($type);
        $icon = self::getIcon($type);

        $html = '<div id="toast" class="fixed top-4 right-4 z-50 ' . $colors . ' ' . self::BASE_CLASSES . ' shadow-xl transform transition-all duration-300 animate-slide-in-right" role="alert">';
        $html .= '<div class="flex items-center">';
        $html .= '<div class="flex-shrink-0">' . $icon . '</div>';
        $html .= '<div class="ml-3 font-medium">' . self::escape($message) . '</div>';
        $html .= '</div>';
        $html .= '</div>';

        // Script pour masquer automatiquement
        $html .= '<script>';
        $html .= 'setTimeout(() => {';
        $html .= '  const toast = document.getElementById("toast");';
        $html .= '  if (toast) {';
        $html .= '    toast.style.transition = "opacity 0.5s";';
        $html .= '    toast.style.opacity = "0";';
        $html .= '    setTimeout(() => toast.remove(), 500);';
        $html .= '  }';
        $html .= '}, ' . $duration . ');';
        $html .= '</script>';

        return $html;
    }
}
