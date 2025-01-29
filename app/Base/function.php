<?php

function view(string $view, array $data = []): void
{
    extract($data);
    require_once(VIEWS_PATH . $view . '.php');
}

function env($key): mixed
{
    return $_ENV[$key];
}

function asset($path) : string
{
    return BASE_URL . '/assets/' . ltrim($path, '/');
}

function url($path): string
{
    return BASE_URL . '/'. $path;
}
