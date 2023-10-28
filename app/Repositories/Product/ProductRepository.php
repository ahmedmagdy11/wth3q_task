<?php

namespace App\Repositories\Product;

use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class ProductRepository implements ProductRepositoryInterface {
    private $product;
    public function __construct(Product $product) {
        $this->product = $product;
    }

    public function getAll() {
        return $this->product
            ->active()
            ->paginate();
    }

    public function getById($id) {
        return $this->product->find($id);
    }

    public function create($request) {
        $data = $request->only([
            'name',
            'description',
            'price',
            'image',
            'slug',
            'is_active',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products');
        }
        return $this->product->create($data);
    }

    public function update($request, $id) {
        $data = $request->only([
            'name',
            'description',
            'price',
            'image',
            'slug',
            'is_active',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products');
        }
        $product = $this->product->find($id);
        if (Arr::has($data, 'image') && $product->image) {
            Storage::delete($product->image);
        }
        return $product->update($data);
    }

    public function delete($id) {
        return $this->product->destroy($id);
    }

}
