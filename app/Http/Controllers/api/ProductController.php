<?php

namespace App\Http\Controllers\api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    //
    function index(){
        $products = Product::all();
        if($products->isNotEmpty()){
            return response()->json(['data' => $products], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['data' => 'No existen productos'], 404, [], JSON_UNESCAPED_UNICODE);
        }
    }

    function show($id){
        $product = Product::find($id);
        if($product){
            return response()->json(['data' => $product], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['data' => 'Producto no existe'], 404, [], JSON_UNESCAPED_UNICODE);
        }
    }
    //curl -X POST -H "Content-Type: application/json" -d '{"product_name":"RTX 4080", "product_code":"admin", "product_category": "Tarjeta gráfica"}' http://localhost:8000/api/products/store
    function store(Request $request){
        $request->validate([
            'product_name' => 'required|string',
            'product_category' => 'required|string',
        ]);
        $lastCode = Product::all()->last();
        $lastCode = (int)substr($lastCode->product_code, 14);
        $lastCode++;

        $now = new \DateTime();
        $code = $now->format('YdmHis').$lastCode;

        $maxId = Product::max('id');

        $productData = [
            'id' => $maxId + 1,
            "product_name" => $request->product_name,
            "product_category" => $request->product_category,
            "product_code" => $code,
        ];

        try{
            Product::create($productData);
            return response()->json(['data' => 'Producto insertado correctamente'], 200, [], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e){
            if($e->getCode() == 23000) return response()->json(['data' => 'Producto ya existe'], 404, [], JSON_UNESCAPED_UNICODE);
            return response()->json(['data' => 'Error al insertar el producto'], 404, [], JSON_UNESCAPED_UNICODE);
        }
    }
    function update(Request $request, $id){
        $product = Product::find($id);

        if($product){
            try{
                $product->update($request->all());
                return response()->json(['data' => 'Producto actualizado correctamente'], 200, [], JSON_UNESCAPED_UNICODE);
            }
            catch(\Exception $e){
                if($e->getCode() == 23000) return response()->json(['data' => 'Error al actualizar el producto, el nombre ya existe'], 404, [], JSON_UNESCAPED_UNICODE);
                return response()->json(['data' => 'Error al actualizar el producto'], 404, [], JSON_UNESCAPED_UNICODE);
            }

        }

    }

    function destroy($id){
        try{
            $deleted = Product::where('id', $id)->delete();
            Product::where('id', '>', $id)->update(['id' => DB::raw('id - 1')]);;

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
