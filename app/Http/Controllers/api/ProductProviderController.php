<?php

namespace App\Http\Controllers\api;

use App\Models\Provider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductProvider;

class ProductProviderController extends Controller
{
    //
    function index(){
        $products_prov = ProductProvider::all();
        if($products_prov->isNotEmpty()){
            return response()->json(['data' => $products_prov], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['data' => 'No products'], 404, [], JSON_UNESCAPED_UNICODE);
        }
    }

    function show($id){
        $product_prov = ProductProvider::find($id);
        if($product_prov){
            return response()->json(['data' => $product_prov], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['data' => 'Product no exists'], 404, [], JSON_UNESCAPED_UNICODE);
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
            ProductProvider::create($product_prov);
            return response()->json(['data' => 'Producto insertado correctamente'], 200, [], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e){
            return response()->json(['data' => 'Error al insertar el producto'], 404, [], JSON_UNESCAPED_UNICODE);
        }
    }
    function update(Request $request, $id){
        $product_prov = ProductProvider::find($id);

        if($product_prov){
            $product_prov->update($request->all());
          return response()->json(['data' => 'Producto actualizado correctamente'], 200, [], JSON_UNESCAPED_UNICODE);
        }
          else {
            return response()->json(['data' => 'Error al actualizar el producto'], 404, [], JSON_UNESCAPED_UNICODE);
        }

    }
    //curl -X DELETE http://localhost:8000/api/products/21
    function destroy($id){
        $deleted = ProductProvider::where('id', $id)->delete();

        if($deleted) {
            return response()->json(['data' => 'Producto eliminado con éxito'], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['data' => 'Error al eliminar el producto'], 404, [], JSON_UNESCAPED_UNICODE);
        }
    }
}
