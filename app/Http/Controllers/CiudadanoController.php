<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ciudadano;

class CiudadanoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Ciudadano::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'curp' => 'required|min:18',
            'nombre' => 'required',
            'apeliido_materno' => 'required',
            'apellid_paterno' => 'required',
        ]);
        $ciudadano = new Ciudadano;

        $ciudadano->CURP = $request->CURP;
        $ciudadano->Nombre = $request->Nombre;
        $ciudadano->ApeliidoMaterno = $request->ApeliidoMaterno;
        $ciudadano->ApellidoPaterno = $request->ApellidoPaterno;   
        $ciudadano->Sexo = $request->Sexo;
        $ciudadano->RFC = $request->RFC;
        $ciudadano->CorreoElectronico = $request->CorreoElectronico;
        $ciudadano->Telefono = $request->Telefono;

        $ciudadano->save();

        return json_code($ciudadano);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ciudadano = Ciudadano::find($id);
        $ciudadano ->fill($request->all());
        $ciudadano->save();

        return Ciudadano::all();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ciudadano = Ciudadano::find($id);
        $ciudadano->delete();

        ciudadano::destroy($id);
        return Ciudadano::all();
    }
}
