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
            'bg-white shadow-lg',
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
            'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium',
            $active
                ? 'border-blue-500 text-gray-900'
                : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700',
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
                $html .= '<span class="text-gray-700 font-medium">' . self::escape($item['label']) . '</span>';
            } else {
                $html .= '<a href="' . self::escape($item['url']) . '" class="hover:text-gray-700">';
                $html .= self::escape($item['label']);
                $html .= '</a>';
                $html .= '<i class="fas fa-chevron-right mx-2 text-gray-400 text-xs"></i>';
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
            'border-b border-gray-200',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<div class="' . $classes . '" ' . self::attributes($attributes) . '>';
        $html .= '<nav class="-mb-px flex space-x-8">';

        foreach ($tabs as $key => $tab) {
            $isActive = $key === $active;

            $linkClasses = self::classNames([
                'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm',
                $isActive
                    ? 'border-blue-500 text-blue-600'
                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
            ]);

            $content = '';
            if (isset($tab['icon'])) {
                $content .= '<i class="' . self::escape($tab['icon']) . ' mr-2"></i>';
            }
            $content .= self::escape($tab['label']);

            if (isset($tab['count'])) {
                $badgeClass = $isActive ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600';
                $content .= ' <span class="ml-2 py-0.5 px-2 rounded-full text-xs font-medium ' . $badgeClass . '">';
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
                'group flex items-center px-3 py-2 text-sm font-medium rounded-md',
                $isActive
                    ? 'bg-blue-100 text-blue-700'
                    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900',
            ]);

            $html .= '<a href="' . self::escape($item['url']) . '" class="' . $linkClasses . '">';

            if (isset($item['icon'])) {
                $iconClass = $isActive ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500';
                $html .= '<i class="' . self::escape($item['icon']) . ' mr-3 ' . $iconClass . '"></i>';
            }

            $html .= self::escape($item['label']);

            if (isset($item['badge'])) {
                $html .= '<span class="ml-auto inline-block py-0.5 px-3 text-xs rounded-full bg-gray-100 text-gray-600">';
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

        $html = '<div class="' . $classes . '" ' . self::attributes($attributes) . '>';

        // Trigger
        $html .= '<div>';
        $html .= '<button type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none" onclick="this.nextElementSibling.classList.toggle(\'hidden\')">';
        $html .= $trigger;
        $html .= ' <i class="fas fa-chevron-down ml-2 -mr-1"></i>';
        $html .= '</button>';

        // Menu items
        $html .= '<div class="hidden origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">';
        $html .= '<div class="py-1">';

        foreach ($items as $item) {
            if ($item === 'divider') {
                $html .= '<div class="border-t border-gray-100"></div>';
            } else {
                $html .= '<a href="' . self::escape($item['url']) . '" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">';

                if (isset($item['icon'])) {
                    $html .= '<i class="' . self::escape($item['icon']) . ' mr-2"></i>';
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
