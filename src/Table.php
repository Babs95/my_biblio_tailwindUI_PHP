<?php

namespace TailwindUI;

/**
 * Composant Table - Tables stylisées
 *
 * Exemples d'utilisation :
 * Table::simple($headers, $rows)
 * Table::striped($headers, $rows)
 * Table::hoverable($headers, $rows)
 */
class Table extends Component
{
    /**
     * Table simple
     */
    public static function simple(array $headers, array $rows, array $attributes = []): string
    {
        return self::render($headers, $rows, false, false, $attributes);
    }

    /**
     * Table avec lignes alternées (striped)
     */
    public static function striped(array $headers, array $rows, array $attributes = []): string
    {
        return self::render($headers, $rows, true, false, $attributes);
    }

    /**
     * Table avec effet hover
     */
    public static function hoverable(array $headers, array $rows, array $attributes = []): string
    {
        return self::render($headers, $rows, false, true, $attributes);
    }

    /**
     * Table complète (striped + hover)
     */
    public static function full(array $headers, array $rows, array $attributes = []): string
    {
        return self::render($headers, $rows, true, true, $attributes);
    }

    /**
     * Rendu de la table
     */
    private static function render(array $headers, array $rows, bool $striped, bool $hoverable, array $attributes): string
    {
        $containerClasses = self::classNames([
            'bg-white rounded-lg shadow overflow-hidden',
            $attributes['containerClass'] ?? '',
        ]);

        unset($attributes['containerClass']);

        $html = '<div class="' . $containerClasses . '">';
        $html .= '<div class="overflow-x-auto">';
        $html .= '<table class="min-w-full divide-y divide-gray-200" ' . self::attributes($attributes) . '>';

        // En-tête
        $html .= '<thead class="bg-gray-50">';
        $html .= '<tr>';
        foreach ($headers as $header) {
            $html .= '<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">';
            $html .= self::escape($header);
            $html .= '</th>';
        }
        $html .= '</tr>';
        $html .= '</thead>';

        // Corps
        $html .= '<tbody class="bg-white divide-y divide-gray-200">';

        if (empty($rows)) {
            $html .= '<tr>';
            $html .= '<td colspan="' . count($headers) . '" class="px-6 py-4 text-center text-gray-500">';
            $html .= 'Aucune donnée disponible';
            $html .= '</td>';
            $html .= '</tr>';
        } else {
            foreach ($rows as $index => $row) {
                $rowClasses = [];

                if ($striped && $index % 2 === 0) {
                    $rowClasses[] = 'bg-gray-50';
                }

                if ($hoverable) {
                    $rowClasses[] = 'hover:bg-gray-100';
                }

                $rowClass = !empty($rowClasses) ? ' class="' . implode(' ', $rowClasses) . '"' : '';

                $html .= '<tr' . $rowClass . '>';

                foreach ($row as $cell) {
                    $html .= '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">';
                    $html .= $cell; // Pas d'escape ici car peut contenir du HTML (badges, etc.)
                    $html .= '</td>';
                }

                $html .= '</tr>';
            }
        }

        $html .= '</tbody>';
        $html .= '</table>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Table responsive avec scroll horizontal sur mobile
     */
    public static function responsive(array $headers, array $rows, array $attributes = []): string
    {
        $attributes['containerClass'] = ($attributes['containerClass'] ?? '') . ' overflow-x-auto';
        return self::render($headers, $rows, true, true, $attributes);
    }

    /**
     * Cellule avec badge de statut
     */
    public static function statusCell(string $status, ?string $label = null): string
    {
        return Badge::status($status, $label);
    }

    /**
     * Cellule avec badge de priorité
     */
    public static function priorityCell(string $priority, ?string $label = null): string
    {
        return Badge::priority($priority, $label);
    }

    /**
     * Cellule avec boutons d'action
     */
    public static function actionsCell(array $actions): string
    {
        $html = '<div class="flex items-center space-x-2">';

        foreach ($actions as $action) {
            $html .= $action;
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Bouton d'action pour table
     */
    public static function actionButton(string $url, string $icon, string $title, string $color = 'blue'): string
    {
        $colorMap = [
            'blue' => 'text-blue-600 hover:text-blue-900',
            'green' => 'text-green-600 hover:text-green-900',
            'red' => 'text-red-600 hover:text-red-900',
            'yellow' => 'text-yellow-600 hover:text-yellow-900',
        ];

        $colorClass = $colorMap[$color] ?? $colorMap['blue'];

        return sprintf(
            '<a href="%s" title="%s" class="%s"><i class="%s"></i></a>',
            self::escape($url),
            self::escape($title),
            $colorClass,
            self::escape($icon)
        );
    }

    /**
     * Cellule avec icône et texte
     */
    public static function iconCell(string $icon, string $text, string $color = 'gray'): string
    {
        return sprintf(
            '<div class="flex items-center"><i class="%s text-%s-500 mr-2"></i><span>%s</span></div>',
            self::escape($icon),
            self::escape($color),
            self::escape($text)
        );
    }

    /**
     * Pagination pour table
     */
    public static function pagination(int $currentPage, int $totalPages, string $baseUrl): string
    {
        if ($totalPages <= 1) {
            return '';
        }

        $html = '<div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">';
        $html .= '<div class="flex-1 flex justify-between sm:hidden">';

        // Bouton précédent (mobile)
        if ($currentPage > 1) {
            $html .= sprintf(
                '<a href="%s?page=%d" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Précédent</a>',
                self::escape($baseUrl),
                $currentPage - 1
            );
        }

        // Bouton suivant (mobile)
        if ($currentPage < $totalPages) {
            $html .= sprintf(
                '<a href="%s?page=%d" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Suivant</a>',
                self::escape($baseUrl),
                $currentPage + 1
            );
        }

        $html .= '</div>';

        // Pagination complète (desktop)
        $html .= '<div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">';
        $html .= '<div><p class="text-sm text-gray-700">Page <span class="font-medium">' . $currentPage . '</span> sur <span class="font-medium">' . $totalPages . '</span></p></div>';
        $html .= '<div><nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">';

        // Pages
        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i === $currentPage) {
                $html .= sprintf(
                    '<span class="z-10 bg-blue-50 border-blue-500 text-blue-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">%d</span>',
                    $i
                );
            } else {
                $html .= sprintf(
                    '<a href="%s?page=%d" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">%d</a>',
                    self::escape($baseUrl),
                    $i,
                    $i
                );
            }
        }

        $html .= '</nav></div>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }
}
