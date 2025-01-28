<?php

function view(string $view, array $data = []): void
{
    extract($data);
    require_once(VIEWS_PATH . $view . '.php');
}

function env($key)
{
    return $_ENV[$key];
}

// function asset($path)
// {
//     return BASEURL . '/assets/' . $path;
// }
