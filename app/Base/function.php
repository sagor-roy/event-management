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

function asset($path, $secure = null)
{
    if ($secure === null) {
        $secure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    }
    $path = ltrim($path, '/');
    $baseUrl = sprintf(
        "%s://%s",
        $secure ? "https" : "http",
        $_SERVER['HTTP_HOST']
    );
    $assetDir = 'assets';

    return sprintf(
        "%s/%s/%s",
        rtrim($baseUrl, '/'),
        trim($assetDir, '/'),
        $path
    );
}

function get_base_url($protocol = true): string
{
    $isSecure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    $protocol_text = $isSecure ? 'https://' : 'http://';

    $host = $_SERVER['HTTP_HOST'];

    $subfolder = dirname($_SERVER['SCRIPT_NAME']);
    $subfolder = $subfolder !== '/' ? $subfolder : '';

    return ($protocol ? $protocol_text : '') . $host . $subfolder;
}


function url($path, $protocol = true): string
{
    return rtrim(get_base_url($protocol), '/') . '/' . ltrim($path, '/');
}


function renderPaginationLinks(int $currentPage, int $totalPages, int $perPage): string
{
    if ($totalPages <= 1) return '';

    $html = '<ul class="pagination">';
    $limitParam = "&limit=$perPage";

    if ($currentPage > 1) {
        $html .= '<li><a href="?page=' . ($currentPage - 1) . $limitParam . '">&laquo; Prev</a></li>';
    }

    for ($i = 1; $i <= $totalPages; $i++) {
        $activeClass = ($i == $currentPage) ? 'class="active"' : '';
        $html .= '<li ' . $activeClass . '><a href="?page=' . $i . $limitParam . '">' . $i . '</a></li>';
    }

    if ($currentPage < $totalPages) {
        $html .= '<li><a href="?page=' . ($currentPage + 1) . $limitParam . '">Next &raquo;</a></li>';
    }

    $html .= '</ul>';
    return $html;
}


function renderPerPageDropdown(): string
{
    $limit = isset($_GET['limit']) ? $_GET['limit'] : 5;
    $options = [5, 10, 25, 50, 100];
    $html = '<form method="GET" action="" style="margin:20px">';
    $html .= '<select style="padding: 10px" name="limit" onchange="this.form.submit()">';

    foreach ($options as $option) {
        $selected = ($option == $limit) ? 'selected' : '';
        $html .= "<option value='$option' $selected>$option per page</option>";
    }

    $html .= '</select>';
    $html .= '</form>';
    return $html;
}


function generateSlug(string $string): string
{
    $slug = strtolower(trim($string));
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    return trim($slug, '-');
}

function abort_404()
{
    require(VIEWS_PATH . '/errors/404.php');
}
