$(document).ready(function () {
    NProgress.start(); // Start loader on page load

    $(window).on("load", function () {
        NProgress.done(); // Stop loader when page is fully loaded
    });

    // Show loader on AJAX request
    $(document).ajaxStart(function () {
        NProgress.start();
    });

    $(document).ajaxStop(function () {
        NProgress.done();
    });

    // Livewire Hook (if using Livewire)
    $(document).on("livewire:load", function () {
        Livewire.hook('message.sent', function () {
            NProgress.start();
        });
        Livewire.hook('message.received', function () {
            NProgress.done();
        });
    });
});