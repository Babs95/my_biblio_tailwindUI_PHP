<?php

namespace TailwindUI;

/**
 * Composant Progress - Barres de progression et indicateurs de chargement
 *
 * Exemples d'utilisation :
 * Progress::bar(75, 'blue')
 * Progress::circle(60, 'green')
 * Progress::steps(['Done', 'In Progress', 'Pending'], 1)
 */
class Progress extends Component
{
    /**
     * Barre de progression simple
     */
    public static function bar(float $percentage, string $color = 'blue', ?string $label = null, array $attributes = [], string $size = 'md'): string
    {
        $percentage = min(100, max(0, $percentage));

        $sizes = [
            'sm' => 'h-1.5',
            'md' => 'h-2.5',
            'lg' => 'h-4',
        ];

        $sizeClass = $sizes[$size] ?? $sizes['md'];

        $colors = [
            'blue' => 'bg-gradient-to-r from-blue-500 via-blue-600 to-indigo-600',
            'green' => 'bg-gradient-to-r from-emerald-400 via-emerald-500 to-teal-600',
            'red' => 'bg-gradient-to-r from-red-500 via-red-600 to-rose-600',
            'orange' => 'bg-gradient-to-r from-amber-400 via-orange-500 to-red-500',
            'purple' => 'bg-gradient-to-r from-purple-500 via-purple-600 to-indigo-700',
            'pink' => 'bg-gradient-to-r from-pink-500 via-rose-500 to-red-500',
        ];

        $colorClass = $colors[$color] ?? $colors['blue'];

        $classes = self::classNames([
            'relative w-full bg-gray-100 rounded-full overflow-hidden ' . $sizeClass,
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<div class="' . $classes . '" ' . self::attributes($attributes) . ' role="progressbar" aria-valuenow="' . $percentage . '" aria-valuemin="0" aria-valuemax="100">';
        $html .= '<div class="' . $colorClass . ' ' . $sizeClass . ' rounded-full transition-all duration-500 ease-out" style="width: ' . $percentage . '%"></div>';
        $html .= '</div>';

        if ($label) {
            $html = '<div class="space-y-2">';
            $html .= '<div class="flex justify-between items-center">';
            $html .= '<span class="text-sm font-medium text-gray-700">' . self::escape($label) . '</span>';
            $html .= '<span class="text-sm font-semibold text-gray-900">' . round($percentage) . '%</span>';
            $html .= '</div>';
            $html .= '<div class="relative w-full bg-gray-100 rounded-full overflow-hidden ' . $sizeClass . '" role="progressbar" aria-valuenow="' . $percentage . '" aria-valuemin="0" aria-valuemax="100">';
            $html .= '<div class="' . $colorClass . ' ' . $sizeClass . ' rounded-full transition-all duration-500 ease-out" style="width: ' . $percentage . '%"></div>';
            $html .= '</div>';
            $html .= '</div>';
        }

        return $html;
    }

    /**
     * Barre de progression animée
     */
    public static function animated(string $color = 'blue', array $attributes = [], string $size = 'md'): string
    {
        $sizes = [
            'sm' => 'h-1.5',
            'md' => 'h-2.5',
            'lg' => 'h-4',
        ];

        $sizeClass = $sizes[$size] ?? $sizes['md'];

        $colors = [
            'blue' => 'bg-gradient-to-r from-blue-500 via-blue-600 to-indigo-600',
            'green' => 'bg-gradient-to-r from-emerald-400 via-emerald-500 to-teal-600',
            'purple' => 'bg-gradient-to-r from-purple-500 via-purple-600 to-indigo-700',
        ];

        $colorClass = $colors[$color] ?? $colors['blue'];

        $html = '<div class="relative w-full bg-gray-100 rounded-full overflow-hidden ' . $sizeClass . '" role="progressbar" aria-busy="true">';
        $html .= '<div class="' . $colorClass . ' ' . $sizeClass . ' rounded-full animate-pulse" style="width: 100%; animation: progress 2s ease-in-out infinite;"></div>';
        $html .= '</div>';

        $html .= '<style>
@keyframes progress {
    0%, 100% { transform: translateX(-100%); }
    50% { transform: translateX(100%); }
}
</style>';

        return $html;
    }

    /**
     * Barre de progression circulaire
     */
    public static function circle(float $percentage, string $color = 'blue', ?string $label = null, array $attributes = [], int $size = 120): string
    {
        $percentage = min(100, max(0, $percentage));
        $strokeWidth = 8;
        $radius = ($size / 2) - ($strokeWidth / 2);
        $circumference = 2 * M_PI * $radius;
        $offset = $circumference - ($percentage / 100) * $circumference;

        $colors = [
            'blue' => ['stroke' => '#3B82F6', 'text' => 'text-blue-600'],
            'green' => ['stroke' => '#10B981', 'text' => 'text-emerald-600'],
            'red' => ['stroke' => '#EF4444', 'text' => 'text-red-600'],
            'orange' => ['stroke' => '#F97316', 'text' => 'text-orange-600'],
            'purple' => ['stroke' => '#A855F7', 'text' => 'text-purple-600'],
        ];

        $colorData = $colors[$color] ?? $colors['blue'];

        $classes = self::classNames([
            'relative inline-flex items-center justify-center',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $html = '<div class="' . $classes . '" style="width: ' . $size . 'px; height: ' . $size . 'px;" ' . self::attributes($attributes) . '>';
        $html .= '<svg class="transform -rotate-90" width="' . $size . '" height="' . $size . '">';
        $html .= '<circle cx="' . ($size / 2) . '" cy="' . ($size / 2) . '" r="' . $radius . '" stroke="#E5E7EB" stroke-width="' . $strokeWidth . '" fill="none" />';
        $html .= '<circle cx="' . ($size / 2) . '" cy="' . ($size / 2) . '" r="' . $radius . '" stroke="' . $colorData['stroke'] . '" stroke-width="' . $strokeWidth . '" fill="none" stroke-linecap="round" stroke-dasharray="' . $circumference . '" stroke-dashoffset="' . $offset . '" class="transition-all duration-500 ease-out" />';
        $html .= '</svg>';

        $html .= '<div class="absolute flex flex-col items-center justify-center">';
        $html .= '<span class="text-2xl font-bold ' . $colorData['text'] . '">' . round($percentage) . '%</span>';
        if ($label) {
            $html .= '<span class="text-xs text-gray-500 mt-1">' . self::escape($label) . '</span>';
        }
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Spinner de chargement
     */
    public static function spinner(string $color = 'blue', array $attributes = [], string $size = 'md'): string
    {
        $sizes = [
            'sm' => 'w-4 h-4',
            'md' => 'w-8 h-8',
            'lg' => 'w-12 h-12',
            'xl' => 'w-16 h-16',
        ];

        $sizeClass = $sizes[$size] ?? $sizes['md'];

        $colors = [
            'blue' => 'text-blue-600',
            'green' => 'text-emerald-600',
            'red' => 'text-red-600',
            'purple' => 'text-purple-600',
            'white' => 'text-white',
        ];

        $colorClass = $colors[$color] ?? $colors['blue'];

        $classes = self::classNames([
            'animate-spin ' . $sizeClass . ' ' . $colorClass,
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        return '<svg class="' . $classes . '" ' . self::attributes($attributes) . ' xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" role="status" aria-label="Chargement en cours"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
    }

    /**
     * Dots de chargement
     */
    public static function dots(string $color = 'blue', array $attributes = []): string
    {
        $colors = [
            'blue' => 'bg-blue-600',
            'green' => 'bg-emerald-600',
            'red' => 'bg-red-600',
            'purple' => 'bg-purple-600',
        ];

        $colorClass = $colors[$color] ?? $colors['blue'];

        $html = '<div class="flex space-x-2" ' . self::attributes($attributes) . ' role="status" aria-label="Chargement en cours">';
        $html .= '<div class="w-3 h-3 ' . $colorClass . ' rounded-full animate-bounce" style="animation-delay: 0s"></div>';
        $html .= '<div class="w-3 h-3 ' . $colorClass . ' rounded-full animate-bounce" style="animation-delay: 0.2s"></div>';
        $html .= '<div class="w-3 h-3 ' . $colorClass . ' rounded-full animate-bounce" style="animation-delay: 0.4s"></div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Progress par étapes
     */
    public static function steps(array $steps, int $currentStep, array $attributes = []): string
    {
        $totalSteps = count($steps);

        $html = '<div class="w-full" ' . self::attributes($attributes) . '>';
        $html .= '<div class="flex items-center">';

        foreach ($steps as $index => $step) {
            $stepNumber = $index + 1;
            $isCompleted = $stepNumber < $currentStep;
            $isCurrent = $stepNumber === $currentStep;

            // Step circle
            if ($isCompleted) {
                $html .= '<div class="flex flex-col items-center flex-1">';
                $html .= '<div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg shadow-emerald-500/30 transition-all duration-300">';
                $html .= '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
                $html .= '</div>';
                $html .= '<span class="text-xs mt-2 font-medium text-emerald-600">' . self::escape($step) . '</span>';
                $html .= '</div>';
            } elseif ($isCurrent) {
                $html .= '<div class="flex flex-col items-center flex-1">';
                $html .= '<div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg shadow-blue-500/40 ring-4 ring-blue-100 transition-all duration-300">';
                $html .= $stepNumber;
                $html .= '</div>';
                $html .= '<span class="text-xs mt-2 font-semibold text-blue-600">' . self::escape($step) . '</span>';
                $html .= '</div>';
            } else {
                $html .= '<div class="flex flex-col items-center flex-1">';
                $html .= '<div class="w-10 h-10 bg-gray-100 border-2 border-gray-300 rounded-full flex items-center justify-center text-gray-500 font-bold transition-all duration-300">';
                $html .= $stepNumber;
                $html .= '</div>';
                $html .= '<span class="text-xs mt-2 text-gray-400">' . self::escape($step) . '</span>';
                $html .= '</div>';
            }

            // Connector line
            if ($index < $totalSteps - 1) {
                $lineColor = $stepNumber < $currentStep ? 'bg-emerald-500' : 'bg-gray-200';
                $html .= '<div class="flex-1 h-1 ' . $lineColor . ' mx-2 transition-colors duration-300 -mt-8"></div>';
            }
        }

        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }
}
