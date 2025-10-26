<script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('passwordInput');
        const icon = this.querySelector('i');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    });

    function showError(inputId, message) {
        $(`#${inputId}Error`).text(message).removeClass('hidden');
    }

    function clearError(inputId) {
        $(`#${inputId}Error`).text('').addClass('hidden');
    }

    // Validate Name
    $('#nameInput').on('input', function() {
        const name = $(this).val();
        if (name.trim().length < 3) {
            showError('name', 'Name must be at least 3 characters.');
        } else {
            clearError('name');
        }
    });

    // Validate Email (optional uniqueness check)
    $('#emailInput').on('change', function() {
        const email = $(this).val();
        if (!email.includes('@') || !email.includes('.')) {
            showError('email', 'Invalid email address.');
            return;
        }

        // Optional: Check if email already exists
        $.ajax({
            url: '/check-email',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                email: email
            },
            success: function(res) {
                if (res.exists) {
                    showError('email', 'Email is already taken.');
                } else {
                    clearError('email');
                }
            }
        });
    });

    // Validate Password
    $('#passwordInput').on('input', function() {
        const password = $(this).val();
        if (password.length > 0 && password.length < 6) {
            showError('password', 'Password must be at least 6 characters.');
        } else {
            clearError('password');
        }
    });

    $('#updateAccountForm').on('submit', function(e) {
        e.preventDefault();

        let form = this;
        let formData = new FormData(form);

        $.ajax({
            url: "{{ route('account.update') }}",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-HTTP-Method-Override': 'PUT'
            },

            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "/login"; // Redirect after alert
                });
            },
            error: function(xhr) {
                handleAjaxError(xhr);
            }
        });
    });
</script>