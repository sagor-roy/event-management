<?php

$title = 'Event Attendee | My Application';
ob_start();
?>


<main>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <!-- Breadcrumb Start -->
        <div
            class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Event Attendee: <?=$event['name']?>
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
                        class="border-b border-stroke px-6.5 flex justify-end py-4 dark:border-strokedark">
                        <a href="<?= url('event/list') ?>" class="inline-flex items-center justify-center rounded-md bg-primary py-2 px-6 text-center font-medium text-white hover:bg-opacity-90 lg:px-6 xl:px-6">
                            Event List
                        </a>
                    </div>
                    <div
                        class="rounded-sm border border-stroke bg-white px-5 pb-2.5 pt-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
                        <div class="max-w-full overflow-x-auto">
                            <table class="w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                                        <th
                                            class="min-w-[220px] px-4 py-4 font-medium text-black dark:text-white xl:pl-11">
                                            Name
                                        </th>
                                        <th
                                            class="min-w-[150px] px-4 py-4 font-medium text-black dark:text-white">
                                            Email
                                        </th>
                                        <th
                                            class="min-w-[150px] px-4 py-4 font-medium text-black dark:text-white">
                                            Phone
                                        </th>
                                        <th
                                            class="min-w-[150px] px-4 py-4 font-medium text-black dark:text-white">
                                            Registered By
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['attendees'] as $row) { ?>
                                        <tr>
                                            <td
                                                class="border-b border-[#eee] px-4 py-5 pl-9 dark:border-strokedark xl:pl-11">
                                                <h5 class="font-medium text-black dark:text-white">
                                                    <?= $row['name'] ?>
                                                </h5>
                                            </td>
                                            <td
                                                class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                                <p class="text-black dark:text-white"><?= $row['email'] ?></p>
                                            </td>
                                            <td
                                                class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                                <p class="text-black dark:text-white"><?= $row['phone'] ?></p>
                                            </td>
                                            <td
                                                class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                                <p class="text-black dark:text-white"><?= date('M d, Y g:i A', strtotime($row['registered_at'])) ?></p>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                            <?php
                            if (!count($data['attendees']) > 0) {
                                echo '<h1 style="text-align: center; margin: 50px; font-size: 20px; font-weight: bold">No Attendee</h1>';
                            }
                            ?>
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


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function deleteEvent(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= url('event/delete/') ?>" + id,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        Swal.fire({
                            title: "Success",
                            text: response.message,
                            icon: "success",
                            confirmButtonText: "Close",
                        });

                        setInterval(() => {
                            window.location.href = "<?= url('event/list') ?>";
                        }, 1000);
                    },
                    error: function(error) {
                        Swal.fire({
                            title: "Opps!!",
                            text: error.responseJSON.message,
                            icon: "error",
                            confirmButtonText: "Close",
                        });
                    }
                });
            }
        })
    }
</script>


<?php
$content = ob_get_clean();
include(VIEWS_PATH . 'layouts/app.php');
?>