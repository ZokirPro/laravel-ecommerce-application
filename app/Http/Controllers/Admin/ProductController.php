<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Contracts\BrandContract;
use App\Contracts\CategoryContract;
use App\Contracts\ProductContract;
use App\Http\Controllers\BaseController;
use App\Http\Requests\StoreProductFormRequest;
class ProductController extends BaseController
{
    protected $brandRepository;

    protected $categoryRepository;

    protected $productRepository;

    public function __construct(
        BrandContract $brandRepository,
        CategoryContract $categoryRepository,
        ProductContract $productRepository
    )
    {
        $this->brandRepository = $brandRepository;
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }
    /********INDEX*************/
    public function index()
    {
        $products = $this->productRepository->listProducts();

        $this->setPageTitle('Products', 'Products List');
        return view('admin.products.index', compact('products'));
    }
    /**********CREATE VIEW************/
    public function create()
    {
        $brands = $this->brandRepository->listBrands('name', 'asc');
        $categories = $this->categoryRepository->listCategories('name', 'asc');

        $this->setPageTitle('Products', 'Create Product');
        return view('admin.products.create', compact('categories', 'brands'));
    }
    /**************STORE****************/
    public function store(StoreProductFormRequest $request)
    {
        $params = $request->except('_token');

        $product = $this->productRepository->createProduct($params);

        if (!$product) {
            
            return $this->responseRedirectBack('Error occurred while creating product.', 'error', true, true);
        }
       
        return $this->responseRedirect('admin.products.index', 'Product added successfully' ,'success',false, false);
    }
    /*******************EDIT*****************/
    public function edit($id)
    {
        $product = $this->productRepository->findProductById($id);
        $brands = $this->brandRepository->listBrands('name', 'asc');
        $categories = $this->categoryRepository->listCategories('name', 'asc');

        $this->setPageTitle('Products', 'Edit Product');
        return view('admin.products.edit', compact('categories', 'brands', 'product'));
    }
    /************UPDATE*******************/
    public function update(Request $request)
    {
        
        $this->validate($request,[
            'name'      =>  'required|max:255',
            'sku'       =>  'required',
             'brand_id'  =>  'required|not_in:0',
            'price'     =>  'required|regex:/^\d+(\.\d{1,2})?$/',
            'sale_price'     =>  'regex:/^\d+(\.\d{1,2})?$/', 
            'quantity'  =>  'required|numeric',
        ]); 

        
        $params = $request->except('_token');
        
        $product = $this->productRepository->updateProduct($params);
        
        if (!$product) {
            //return "1";
            return $this->responseRedirectBack('Error occurred while updating product.', 'error', true, true);
        }
           // return "2";
        return $this->responseRedirect('admin.products.index', 'Product updated successfully' ,'success',false, false);
    }
}   