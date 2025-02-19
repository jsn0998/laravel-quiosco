<?php

namespace App\Http\Controllers;

use App\Http\Resources\PedidoCollection;
use App\Models\Pedido;
use App\Models\PedidoProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return "correcto... ";
        return new PedidoCollection(Pedido::with('user')->with('productos')->where('estado',0)->get());// with, adiiona el resultado del metodo user a la consulta

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Almacenar un pedido
        $pedido = new Pedido;
        $pedido->user_id = Auth::user()->id;
        $pedido->total = $request->total;
        $pedido->save();

        // Obtener el ID del producto
        $id = $pedido->id;

        // Obtener los productos
        $productos = $request->productos;

        // Formatear un producto
        $pedido_producto = [];

        foreach ($productos as $key => $producto) {
            $pedido_producto[] = [
                'pedido_id'=>$id,
                'producto_id'=>$producto['id'],
                'cantidad'=>$producto['cantidad'],
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ];
        }

        // Almacenar en la BD
        PedidoProducto::insert($pedido_producto);

        return [
            // 'message'=>'Relaizando pedido'.$pedido->id,
            // 'productos'=>$request->productos
            'message'=> 'Pedido realizado correctamente, estara listo en unos minutos'
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {
        $pedido->estado = 1;
        $pedido->save();

        return [
            'pedido'=>$pedido,
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        //
    }
}
