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
    private const INPUT_BASE = 'w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent';

    /**
     * Classes de base pour les labels
     */
    private const LABEL_BASE = 'block text-sm font-medium text-gray-700 mb-2';

    /**
     * Input text/email/password/number/etc.
     */
    public static function input(string $name, string $label, array $attributes = [], ?string $error = null, ?string $help = null): string
    {
        $html = self::renderLabel($name, $label, $attributes['required'] ?? false);

        $classes = self::classNames([
            self::INPUT_BASE,
            $error ? 'border-red-500 focus:ring-red-500' : '',
            $attributes['class'] ?? '',
        ]);

        $attrs = array_merge([
            'type' => 'text',
            'id' => $name,
            'name' => $name,
            'class' => $classes,
        ], $attributes);

        unset($attrs['class']);
        $html .= sprintf('<input %s />', self::attributes($attrs));

        if ($error) {
            $html .= self::renderError($error);
        }

        if ($help) {
            $html .= self::renderHelp($help);
        }

        return '<div class="mb-4">' . $html . '</div>';
    }

    /**
     * Textarea
     */
    public static function textarea(string $name, string $label, array $attributes = [], ?string $error = null, ?string $help = null): string
    {
        $html = self::renderLabel($name, $label, $attributes['required'] ?? false);

        $value = $attributes['value'] ?? '';
        unset($attributes['value']);

        $classes = self::classNames([
            self::INPUT_BASE,
            $error ? 'border-red-500 focus:ring-red-500' : '',
            $attributes['class'] ?? '',
        ]);

        $attrs = array_merge([
            'id' => $name,
            'name' => $name,
            'rows' => 4,
            'class' => $classes,
        ], $attributes);

        unset($attrs['class']);
        $html .= sprintf(
            '<textarea %s>%s</textarea>',
            self::attributes($attrs),
            self::escape($value)
        );

        if ($error) {
            $html .= self::renderError($error);
        }

        if ($help) {
            $html .= self::renderHelp($help);
        }

        return '<div class="mb-4">' . $html . '</div>';
    }

    /**
     * Select dropdown
     */
    public static function select(string $name, string $label, array $options, $selected = null, array $attributes = [], ?string $error = null, ?string $help = null): string
    {
        $html = self::renderLabel($name, $label, $attributes['required'] ?? false);

        $classes = self::classNames([
            self::INPUT_BASE,
            'cursor-pointer',
            $error ? 'border-red-500 focus:ring-red-500' : '',
            $attributes['class'] ?? '',
        ]);

        $attrs = array_merge([
            'id' => $name,
            'name' => $name,
            'class' => $classes,
        ], $attributes);

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
            $html .= self::renderError($error);
        }

        if ($help) {
            $html .= self::renderHelp($help);
        }

        return '<div class="mb-4">' . $html . '</div>';
    }

    /**
     * Checkbox
     */
    public static function checkbox(string $name, string $label, bool $checked = false, array $attributes = [], ?string $help = null): string
    {
        $attrs = array_merge([
            'type' => 'checkbox',
            'id' => $name,
            'name' => $name,
            'class' => 'h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded',
            'checked' => $checked,
        ], $attributes);

        $html = '<div class="mb-4 flex items-start">';
        $html .= sprintf('<input %s />', self::attributes($attrs));
        $html .= '<label for="' . self::escape($name) . '" class="ml-3 text-sm text-gray-700">';
        $html .= self::escape($label);
        $html .= '</label>';
        $html .= '</div>';

        if ($help) {
            $html .= self::renderHelp($help);
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
            'class' => 'h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300',
            'checked' => $checked,
        ], $attributes);

        $html = '<div class="flex items-center mb-2">';
        $html .= sprintf('<input %s />', self::attributes($attrs));
        $html .= '<label for="' . self::escape($name . '_' . $value) . '" class="ml-3 text-sm text-gray-700">';
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
        $html = self::renderLabel($name, $label, $attributes['required'] ?? false);

        $classes = self::classNames([
            'block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none',
            $error ? 'border-red-500' : '',
            $attributes['class'] ?? '',
        ]);

        $attrs = array_merge([
            'type' => 'file',
            'id' => $name,
            'name' => $name,
            'class' => $classes,
        ], $attributes);

        unset($attrs['class']);
        $html .= sprintf('<input %s />', self::attributes($attrs));

        if ($error) {
            $html .= self::renderError($error);
        }

        if ($help) {
            $html .= self::renderHelp($help);
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
            'class' => 'w-full h-12 border border-gray-300 rounded-lg cursor-pointer',
        ], $attributes);

        $html .= sprintf('<input %s />', self::attributes($attrs));

        return '<div class="mb-4">' . $html . '</div>';
    }

    /**
     * Date/Time picker
     */
    public static function datetime(string $name, string $label, string $type = 'datetime-local', array $attributes = [], ?string $error = null): string
    {
        $html = self::renderLabel($name, $label, $attributes['required'] ?? false);

        $classes = self::classNames([
            self::INPUT_BASE,
            $error ? 'border-red-500 focus:ring-red-500' : '',
            $attributes['class'] ?? '',
        ]);

        $attrs = array_merge([
            'type' => $type, // datetime-local, date, time
            'id' => $name,
            'name' => $name,
            'class' => $classes,
        ], $attributes);

        unset($attrs['class']);
        $html .= sprintf('<input %s />', self::attributes($attrs));

        if ($error) {
            $html .= self::renderError($error);
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
            $html .= ' <span class="text-red-500">*</span>';
        }

        $html .= '</label>';

        return $html;
    }

    /**
     * Rendu du message d'erreur
     */
    private static function renderError(string $error): string
    {
        return '<p class="mt-1 text-sm text-red-600">' . self::escape($error) . '</p>';
    }

    /**
     * Rendu du texte d'aide
     */
    private static function renderHelp(string $help): string
    {
        return '<p class="mt-1 text-sm text-gray-500">' . self::escape($help) . '</p>';
    }

    /**
     * Groupe de champs en grille
     */
    public static function grid(array $fields, int $cols = 2): string
    {
        $gridClass = $cols === 2 ? 'grid-cols-2' : 'grid-cols-' . $cols;
        $html = '<div class="grid ' . $gridClass . ' gap-6">';

        foreach ($fields as $field) {
            $html .= $field;
        }

        $html .= '</div>';

        return $html;
    }
}
