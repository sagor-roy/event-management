<?php

$rules = [
    'name' => ['required'],
    'email' => ['required', 'email']
];

// Define the error messages for each validation rule
$messages = [
    'required' => 'The :attribute field is required.',
    'email' => 'The :attribute field must be a valid email address.'
];