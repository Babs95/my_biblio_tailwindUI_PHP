<?php

namespace TailwindUI;

/**
 * Composant FlyoutMenu - Menus déroulants avancés
 *
 * Exemples d'utilisation :
 * FlyoutMenu::simple('Produits', $items)
 * FlyoutMenu::mega('Solutions', $sections)
 * FlyoutMenu::withIcons('Features', $items)
 */
class FlyoutMenu extends Component
{
    private static bool $scriptIncluded = false;

    /**
     * Script JavaScript pour la gestion des menus flyout
     * Retourne le script seulement s'il n'a pas déjà été inclus
     */
    private static function getScript(): string
    {
        if (self::$scriptIncluded) {
            return '';
        }

        self::$scriptIncluded = true;

        return '<script>
(function() {
    if (window.flyoutMenuInitialized) return;
    window.flyoutMenuInitialized = true;

    document.addEventListener("click", function(e) {
        var trigger = e.target.closest("[data-flyout-trigger]");

        if (trigger) {
            e.preventDefault();
            e.stopPropagation();

            var targetId = trigger.getAttribute("data-flyout-target");
            var menu = document.getElementById(targetId);

            if (menu) {
                var isHidden = menu.classList.contains("hidden");

                // Fermer tous les menus et mettre à jour aria-expanded
                document.querySelectorAll("[data-flyout-content]").forEach(function(m) {
                    m.classList.add("hidden");
                });
                document.querySelectorAll("[data-flyout-trigger]").forEach(function(t) {
                    t.setAttribute("aria-expanded", "false");
                });

                // Toggle ce menu
                if (isHidden) {
                    menu.classList.remove("hidden");
                    trigger.setAttribute("aria-expanded", "true");
                }
            }
        } else {
            // Clic en dehors - fermer tous les menus
            if (!e.target.closest("[data-flyout-content]")) {
                document.querySelectorAll("[data-flyout-content]").forEach(function(menu) {
                    menu.classList.add("hidden");
                });
                document.querySelectorAll("[data-flyout-trigger]").forEach(function(t) {
                    t.setAttribute("aria-expanded", "false");
                });
            }
        }
    });

    document.addEventListener("keydown", function(e) {
        if (e.key === "Escape") {
            document.querySelectorAll("[data-flyout-content]").forEach(function(menu) {
                menu.classList.add("hidden");
            });
            document.querySelectorAll("[data-flyout-trigger]").forEach(function(t) {
                t.setAttribute("aria-expanded", "false");
            });
        }
    });
})();
</script>';
    }

    /**
     * Génère le bouton trigger avec attributs ARIA
     */
    private static function getTriggerButton(string $trigger, string $id): string
    {
        return '<button type="button" data-flyout-trigger data-flyout-target="' . $id . '" ' .
               'class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 hover:text-gray-900 transition-colors duration-200" ' .
               'aria-expanded="false" aria-haspopup="true" aria-controls="' . $id . '">' .
               self::escape($trigger) .
               '<svg class="ml-2 h-3 w-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">' .
               '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>' .
               '</svg>' .
               '</button>';
    }

    /**
     * Menu flyout simple
     */
    public static function simple(string $trigger, array $items, array $attributes = []): string
    {
        $classes = self::classNames([
            'relative inline-block text-left',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $id = 'flyout-' . uniqid();

        $html = self::getScript();
        $html .= '<div class="' . $classes . '" data-flyout-menu ' . self::attributes($attributes) . '>';
        $html .= self::getTriggerButton($trigger, $id);

        // Dropdown panel
        $html .= '<div id="' . $id . '" data-flyout-content role="menu" aria-orientation="vertical" class="hidden absolute left-0 z-50 mt-2 w-56 origin-top-left rounded-xl bg-white shadow-lg ring-1 ring-black/5 focus:outline-none">';
        $html .= '<div class="py-2">';

        foreach ($items as $item) {
            if ($item === 'divider') {
                $html .= '<div class="border-t border-gray-100 my-2" role="separator"></div>';
            } else {
                $html .= '<a href="' . self::escape($item['url']) . '" role="menuitem" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors duration-150">';
                if (isset($item['icon'])) {
                    $html .= '<i class="' . self::escape($item['icon']) . ' mr-3 text-gray-400" aria-hidden="true"></i>';
                }
                $html .= self::escape($item['label']);
                $html .= '</a>';
            }
        }

        $html .= '</div>';
        $html .= '</div>';

        $html .= '</div>';

        return $html;
    }

    /**
     * Menu flyout avec icônes et descriptions
     */
    public static function withDescriptions(string $trigger, array $items, array $attributes = []): string
    {
        $classes = self::classNames([
            'relative inline-block text-left',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $id = 'flyout-' . uniqid();

        $html = self::getScript();
        $html .= '<div class="' . $classes . '" data-flyout-menu ' . self::attributes($attributes) . '>';
        $html .= self::getTriggerButton($trigger, $id);

        // Dropdown panel
        $html .= '<div id="' . $id . '" data-flyout-content role="menu" aria-orientation="vertical" class="hidden absolute left-0 z-50 mt-3 w-80 origin-top-left">';
        $html .= '<div class="rounded-2xl bg-white shadow-xl ring-1 ring-black/5 overflow-hidden">';
        $html .= '<div class="p-4 space-y-1">';

        foreach ($items as $item) {
            $html .= '<a href="' . self::escape($item['url']) . '" role="menuitem" class="group flex items-start p-3 rounded-xl hover:bg-gray-50 transition-colors duration-150">';

            if (isset($item['icon'])) {
                $html .= '<div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-lg bg-blue-50 text-blue-600 group-hover:bg-blue-100 transition-colors">';
                $html .= '<i class="' . self::escape($item['icon']) . '" aria-hidden="true"></i>';
                $html .= '</div>';
            }

            $html .= '<div class="ml-4">';
            $html .= '<p class="text-sm font-semibold text-gray-900">' . self::escape($item['label']) . '</p>';
            if (isset($item['description'])) {
                $html .= '<p class="text-sm text-gray-500 mt-1">' . self::escape($item['description']) . '</p>';
            }
            $html .= '</div>';

            $html .= '</a>';
        }

        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';

        $html .= '</div>';

        return $html;
    }

    /**
     * Mega menu (menu large avec plusieurs colonnes)
     */
    public static function mega(string $trigger, array $sections, ?array $featured = null, array $attributes = []): string
    {
        $classes = self::classNames([
            'relative',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $id = 'mega-' . uniqid();

        $html = self::getScript();
        $html .= '<div class="' . $classes . '" data-flyout-menu ' . self::attributes($attributes) . '>';
        $html .= self::getTriggerButton($trigger, $id);

        // Mega menu panel
        $html .= '<div id="' . $id . '" data-flyout-content role="menu" class="hidden absolute left-1/2 z-50 mt-3 w-screen max-w-4xl -translate-x-1/2 transform">';
        $html .= '<div class="rounded-2xl bg-white shadow-xl ring-1 ring-black/5 overflow-hidden">';

        $html .= '<div class="grid grid-cols-1 lg:grid-cols-' . (count($sections) + ($featured ? 1 : 0)) . ' divide-x divide-gray-100">';

        // Sections
        foreach ($sections as $section) {
            $html .= '<div class="p-6">';
            $html .= '<h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">';
            $html .= self::escape($section['title']);
            $html .= '</h3>';
            $html .= '<ul class="space-y-3" role="group">';

            foreach ($section['items'] as $item) {
                $html .= '<li>';
                $html .= '<a href="' . self::escape($item['url']) . '" role="menuitem" class="group flex items-center text-sm text-gray-600 hover:text-blue-600 transition-colors">';
                if (isset($item['icon'])) {
                    $html .= '<i class="' . self::escape($item['icon']) . ' mr-3 text-gray-400 group-hover:text-blue-500" aria-hidden="true"></i>';
                }
                $html .= self::escape($item['label']);
                $html .= '</a>';
                $html .= '</li>';
            }

            $html .= '</ul>';
            $html .= '</div>';
        }

        // Featured section
        if ($featured) {
            $html .= '<div class="bg-gray-50 p-6">';
            $html .= '<h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">';
            $html .= self::escape($featured['title']);
            $html .= '</h3>';

            foreach ($featured['items'] as $item) {
                $html .= '<a href="' . self::escape($item['url']) . '" role="menuitem" class="group block p-3 -mx-3 rounded-xl hover:bg-white transition-colors mb-2">';

                if (isset($item['image'])) {
                    $alt = isset($item['label']) ? self::escape($item['label']) : '';
                    $html .= '<img src="' . self::escape($item['image']) . '" alt="' . $alt . '" class="w-full h-32 object-cover rounded-lg mb-3">';
                }

                $html .= '<p class="text-sm font-semibold text-gray-900 group-hover:text-blue-600">' . self::escape($item['label']) . '</p>';

                if (isset($item['description'])) {
                    $html .= '<p class="text-xs text-gray-500 mt-1">' . self::escape($item['description']) . '</p>';
                }

                $html .= '</a>';
            }

            $html .= '</div>';
        }

        $html .= '</div>';

        $html .= '</div>';
        $html .= '</div>';

        $html .= '</div>';

        return $html;
    }

    /**
     * Menu flyout avec grille d'icônes
     */
    public static function iconGrid(string $trigger, array $items, int $cols = 3, array $attributes = []): string
    {
        // Validation du paramètre cols
        $cols = max(2, min(4, $cols));

        $classes = self::classNames([
            'relative inline-block text-left',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $id = 'flyout-grid-' . uniqid();

        $html = self::getScript();
        $html .= '<div class="' . $classes . '" data-flyout-menu ' . self::attributes($attributes) . '>';
        $html .= self::getTriggerButton($trigger, $id);

        // Grid panel
        $width = $cols === 2 ? 'w-64' : ($cols === 3 ? 'w-80' : 'w-96');

        $html .= '<div id="' . $id . '" data-flyout-content role="menu" class="hidden absolute left-0 z-50 mt-3 ' . $width . ' origin-top-left">';
        $html .= '<div class="rounded-2xl bg-white shadow-xl ring-1 ring-black/5 p-4">';
        $html .= '<div class="grid grid-cols-' . $cols . ' gap-2">';

        foreach ($items as $item) {
            $html .= '<a href="' . self::escape($item['url']) . '" role="menuitem" class="flex flex-col items-center p-4 rounded-xl hover:bg-gray-50 transition-colors text-center">';
            $html .= '<div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center mb-2">';
            $html .= '<i class="' . self::escape($item['icon']) . ' text-blue-600" aria-hidden="true"></i>';
            $html .= '</div>';
            $html .= '<span class="text-xs font-medium text-gray-700">' . self::escape($item['label']) . '</span>';
            $html .= '</a>';
        }

        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';

        $html .= '</div>';

        return $html;
    }

    /**
     * Menu flyout avec footer
     */
    public static function withFooter(string $trigger, array $items, array $footer, array $attributes = []): string
    {
        $classes = self::classNames([
            'relative inline-block text-left',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $id = 'flyout-footer-' . uniqid();

        $html = self::getScript();
        $html .= '<div class="' . $classes . '" data-flyout-menu ' . self::attributes($attributes) . '>';
        $html .= self::getTriggerButton($trigger, $id);

        // Dropdown panel
        $html .= '<div id="' . $id . '" data-flyout-content role="menu" class="hidden absolute left-0 z-50 mt-3 w-72 origin-top-left">';
        $html .= '<div class="rounded-2xl bg-white shadow-xl ring-1 ring-black/5 overflow-hidden">';

        // Items
        $html .= '<div class="p-3 space-y-1">';
        foreach ($items as $item) {
            $html .= '<a href="' . self::escape($item['url']) . '" role="menuitem" class="group flex items-start p-3 rounded-xl hover:bg-gray-50 transition-colors">';

            if (isset($item['icon'])) {
                $html .= '<i class="' . self::escape($item['icon']) . ' mr-3 text-gray-400 group-hover:text-blue-500 mt-0.5" aria-hidden="true"></i>';
            }

            $html .= '<div>';
            $html .= '<p class="text-sm font-semibold text-gray-900">' . self::escape($item['label']) . '</p>';
            if (isset($item['description'])) {
                $html .= '<p class="text-xs text-gray-500 mt-0.5">' . self::escape($item['description']) . '</p>';
            }
            $html .= '</div>';

            $html .= '</a>';
        }
        $html .= '</div>';

        // Footer
        $html .= '<div class="bg-gray-50 px-4 py-3 border-t border-gray-100">';
        foreach ($footer as $link) {
            $html .= '<a href="' . self::escape($link['url']) . '" class="flex items-center text-sm font-medium text-blue-600 hover:text-blue-700">';
            $html .= self::escape($link['label']);
            $html .= '<svg class="ml-2 h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">';
            $html .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>';
            $html .= '</svg>';
            $html .= '</a>';
        }
        $html .= '</div>';

        $html .= '</div>';
        $html .= '</div>';

        $html .= '</div>';

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
