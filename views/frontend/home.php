<?php

$title = 'Home | My Application';
ob_start();

?>

<img
    src="<?= asset('/src/images/banner.png') ?>"
    alt="bannger"
    class="w-full object-cover" />

<!-- buy ticket container -->
<div class="container">
    <div class="my-6">
        <div class="lg:mx-10 space-y-5">
            <!-- Ticket Card  -->
            <div class="block w-full rounded-md bg-gray-100 p-4 shadow-card">
                <h4 class="mb-2.5 text-md font-semibold text-dark">
                    DHAKA SESSIONS শীতের আড্ডা with KAAKTAAL
                </h4>
                <!-- ticket info -->
                <div class="space-y-3 mt-6">
                    <!-- date -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                                <path d="M200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Zm280 240q-17 0-28.5-11.5T440-440q0-17 11.5-28.5T480-480q17 0 28.5 11.5T520-440q0 17-11.5 28.5T480-400Zm-160 0q-17 0-28.5-11.5T280-440q0-17 11.5-28.5T320-480q17 0 28.5 11.5T360-440q0 17-11.5 28.5T320-400Zm320 0q-17 0-28.5-11.5T600-440q0-17 11.5-28.5T640-480q17 0 28.5 11.5T680-440q0 17-11.5 28.5T640-400ZM480-240q-17 0-28.5-11.5T440-280q0-17 11.5-28.5T480-320q17 0 28.5 11.5T520-280q0 17-11.5 28.5T480-240Zm-160 0q-17 0-28.5-11.5T280-280q0-17 11.5-28.5T320-320q17 0 28.5 11.5T360-280q0 17-11.5 28.5T320-240Zm320 0q-17 0-28.5-11.5T600-280q0-17 11.5-28.5T640-320q17 0 28.5 11.5T680-280q0 17-11.5 28.5T640-240Z" />
                            </svg>
                            <p>27th July 2024</p>
                        </div>
                    </div>
                    <!-- Time -->
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                            <path d="M480-480q33 0 56.5-23.5T560-560q0-33-23.5-56.5T480-640q-33 0-56.5 23.5T400-560q0 33 23.5 56.5T480-480Zm0 294q122-112 181-203.5T720-552q0-109-69.5-178.5T480-800q-101 0-170.5 69.5T240-552q0 71 59 162.5T480-186Zm0 106Q319-217 239.5-334.5T160-552q0-150 96.5-239T480-880q127 0 223.5 89T800-552q0 100-79.5 217.5T480-80Zm0-480Z" />
                        </svg>
                        <p>Dhaka</p>
                    </div>
                    <!-- Price -->
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                            <path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Zm80-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z" />
                        </svg>
                        <p>Total: 50 Sit</p>
                    </div>
                </div>
                <!-- ticket info ends -->
                <div class="mt-6">
                    <div class="flex items-center justify-between gap-2">
                        <!-- Buy Action -->
                        <div class="flex items-center gap-x-3">
                            <a href="<?=url('/details/slug')?>"
                                data-ticket-id="1"
                                class="openModalBtn effect-scale flex h-8 w-24 items-center justify-center rounded-lg bg-blue-400 text-xs font-medium text-white">
                                Register Now
                            </a>
                        </div>

                        <!-- Buy Action ends -->
                    </div>
                </div>
            </div>
            <!-- Ticket Card  ends -->
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include(VIEWS_PATH . 'layouts/frontend.php');
?>