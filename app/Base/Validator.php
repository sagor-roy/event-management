<?php

namespace App\Base;

class Validator
{
    /**
     * Stores validation errors.
     *
     * @var array
     */
    protected $errors;

    /**
     * Stores validation rules.
     *
     * @var array
     */
    protected $rules;

    /**
     * Stores the input data to be validated.
     *
     * @var array
     */
    protected $data;

    /**
     * Default validation error messages.
     *
     * @var array
     */
    protected $messages = [
        'required' => 'The :attribute field is required.',
        'email' => 'The :attribute must be a valid email address.',
        'min' => 'The :attribute must be at least :min characters.',
        'max' => 'The :attribute must not exceed :max characters.',
        'confirmed' => 'The :attribute confirmation does not match.',
    ];

    /**
     * Constructor to initialize the validator with data and rules.
     *
     * @param array $data The input data to be validated
     * @param array $rules The validation rules
     */
    public function __construct(array $data, array $rules)
    {
        $this->errors = [];
        $this->rules = $rules;
        $this->data = $data;
    }

    /**
     * Validate the input data against the defined rules.
     *
     * @return bool Returns true if validation passes, otherwise false
     */
    public function validate(): bool
    {
        foreach ($this->rules as $attribute => $ruleString) {
            $rules = explode('|', $ruleString);

            foreach ($rules as $rule) {
                $params = explode(':', $rule);
                $ruleName = $params[0];

                $methodName = 'validate' . ucfirst($ruleName);
                if (!method_exists($this, $methodName)) {
                    continue;
                }

                $param = $params[1] ?? null;

                // Call the corresponding validation method
                if (!$this->$methodName($this->data[$attribute] ?? null, $param)) {
                    // Replace placeholders in error message
                    $errorMessage = str_replace(
                        [':attribute', ":$ruleName"],
                        [$attribute, $param],
                        $this->messages[$ruleName] ?? 'The :attribute is invalid.'
                    );
                    $this->errors[$attribute][] = $errorMessage;
                }
            }
        }
        return empty($this->errors);
    }

    /**
     * Check if validation fails.
     *
     * @return bool Returns true if validation fails, otherwise false
     */
    public function fails(): bool
    {
        return !$this->validate();
    }

    /**
     * Retrieve validation errors.
     *
     * @return array The list of validation errors
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * Validate that a field is required.
     *
     * @param mixed $value The value to check
     * @return bool Returns true if the field is not empty, otherwise false
     */
    protected function validateRequired($value): bool
    {
        return $value !== null && $value !== '';
    }

    /**
     * Validate that a field contains a valid email address.
     *
     * @param string|null $value The email address to validate
     * @return bool Returns true if valid, otherwise false
     */
    protected function validateEmail($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Validate that a field has a minimum length.
     *
     * @param string|null $value The input value
     * @param int $min The minimum length required
     * @return bool Returns true if valid, otherwise false
     */
    protected function validateMin($value, $min): bool
    {
        return strlen($value) >= (int)$min;
    }

    /**
     * Validate that a field does not exceed the maximum length.
     *
     * @param string|null $value The input value
     * @param int $max The maximum allowed length
     * @return bool Returns true if valid, otherwise false
     */
    protected function validateMax($value, $max): bool
    {
        return strlen($value) <= (int)$max;
    }

    /**
     * Validate that a field matches its confirmation field.
     *
     * @param string|null $value The value to check
     * @param string|null $param Not used (optional parameter)
     * @return bool Returns true if values match, otherwise false
     */
    protected function validateConfirmed($value, $param = null): bool
    {
        $confirmationField = 'password_confirmation';
        return isset($this->data[$confirmationField]) && $value === $this->data[$confirmationField];
    }

    /**
     * Validate that a field value is within a predefined set.
     *
     * @param string|null $value The input value
     * @param string|null $param A comma-separated list of allowed values
     * @return bool Returns true if the value is allowed, otherwise false
     */
    protected function validateIn($value, $param = null): bool
    {
        $allowedValues = explode(',', $param);
        return in_array($value, $allowedValues, true);
    }
}
