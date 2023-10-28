<?php

namespace App\Http\Controllers;

use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller {
    // Resource Controller 

    private $createRules = [
        'name' => 'required|string',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'is_active' => 'required|boolean',
        'slug' => 'required|string|unique:products,slug',

    ];

    private $updateRules = [
        'name' => 'string',
        'description' => 'string',
        'price' => 'numeric',
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'is_active' => 'boolean',
        'slug' => 'string|unique:products,slug',
    ];

    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository) {
        $this->productRepository = $productRepository;
    }

    public function index() {
        try {
            $products = $this->productRepository->getAll();
            return _api_json($products);
        } catch (\Exception $e) {
            $message = _lang('app.something_went_wrong');
            return _api_json([], ['message' => $message], 400);
        }
    }

    public function store(Request $request) {
        try {
            $validator = Validator::make($request->all(), $this->createRules);
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return _api_json([], ['errors' => $errors], 400);
            }
            DB::beginTransaction();
            $product = $this->productRepository->create($request);
            DB::commit();
            return _api_json($product, ['message' => _lang('app.created_successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = _lang('app.something_went_wrong');
            return _api_json([], ['message' => $message], 400);
        }
    }

    public function show($id) {
        try {
            $product = $this->productRepository->getById($id);
            if (!$product) {
                $message = _lang('app.not_found');
                return _api_json([], ['message' => $message], 404);
            }
            return _api_json($product);
        } catch (\Exception $e) {
            $message = _lang('app.something_went_wrong');
            return _api_json([], ['message' => $message], 400);
        }
    }

    public function update(Request $request, $id) {
        try {
            $validator = Validator::make($request->all(), $this->updateRules);
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return _api_json([], ['errors' => $errors], 400);
            }

            $product = $this->productRepository->getById($id);
            if (!$product) {
                $message = _lang('app.not_found');
                return _api_json([], ['message' => $message], 404);
            }
            DB::beginTransaction();
            $product = $this->productRepository->update($request, $id);
            DB::commit();
            return _api_json($product, ['message' => _lang('app.updated_successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = _lang('app.something_went_wrong');
            return _api_json([], ['message' => $message], 400);
        }
    }

    public function destroy($id) {
        try {
            $product = $this->productRepository->getById($id);
            if (!$product) {
                $message = _lang('app.not_found');
                return _api_json([], ['message' => $message], 404);
            }
            DB::beginTransaction();
            $this->productRepository->delete($id);
            DB::commit();
            return _api_json([], ['message' => _lang('app.deleted_successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = _lang('app.something_went_wrong');
            return _api_json([], ['message' => $message], 400);
        }
    }
}
