<?php

namespace App\Base;

class Validator
{
    protected $errors;
    protected $rules;
    protected $data;

    public function __construct(array $data, array $rules)
    {
        $this->errors = [];
        $this->rules = $rules;
        $this->data = $data;
    }

    public function validate()
    {
        // Define the error messages for each validation rule
        $messages = [
            'required' => 'The :attribute field is required.',
            'email' => 'The :attribute field must be a valid email address.'
        ];

        foreach ($this->data as $attribute => $value) {
            foreach ($this->rules[$attribute] as $rule) {
                $methodName = 'validate' . ucfirst($rule);
                if (!$this->$methodName($value)) {
                    $errorMessage = str_replace(':attribute', $attribute, $messages[$rule]);
                    $this->errors[$attribute][] = $errorMessage;
                }
            }
        }
        return empty($this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public static function validateRequired($value)
    {
        return !empty($value);
    }

    public static function validateEmail($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function fails()
    {
        if (!$this->validate()) {
            $errors = $this->getErrors();
            Session::set('errors', $errors);
            return true;
        }
    }
}
