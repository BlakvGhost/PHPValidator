<?php

/**
 * NotRequiredWith - Une règle de validation qui exige que le champ ne soit pas présent si un autre champ spécifié est présent
 *
 * @package BlakvGhost\PHPValidator\Rules
 * @autor Kabirou ALASSANE
 * @github https://github.com/BlakvGhost
 */

namespace BlakvGhost\PHPValidator\Rules;

use BlakvGhost\PHPValidator\Contracts\Rule;
use BlakvGhost\PHPValidator\Lang\LangManager;

class NotRequiredWithRule implements Rule
{
    /**
     * Nom du champ en cours de validation.
     *
     * @var string
     */
    protected $field;

    /**
     * Constructeur de la classe NotRequiredWithRule.
     *
     * @param array $parameters Paramètres pour la règle, spécifiant le champ à vérifier.
     */
    public function __construct(protected array $parameters)
    {
        // Pas de logique spécifique nécessaire dans le constructeur pour cette règle.
    }

    /**
     * Vérifie si la valeur n'est pas requise si une autre valeur est présente.
     *
     * @param string $field Nom du champ en cours de validation.
     * @param mixed $value Valeur du champ en cours de validation.
     * @param array $data Toutes les données de validation.
     * @return bool True si la valeur n'est pas requise avec une autre valeur, false sinon.
     */
    public function passes(string $field, $value, array $data): bool
    {
        // Définir la propriété field pour l'utiliser dans la méthode message.
        $this->field = $field;

        $otherKey = $this->parameters[0];

        // Retourner vrai si l'autre champ est présent et le champ en cours de validation est vide ou absent
        return !isset($data[$otherKey]) || empty($value);
    }

    /**
     * Obtenir le message d'erreur de validation pour cette règle.
     *
     * @return string Message d'erreur de validation.
     */
    public function message(): string
    {
        // Utiliser LangManager pour obtenir un message d'erreur de validation traduit.
        return LangManager::getTranslation('validation.not_required_with', [
            'attribute' => $this->field,
            'value' => $this->parameters[0]
        ]);
    }
}
