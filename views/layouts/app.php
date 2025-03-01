<?php
$route = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$hideLayoutRoutes = ['/login', '/register'];
$hideLayout = in_array($route, $hideLayoutRoutes);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $title ?? 'Event Management'; ?></title>
    <link rel="icon" href="favicon.ico" />
    <link href="<?= asset('src/style.css') ?>" rel="stylesheet" />
    <link href="<?= asset('src/common.css') ?>" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11.0.5/swiper-bundle.min.css" />

</head>

<body
    x-data="{ page: 'ecommerce', 'loaded': true, 'darkMode': true, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
    x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{'dark text-bodydark bg-boxdark-2': darkMode === true}">
    <div
        x-show="loaded"
        x-init="window.addEventListener('DOMContentLoaded', () => {setTimeout(() => loaded = false, 500)})"
        class="fixed left-0 top-0 z-999999 flex h-screen w-screen items-center justify-center bg-white dark:bg-black">
        <div
            class="h-16 w-16 animate-spin rounded-full border-4 border-solid border-primary border-t-transparent"></div>
    </div>

    <?php if (!$hideLayout): ?>
        <div class="flex h-screen overflow-hidden">
            <?php include(VIEWS_PATH . 'partials/sidebar.php') ?>
            <div
                class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
                <?php include(VIEWS_PATH . 'partials/navbar.php') ?>
                <main>
                    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
                        <?php echo $content ?? ''; ?>
                    </div>
                </main>
            </div>
        </div>
    <?php else: ?>
        <main>
            <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
                <?php echo $content ?? ''; ?>
            </div>
        </main>
    <?php endif; ?>
    <script defer src="<?= asset('src/bundle.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.2/dist/sweetalert2.all.min.js"></script>
</body>

</html>