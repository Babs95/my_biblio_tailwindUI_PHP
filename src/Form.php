<?php

namespace TailwindUI;

/**
 * Composant Form - Éléments de formulaire stylisés
 *
 * Exemples d'utilisation :
 * Form::input('email', 'Email', ['type' => 'email', 'required' => true])
 * Form::textarea('description', 'Description', ['rows' => 4])
 * Form::select('status', 'Statut', $options, $selected)
 */
class Form extends Component
{
    /**
     * Classes de base pour les inputs
     */
    private const INPUT_BASE = 'w-full px-4 py-3.5 bg-gray-50/50 border border-gray-200 rounded-2xl text-gray-900 placeholder-gray-400 transition-all duration-300 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:shadow-lg focus:shadow-blue-500/5 hover:border-gray-300 hover:bg-gray-50';

    /**
     * Classes de base pour les labels
     */
    private const LABEL_BASE = 'block text-sm font-semibold text-gray-700 mb-2.5';

    /**
     * Input text/email/password/number/etc.
     */
    public static function input(string $name, string $label, array $attributes = [], ?string $error = null, ?string $help = null): string
    {
        $errorId = $error ? $name . '-error' : null;
        $helpId = $help ? $name . '-help' : null;
        $describedBy = array_filter([$errorId, $helpId]);

        $html = self::renderLabel($name, $label, $attributes['required'] ?? false);

        $classes = self::classNames([
            self::INPUT_BASE,
            $error ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '',
            $attributes['class'] ?? '',
        ]);

        $attrs = array_merge([
            'type' => 'text',
            'id' => $name,
            'name' => $name,
            'class' => $classes,
        ], $attributes);

        // Ajouter les attributs ARIA
        if (!empty($describedBy)) {
            $attrs['aria-describedby'] = implode(' ', $describedBy);
        }
        if ($error) {
            $attrs['aria-invalid'] = 'true';
        }
        if ($attrs['required'] ?? false) {
            $attrs['aria-required'] = 'true';
        }

        unset($attrs['class']);
        $html .= sprintf('<input %s />', self::attributes($attrs));

        if ($error) {
            $html .= self::renderError($error, $errorId);
        }

        if ($help) {
            $html .= self::renderHelp($help, $helpId);
        }

        return '<div class="mb-4">' . $html . '</div>';
    }

    /**
     * Textarea
     */
    public static function textarea(string $name, string $label, array $attributes = [], ?string $error = null, ?string $help = null): string
    {
        $errorId = $error ? $name . '-error' : null;
        $helpId = $help ? $name . '-help' : null;
        $describedBy = array_filter([$errorId, $helpId]);

        $html = self::renderLabel($name, $label, $attributes['required'] ?? false);

        $value = $attributes['value'] ?? '';
        unset($attributes['value']);

        $classes = self::classNames([
            self::INPUT_BASE,
            $error ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '',
            $attributes['class'] ?? '',
        ]);

        $attrs = array_merge([
            'id' => $name,
            'name' => $name,
            'rows' => 4,
            'class' => $classes,
        ], $attributes);

        // Ajouter les attributs ARIA
        if (!empty($describedBy)) {
            $attrs['aria-describedby'] = implode(' ', $describedBy);
        }
        if ($error) {
            $attrs['aria-invalid'] = 'true';
        }
        if ($attrs['required'] ?? false) {
            $attrs['aria-required'] = 'true';
        }

        unset($attrs['class']);
        $html .= sprintf(
            '<textarea %s>%s</textarea>',
            self::attributes($attrs),
            self::escape($value)
        );

        if ($error) {
            $html .= self::renderError($error, $errorId);
        }

        if ($help) {
            $html .= self::renderHelp($help, $helpId);
        }

        return '<div class="mb-4">' . $html . '</div>';
    }

    /**
     * Select dropdown
     */
    public static function select(string $name, string $label, array $options, $selected = null, array $attributes = [], ?string $error = null, ?string $help = null): string
    {
        $errorId = $error ? $name . '-error' : null;
        $helpId = $help ? $name . '-help' : null;
        $describedBy = array_filter([$errorId, $helpId]);

        $html = self::renderLabel($name, $label, $attributes['required'] ?? false);

        $classes = self::classNames([
            self::INPUT_BASE,
            'cursor-pointer',
            $error ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '',
            $attributes['class'] ?? '',
        ]);

        $attrs = array_merge([
            'id' => $name,
            'name' => $name,
            'class' => $classes,
        ], $attributes);

        // Ajouter les attributs ARIA
        if (!empty($describedBy)) {
            $attrs['aria-describedby'] = implode(' ', $describedBy);
        }
        if ($error) {
            $attrs['aria-invalid'] = 'true';
        }
        if ($attrs['required'] ?? false) {
            $attrs['aria-required'] = 'true';
        }

        unset($attrs['class']);
        $html .= sprintf('<select %s>', self::attributes($attrs));

        foreach ($options as $value => $text) {
            $isSelected = $value == $selected ? 'selected' : '';
            $html .= sprintf(
                '<option value="%s" %s>%s</option>',
                self::escape((string)$value),
                $isSelected,
                self::escape($text)
            );
        }

        $html .= '</select>';

        if ($error) {
            $html .= self::renderError($error, $errorId);
        }

        if ($help) {
            $html .= self::renderHelp($help, $helpId);
        }

        return '<div class="mb-4">' . $html . '</div>';
    }

    /**
     * Checkbox
     */
    public static function checkbox(string $name, string $label, bool $checked = false, array $attributes = [], ?string $help = null): string
    {
        $helpId = $help ? $name . '-help' : null;

        $attrs = array_merge([
            'type' => 'checkbox',
            'id' => $name,
            'name' => $name,
            'class' => 'h-5 w-5 text-blue-600 focus:ring-4 focus:ring-blue-500/20 border-gray-300 rounded-lg transition-all duration-200 cursor-pointer',
            'checked' => $checked,
        ], $attributes);

        if ($helpId) {
            $attrs['aria-describedby'] = $helpId;
        }

        $html = '<div class="mb-4 flex items-center">';
        $html .= sprintf('<input %s />', self::attributes($attrs));
        $html .= '<label for="' . self::escape($name) . '" class="ml-3 text-sm font-medium text-gray-700 cursor-pointer select-none">';
        $html .= self::escape($label);
        $html .= '</label>';
        $html .= '</div>';

        if ($help) {
            $html .= self::renderHelp($help, $helpId);
        }

        return $html;
    }

    /**
     * Radio button
     */
    public static function radio(string $name, string $value, string $label, bool $checked = false, array $attributes = []): string
    {
        $attrs = array_merge([
            'type' => 'radio',
            'id' => $name . '_' . $value,
            'name' => $name,
            'value' => $value,
            'class' => 'h-5 w-5 text-blue-600 focus:ring-4 focus:ring-blue-500/20 border-gray-300 transition-all duration-200 cursor-pointer',
            'checked' => $checked,
        ], $attributes);

        $html = '<div class="flex items-center mb-3">';
        $html .= sprintf('<input %s />', self::attributes($attrs));
        $html .= '<label for="' . self::escape($name . '_' . $value) . '" class="ml-3 text-sm font-medium text-gray-700 cursor-pointer select-none">';
        $html .= self::escape($label);
        $html .= '</label>';
        $html .= '</div>';

        return $html;
    }

    /**
     * File upload
     */
    public static function file(string $name, string $label, array $attributes = [], ?string $error = null, ?string $help = null): string
    {
        $errorId = $error ? $name . '-error' : null;
        $helpId = $help ? $name . '-help' : null;
        $describedBy = array_filter([$errorId, $helpId]);

        $html = self::renderLabel($name, $label, $attributes['required'] ?? false);

        $classes = self::classNames([
            'block w-full text-sm text-gray-900 border border-gray-200 rounded-xl cursor-pointer bg-gray-50 focus:outline-none file:mr-4 file:py-3 file:px-4 file:rounded-l-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-colors',
            $error ? 'border-red-500' : '',
            $attributes['class'] ?? '',
        ]);

        $attrs = array_merge([
            'type' => 'file',
            'id' => $name,
            'name' => $name,
            'class' => $classes,
        ], $attributes);

        // Ajouter les attributs ARIA
        if (!empty($describedBy)) {
            $attrs['aria-describedby'] = implode(' ', $describedBy);
        }
        if ($error) {
            $attrs['aria-invalid'] = 'true';
        }
        if ($attrs['required'] ?? false) {
            $attrs['aria-required'] = 'true';
        }

        unset($attrs['class']);
        $html .= sprintf('<input %s />', self::attributes($attrs));

        if ($error) {
            $html .= self::renderError($error, $errorId);
        }

        if ($help) {
            $html .= self::renderHelp($help, $helpId);
        }

        return '<div class="mb-4">' . $html . '</div>';
    }

    /**
     * Color picker
     */
    public static function color(string $name, string $label, string $value = '#3B82F6', array $attributes = []): string
    {
        $html = self::renderLabel($name, $label, $attributes['required'] ?? false);

        $attrs = array_merge([
            'type' => 'color',
            'id' => $name,
            'name' => $name,
            'value' => $value,
            'class' => 'w-full h-14 border border-gray-200 rounded-xl cursor-pointer bg-gray-50 hover:border-gray-300 transition-colors',
        ], $attributes);

        $html .= sprintf('<input %s />', self::attributes($attrs));

        return '<div class="mb-4">' . $html . '</div>';
    }

    /**
     * Date/Time picker
     */
    public static function datetime(string $name, string $label, string $type = 'datetime-local', array $attributes = [], ?string $error = null): string
    {
        $errorId = $error ? $name . '-error' : null;

        $html = self::renderLabel($name, $label, $attributes['required'] ?? false);

        $classes = self::classNames([
            self::INPUT_BASE,
            $error ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '',
            $attributes['class'] ?? '',
        ]);

        $attrs = array_merge([
            'type' => $type, // datetime-local, date, time
            'id' => $name,
            'name' => $name,
            'class' => $classes,
        ], $attributes);

        // Ajouter les attributs ARIA
        if ($errorId) {
            $attrs['aria-describedby'] = $errorId;
        }
        if ($error) {
            $attrs['aria-invalid'] = 'true';
        }
        if ($attrs['required'] ?? false) {
            $attrs['aria-required'] = 'true';
        }

        unset($attrs['class']);
        $html .= sprintf('<input %s />', self::attributes($attrs));

        if ($error) {
            $html .= self::renderError($error, $errorId);
        }

        return '<div class="mb-4">' . $html . '</div>';
    }

    /**
     * Rendu du label
     */
    private static function renderLabel(string $for, string $text, bool $required = false): string
    {
        $html = '<label for="' . self::escape($for) . '" class="' . self::LABEL_BASE . '">';
        $html .= self::escape($text);

        if ($required) {
            $html .= ' <span class="text-red-500" aria-hidden="true">*</span>';
        }

        $html .= '</label>';

        return $html;
    }

    /**
     * Rendu du message d'erreur
     */
    private static function renderError(string $error, ?string $id = null): string
    {
        $idAttr = $id ? ' id="' . self::escape($id) . '"' : '';
        return '<p' . $idAttr . ' class="mt-2 text-sm text-red-600 flex items-center" role="alert">' .
               '<svg class="h-4 w-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">' .
               '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>' .
               '</svg>' .
               self::escape($error) .
               '</p>';
    }

    /**
     * Rendu du texte d'aide
     */
    private static function renderHelp(string $help, ?string $id = null): string
    {
        $idAttr = $id ? ' id="' . self::escape($id) . '"' : '';
        return '<p' . $idAttr . ' class="mt-2 text-sm text-gray-500">' . self::escape($help) . '</p>';
    }

    /**
     * Groupe de champs en grille
     */
    public static function grid(array $fields, int $cols = 2): string
    {
        // Validation du paramètre cols (2-4)
        $cols = max(1, min(4, $cols));

        $gridClass = 'grid-cols-' . $cols;
        $html = '<div class="grid ' . $gridClass . ' gap-6">';

        foreach ($fields as $field) {
            $html .= $field;
        }

        $html .= '</div>';

        return $html;
    }
}
