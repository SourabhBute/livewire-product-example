<div>
    <form wire:submit.prevent="store">
        <div class="add-input">
            <div class="col-md-5 mx-n3">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Enter category name" wire:model="category_name">
                    @error('category_name') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="row justify-content-end">
                <div class="col-md-2 ">
                    <button class="btn text-white btn-info btn-sm position-absolute" wire:click.prevent="addInput">Add</button>
                </div>
            </div>
        </div>

        @foreach($products as $key => $product)
            <div class=" add-input">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Enter product name" wire:model.lazy="products.{{$key}}.name">
                            @error('products.'.$key.'.name') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <input type="text" class="form-control" wire:model.lazy="products.{{$key}}.price" placeholder="Enter product price">
                            @error('products.'.$key.'.price') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    @if($key > 0)
                    <div class="col-md-2">
                        <button class="btn btn-danger btn-sm" wire:click.prevent="removeInput({{$key}})">Remove</button>
                    </div>
                    @endif
                </div>
            </div>
        @endforeach

        <div class="row">
            <div class="col-md-12">
                <button type="button" wire:click.prevent="store()" class="btn btn-primary btn-sm">Create</button>

            </div>
        </div>

    </form>
</div>
