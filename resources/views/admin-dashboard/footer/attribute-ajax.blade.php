<script>
    document.getElementById('selectAttr').addEventListener('change', function() {
        const selected = this.value;

        document.getElementById('createAttributeForm').action = "/" + selected;

        fetch(`/admin/attributes/fetch?type=${selected}`)
            .then(response => response.json())
            .then(data => {
                const tableBody = document.getElementById('attributesTableBody');
                tableBody.innerHTML = '';

                if (data.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="3" class="text-center">No attributes found</td></tr>`;
                    return;
                }

                data.forEach((attr, index) => {
                    const row = document.createElement('tr');
                    row.classList.add('border-bottom');
                    row.innerHTML = `
                    <td class="align-middle text-start">${index + 1}</td>
                    <td class="align-middle text-start">
                        <div class="fw-bold">${attr.name}</div>
                    </td>
                    <td class="text-center align-middle">
                        <div class="gap-2 d-flex justify-content-end">
                            <button class="btn btn-sm btn-outline-primary"
                                onclick="openEditModal('${attr.id}', '${attr.name.replace(/'/g, "\\'")}')">
                                Edit
                            </button>
                        </div>
                    </td>
                `;
                    tableBody.appendChild(row);
                });
            })
            .catch(error => {
                console.error('Error fetching attributes:', error);
            });
    });

    $('#createAttributeForm').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        openLoadingModal();

        let routeName = "/" + document.getElementById('selectAttr').value + "-table";

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
                    text: 'Attribute created successfully!',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    $('#createAttributeForm')[0].reset();
                    reloadTable('attributes-tbl', 'attributeTableWrapper', routeName);
                    closeLoadingModal();
                });
            },
            error: function(xhr) {
                handleAjaxError(xhr);
                closeLoadingModal();
            }
        });
    });

    $('#editAttributeForm').on('submit', function(e) {
        e.preventDefault();

        const form = this;
        const actionUrl = form.action; // dynamically set via JS
        const formData = new FormData(form);

        openLoadingModal();

        let routeName = "/" + document.getElementById('selectAttr').value + "-table";

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
                    text: 'Attribute updated successfully!',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    reloadTable('attributes-tbl', 'attributeTableWrapper', routeName);
                    document.getElementById('editAttributeForm').reset();
                    closeEditModal();
                    closeLoadingModal();
                });
            },
            error: function(xhr) {
                handleAjaxError(xhr);
                document.getElementById('editAttributeForm').reset();
                closeEditModal();
                closeLoadingModal();
            }
        });
    });

</script>