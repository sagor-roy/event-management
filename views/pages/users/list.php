<?php

$title = 'Users List | My Application';
ob_start();
?>


<main>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <!-- Breadcrumb Start -->
        <div
            class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Users List
            </h2>

            <nav>
                <ol class="flex items-center gap-2">
                    <li>
                        <a class="font-medium" href="index.html">Dashboard /</a>
                    </li>
                    <li class="font-medium text-primary">List</li>
                </ol>
            </nav>
        </div>
        <!-- Breadcrumb End -->

        <!-- ====== Form Layout Section Start -->
        <div class="grid grid-cols-1 gap-9">
            <div class="flex flex-col gap-9">
                <!-- Contact Form -->
                <div
                    class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div
                        class="border-b border-stroke px-6.5 flex py-4 dark:border-strokedark">
                        <h1>Users </h1>
                    </div>
                    <div
                        class="rounded-sm border border-stroke bg-white px-5 pb-2.5 pt-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
                        <div class="max-w-full overflow-x-auto">
                            <table class="w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                                        <th
                                            class="min-w-[220px] px-4 py-4 font-medium text-black dark:text-white xl:pl-11">
                                            No.
                                        </th>
                                        <th
                                            class="min-w-[150px] px-4 py-4 font-medium text-black dark:text-white">
                                            Name
                                        </th>
                                        <th
                                            class="min-w-[150px] px-4 py-4 font-medium text-black dark:text-white">
                                            Email
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['users'] as $row) { ?>
                                        <tr>
                                            <td
                                                class="border-b border-[#eee] px-4 py-5 pl-9 dark:border-strokedark xl:pl-11">
                                                <h5 class="font-medium text-black dark:text-white">
                                                    <?=$row['id']?>
                                                </h5>
                                            </td>
                                            <td
                                                class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                                <p class="text-black dark:text-white"><?=$row['name']?></p>
                                            </td>
                                            <td
                                                class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                                <p class="text-black dark:text-white"><?=$row['email']?></p>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <?= renderPerPageDropdown() ?>
                        <?= renderPaginationLinks($data['pagination']['current_page'], $data['pagination']['total_pages'], $data['pagination']['per_page']) ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- ====== Form Layout Section End -->
    </div>
</main>


<?php
$content = ob_get_clean();
include(VIEWS_PATH . 'layouts/app.php');
?>