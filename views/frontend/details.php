<?php

$title = 'Details | My Application';
ob_start();

?>

<div class="space-y-3 bg-gray-300 py-20 text-center">
    <h1 class="text-2xl font-bold">
        Lorem ipsum dolor sit amet consectetur
    </h1>
    <h1><span class="font-bold">Deadline:</span> Jan 05, 2025</h1>
    <h1><span class="font-bold">Location:</span> Dhaka</h1>
</div>

<!-- buy ticket container -->
<div class="container">
    <div class="my-6">
        <form class="w-full p-6">
            <h2 class="mb-6 text-center text-2xl font-bold">Register Form</h2>

            <div class="mb-4">
                <label class="mb-2 block font-medium text-gray-700" for="name">Name</label>
                <input
                    type="text"
                    id="name"
                    class="w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Enter your name" />
            </div>

            <div class="mb-4">
                <label class="mb-2 block font-medium text-gray-700" for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    class="w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Enter your email" />
            </div>

            <div class="mb-4">
                <label class="mb-2 block font-medium text-gray-700" for="phone">Phone</label>
                <input
                    type="tel"
                    id="phone"
                    class="w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Enter your phone number" />
            </div>

            <button
                type="submit"
                class="w-full rounded-lg bg-blue-500 py-2 text-white transition hover:bg-blue-600">
                Submit
            </button>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include(VIEWS_PATH . 'layouts/frontend.php');
?>