$(function () {
    $(document).on("click", "#delete", function (e) {
        e.preventDefault();
        var link = $(this).attr("href");

        Swal.fire({
            title: "Are you sure?",
            text: "Delete This Data?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link;
                Swal.fire("Deleted!", "Your file has been deleted.", "success");
            }
        });
    });
});



document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.grid-item');
    const selectedRecordInput = document.getElementById('selectedRecord');

    // Add event listeners to each button
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const selectedValue = this.getAttribute('data-value'); // Get the data-value attribute

            // Set the hidden input's value
            selectedRecordInput.value = selectedValue;

            // Optionally, add visual feedback to the selected button
            buttons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
        });
    });
});




 document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.inputGgle');

    inputs.forEach(input => {
        // Check if the input has content to apply the 'filled' class
        input.addEventListener('input', function() {
            if (input.value.trim() !== '') {
                input.classList.add('filled');
            } else {
                input.classList.remove('filled');
            }
        });

        // Apply the 'focused' class on focus and remove on blur
        input.addEventListener('focus', function() {
            input.classList.add('focused');
        });

        input.addEventListener('blur', function() {
            input.classList.remove('focused');
        });
    });
});