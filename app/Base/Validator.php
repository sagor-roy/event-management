<?php

namespace App\Base;

class Validator
{
    protected $errors;
    protected $rules;
    protected $data;
    protected $messages = [
        'required' => 'The :attribute field is required.',
        'email' => 'The :attribute must be a valid email address.',
        'min' => 'The :attribute must be at least :min characters.',
        'max' => 'The :attribute must not exceed :max characters.',
    ];
    

    public function __construct(array $data, array $rules)
    {
        $this->errors = [];
        $this->rules = $rules;
        $this->data = $data;
    }

    public function validate()
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

                if (!$this->$methodName($this->data[$attribute] ?? null, $param)) {
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

    public function fails()
    {
        return !$this->validate();
    }

    public function errors()
    {
        return $this->errors;
    }

    protected function validateRequired($value)
    {
        return !empty($value);
    }

    protected function validateEmail($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    protected function validateMin($value, $min)
    {
        return strlen($value) >= (int)$min;
    }

    protected function validateMax($value, $max)
    {
        return strlen($value) <= (int)$max;
    }
}
