<table id="attributes-tbl" class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Attribute</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="attributesTableBody">
        @foreach($attributes as $attribute)
        <tr class="border-bottom">
            <td class="align-middle text-start">{{ $loop->iteration }}</td>
            <td class="align-middle text-start">
                <div class="fw-bold">{{ $attribute->name }}</div>
            </td>
            <td class="text-center align-middle">
                <div class="gap-2 d-flex justify-content-end">
                    <button class="btn btn-sm btn-outline-primary"
                        onclick="openEditModal(
                            '{{ $attribute->id }}',
                            '{{ addslashes($attribute->name) }}'
                        )">
                        Edit
                    </button>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
