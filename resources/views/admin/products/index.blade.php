@extends('layouts.app')

@section('breadcrumb')

<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Admin</a>
            </li>
            <li class="breadcrumb-item active">
                <span>Products</span>
            </li>
        </ol>
    </nav>
</div>

@endsection

@section('content')
<div class="">
    <div class="mb-2 d-flex justify-content-between">
        <h2 class="m-0 align-self-end">Products</h2>
        <a href="{{route('admin.products.create')}}" class="btn btn-primary btn-lg rounded-0 text-white">
            <i class="bi bi-plus-lg"></i> Create Product
        </a>
    </div>
    <div class="card">
        <div class="card-body">
            {{ $dataTable->table() }}
        </div>
    </div>
</div>

{{-- Delete Modal --}}
<div class="modal fade" id="delete-confirmation" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h1 class="modal-title fs-5">Delete confirmation</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this record?
            </div>
            <div class="modal-footer">
                <input name="id" id="record-id" type="text" hidden>
                <button type="submit" class="btn btn-danger delete-record" data-bs-dismiss="modal">Delete</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')

{{ $dataTable->scripts(attributes: ['type' => 'module']) }}

<script>

    $(document).on('click','.delete-confirmation',function(){
        let id = $(this).attr('data-id');
        $('#record-id').val(id);
    });

    $(document).on('click', '.delete-record', function() {
        let id = $('#record-id').val();
        $.ajax({
            url: '/api/admin/products/delete/' + id,
            type: 'DELETE',
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-Token', '{{ csrf_token() }}');
            },
            success: function (data) {
                if (data.success) {
                    $('#datatable').DataTable().draw(false); // no pagination reset
                }
            }
        });     
    }); 

</script>


@endpush