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
    private static bool $scriptIncluded = false;

    /**
     * Classes de base pour toutes les alertes
     */
    private const BASE_CLASSES = 'px-4 py-4 rounded-xl relative mb-4 backdrop-blur-sm';

    /**
     * Script pour la gestion des alertes avec event delegation
     */
    private static function getScript(): string
    {
        if (self::$scriptIncluded) {
            return '';
        }

        self::$scriptIncluded = true;

        return '<script>
(function() {
    if (window.alertInitialized) return;
    window.alertInitialized = true;

    document.addEventListener("click", function(e) {
        var dismissBtn = e.target.closest("[data-alert-dismiss]");
        if (dismissBtn) {
            var alert = dismissBtn.closest("[role=alert]");
            if (alert) {
                alert.style.transition = "opacity 0.3s";
                alert.style.opacity = "0";
                setTimeout(function() { alert.remove(); }, 300);
            }
        }
    });
})();
</script>';
    }

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

        $html = self::getScript();
        $html .= '<div class="' . $classes . '" ' . self::attributes($attrs) . '>';

        // Icône
        $html .= '<div class="flex items-start">';
        $html .= '<div class="flex-shrink-0" aria-hidden="true">';
        $html .= self::getIcon($type);
        $html .= '</div>';

        // Message
        $html .= '<div class="ml-3 flex-1">';
        $html .= '<span class="block sm:inline">' . self::escape($message) . '</span>';
        $html .= '</div>';

        // Bouton de fermeture
        if ($dismissible) {
            $html .= '<button type="button" aria-label="Fermer l\'alerte" data-alert-dismiss class="ml-3 inline-flex text-gray-400 hover:text-gray-600 focus:outline-none transition-colors rounded-lg p-1 hover:bg-gray-100">';
            $html .= '<svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">';
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
     * Obtient l'icône SVG pour un type donné
     */
    private static function getIcon(string $type): string
    {
        $icons = [
            'success' => '<svg class="h-5 w-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>',
            'error' => '<svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>',
            'warning' => '<svg class="h-5 w-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>',
            'info' => '<svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>',
        ];

        return $icons[$type] ?? $icons['info'];
    }

    /**
     * Affiche les messages flash de session
     */
    public static function flashMessages(array $flashes, int $autoDismiss = 5000): string
    {
        if (empty($flashes)) {
            return '';
        }

        $id = 'flash-container-' . uniqid();

        $html = '<div id="' . $id . '" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">';

        foreach ($flashes as $type => $message) {
            $method = method_exists(self::class, $type) ? $type : 'info';
            $html .= self::$method($message);
        }

        $html .= '</div>';

        // Script pour masquer automatiquement
        if ($autoDismiss > 0) {
            $html .= '<script>';
            $html .= '(function() {';
            $html .= 'setTimeout(function() {';
            $html .= '  var container = document.getElementById("' . $id . '");';
            $html .= '  if (container) {';
            $html .= '    var alerts = container.querySelectorAll("[role=alert]");';
            $html .= '    alerts.forEach(function(alert) {';
            $html .= '      alert.style.transition = "opacity 0.5s";';
            $html .= '      alert.style.opacity = "0";';
            $html .= '      setTimeout(function() { alert.remove(); }, 500);';
            $html .= '    });';
            $html .= '  }';
            $html .= '}, ' . intval($autoDismiss) . ');';
            $html .= '})();';
            $html .= '</script>';
        }

        return $html;
    }

    /**
     * Toast notification (position fixe en haut à droite)
     */
    public static function toast(string $message, string $type = 'info', int $duration = 3000): string
    {
        $colors = self::getTypeColors($type);
        $icon = self::getIcon($type);

        $id = 'toast-' . uniqid();

        $html = '<div id="' . $id . '" class="fixed top-4 right-4 z-50 ' . $colors . ' ' . self::BASE_CLASSES . ' shadow-xl transform transition-all duration-300" role="alert" aria-live="polite">';
        $html .= '<div class="flex items-center">';
        $html .= '<div class="flex-shrink-0" aria-hidden="true">' . $icon . '</div>';
        $html .= '<div class="ml-3 font-medium">' . self::escape($message) . '</div>';
        $html .= '</div>';
        $html .= '</div>';

        // Script pour masquer automatiquement
        $html .= '<script>';
        $html .= '(function() {';
        $html .= 'setTimeout(function() {';
        $html .= '  var toast = document.getElementById("' . $id . '");';
        $html .= '  if (toast) {';
        $html .= '    toast.style.transition = "opacity 0.5s";';
        $html .= '    toast.style.opacity = "0";';
        $html .= '    setTimeout(function() { toast.remove(); }, 500);';
        $html .= '  }';
        $html .= '}, ' . intval($duration) . ');';
        $html .= '})();';
        $html .= '</script>';

        return $html;
    }

    /**
     * Réinitialise le flag d'inclusion du script (utile pour les tests)
     */
    public static function resetScriptFlag(): void
    {
        self::$scriptIncluded = false;
    }
}
