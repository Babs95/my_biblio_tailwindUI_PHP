<?php

namespace TailwindUI;

/**
 * Composant Navigation - Éléments de navigation
 *
 * Exemples d'utilisation :
 * Navigation::navbar($brand, $links, $userMenu)
 * Navigation::breadcrumb($items)
 * Navigation::tabs($tabs, $active)
 */
class Navigation extends Component
{
    /**
     * Navbar complète
     */
    public static function navbar(string $brand, array $links = [], ?array $userMenu = null, array $attributes = []): string
    {
        $classes = self::classNames([
            'bg-white/80 backdrop-blur-md shadow-sm border-b border-gray-100',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<nav class="' . $classes . '" ' . self::attributes($attributes) . '>';
        $html .= '<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">';
        $html .= '<div class="flex justify-between h-16">';

        // Logo/Brand
        $html .= '<div class="flex">';
        $html .= '<div class="flex-shrink-0 flex items-center">';
        $html .= $brand;
        $html .= '</div>';

        // Navigation Links
        if (!empty($links)) {
            $html .= '<div class="hidden sm:ml-10 sm:flex sm:space-x-8">';
            foreach ($links as $link) {
                $html .= $link;
            }
            $html .= '</div>';
        }

        $html .= '</div>';

        // User Menu
        if ($userMenu) {
            $html .= '<div class="flex items-center">';
            $html .= '<div class="ml-3 relative">';
            $html .= '<div class="flex items-center space-x-4">';

            if (isset($userMenu['name'])) {
                $html .= '<span class="text-sm text-gray-700">' . self::escape($userMenu['name']) . '</span>';
            }

            if (isset($userMenu['actions'])) {
                foreach ($userMenu['actions'] as $action) {
                    $html .= $action;
                }
            }

            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
        }

        $html .= '</div>';
        $html .= '</div>';
        $html .= '</nav>';

        return $html;
    }

    /**
     * Lien de navigation
     */
    public static function link(string $text, string $url, bool $active = false, ?string $icon = null, array $attributes = []): string
    {
        $classes = self::classNames([
            'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold transition-all duration-200',
            $active
                ? 'border-blue-600 text-gray-900'
                : 'border-transparent text-gray-500 hover:border-blue-300 hover:text-gray-900',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $content = '';
        if ($icon) {
            $content .= '<i class="' . self::escape($icon) . ' mr-2"></i>';
        }
        $content .= self::escape($text);

        $attrs = array_merge(['href' => $url, 'class' => $classes], $attributes);

        return sprintf('<a %s>%s</a>', self::attributes($attrs), $content);
    }

    /**
     * Breadcrumb (fil d'Ariane)
     */
    public static function breadcrumb(array $items, array $attributes = []): string
    {
        $classes = self::classNames([
            'flex items-center space-x-2 text-sm text-gray-500',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<nav class="' . $classes . '" ' . self::attributes($attributes) . '>';
        $html .= '<ol class="flex items-center space-x-2">';

        $count = count($items);
        foreach ($items as $index => $item) {
            $isLast = ($index === $count - 1);

            $html .= '<li class="flex items-center">';

            if ($isLast) {
                $html .= '<span class="text-gray-900 font-semibold">' . self::escape($item['label']) . '</span>';
            } else {
                $html .= '<a href="' . self::escape($item['url']) . '" class="hover:text-blue-600 transition-colors">';
                $html .= self::escape($item['label']);
                $html .= '</a>';
                $html .= '<i class="fas fa-chevron-right mx-3 text-gray-300 text-xs"></i>';
            }

            $html .= '</li>';
        }

        $html .= '</ol>';
        $html .= '</nav>';

        return $html;
    }

    /**
     * Tabs (onglets)
     */
    public static function tabs(array $tabs, string $active, array $attributes = []): string
    {
        $classes = self::classNames([
            'border-b border-gray-100',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<div class="' . $classes . '" ' . self::attributes($attributes) . '>';
        $html .= '<nav class="-mb-px flex space-x-8">';

        foreach ($tabs as $key => $tab) {
            $isActive = $key === $active;

            $linkClasses = self::classNames([
                'whitespace-nowrap py-4 px-1 border-b-2 font-semibold text-sm transition-all duration-200',
                $isActive
                    ? 'border-blue-600 text-blue-600'
                    : 'border-transparent text-gray-500 hover:text-gray-900 hover:border-gray-300',
            ]);

            $content = '';
            if (isset($tab['icon'])) {
                $content .= '<i class="' . self::escape($tab['icon']) . ' mr-2"></i>';
            }
            $content .= self::escape($tab['label']);

            if (isset($tab['count'])) {
                $badgeClass = $isActive ? 'bg-blue-50 text-blue-600 ring-1 ring-inset ring-blue-600/20' : 'bg-gray-50 text-gray-600 ring-1 ring-inset ring-gray-500/20';
                $content .= ' <span class="ml-2 py-0.5 px-2.5 rounded-lg text-xs font-semibold ' . $badgeClass . '">';
                $content .= $tab['count'];
                $content .= '</span>';
            }

            $html .= '<a href="' . self::escape($tab['url']) . '" class="' . $linkClasses . '">';
            $html .= $content;
            $html .= '</a>';
        }

        $html .= '</nav>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Sidebar menu
     */
    public static function sidebar(array $items, string $active = '', array $attributes = []): string
    {
        $classes = self::classNames([
            'space-y-1',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<nav class="' . $classes . '" ' . self::attributes($attributes) . '>';

        foreach ($items as $key => $item) {
            $isActive = $key === $active;

            $linkClasses = self::classNames([
                'group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200',
                $isActive
                    ? 'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-600/20'
                    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900',
            ]);

            $html .= '<a href="' . self::escape($item['url']) . '" class="' . $linkClasses . '">';

            if (isset($item['icon'])) {
                $iconClass = $isActive ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600';
                $html .= '<i class="' . self::escape($item['icon']) . ' mr-3 ' . $iconClass . ' transition-colors"></i>';
            }

            $html .= self::escape($item['label']);

            if (isset($item['badge'])) {
                $html .= '<span class="ml-auto inline-block py-0.5 px-2.5 text-xs font-semibold rounded-lg bg-gray-100 text-gray-600">';
                $html .= self::escape($item['badge']);
                $html .= '</span>';
            }

            $html .= '</a>';
        }

        $html .= '</nav>';

        return $html;
    }

    /**
     * Dropdown menu
     */
    public static function dropdown(string $trigger, array $items, array $attributes = []): string
    {
        $classes = self::classNames([
            'relative inline-block text-left',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $id = 'dropdown-' . uniqid();

        $html = '<div class="' . $classes . '" data-dropdown ' . self::attributes($attributes) . '>';

        // Script d'initialisation (une seule fois)
        $html .= '<script>
if (!window.dropdownInitialized) {
    window.dropdownInitialized = true;
    document.addEventListener("click", function(e) {
        var btn = e.target.closest("[data-dropdown-trigger]");
        if (btn) {
            e.stopPropagation();
            var menu = btn.nextElementSibling;
            var isHidden = menu.classList.contains("hidden");
            document.querySelectorAll("[data-dropdown] [data-dropdown-trigger] + div").forEach(function(m) {
                m.classList.add("hidden");
            });
            document.querySelectorAll("[data-dropdown-trigger]").forEach(function(b) {
                b.setAttribute("aria-expanded", "false");
            });
            if (isHidden) {
                menu.classList.remove("hidden");
                btn.setAttribute("aria-expanded", "true");
            }
        } else if (!e.target.closest("[data-dropdown]")) {
            document.querySelectorAll("[data-dropdown] [data-dropdown-trigger] + div").forEach(function(m) {
                m.classList.add("hidden");
            });
            document.querySelectorAll("[data-dropdown-trigger]").forEach(function(b) {
                b.setAttribute("aria-expanded", "false");
            });
        }
    });
}
</script>';

        // Trigger
        $html .= '<div>';
        $html .= '<button type="button" data-dropdown-trigger class="inline-flex justify-center w-full rounded-2xl border border-gray-200 shadow-sm px-4 py-2.5 bg-white text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-4 focus:ring-blue-500/10 transition-all duration-300" aria-expanded="false" aria-haspopup="true" aria-controls="' . $id . '">';
        $html .= self::escape($trigger);
        $html .= ' <svg class="ml-2 -mr-1 h-4 w-4 text-gray-400 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>';
        $html .= '</button>';

        // Menu items
        $html .= '<div id="' . $id . '" class="hidden origin-top-right absolute right-0 mt-3 w-56 rounded-2xl shadow-xl shadow-gray-200/50 bg-white ring-1 ring-black/5 z-10" role="menu" aria-orientation="vertical">';
        $html .= '<div class="py-2">';

        foreach ($items as $item) {
            if ($item === 'divider') {
                $html .= '<div class="border-t border-gray-100 my-1" role="separator"></div>';
            } else {
                $html .= '<a href="' . self::escape($item['url']) . '" role="menuitem" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition-all duration-200">';

                if (isset($item['icon'])) {
                    $html .= '<i class="' . self::escape($item['icon']) . ' mr-2 text-gray-400" aria-hidden="true"></i>';
                }

                $html .= self::escape($item['label']);
                $html .= '</a>';
            }
        }

        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Pagination
     */
    public static function pagination(int $currentPage, int $totalPages, string $baseUrl, array $attributes = []): string
    {
        return Table::pagination($currentPage, $totalPages, $baseUrl);
    }
}
