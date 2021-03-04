<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ClienteExport;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $opcion = $request->opcion;

        $clientes = Cliente::where($opcion, 'like', '%' . $buscar . '%')
            ->orderBy($opcion, 'asc')
            ->paginate(5);

        $result = [
            'pagination' => [
                'total'        => $clientes->total(),
                'current_page' => $clientes->currentPage(),
                'per_page'     => $clientes->perPage(),
                'last_page'    => $clientes->lastPage(),
                'from'         => $clientes->firstItem(),
                'to'           => $clientes->lastItem(),
            ],
            'clientes' => $clientes
        ];

        return $result;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $clientes = new Cliente();
        $clientes->nombre = $request->nombre;
        $clientes->apellidos = $request->apellidos;
        $clientes->edad = $request->edad;
        $clientes->correo = $request->correo;
        $clientes->nacionalidad = $request->nacionalidad;
        $clientes->ci = $request->ci;
        $clientes->telefono = $request->telefono;
        $clientes->empresa = $request->empresa;
        $clientes->estado = true;
        $clientes->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $clientes = Cliente::findOrfail($request->id);
        $clientes->nombre = $request->nombre;
        $clientes->apellidos = $request->apellidos;
        $clientes->edad = $request->edad;
        $clientes->correo = $request->correo;
        $clientes->nacionalidad = $request->nacionalidad;
        $clientes->ci = $request->ci;
        $clientes->telefono = $request->telefono;
        $clientes->empresa = $request->empresa;
        $clientes->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        //
    }

    public function activar(Request $request)
    {
        $clientes = Cliente::findOrFail($request->id);
        $clientes->estado = true;
        $clientes->save();
    }

    public function desactivar(Request $request)
    {
        $clientes = Cliente::findOrFail($request->id);
        $clientes->estado = false;
        $clientes->save();
    }

    public function excel()
    {
        return Excel::download(new ClienteExport, 'lista-cliente.xlsx');
    }
}
