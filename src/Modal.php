<?php

namespace TailwindUI;

/**
 * Composant Modal - Fenêtres modales avec backdrop et animations
 *
 * Exemples d'utilisation :
 * Modal::basic('modal-id', 'Titre', 'Contenu')
 * Modal::confirm('confirm-id', 'Confirmer', 'Êtes-vous sûr?')
 * Modal::fullscreen('fs-id', 'Titre', 'Contenu')
 */
class Modal extends Component
{
    private static bool $scriptIncluded = false;

    /**
     * Modal basique avec animations
     */
    public static function basic(string $id, string $title, string $content, ?string $footer = null, array $attributes = [], string $size = 'md'): string
    {
        $sizes = [
            'sm' => 'max-w-md',
            'md' => 'max-w-lg',
            'lg' => 'max-w-2xl',
            'xl' => 'max-w-4xl',
            '2xl' => 'max-w-6xl',
        ];

        $sizeClass = $sizes[$size] ?? $sizes['md'];

        $classes = self::classNames([
            'hidden fixed inset-0 z-50 overflow-y-auto',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = self::getScript();
        $html .= '<div id="' . self::escape($id) . '" class="' . $classes . '" ' . self::attributes($attributes) . ' role="dialog" aria-modal="true" aria-labelledby="' . self::escape($id) . '-title">';

        // Backdrop
        $html .= '<div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" data-modal-backdrop></div>';

        // Conteneur centré
        $html .= '<div class="flex min-h-screen items-center justify-center p-4">';

        // Modal
        $html .= '<div class="' . $sizeClass . ' w-full relative bg-white rounded-3xl shadow-2xl transform transition-all" data-modal-content>';

        // Header
        $html .= '<div class="flex items-center justify-between px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50/80 via-white to-gray-50/80">';
        $html .= '<h3 id="' . self::escape($id) . '-title" class="text-xl font-bold text-gray-900">' . self::escape($title) . '</h3>';
        $html .= '<button type="button" data-modal-close class="text-gray-400 hover:text-gray-600 transition-colors rounded-lg p-2 hover:bg-gray-100" aria-label="Fermer">';
        $html .= '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>';
        $html .= '</button>';
        $html .= '</div>';

        // Body
        $html .= '<div class="px-6 py-6">' . $content . '</div>';

        // Footer
        if ($footer) {
            $html .= '<div class="px-6 py-4 bg-gradient-to-r from-gray-50/50 to-gray-100/50 border-t border-gray-100 rounded-b-3xl">';
            $html .= $footer;
            $html .= '</div>';
        }

        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Modal de confirmation
     */
    public static function confirm(string $id, string $title, string $message, string $confirmText = 'Confirmer', string $cancelText = 'Annuler', string $confirmVariant = 'danger', array $attributes = []): string
    {
        $footer = '<div class="flex justify-end space-x-3">';
        $footer .= Button::secondary($cancelText, ['data-modal-close' => true]);
        $footer .= Button::{$confirmVariant}($confirmText, ['data-modal-confirm' => true]);
        $footer .= '</div>';

        return self::basic($id, $title, '<p class="text-gray-600">' . self::escape($message) . '</p>', $footer, $attributes, 'sm');
    }

    /**
     * Modal glassmorphism
     */
    public static function glass(string $id, string $title, string $content, ?string $footer = null, array $attributes = [], string $size = 'md'): string
    {
        $sizes = [
            'sm' => 'max-w-md',
            'md' => 'max-w-lg',
            'lg' => 'max-w-2xl',
            'xl' => 'max-w-4xl',
        ];

        $sizeClass = $sizes[$size] ?? $sizes['md'];

        $html = self::getScript();
        $html .= '<div id="' . self::escape($id) . '" class="hidden fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true" aria-labelledby="' . self::escape($id) . '-title">';

        // Backdrop avec blur
        $html .= '<div class="fixed inset-0 bg-gray-900/40 backdrop-blur-md transition-opacity" data-modal-backdrop></div>';

        // Conteneur centré
        $html .= '<div class="flex min-h-screen items-center justify-center p-4">';

        // Modal glass
        $html .= '<div class="' . $sizeClass . ' w-full relative backdrop-blur-xl bg-white/80 border border-white/20 rounded-3xl shadow-2xl transform transition-all" data-modal-content>';

        // Header
        $html .= '<div class="flex items-center justify-between px-6 py-5 border-b border-white/20">';
        $html .= '<h3 id="' . self::escape($id) . '-title" class="text-xl font-bold text-gray-900">' . self::escape($title) . '</h3>';
        $html .= '<button type="button" data-modal-close class="text-gray-400 hover:text-gray-600 transition-colors rounded-lg p-2 hover:bg-white/50" aria-label="Fermer">';
        $html .= '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>';
        $html .= '</button>';
        $html .= '</div>';

        // Body
        $html .= '<div class="px-6 py-6">' . $content . '</div>';

        // Footer
        if ($footer) {
            $html .= '<div class="px-6 py-4 border-t border-white/20 rounded-b-3xl">';
            $html .= $footer;
            $html .= '</div>';
        }

        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Modal fullscreen
     */
    public static function fullscreen(string $id, string $title, string $content, ?string $footer = null, array $attributes = []): string
    {
        $html = self::getScript();
        $html .= '<div id="' . self::escape($id) . '" class="hidden fixed inset-0 z-50" role="dialog" aria-modal="true" aria-labelledby="' . self::escape($id) . '-title">';

        // Backdrop
        $html .= '<div class="fixed inset-0 bg-white" data-modal-backdrop></div>';

        // Conteneur fullscreen
        $html .= '<div class="relative h-full flex flex-col" data-modal-content>';

        // Header
        $html .= '<div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-white z-10">';
        $html .= '<h3 id="' . self::escape($id) . '-title" class="text-xl font-bold text-gray-900">' . self::escape($title) . '</h3>';
        $html .= '<button type="button" data-modal-close class="text-gray-400 hover:text-gray-600 transition-colors rounded-lg p-2 hover:bg-gray-100" aria-label="Fermer">';
        $html .= '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>';
        $html .= '</button>';
        $html .= '</div>';

        // Body scrollable
        $html .= '<div class="flex-1 overflow-y-auto px-6 py-6 bg-gray-50">' . $content . '</div>';

        // Footer
        if ($footer) {
            $html .= '<div class="px-6 py-4 border-t border-gray-200 bg-white">';
            $html .= $footer;
            $html .= '</div>';
        }

        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Modal drawer (slide from side)
     */
    public static function drawer(string $id, string $title, string $content, string $position = 'right', array $attributes = []): string
    {
        $positions = [
            'right' => 'right-0 translate-x-full data-[open]:translate-x-0',
            'left' => 'left-0 -translate-x-full data-[open]:translate-x-0',
            'top' => 'top-0 -translate-y-full data-[open]:translate-y-0 w-full',
            'bottom' => 'bottom-0 translate-y-full data-[open]:translate-y-0 w-full',
        ];

        $positionClass = $positions[$position] ?? $positions['right'];
        $widthClass = ($position === 'top' || $position === 'bottom') ? 'h-auto max-h-[80vh]' : 'w-full max-w-md h-full';

        $html = self::getScript();
        $html .= '<div id="' . self::escape($id) . '" class="hidden fixed inset-0 z-50" role="dialog" aria-modal="true" aria-labelledby="' . self::escape($id) . '-title">';

        // Backdrop
        $html .= '<div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" data-modal-backdrop></div>';

        // Drawer
        $html .= '<div class="fixed ' . $positionClass . ' ' . $widthClass . ' bg-white shadow-2xl transform transition-transform duration-300 flex flex-col" data-modal-content>';

        // Header
        $html .= '<div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">';
        $html .= '<h3 id="' . self::escape($id) . '-title" class="text-xl font-bold text-gray-900">' . self::escape($title) . '</h3>';
        $html .= '<button type="button" data-modal-close class="text-gray-400 hover:text-gray-600 transition-colors rounded-lg p-2 hover:bg-gray-100" aria-label="Fermer">';
        $html .= '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>';
        $html .= '</button>';
        $html .= '</div>';

        // Body
        $html .= '<div class="flex-1 overflow-y-auto px-6 py-6">' . $content . '</div>';

        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Bouton pour ouvrir une modal
     */
    public static function trigger(string $targetId, string $text, string $variant = 'primary', array $attributes = [], string $size = 'md'): string
    {
        $attributes['data-modal-trigger'] = $targetId;
        return Button::{$variant}($text, $attributes, $size);
    }

    /**
     * Script JavaScript pour gérer les modals
     */
    private static function getScript(): string
    {
        if (self::$scriptIncluded) {
            return '';
        }

        self::$scriptIncluded = true;

        return '<script>
(function() {
    if (window.modalInitialized) return;
    window.modalInitialized = true;

    // Open modal
    document.addEventListener("click", function(e) {
        var trigger = e.target.closest("[data-modal-trigger]");
        if (trigger) {
            var modalId = trigger.getAttribute("data-modal-trigger");
            var modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove("hidden");
                document.body.style.overflow = "hidden";
                setTimeout(function() {
                    modal.querySelector("[data-modal-backdrop]").style.opacity = "1";
                    var content = modal.querySelector("[data-modal-content]");
                    content.style.opacity = "0";
                    content.style.transform = "scale(0.95)";
                    setTimeout(function() {
                        content.style.transition = "all 0.2s";
                        content.style.opacity = "1";
                        content.style.transform = "scale(1)";
                    }, 10);
                }, 10);
            }
        }
    });

    // Close modal
    document.addEventListener("click", function(e) {
        var closeBtn = e.target.closest("[data-modal-close]");
        var backdrop = e.target.closest("[data-modal-backdrop]");

        if (closeBtn || backdrop) {
            var modal = closeBtn ? closeBtn.closest("[role=dialog]") : backdrop.closest("[role=dialog]");
            if (modal) {
                var content = modal.querySelector("[data-modal-content]");
                content.style.transition = "all 0.2s";
                content.style.opacity = "0";
                content.style.transform = "scale(0.95)";
                setTimeout(function() {
                    modal.classList.add("hidden");
                    document.body.style.overflow = "";
                }, 200);
            }
        }
    });

    // Escape key to close
    document.addEventListener("keydown", function(e) {
        if (e.key === "Escape") {
            var openModals = document.querySelectorAll("[role=dialog]:not(.hidden)");
            openModals.forEach(function(modal) {
                modal.querySelector("[data-modal-close]")?.click();
            });
        }
    });
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
