<div>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if($updateMode)
        @include('livewire.products.update')
    @else
        @include('livewire.products.create')
    @endif

    <table class="table table-bordered mt-5">
        <thead>
            <tr>
                <th>Category Name</th>
                <th>Created At</th>
                <th width="150px">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->category_name }}</td>
                <td>{{ $category->created_at->format("m/d/Y") }}</td>
                <td >
                    <button wire:click="edit({{ $category->id }})" class="btn btn-primary btn-sm">Edit</button>
                    <button type="button" wire:click.prevent="deleteId({{ $category->id }})" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmationModal">Delete</button>


                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
    {{ $categories->links() }}

    <div wire:ignore.self class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Confirm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true close-btn">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                    <button type="button" wire:click.prevent="delete()" class="btn btn-danger close-modal" data-dismiss="modal">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>




</div>



