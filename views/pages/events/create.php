<?php
$title = 'Create Event | My Application';
ob_start();

$event_action = isset($status) && $status === 'edit' ? 'Edit' : 'Create';
$event_action_url = isset($status) && $status === 'edit' ? url('event/update/' . $event['id']) : url('event/store');

$values = [
    'name' => isset($event['name']) ? $event['name'] : '',
    'date' => isset($event['date']) ? date('M d, Y', strtotime($event['date'])) : '',
    'location' => isset($event['location']) ? $event['location'] : '',
    'max_capacity' => isset($event['max_capacity']) ? $event['max_capacity'] : '',
    'status' => isset($event['status']) ? $event['status'] : '',
    'description' => isset($event['description']) ? $event['description'] : '',
];
?>


<main>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <!-- Breadcrumb Start -->
        <div
            class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Event <?= $event_action ?>
            </h2>

            <nav>
                <ol class="flex items-center gap-2">
                    <li>
                        <a class="font-medium" href="index.html">Dashboard /</a>
                    </li>
                    <li class="font-medium text-primary"><?= $event_action ?></li>
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

                    <div id="errors" style="margin:20px;"></div>

                    <form id="submitForm">
                        <div class="p-6.5">
                            <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div class="w-full xl:w-1/2">
                                    <label
                                        class="mb-3 block text-sm font-medium text-black dark:text-white">
                                        Event Name <sup style="color: red;">*</sup>
                                    </label>
                                    <input
                                        value="<?= $values['name'] ?>"
                                        name="name"
                                        type="text"
                                        placeholder="Event Name"
                                        class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                </div>

                                <div class="w-full xl:w-1/2">
                                    <label
                                        class="mb-3 block text-sm font-medium text-black dark:text-white">
                                        Event Date <sup style="color: red;">*</sup>
                                    </label>
                                    <div class="relative">
                                        <input
                                            value="<?= $values['date'] ?>"
                                            name="date"
                                            class="form-datepicker w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                            placeholder="mm/dd/yyyy"
                                            data-class="flatpickr-right" />

                                        <div
                                            class="pointer-events-none absolute inset-0 left-auto right-5 flex items-center">
                                            <svg
                                                width="18"
                                                height="18"
                                                viewBox="0 0 18 18"
                                                fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M15.7504 2.9812H14.2879V2.36245C14.2879 2.02495 14.0066 1.71558 13.641 1.71558C13.2754 1.71558 12.9941 1.99683 12.9941 2.36245V2.9812H4.97852V2.36245C4.97852 2.02495 4.69727 1.71558 4.33164 1.71558C3.96602 1.71558 3.68477 1.99683 3.68477 2.36245V2.9812H2.25039C1.29414 2.9812 0.478516 3.7687 0.478516 4.75308V14.5406C0.478516 15.4968 1.26602 16.3125 2.25039 16.3125H15.7504C16.7066 16.3125 17.5223 15.525 17.5223 14.5406V4.72495C17.5223 3.7687 16.7066 2.9812 15.7504 2.9812ZM1.77227 8.21245H4.16289V10.9968H1.77227V8.21245ZM5.42852 8.21245H8.38164V10.9968H5.42852V8.21245ZM8.38164 12.2625V15.0187H5.42852V12.2625H8.38164V12.2625ZM9.64727 12.2625H12.6004V15.0187H9.64727V12.2625ZM9.64727 10.9968V8.21245H12.6004V10.9968H9.64727ZM13.8379 8.21245H16.2285V10.9968H13.8379V8.21245ZM2.25039 4.24683H3.71289V4.83745C3.71289 5.17495 3.99414 5.48433 4.35977 5.48433C4.72539 5.48433 5.00664 5.20308 5.00664 4.83745V4.24683H13.0504V4.83745C13.0504 5.17495 13.3316 5.48433 13.6973 5.48433C14.0629 5.48433 14.3441 5.20308 14.3441 4.83745V4.24683H15.7504C16.0316 4.24683 16.2566 4.47183 16.2566 4.75308V6.94683H1.77227V4.75308C1.77227 4.47183 1.96914 4.24683 2.25039 4.24683ZM1.77227 14.5125V12.2343H4.16289V14.9906H2.25039C1.96914 15.0187 1.77227 14.7937 1.77227 14.5125ZM15.7504 15.0187H13.8379V12.2625H16.2285V14.5406C16.2566 14.7937 16.0316 15.0187 15.7504 15.0187Z"
                                                    fill="#64748B" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div class="w-full xl:w-1/2">
                                    <label
                                        class="mb-3 block text-sm font-medium text-black dark:text-white">
                                        Event Location <sup style="color: red;">*</sup>
                                    </label>
                                    <input
                                        value="<?= $values['location'] ?>"
                                        name="location"
                                        type="text"
                                        placeholder="Location"
                                        class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                </div>

                                <div class="w-full xl:w-1/2">
                                    <label
                                        class="mb-3 block text-sm font-medium text-black dark:text-white">
                                        Event Capacity <sup style="color: red;">*</sup>
                                    </label>
                                    <input
                                        value="<?= $values['max_capacity'] ?>"
                                        name="max_capacity"
                                        type="number" min="1"
                                        placeholder="Capacity"
                                        class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                </div>
                            </div>

                            <div class="w-full mb-4.5">
                                <label
                                    class="mb-3 block text-sm font-medium text-black dark:text-white">
                                    Select Option <sup style="color: red;">*</sup>
                                </label>
                                <div
                                    class="relative z-20 bg-white dark:bg-form-input">
                                    <select
                                        name="status"
                                        class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 pl-5 pr-12 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input"
                                        :class="isOptionSelected && 'text-black dark:text-white'">
                                        <option value="1" <?php echo $values['status'] == '1' ? 'selected' : ''; ?>>Active</option>
                                        <option value="0" <?php echo $values['status'] == '0' ? 'selected' : ''; ?>>Inactive</option>
                                    </select>
                                    <span
                                        class="absolute right-4 top-1/2 z-10 -translate-y-1/2">
                                        <svg
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g opacity="0.8">
                                                <path
                                                    fill-rule="evenodd"
                                                    clip-rule="evenodd"
                                                    d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z"
                                                    fill="#637381"></path>
                                            </g>
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div class="mb-6">
                                <label
                                    class="mb-3 block text-sm font-medium text-black dark:text-white">
                                    Description <sup style="color: red;">*</sup>
                                </label>
                                <textarea
                                    name="description"
                                    rows="6"
                                    placeholder="Event Details"
                                    class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"><?= $values['description'] ?></textarea>
                            </div>

                            <button
                                type="submit" id="submit-button"
                                class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
                                <?= $event_action ?> Event
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- ====== Form Layout Section End -->
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#submitForm").submit(function(e) {
            e.preventDefault();

            var submitButton = $("#submit-button");
            submitButton.prop('disabled', true);
            submitButton.text("Loading...");

            $.ajax({
                url: "<?= $event_action_url ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    Swal.fire({
                        title: "Success",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "Close",
                    });

                    $('#errors').html('');

                    if ("<?= $event_action ?>" == 'Create') {
                        $("#submitForm")[0].reset();
                    }
                },
                error: function(error) {

                    $('#errors').html('');
                    let errorList = $('<ul class="error-list"></ul>');

                    if (error.status == 400) {
                        let errorsData = error.responseJSON.data;

                        Swal.fire({
                            title: "Opps!!",
                            text: error.responseJSON.message,
                            icon: "error",
                            confirmButtonText: "Close",
                        });

                        errorList.append('<li class="error-item">' + error.responseJSON.message + '</li>');

                        $.each(errorsData, function(field, messages) {
                            $.each(messages, function(index, message) {
                                errorList.append('<li class="error-item">' + message + '</li>');
                            });
                        });
                        $('#errors').append(errorList);
                    } else {
                        errorList.append('<li class="error-item">' + error.responseJSON.message + '</li>');
                        $('#errors').append(errorList);
                    }
                },
                complete: function() {
                    submitButton.prop('disabled', false);
                    submitButton.text("<?= $event_action ?> Event");
                }
            });
        });
    });
</script>


<?php
$content = ob_get_clean();
include(VIEWS_PATH . 'layouts/app.php');
?>