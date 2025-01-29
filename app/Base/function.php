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

function asset($path): string
{
    return BASE_URL . '/assets/' . ltrim($path, '/');
}

function url($path): string
{
    return BASE_URL . '/' . $path;
}

function renderPaginationLinks(int $currentPage, int $totalPages, int $perPage): string
{
    if ($totalPages <= 1) return '';

    $html = '<ul class="pagination">';
    $limitParam = "&limit=$perPage";

    // Previous Button
    if ($currentPage > 1) {
        $html .= '<li><a href="?page=' . ($currentPage - 1) . $limitParam . '">&laquo; Prev</a></li>';
    }

    // Page Numbers
    for ($i = 1; $i <= $totalPages; $i++) {
        $activeClass = ($i == $currentPage) ? 'class="active"' : '';
        $html .= '<li ' . $activeClass . '><a href="?page=' . $i . $limitParam . '">' . $i . '</a></li>';
    }

    // Next Button
    if ($currentPage < $totalPages) {
        $html .= '<li><a href="?page=' . ($currentPage + 1) . $limitParam . '">Next &raquo;</a></li>';
    }

    $html .= '</ul>';
    return $html;
}


function renderPerPageDropdown(int $currentPerPage): string
{
    $options = [5, 10, 25, 50, 100];
    $html = '<form method="GET" action="">';
    $html .= '<select name="limit" onchange="this.form.submit()">';

    foreach ($options as $option) {
        $selected = ($option == $currentPerPage) ? 'selected' : '';
        $html .= "<option value='$option' $selected>$option per page</option>";
    }

    $html .= '</select>';
    $html .= '</form>';
    return $html;
}
