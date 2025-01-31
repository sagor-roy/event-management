<?php

/**
 * Load a view file and pass data to it.
 *
 * @param string $view The name of the view file (without extension)
 * @param array $data (Optional) An associative array of data to extract and use in the view
 * @return void
 */
function view(string $view, array $data = []): void
{
    extract($data);
    require_once(VIEWS_PATH . $view . '.php');
}

/**
 * Retrieve an environment variable.
 *
 * @param string $key The key of the environment variable
 * @return mixed The value of the environment variable
 */
function env($key): mixed
{
    return $_ENV[$key];
}

/**
 * Generate the full URL for an asset file.
 *
 * @param string $path The asset file path
 * @param bool|null $secure Whether to use HTTPS (default is auto-detect)
 * @return string The full asset URL
 */
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

/**
 * Get the base URL of the application.
 *
 * @param bool $protocol Whether to include the protocol (http/https)
 * @return string The base URL of the application
 */
function get_base_url($protocol = true): string
{
    $isSecure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    $protocol_text = $isSecure ? 'https://' : 'http://';

    $host = $_SERVER['HTTP_HOST'];

    $subfolder = dirname($_SERVER['SCRIPT_NAME']);
    $subfolder = $subfolder !== '/' ? $subfolder : '';

    return ($protocol ? $protocol_text : '') . $host . $subfolder;
}

/**
 * Generate a full URL based on the given path.
 *
 * @param string $path The relative path
 * @param bool $protocol Whether to include the protocol (http/https)
 * @return string The full URL
 */
function url($path, $protocol = true): string
{
    return rtrim(get_base_url($protocol), '/') . '/' . ltrim($path, '/');
}

/**
 * Generate pagination links for navigation.
 *
 * @param int $currentPage The current page number
 * @param int $totalPages The total number of pages
 * @param int $perPage The number of items per page
 * @return string HTML markup for pagination links
 */
function renderPaginationLinks(int $currentPage, int $totalPages, int $perPage): string
{
    if ($totalPages <= 1) return '';

    $html = '<ul class="pagination">';
    $limitParam = "&limit=$perPage";

    // Previous page link
    if ($currentPage > 1) {
        $html .= '<li><a href="?page=' . ($currentPage - 1) . $limitParam . '">&laquo; Prev</a></li>';
    }

    // Page number links
    for ($i = 1; $i <= $totalPages; $i++) {
        $activeClass = ($i == $currentPage) ? 'class="active"' : '';
        $html .= '<li ' . $activeClass . '><a href="?page=' . $i . $limitParam . '">' . $i . '</a></li>';
    }

    // Next page link
    if ($currentPage < $totalPages) {
        $html .= '<li><a href="?page=' . ($currentPage + 1) . $limitParam . '">Next &raquo;</a></li>';
    }

    $html .= '</ul>';
    return $html;
}

/**
 * Render a dropdown for selecting items per page.
 *
 * @return string HTML markup for the dropdown
 */
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

/**
 * Generate a URL-friendly slug from a string.
 *
 * @param string $string The input string
 * @return string The generated slug
 */
function generateSlug(string $string): string
{
    $slug = strtolower(trim($string));
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    return trim($slug, '-');
}

/**
 * Show a 404 error page.
 *
 * @return void
 */
function abort_404()
{
    require(VIEWS_PATH . '/errors/404.php');
}
