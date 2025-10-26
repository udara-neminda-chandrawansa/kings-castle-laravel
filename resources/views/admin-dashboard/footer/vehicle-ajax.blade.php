<script>
    $('#createCarForm').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        openLoadingModal();

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'Accept': 'application/json' // 🔥 Important
            },
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Vehicle created successfully!',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    $('#createCarForm')[0].reset();
                    reloadTable('vehicles-tbl','vehicleTableWrapper','/vehicle-table');
                    closeLoadingModal();
                });
            },
            error: function(xhr) {
                handleAjaxError(xhr);
                closeLoadingModal();
            }
        });
    });

    $('#editVehicleForm').on('submit', function(e) {
        e.preventDefault();

        const form = this;
        const actionUrl = form.action; // dynamically set via JS
        const formData = new FormData(form);

        openLoadingModal();

        console.log("action url: " + actionUrl);
        for (let [key, value] of formData.entries()) {
            console.log(`${key}:`, value);
        }

        // Add method spoofing for PUT request
        formData.append('_method', 'PUT');

        $.ajax({
            url: actionUrl,
            method: 'POST', // Keep as POST since we're spoofing
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'Accept': 'application/json'
            },
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Vehicle updated successfully!',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    reloadTable('vehicles-tbl','vehicleTableWrapper','/vehicle-table');
                    document.getElementById('editVehicleForm').reset();
                    closeEditModal();
                    closeLoadingModal();
                });
            },
            error: function(xhr) {
                handleAjaxError(xhr);
                document.getElementById('editVehicleForm').reset();
                closeEditModal();
                closeLoadingModal();
            }
        });
    });

    $(document).on('submit', '.delete-vehicle-form', function(e) {
        e.preventDefault();

        const form = this;
        const actionUrl = form.action;

        openLoadingModal();

        // Optional: show confirmation with SweetAlert
        Swal.fire({
            title: 'Are you sure?',
            text: "This vehicle and its images will be permanently deleted.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: actionUrl,
                    method: 'POST',
                    data: $(form).serialize(),
                    headers: {
                        'X-HTTP-Method-Override': 'DELETE'
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Vehicle deleted successfully!',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            reloadTable('vehicles-tbl','vehicleTableWrapper','/vehicle-table');
                            closeLoadingModal();
                        });
                    },
                    error: function(xhr) {
                        handleAjaxError(xhr);
                        closeLoadingModal();
                    }
                });
            }else{
                closeLoadingModal();
            }
        });
    });
</script>