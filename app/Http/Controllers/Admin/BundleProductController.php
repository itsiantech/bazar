<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BundleProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class BundleProductController extends Controller
{
    public function BundleProductsList()
    {
        $products = Product::whereHas('bundle_products')->get();

        return view("admin.products.index", compact( 'products'));
    }
    public function MakeBundle(Product $product)
    {
        $products = Product::select('name_en','id')->get();
        $product->load('bundle');
        $bundles = $product->BundleProducts();

        $total = $product->calculateBundleTotal($bundles);

        $bundleProductsId = collect($bundles)->pluck('id')->toArray();

        return view("admin.products.bundle", compact('product','products', 'bundles', 'bundleProductsId', 'total'));
    }

    public function SyncBundleProducts(Request $request, Product $product)
    {
        $form_data = $this->validate($request, [
            'product_id' => 'array',
            'product_id*' => 'integer',
            'discount' => 'required|numeric',
            'is_percent' => 'required',
        ]);

        try {

            DB::transaction(function() use($form_data, $product){
                if(array_key_exists('product_id', $form_data))
                {
                    $bundle = $product->bundle;
                    $product->syncBundles($form_data['product_id']);
                    unset($form_data['product_id']);
                    if(empty($bundle)) $product->bundle()->create($form_data);
                    else $product->bundle()->update($form_data);

                }
                else
                {
                    $product->bundle_products()->delete();
                    $product->bundle->delete();
                }
            });

        }catch (\Exception $e)
        {
            return back()->withErrors($e->getMessage());
        }

        return redirect()->route('product.makeBundle', ['product' => $product->id])->with('success', 'Bundle created successfully');

    }

    public function BundleProducts(Product $product)
    {
        $product->load('bundle');
        $products = $product->BundleProducts();
        return view("products.bundle", compact('product','products'));
    }

    public function update(Request $request, BundleProduct $bundle)
    {
        $form = $this->validate($request, [
            'quantity' => 'required'
        ]);
        $bundle->update($form);

        return redirect()->back()->withSuccess('Successfully updated');
    }
}
