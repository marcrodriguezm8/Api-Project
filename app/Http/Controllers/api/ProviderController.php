<?php

namespace App\Http\Controllers\api;

use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProviderController extends Controller
{
    //
    function index(){
        $providers = Provider::all();
        if($providers->isNotEmpty()){
            return response()->json(['data' => $providers], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['data' => 'No existen proveedores'], 404, [], JSON_UNESCAPED_UNICODE);
        }
    }

    function show($id){
        $provider = Provider::find($id);
        if($provider){
            return response()->json(['data' => $provider], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['data' => 'Proveedor no existe'], 404, [], JSON_UNESCAPED_UNICODE);
        }
    }
    //curl -X POST -H "Content-Type: application/json" -d '{"product_name":"RTX 4080", "product_code":"admin", "product_category": "Tarjeta gráfica"}' http://localhost:8000/api/products/store
    function store(Request $request){
        $provider = $request->validate([
            'provider_name' => 'required|string',
            'provider_phone' => 'nullable|string',
            'provider_email' => 'required|string',
            'provider_location' => 'required|string',
        ]);

        $maxId = Provider::max('id');
        $provider['id'] = $maxId + 1;
        try{
            Provider::create($provider);
            return response()->json(['data' => 'Proveedor insertado correctamente'], 200, [], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e){
            if($e->getCode() == 23000) return response()->json(['data' => 'El nombre o el email ya existen'], 404, [], JSON_UNESCAPED_UNICODE);
            return response()->json(['data' => 'Error al insertar el proveedor'], 404, [], JSON_UNESCAPED_UNICODE);
        }
    }
    function update(Request $request, $id){
        $provider = Provider::find($id);

        if($provider){
            try{
                $provider->update($request->all());
                return response()->json(['data' => 'Proveedor actualizado correctamente'], 200, [], JSON_UNESCAPED_UNICODE);
            }
            catch(\Exception $e){
                if($e->getCode() == 23000) return response()->json(['data' => 'El nombre o el email ya existen'], 404, [], JSON_UNESCAPED_UNICODE);
                return response()->json(['data' => 'Error al actualizar el proveedor'], 404, [], JSON_UNESCAPED_UNICODE);
            }

        }

    }
    //curl -X DELETE http://localhost:8000/api/products/21
    function destroy($id){
        try{
            $deleted = Provider::where('id', $id)->delete();
            Provider::where('id', '>', $id)->update(['id' => DB::raw('id - 1')]);

            if($deleted) {
                return response()->json(['data' => 'Proveedor eliminado con éxito'], 200, [], JSON_UNESCAPED_UNICODE);
            } else {
                return response()->json(['data' => 'Error al eliminar el proveedor'], 404, [], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e){
            return response()->json(['data' => 'Error al eliminar el proveedor'], 404, [], JSON_UNESCAPED_UNICODE);
        }

    }
}
