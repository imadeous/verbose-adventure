<?php

namespace Core;

class Validator
{
    protected $errors = [];


    /**
     * Validate data against a set of rules.
     *
     * @param array $data
     * @param array $rules
     * @return array Validation errors
     */
    public function validate(array $data, array $rules)
    {
        foreach ($rules as $field => $ruleString) {
            $rulesArray = explode('|', $ruleString);
            $value = $data[$field] ?? null;

            foreach ($rulesArray as $rule) {
                $this->applyRule($field, $value, $rule);
            }
        }
        return $this->errors;
    }


    /**
     * Apply a single validation rule to a field value.
     *
     * @param string $field
     * @param mixed $value
     * @param string $rule
     * @return void
     */
    protected function applyRule($field, $value, $rule)
    {
        switch ($rule) {
            case 'required':
                if (empty($value)) {
                    $this->addError($field, "The {$field} field is required.");
                }
                break;
            case 'email':
                if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($field, "The {$field} must be a valid email address.");
                }
                break;
        }
    }


    /**
     * Add an error message for a field.
     *
     * @param string $field
     * @param string $message
     * @return void
     */
    protected function addError($field, $message)
    {
        $this->errors[$field][] = $message;
    }


    /**
     * Get all validation errors.
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
