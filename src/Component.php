<?php

namespace TailwindUI;

/**
 * Classe de base pour tous les composants UI
 * Fournit des méthodes utilitaires communes
 */
abstract class Component
{
    /**
     * Génère une classe HTML à partir d'un tableau de classes conditionnelles
     *
     * @param array $classes Tableau de classes avec conditions [classe => condition]
     * @return string Classes HTML concaténées
     */
    protected static function classNames(array $classes): string
    {
        $result = [];

        foreach ($classes as $class => $condition) {
            if (is_int($class)) {
                // Classe sans condition
                $result[] = $condition;
            } elseif ($condition) {
                // Classe avec condition vraie
                $result[] = $class;
            }
        }

        return implode(' ', $result);
    }

    /**
     * Échappe les attributs HTML
     *
     * @param string $value Valeur à échapper
     * @return string Valeur échappée
     */
    protected static function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Génère des attributs HTML à partir d'un tableau
     *
     * @param array $attributes Tableau d'attributs
     * @return string Attributs HTML
     */
    protected static function attributes(array $attributes): string
    {
        $result = [];

        foreach ($attributes as $key => $value) {
            if ($value === null || $value === false) {
                continue;
            }

            if ($value === true) {
                $result[] = $key;
            } else {
                $result[] = sprintf('%s="%s"', $key, self::escape((string)$value));
            }
        }

        return implode(' ', $result);
    }
}
