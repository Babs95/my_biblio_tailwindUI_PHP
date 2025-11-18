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

        $html = '<div class="' . $classes . '" ' . self::attributes($attributes) . '>';

        // Trigger button
        $html .= '<button type="button" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 hover:text-gray-900 transition-colors duration-200" onclick="document.getElementById(\'' . $id . '\').classList.toggle(\'hidden\')" onblur="setTimeout(() => document.getElementById(\'' . $id . '\').classList.add(\'hidden\'), 200)">';
        $html .= self::escape($trigger);
        $html .= '<i class="fas fa-chevron-down ml-2 text-xs text-gray-400"></i>';
        $html .= '</button>';

        // Dropdown panel
        $html .= '<div id="' . $id . '" class="hidden absolute left-0 z-50 mt-2 w-56 origin-top-left rounded-xl bg-white shadow-lg ring-1 ring-black/5 focus:outline-none">';
        $html .= '<div class="py-2">';

        foreach ($items as $item) {
            if ($item === 'divider') {
                $html .= '<div class="border-t border-gray-100 my-2"></div>';
            } else {
                $html .= '<a href="' . self::escape($item['url']) . '" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors duration-150">';
                if (isset($item['icon'])) {
                    $html .= '<i class="' . self::escape($item['icon']) . ' mr-3 text-gray-400"></i>';
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

        $html = '<div class="' . $classes . '" ' . self::attributes($attributes) . '>';

        // Trigger button
        $html .= '<button type="button" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 hover:text-gray-900 transition-colors duration-200" onclick="document.getElementById(\'' . $id . '\').classList.toggle(\'hidden\')">';
        $html .= self::escape($trigger);
        $html .= '<i class="fas fa-chevron-down ml-2 text-xs text-gray-400"></i>';
        $html .= '</button>';

        // Dropdown panel
        $html .= '<div id="' . $id . '" class="hidden absolute left-0 z-50 mt-3 w-80 origin-top-left">';
        $html .= '<div class="rounded-2xl bg-white shadow-xl ring-1 ring-black/5 overflow-hidden">';
        $html .= '<div class="p-4 space-y-1">';

        foreach ($items as $item) {
            $html .= '<a href="' . self::escape($item['url']) . '" class="group flex items-start p-3 rounded-xl hover:bg-gray-50 transition-colors duration-150">';

            if (isset($item['icon'])) {
                $html .= '<div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-lg bg-blue-50 text-blue-600 group-hover:bg-blue-100 transition-colors">';
                $html .= '<i class="' . self::escape($item['icon']) . '"></i>';
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

        $html = '<div class="' . $classes . '" ' . self::attributes($attributes) . '>';

        // Trigger button
        $html .= '<button type="button" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 hover:text-gray-900 transition-colors duration-200" onclick="document.getElementById(\'' . $id . '\').classList.toggle(\'hidden\')">';
        $html .= self::escape($trigger);
        $html .= '<i class="fas fa-chevron-down ml-2 text-xs text-gray-400"></i>';
        $html .= '</button>';

        // Mega menu panel
        $html .= '<div id="' . $id . '" class="hidden absolute left-1/2 z-50 mt-3 w-screen max-w-4xl -translate-x-1/2 transform">';
        $html .= '<div class="rounded-2xl bg-white shadow-xl ring-1 ring-black/5 overflow-hidden">';

        $html .= '<div class="grid grid-cols-1 lg:grid-cols-' . (count($sections) + ($featured ? 1 : 0)) . ' divide-x divide-gray-100">';

        // Sections
        foreach ($sections as $section) {
            $html .= '<div class="p-6">';
            $html .= '<h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">';
            $html .= self::escape($section['title']);
            $html .= '</h3>';
            $html .= '<ul class="space-y-3">';

            foreach ($section['items'] as $item) {
                $html .= '<li>';
                $html .= '<a href="' . self::escape($item['url']) . '" class="group flex items-center text-sm text-gray-600 hover:text-blue-600 transition-colors">';
                if (isset($item['icon'])) {
                    $html .= '<i class="' . self::escape($item['icon']) . ' mr-3 text-gray-400 group-hover:text-blue-500"></i>';
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
                $html .= '<a href="' . self::escape($item['url']) . '" class="group block p-3 -mx-3 rounded-xl hover:bg-white transition-colors mb-2">';

                if (isset($item['image'])) {
                    $html .= '<img src="' . self::escape($item['image']) . '" alt="" class="w-full h-32 object-cover rounded-lg mb-3">';
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
        $classes = self::classNames([
            'relative inline-block text-left',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $id = 'flyout-grid-' . uniqid();

        $html = '<div class="' . $classes . '" ' . self::attributes($attributes) . '>';

        // Trigger button
        $html .= '<button type="button" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 hover:text-gray-900 transition-colors duration-200" onclick="document.getElementById(\'' . $id . '\').classList.toggle(\'hidden\')">';
        $html .= self::escape($trigger);
        $html .= '<i class="fas fa-chevron-down ml-2 text-xs text-gray-400"></i>';
        $html .= '</button>';

        // Grid panel
        $width = $cols === 2 ? 'w-64' : ($cols === 3 ? 'w-80' : 'w-96');

        $html .= '<div id="' . $id . '" class="hidden absolute left-0 z-50 mt-3 ' . $width . ' origin-top-left">';
        $html .= '<div class="rounded-2xl bg-white shadow-xl ring-1 ring-black/5 p-4">';
        $html .= '<div class="grid grid-cols-' . $cols . ' gap-2">';

        foreach ($items as $item) {
            $html .= '<a href="' . self::escape($item['url']) . '" class="flex flex-col items-center p-4 rounded-xl hover:bg-gray-50 transition-colors text-center">';
            $html .= '<div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center mb-2">';
            $html .= '<i class="' . self::escape($item['icon']) . ' text-blue-600"></i>';
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

        $html = '<div class="' . $classes . '" ' . self::attributes($attributes) . '>';

        // Trigger button
        $html .= '<button type="button" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 hover:text-gray-900 transition-colors duration-200" onclick="document.getElementById(\'' . $id . '\').classList.toggle(\'hidden\')">';
        $html .= self::escape($trigger);
        $html .= '<i class="fas fa-chevron-down ml-2 text-xs text-gray-400"></i>';
        $html .= '</button>';

        // Dropdown panel
        $html .= '<div id="' . $id . '" class="hidden absolute left-0 z-50 mt-3 w-72 origin-top-left">';
        $html .= '<div class="rounded-2xl bg-white shadow-xl ring-1 ring-black/5 overflow-hidden">';

        // Items
        $html .= '<div class="p-3 space-y-1">';
        foreach ($items as $item) {
            $html .= '<a href="' . self::escape($item['url']) . '" class="group flex items-start p-3 rounded-xl hover:bg-gray-50 transition-colors">';

            if (isset($item['icon'])) {
                $html .= '<i class="' . self::escape($item['icon']) . ' mr-3 text-gray-400 group-hover:text-blue-500 mt-0.5"></i>';
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
            $html .= '<i class="fas fa-arrow-right ml-2 text-xs"></i>';
            $html .= '</a>';
        }
        $html .= '</div>';

        $html .= '</div>';
        $html .= '</div>';

        $html .= '</div>';

        return $html;
    }
}
