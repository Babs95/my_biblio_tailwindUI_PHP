<?php

namespace TailwindUI;

/**
 * Composant Skeleton - Placeholders de chargement animés
 *
 * Exemples d'utilisation :
 * Skeleton::text(3)
 * Skeleton::card()
 * Skeleton::avatar('lg')
 */
class Skeleton extends Component
{
    /**
     * Classes de base pour l'animation
     */
    private const ANIMATION_CLASS = 'animate-pulse bg-gradient-to-r from-gray-200 via-gray-100 to-gray-200 bg-size-200 rounded';

    /**
     * Ligne de texte skeleton
     */
    public static function text(int $lines = 1, ?string $width = null, array $attributes = []): string
    {
        $widths = $width ? [$width] : ['100%', '90%', '95%', '85%', '100%'];

        $html = '<div class="space-y-3" ' . self::attributes($attributes) . '>';
        for ($i = 0; $i < $lines; $i++) {
            $lineWidth = $widths[$i % count($widths)];
            $html .= '<div class="' . self::ANIMATION_CLASS . ' h-4" style="width: ' . $lineWidth . '"></div>';
        }
        $html .= '</div>';

        return $html;
    }

    /**
     * Titre skeleton
     */
    public static function title(array $attributes = []): string
    {
        $html = '<div class="space-y-3" ' . self::attributes($attributes) . '>';
        $html .= '<div class="' . self::ANIMATION_CLASS . ' h-8 w-2/3"></div>';
        $html .= '<div class="' . self::ANIMATION_CLASS . ' h-4 w-1/2"></div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Avatar skeleton
     */
    public static function avatar(string $size = 'md', string $shape = 'circle', array $attributes = []): string
    {
        $sizes = [
            'sm' => 'w-8 h-8',
            'md' => 'w-12 h-12',
            'lg' => 'w-16 h-16',
            'xl' => 'w-24 h-24',
        ];

        $sizeClass = $sizes[$size] ?? $sizes['md'];
        $shapeClass = $shape === 'circle' ? 'rounded-full' : 'rounded-lg';

        return '<div class="' . self::ANIMATION_CLASS . ' ' . $sizeClass . ' ' . $shapeClass . '" ' . self::attributes($attributes) . '></div>';
    }

    /**
     * Bouton skeleton
     */
    public static function button(string $size = 'md', array $attributes = []): string
    {
        $sizes = [
            'sm' => 'h-8 w-20',
            'md' => 'h-10 w-24',
            'lg' => 'h-12 w-32',
        ];

        $sizeClass = $sizes[$size] ?? $sizes['md'];

        return '<div class="' . self::ANIMATION_CLASS . ' ' . $sizeClass . ' rounded-2xl" ' . self::attributes($attributes) . '></div>';
    }

    /**
     * Image skeleton
     */
    public static function image(string $aspectRatio = '16/9', array $attributes = []): string
    {
        $ratios = [
            '16/9' => 'aspect-video',
            '4/3' => 'aspect-4/3',
            '1/1' => 'aspect-square',
            '3/2' => 'aspect-3/2',
        ];

        $ratioClass = $ratios[$aspectRatio] ?? $ratios['16/9'];

        return '<div class="' . self::ANIMATION_CLASS . ' w-full ' . $ratioClass . ' rounded-2xl" ' . self::attributes($attributes) . '></div>';
    }

    /**
     * Card skeleton complète
     */
    public static function card(bool $withImage = true, int $textLines = 3, array $attributes = []): string
    {
        $html = '<div class="bg-white rounded-3xl shadow-sm border border-gray-100/50 overflow-hidden" ' . self::attributes($attributes) . '>';

        if ($withImage) {
            $html .= '<div class="' . self::ANIMATION_CLASS . ' w-full h-48"></div>';
        }

        $html .= '<div class="p-6 space-y-4">';

        // Title
        $html .= '<div class="' . self::ANIMATION_CLASS . ' h-6 w-3/4"></div>';

        // Text lines
        $html .= '<div class="space-y-3">';
        for ($i = 0; $i < $textLines; $i++) {
            $width = $i === $textLines - 1 ? 'w-1/2' : 'w-full';
            $html .= '<div class="' . self::ANIMATION_CLASS . ' h-4 ' . $width . '"></div>';
        }
        $html .= '</div>';

        // Footer with avatar and button
        $html .= '<div class="flex items-center justify-between pt-4">';
        $html .= '<div class="flex items-center space-x-3">';
        $html .= '<div class="' . self::ANIMATION_CLASS . ' w-10 h-10 rounded-full"></div>';
        $html .= '<div class="' . self::ANIMATION_CLASS . ' h-4 w-24"></div>';
        $html .= '</div>';
        $html .= '<div class="' . self::ANIMATION_CLASS . ' h-10 w-20 rounded-2xl"></div>';
        $html .= '</div>';

        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Liste skeleton
     */
    public static function list(int $items = 3, bool $withAvatar = true, array $attributes = []): string
    {
        $html = '<div class="space-y-4" ' . self::attributes($attributes) . '>';

        for ($i = 0; $i < $items; $i++) {
            $html .= '<div class="flex items-center space-x-4">';

            if ($withAvatar) {
                $html .= '<div class="' . self::ANIMATION_CLASS . ' w-12 h-12 rounded-full flex-shrink-0"></div>';
            }

            $html .= '<div class="flex-1 space-y-2">';
            $html .= '<div class="' . self::ANIMATION_CLASS . ' h-4 w-3/4"></div>';
            $html .= '<div class="' . self::ANIMATION_CLASS . ' h-3 w-1/2"></div>';
            $html .= '</div>';

            $html .= '</div>';
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Table skeleton
     */
    public static function table(int $rows = 5, int $cols = 4, array $attributes = []): string
    {
        $html = '<div class="overflow-hidden rounded-3xl border border-gray-100" ' . self::attributes($attributes) . '>';
        $html .= '<table class="min-w-full divide-y divide-gray-200">';

        // Header
        $html .= '<thead class="bg-gray-50">';
        $html .= '<tr>';
        for ($i = 0; $i < $cols; $i++) {
            $html .= '<th class="px-6 py-4">';
            $html .= '<div class="' . self::ANIMATION_CLASS . ' h-4 w-24"></div>';
            $html .= '</th>';
        }
        $html .= '</tr>';
        $html .= '</thead>';

        // Body
        $html .= '<tbody class="bg-white divide-y divide-gray-200">';
        for ($i = 0; $i < $rows; $i++) {
            $html .= '<tr>';
            for ($j = 0; $j < $cols; $j++) {
                $html .= '<td class="px-6 py-4">';
                $html .= '<div class="' . self::ANIMATION_CLASS . ' h-4 w-full"></div>';
                $html .= '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody>';

        $html .= '</table>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Profile skeleton
     */
    public static function profile(array $attributes = []): string
    {
        $html = '<div class="bg-white rounded-3xl shadow-sm border border-gray-100/50 p-8" ' . self::attributes($attributes) . '>';

        // Cover image
        $html .= '<div class="' . self::ANIMATION_CLASS . ' w-full h-32 rounded-2xl mb-6"></div>';

        // Avatar
        $html .= '<div class="flex items-start space-x-6 -mt-16 relative z-10">';
        $html .= '<div class="' . self::ANIMATION_CLASS . ' w-24 h-24 rounded-full ring-4 ring-white"></div>';

        $html .= '<div class="flex-1 pt-16 space-y-4">';
        // Name and title
        $html .= '<div class="' . self::ANIMATION_CLASS . ' h-6 w-48"></div>';
        $html .= '<div class="' . self::ANIMATION_CLASS . ' h-4 w-32"></div>';

        // Bio
        $html .= '<div class="space-y-2 pt-4">';
        $html .= '<div class="' . self::ANIMATION_CLASS . ' h-4 w-full"></div>';
        $html .= '<div class="' . self::ANIMATION_CLASS . ' h-4 w-5/6"></div>';
        $html .= '<div class="' . self::ANIMATION_CLASS . ' h-4 w-4/6"></div>';
        $html .= '</div>';

        // Stats
        $html .= '<div class="flex space-x-6 pt-4">';
        for ($i = 0; $i < 3; $i++) {
            $html .= '<div class="space-y-1">';
            $html .= '<div class="' . self::ANIMATION_CLASS . ' h-6 w-16"></div>';
            $html .= '<div class="' . self::ANIMATION_CLASS . ' h-3 w-16"></div>';
            $html .= '</div>';
        }
        $html .= '</div>';

        $html .= '</div>';
        $html .= '</div>';

        $html .= '</div>';

        return $html;
    }

    /**
     * Grid de cards skeleton
     */
    public static function grid(int $items = 6, int $columns = 3, bool $withImage = true, array $attributes = []): string
    {
        $gridCols = [
            1 => 'grid-cols-1',
            2 => 'grid-cols-1 md:grid-cols-2',
            3 => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
            4 => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-4',
        ];

        $gridClass = $gridCols[$columns] ?? $gridCols[3];

        $html = '<div class="grid ' . $gridClass . ' gap-6" ' . self::attributes($attributes) . '>';

        for ($i = 0; $i < $items; $i++) {
            $html .= self::card($withImage, 2);
        }

        $html .= '</div>';

        return $html;
    }
}
