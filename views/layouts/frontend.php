<?php
$route = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$hideLayoutRoutes = ['/'];
$hideLayout = in_array($route, $hideLayoutRoutes);
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@11.0.5/swiper-bundle.min.css" />
    <link rel="stylesheet" href="<?= asset('src/output.css') ?>" />
    <title><?php echo $title ?? 'Event Management'; ?></title>
</head>

<body>
    <div class="mx-auto max-w-[550px] overflow-x-hidden">
        <!-- header starts -->
        <header
            class="fixed inset-x-0 top-0 z-50 h-[55px] w-full bg-gray-400 text-white">
            <div
                class="container relative flex h-full max-w-[550px] items-center justify-between">
                <!-- back button -->


                <?php if (!$hideLayout): ?>
                    <a
                        href="<?= url('/') ?>"
                        class="text-white">
                        <svg
                            width="23"
                            height="23"
                            viewBox="0 0 23 23"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.25 0C12.2891 0 13.2852 0.132812 14.2383 0.398438C15.1914 0.664062 16.0898 1.03906 16.9336 1.52344C17.7773 2.00781 18.5352 2.59375 19.207 3.28125C19.8789 3.96875 20.4648 4.73047 20.9648 5.56641C21.4648 6.40234 21.8438 7.29688 22.1016 8.25C22.3594 9.20312 22.4922 10.2031 22.5 11.25C22.5 12.2891 22.3672 13.2852 22.1016 14.2383C21.8359 15.1914 21.4609 16.0898 20.9766 16.9336C20.4922 17.7773 19.9062 18.5352 19.2188 19.207C18.5312 19.8789 17.7695 20.4648 16.9336 20.9648C16.0977 21.4648 15.2031 21.8438 14.25 22.1016C13.2969 22.3594 12.2969 22.4922 11.25 22.5C10.2109 22.5 9.21484 22.3672 8.26172 22.1016C7.30859 21.8359 6.41016 21.4609 5.56641 20.9766C4.72266 20.4922 3.96484 19.9062 3.29297 19.2188C2.62109 18.5312 2.03516 17.7695 1.53516 16.9336C1.03516 16.0977 0.65625 15.2031 0.398438 14.25C0.140625 13.2969 0.0078125 12.2969 0 11.25C0 10.2109 0.132812 9.21484 0.398438 8.26172C0.664062 7.30859 1.03906 6.41016 1.52344 5.56641C2.00781 4.72266 2.59375 3.96484 3.28125 3.29297C3.96875 2.62109 4.73047 2.03516 5.56641 1.53516C6.40234 1.03516 7.29688 0.65625 8.25 0.398438C9.20312 0.140625 10.2031 0.0078125 11.25 0ZM11.25 21C12.1484 21 13.0117 20.8828 13.8398 20.6484C14.668 20.4141 15.4414 20.0859 16.1602 19.6641C16.8789 19.2422 17.5391 18.7344 18.1406 18.1406C18.7422 17.5469 19.25 16.8906 19.6641 16.1719C20.0781 15.4531 20.4062 14.6758 20.6484 13.8398C20.8906 13.0039 21.0078 12.1406 21 11.25C21 10.3516 20.8828 9.48828 20.6484 8.66016C20.4141 7.83203 20.0859 7.05859 19.6641 6.33984C19.2422 5.62109 18.7344 4.96094 18.1406 4.35938C17.5469 3.75781 16.8906 3.25 16.1719 2.83594C15.4531 2.42188 14.6758 2.09375 13.8398 1.85156C13.0039 1.60938 12.1406 1.49219 11.25 1.5C10.3516 1.5 9.48828 1.61719 8.66016 1.85156C7.83203 2.08594 7.05859 2.41406 6.33984 2.83594C5.62109 3.25781 4.96094 3.76562 4.35938 4.35938C3.75781 4.95312 3.25 5.60938 2.83594 6.32812C2.42188 7.04688 2.09375 7.82422 1.85156 8.66016C1.60938 9.49609 1.49219 10.3594 1.5 11.25C1.5 12.1484 1.61719 13.0117 1.85156 13.8398C2.08594 14.668 2.41406 15.4414 2.83594 16.1602C3.25781 16.8789 3.76562 17.5391 4.35938 18.1406C4.95312 18.7422 5.60938 19.25 6.32812 19.6641C7.04688 20.0781 7.82422 20.4062 8.66016 20.6484C9.49609 20.8906 10.3594 21.0078 11.25 21ZM8.51953 10.5H16.5V12H8.51953L11.7773 15.2109L10.7227 16.2891L5.63672 11.25L10.7227 6.21094L11.7773 7.28906L8.51953 10.5Z"
                                fill="currentColor"></path>
                        </svg>
                    </a>
                <?php else: ?>
                    <span></span>
                <?php endif ?>

                <a href="<?= url('login') ?>" class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#ffffff">
                        <path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z" />
                    </svg>
                    Login</a>
            </div>
        </header>
        <!-- header ends -->

        <!-- main starts -->
        <main class="mt-[55px] flex flex-col overflow-y-auto">
            <!-- banner -->

            <!-- Slider main container -->
            <?php echo $content ?? ''; ?>

            <!-- buy ticket container ends -->
        </main>
        <!-- main ends -->
    </div>
</body>

</html>