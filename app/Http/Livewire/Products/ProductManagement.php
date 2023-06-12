<?php

namespace App\Http\Livewire\Products;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Livewire\WithPagination;

class ProductManagement extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';



    public $category_name, $name, $price, $category, $category_id ;
    public $updateMode = false;

    public $deleteId = '';

    public $products=[];


    protected $rules=[
        'category_name' => 'required|string',
        'products.*.name' => 'required|string',
        'products.*.price' =>'required|numeric|min:0',
    ];



    protected $messages = [
        'products.*.name.required' => 'The prdouct name field is required.',
        'products.*.price.required' => 'This Price field is required',
        'products.*.price.numeric' => 'Please enter a valid price',
    ];

    public function updated($propertyName){

       $this->validateOnly($propertyName);

    }


    public function mount()
    {
        if($this->updateMode == false) {
            $this->fill([
                'products' => collect([['category_id'=> '',  'name' => '','price' => '']]),
            ]);
        }

    }


    public function addInput()
    {   if($this->updateMode) {
            $this->products[] = (['category_id'=> '','option' =>'','price' => '']);
         } else {
            $this->products->push([ 'category_id'=> '', 'name' => '','price' => '']);
         }

    }

    public function removeInput($index)
    {    if($this->updateMode) {
            unset($this->products[$index]);
            $this->products = array_values($this->products);
         } else {
            $this->products->pull($index);

         }
    }

    public function store() {

        $this->validate();

        $category  =  Category::Create([
            'category_name' => $this->category_name,
        ]);

        foreach($this->products as $key => $value){
            Product::create(['name' => $value['name'], 'price' => $value['price'], 'category_id'=> $category->id, 'created_at' => Carbon::now(), 'updated_at'=> Carbon::now()]);
        }

        session()->flash('message', 'Product Created Successfully.');
        $this->resetField();
    }


    public function edit($id) {
        $this->products=[];
        $category =  Category::find($id);
        $this->category_id = $id;
        $this->category_name = $category->category_name;

        $products = product::where('category_id', $id)->get();

        foreach($products as $key => $value){
            $this->products[] = ['name' => $value->name,'price' => $value->price];
        }

        $this->updateMode = true;
    }

    public function update() {

        $this->validate();

        Category::where('id', $this->category_id)->update(["category_name" => $this->category_name]);

        Product::whereCategoryId($this->category_id)->delete();

        foreach($this->products as $key => $value){
           Product::create( ['name' => $value['name'], 'price' => $value['price'], 'category_id' => $this->category_id, 'created_at' => Carbon::now(), 'updated_at'=> Carbon::now()]);
        }

        $this->updateMode = false;

        session()->flash('message', 'Product Updated Successfully.');

        $this->resetField();
    }


    public function cancel()
    {
        $this->updateMode = false;
        $this->resetField();
    }


    private function resetField() {
        $this->category_name = "";
        $this->products=[];
        $this->fill([
            'products' => collect([['category_id'=> '',  'name' => '','price' => '']]),
        ]);
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;

        $this->dispatchBrowserEvent('show-delete-modal');
    }

    public function delete()
    {
        Category::find($this->deleteId)->delete();
        session()->flash('message', 'Category Deleted Successfully.');
    }

    public function render()
    {

        return view('livewire.products.product-management', [
            "categories" => Category::orderBy('id', 'DESC')->paginate(5)
        ]);
    }
}
