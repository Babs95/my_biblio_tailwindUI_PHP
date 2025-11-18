<?php

namespace TailwindUI;

/**
 * Composant Banner - Bannières et barres d'annonce
 *
 * Exemples d'utilisation :
 * Banner::announcement('Nouveau : Version 2.0 disponible !')
 * Banner::promo('Offre spéciale', '50% de réduction')
 * Banner::cookie('Nous utilisons des cookies')
 */
class Banner extends Component
{
    /**
     * Barre d'annonce simple
     */
    public static function announcement(string $message, ?string $url = null, bool $dismissible = true, array $attributes = []): string
    {
        $classes = self::classNames([
            'bg-blue-600 text-white',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $id = 'banner-' . uniqid();

        $html = '<div id="' . $id . '" class="' . $classes . '" ' . self::attributes($attributes) . '>';
        $html .= '<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">';
        $html .= '<div class="flex items-center justify-between flex-wrap gap-2">';

        $html .= '<div class="flex-1 flex items-center justify-center">';
        $html .= '<p class="text-sm font-medium text-center">';

        if ($url) {
            $html .= '<a href="' . self::escape($url) . '" class="hover:underline">';
            $html .= self::escape($message);
            $html .= ' <span aria-hidden="true">&rarr;</span>';
            $html .= '</a>';
        } else {
            $html .= self::escape($message);
        }

        $html .= '</p>';
        $html .= '</div>';

        if ($dismissible) {
            $html .= '<button type="button" class="flex-shrink-0 p-1 rounded-lg hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-white transition-colors" onclick="document.getElementById(\'' . $id . '\').remove()">';
            $html .= '<svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">';
            $html .= '<path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>';
            $html .= '</svg>';
            $html .= '</button>';
        }

        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Bannière promotionnelle
     */
    public static function promo(string $title, string $description, ?string $ctaText = null, ?string $ctaUrl = null, bool $dismissible = true, array $attributes = []): string
    {
        $classes = self::classNames([
            'bg-gradient-to-r from-purple-600 to-blue-600 text-white',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $id = 'promo-' . uniqid();

        $html = '<div id="' . $id . '" class="' . $classes . '" ' . self::attributes($attributes) . '>';
        $html .= '<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">';
        $html .= '<div class="flex items-center justify-between flex-wrap gap-4">';

        // Content
        $html .= '<div class="flex-1">';
        $html .= '<p class="text-sm font-bold">' . self::escape($title) . '</p>';
        $html .= '<p class="text-sm text-purple-100">' . self::escape($description) . '</p>';
        $html .= '</div>';

        // CTA
        if ($ctaText && $ctaUrl) {
            $html .= '<div class="flex-shrink-0">';
            $html .= '<a href="' . self::escape($ctaUrl) . '" class="inline-flex items-center px-4 py-2 bg-white text-purple-600 text-sm font-semibold rounded-lg hover:bg-purple-50 transition-colors">';
            $html .= self::escape($ctaText);
            $html .= '</a>';
            $html .= '</div>';
        }

        // Dismiss button
        if ($dismissible) {
            $html .= '<button type="button" class="flex-shrink-0 p-1 rounded-lg hover:bg-white/10 focus:outline-none transition-colors" onclick="document.getElementById(\'' . $id . '\').remove()">';
            $html .= '<svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">';
            $html .= '<path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>';
            $html .= '</svg>';
            $html .= '</button>';
        }

        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Bannière cookie/RGPD
     */
    public static function cookie(string $message, string $acceptText = 'Accepter', string $declineText = 'Refuser', array $attributes = []): string
    {
        $classes = self::classNames([
            'fixed bottom-0 inset-x-0 z-50',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $id = 'cookie-' . uniqid();

        $html = '<div id="' . $id . '" class="' . $classes . '" ' . self::attributes($attributes) . '>';
        $html .= '<div class="bg-gray-900 text-white">';
        $html .= '<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">';
        $html .= '<div class="md:flex md:items-center md:justify-between">';

        // Message
        $html .= '<div class="flex-1 mb-4 md:mb-0 md:mr-8">';
        $html .= '<p class="text-sm text-gray-300">';
        $html .= self::escape($message);
        $html .= '</p>';
        $html .= '</div>';

        // Buttons
        $html .= '<div class="flex space-x-4">';
        $html .= '<button type="button" onclick="document.getElementById(\'' . $id . '\').remove(); localStorage.setItem(\'cookies\', \'accepted\')" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors">';
        $html .= self::escape($acceptText);
        $html .= '</button>';
        $html .= '<button type="button" onclick="document.getElementById(\'' . $id . '\').remove(); localStorage.setItem(\'cookies\', \'declined\')" class="px-4 py-2 bg-gray-700 text-white text-sm font-semibold rounded-lg hover:bg-gray-600 transition-colors">';
        $html .= self::escape($declineText);
        $html .= '</button>';
        $html .= '</div>';

        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Bannière avec compte à rebours
     */
    public static function countdown(string $message, string $endDate, ?string $ctaText = null, ?string $ctaUrl = null, array $attributes = []): string
    {
        $classes = self::classNames([
            'bg-gradient-to-r from-red-600 to-orange-500 text-white',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $id = 'countdown-' . uniqid();

        $html = '<div id="' . $id . '" class="' . $classes . '" ' . self::attributes($attributes) . '>';
        $html .= '<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">';
        $html .= '<div class="flex items-center justify-center flex-wrap gap-4">';

        // Message
        $html .= '<span class="text-sm font-bold">' . self::escape($message) . '</span>';

        // Countdown
        $html .= '<div class="flex items-center space-x-2 font-mono">';
        $html .= '<div class="bg-white/20 rounded-lg px-2 py-1"><span id="' . $id . '-days">00</span><span class="text-xs ml-1">j</span></div>';
        $html .= '<span>:</span>';
        $html .= '<div class="bg-white/20 rounded-lg px-2 py-1"><span id="' . $id . '-hours">00</span><span class="text-xs ml-1">h</span></div>';
        $html .= '<span>:</span>';
        $html .= '<div class="bg-white/20 rounded-lg px-2 py-1"><span id="' . $id . '-mins">00</span><span class="text-xs ml-1">m</span></div>';
        $html .= '<span>:</span>';
        $html .= '<div class="bg-white/20 rounded-lg px-2 py-1"><span id="' . $id . '-secs">00</span><span class="text-xs ml-1">s</span></div>';
        $html .= '</div>';

        // CTA
        if ($ctaText && $ctaUrl) {
            $html .= '<a href="' . self::escape($ctaUrl) . '" class="px-4 py-2 bg-white text-red-600 text-sm font-semibold rounded-lg hover:bg-red-50 transition-colors">';
            $html .= self::escape($ctaText);
            $html .= '</a>';
        }

        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';

        // Countdown script
        $html .= '<script>';
        $html .= '(function() {';
        $html .= 'const endDate = new Date("' . self::escape($endDate) . '").getTime();';
        $html .= 'const timer = setInterval(function() {';
        $html .= 'const now = new Date().getTime();';
        $html .= 'const distance = endDate - now;';
        $html .= 'if (distance < 0) { clearInterval(timer); return; }';
        $html .= 'const days = Math.floor(distance / (1000 * 60 * 60 * 24));';
        $html .= 'const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));';
        $html .= 'const mins = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));';
        $html .= 'const secs = Math.floor((distance % (1000 * 60)) / 1000);';
        $html .= 'document.getElementById("' . $id . '-days").textContent = String(days).padStart(2, "0");';
        $html .= 'document.getElementById("' . $id . '-hours").textContent = String(hours).padStart(2, "0");';
        $html .= 'document.getElementById("' . $id . '-mins").textContent = String(mins).padStart(2, "0");';
        $html .= 'document.getElementById("' . $id . '-secs").textContent = String(secs).padStart(2, "0");';
        $html .= '}, 1000);';
        $html .= '})();';
        $html .= '</script>';

        return $html;
    }

    /**
     * Bannière d'alerte/urgence
     */
    public static function alert(string $type, string $message, ?string $url = null, bool $dismissible = true, array $attributes = []): string
    {
        $colors = [
            'info' => 'bg-blue-50 text-blue-800 border-blue-200',
            'success' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
            'warning' => 'bg-amber-50 text-amber-800 border-amber-200',
            'danger' => 'bg-red-50 text-red-800 border-red-200',
        ];

        $icons = [
            'info' => 'fas fa-info-circle text-blue-500',
            'success' => 'fas fa-check-circle text-emerald-500',
            'warning' => 'fas fa-exclamation-triangle text-amber-500',
            'danger' => 'fas fa-exclamation-circle text-red-500',
        ];

        $colorClass = $colors[$type] ?? $colors['info'];
        $iconClass = $icons[$type] ?? $icons['info'];

        $classes = self::classNames([
            $colorClass . ' border-b',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $id = 'alert-banner-' . uniqid();

        $html = '<div id="' . $id . '" class="' . $classes . '" ' . self::attributes($attributes) . '>';
        $html .= '<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">';
        $html .= '<div class="flex items-center justify-between">';

        // Icon and message
        $html .= '<div class="flex items-center">';
        $html .= '<i class="' . $iconClass . ' mr-3"></i>';
        $html .= '<p class="text-sm font-medium">';

        if ($url) {
            $html .= '<a href="' . self::escape($url) . '" class="hover:underline">';
            $html .= self::escape($message);
            $html .= '</a>';
        } else {
            $html .= self::escape($message);
        }

        $html .= '</p>';
        $html .= '</div>';

        // Dismiss button
        if ($dismissible) {
            $html .= '<button type="button" class="flex-shrink-0 ml-4 p-1 rounded-lg hover:bg-black/5 focus:outline-none transition-colors" onclick="document.getElementById(\'' . $id . '\').remove()">';
            $html .= '<svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">';
            $html .= '<path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>';
            $html .= '</svg>';
            $html .= '</button>';
        }

        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Bannière flottante (en bas de page)
     */
    public static function floating(string $message, string $ctaText, string $ctaUrl, bool $dismissible = true, array $attributes = []): string
    {
        $classes = self::classNames([
            'fixed bottom-4 left-4 right-4 md:left-auto md:right-4 md:max-w-md z-50',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $id = 'floating-' . uniqid();

        $html = '<div id="' . $id . '" class="' . $classes . '" ' . self::attributes($attributes) . '>';
        $html .= '<div class="bg-gray-900 text-white rounded-2xl shadow-2xl p-4">';
        $html .= '<div class="flex items-center justify-between gap-4">';

        // Message
        $html .= '<p class="text-sm">' . self::escape($message) . '</p>';

        // Actions
        $html .= '<div class="flex items-center space-x-2">';
        $html .= '<a href="' . self::escape($ctaUrl) . '" class="flex-shrink-0 px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors">';
        $html .= self::escape($ctaText);
        $html .= '</a>';

        if ($dismissible) {
            $html .= '<button type="button" class="flex-shrink-0 p-2 rounded-lg hover:bg-gray-800 focus:outline-none transition-colors" onclick="document.getElementById(\'' . $id . '\').remove()">';
            $html .= '<svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">';
            $html .= '<path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>';
            $html .= '</svg>';
            $html .= '</button>';
        }

        $html .= '</div>';

        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Bannière avec icône personnalisée
     */
    public static function withIcon(string $icon, string $message, string $color = 'blue', bool $dismissible = true, array $attributes = []): string
    {
        $colors = [
            'blue' => 'bg-blue-600',
            'green' => 'bg-emerald-600',
            'red' => 'bg-red-600',
            'yellow' => 'bg-amber-500',
            'purple' => 'bg-purple-600',
            'gray' => 'bg-gray-800',
        ];

        $bgColor = $colors[$color] ?? $colors['blue'];

        $classes = self::classNames([
            $bgColor . ' text-white',
            $attributes['class'] ?? '',
        ]);

        unset($attributes['class']);

        $id = 'icon-banner-' . uniqid();

        $html = '<div id="' . $id . '" class="' . $classes . '" ' . self::attributes($attributes) . '>';
        $html .= '<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">';
        $html .= '<div class="flex items-center justify-between">';

        // Icon and message
        $html .= '<div class="flex items-center">';
        $html .= '<i class="' . self::escape($icon) . ' mr-3 text-lg"></i>';
        $html .= '<p class="text-sm font-medium">' . self::escape($message) . '</p>';
        $html .= '</div>';

        // Dismiss button
        if ($dismissible) {
            $html .= '<button type="button" class="flex-shrink-0 p-1 rounded-lg hover:bg-white/10 focus:outline-none transition-colors" onclick="document.getElementById(\'' . $id . '\').remove()">';
            $html .= '<svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">';
            $html .= '<path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>';
            $html .= '</svg>';
            $html .= '</button>';
        }

        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }
}
