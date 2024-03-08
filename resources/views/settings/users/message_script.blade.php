<script>
    // Select/Deselect all checkboxes
    document.getElementById("selectAllCheckboxes").addEventListener("change", function() {
        let checkboxes = document.querySelectorAll(".userCheckbox");
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = event.target.checked;
        });
    });

    // Show message modal when the message button is clicked
    document.getElementById("messageButton").addEventListener("click", function() {
        let checkedCheckboxes = document.querySelectorAll(".userCheckbox:checked");
        if (checkedCheckboxes.length > 0) {
            $('#messageModal').modal('show');
        } else {
            alert("Please select at least one user to send a message.");
        }
    });

    // Send message functionality
    document.getElementById("sendMessageButton").addEventListener("click", function() {
        let checkedCheckboxes = document.querySelectorAll(".userCheckbox:checked");
        let userIds = Array.from(checkedCheckboxes).map(function(checkbox) {
            return checkbox.value;
        });
        let message = document.getElementById("message").value;

        // Create a form dynamically
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route('users.message') }}';
        form.style.display = 'none';

        // Add CSRF token input
        let csrfTokenInput = document.createElement('input');
        csrfTokenInput.type = 'hidden';
        csrfTokenInput.name = '_token';
        csrfTokenInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfTokenInput);

        // Add users input
        userIds.forEach(function(userId) {
            let userIdInput = document.createElement('input');
            userIdInput.type = 'hidden';
            userIdInput.name = 'users[]';
            userIdInput.value = userId;
            form.appendChild(userIdInput);
        });

        // Add message input
        let messageInput = document.createElement('input');
        messageInput.type = 'hidden';
        messageInput.name = 'message';
        messageInput.value = message;
        form.appendChild(messageInput);

        // Append the form to the body and submit it
        document.body.appendChild(form);
        form.submit();
    });
</script>