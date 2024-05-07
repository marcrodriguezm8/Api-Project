<?php

namespace App\Http\Controllers\api;

use App\Models\Product;
use App\Models\Provider;
use Illuminate\Http\Request;
use App\Models\ProductProvider;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProductProviderController extends Controller
{
    //
    function index(){
        $products_prov = ProductProvider::join('products', 'products.id', '=', 'product_provider.product_id')
            ->join('providers', 'providers.id', '=', 'product_provider.provider_id')
            ->select('product_provider.id as product_provider_id', 'product_provider.product_id', 'product_provider.provider_id', 'product_provider.product_price',
            'product_provider.product_stock', 'products.*', 'providers.*')
            ->get();


        if($products_prov->isNotEmpty()){
            return response()->json(['data' => $products_prov], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['data' => 'No existen productos'], 404, [], JSON_UNESCAPED_UNICODE);
        }
    }

    function show($id){
        $product_prov = ProductProvider::where('product_id', $id)
            ->join('products', 'products.id', '=', 'product_provider.product_id')
            ->join('providers', 'providers.id', '=', 'product_provider.provider_id')
            ->select('product_provider.*', 'products.*', 'providers.*')
            ->get();


        if($product_prov){
            return response()->json(['data' => $product_prov], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['data' => 'Producto no existe'], 404, [], JSON_UNESCAPED_UNICODE);
        }
    }
    //curl -X POST -H "Content-Type: application/json" -d '{"product_name":"RTX 4080", "product_code":"admin", "product_category": "Tarjeta gráfica"}' http://localhost:8000/api/products/store
    function store(Request $request){
        $product_prov = $request->validate([
            'product_id' => 'required|integer',
            'provider_id' => 'required|integer',
            'product_price' => 'required|numeric',
            'product_stock' => 'required|integer',
        ]);

        try{
            $maxId = ProductProvider::max('id');
            $maxIdProduct = Product::max('id');
            $maxIdProvider = Provider::max('id');

            if($request->product_id > $maxIdProduct) throw new \Exception(': El id del producto no existe', 404);
            else if($request->provider_id > $maxIdProvider) throw new \Exception(': El id del proveedor no existe', 404);
            else $product_prov['id'] = $maxId + 1;

            ProductProvider::create($product_prov);
            return response()->json(['data' => 'Producto insertado correctamente'], 200, [], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e){
            if($e->getCode() == 404) return response()->json(['data' => 'Error al insertar el producto '.$e->getMessage()], 404, [], JSON_UNESCAPED_UNICODE);
            return response()->json(['data' => 'Error al insertar el producto'], 404, [], JSON_UNESCAPED_UNICODE);
        }
    }
    function update(Request $request, $id){
        $product_prov = ProductProvider::find($id);

        if($product_prov){
            try{
                $maxIdProduct = Product::max('id');
                $maxIdProvider = Provider::max('id');

                if($request->product_id > $maxIdProduct) throw new \Exception(': El id del producto no existe', 404);
                else if($request->provider_id > $maxIdProvider) throw new \Exception(': El id del proveedor no existe', 404);

                $product_prov->update($request->all());
                return response()->json(['data' => 'Producto actualizado correctamente'], 200, [], JSON_UNESCAPED_UNICODE);
            }
            catch(\Exception $e){
                if($e->getCode() == 404) return response()->json(['data' => 'Error al actualizar el producto '.$e->getMessage()], 404, [], JSON_UNESCAPED_UNICODE);
                return response()->json(['data' => 'Error al actualizar el producto'], 404, [], JSON_UNESCAPED_UNICODE);
            }
        }

    }
    //curl -X DELETE http://localhost:8000/api/products/21
    function destroy($id){
        try{
            $deleted = ProductProvider::where('id', $id)->delete();
            ProductProvider::where('id', '>', $id)->update(['id' => DB::raw('id - 1')]);;

            if($deleted) {
                return response()->json(['data' => 'Producto eliminado con éxito'], 200, [], JSON_UNESCAPED_UNICODE);
            } else {
                return response()->json(['data' => 'Error al eliminar el producto'], 404, [], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e){
            return response()->json(['data' => 'Error al eliminar el producto'], 404, [], JSON_UNESCAPED_UNICODE);
        }

    }
}
