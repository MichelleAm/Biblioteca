<?php

namespace App\Http\Controllers;

use App\Biblioteca;
use Illuminate\Http\Request;


class UnaBibliotecaController extends Controller
{
    public function __construct()
    {
        // if(isset($_SESSION['biblioteca'])) unset($_SESSION['biblioteca']);
        $this->middleware('auth')->except('index', 'show');
        // $this->middleware('admin')->only('create', 'store', 'edit', 'update', 'destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Biblioteca $biblioteca_id)
    {
        //
        // dd($biblioteca_id);
        $bibliotecas = Biblioteca::where('id', $biblioteca_id->id)
                ->orderBy('nombre')
               ->paginate();
        return view('bibliotecas.bibliotecaIndex', compact('biblioteca_id','bibliotecas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($biblioteca_id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $biblioteca_id)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Biblioteca  $biblioteca
     * @return \Illuminate\Http\Response
     */
    public function show($biblioteca_id, Biblioteca $biblioteca)
    {
        //
        return view('bibliotecas.bibliotecaShow', compact('biblioteca_id', 'biblioteca'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Biblioteca  $biblioteca
     * @return \Illuminate\Http\Response
     */
    public function edit($biblioteca_id, Biblioteca $biblioteca)
    {
        //
        // dd($biblioteca);
        return view('bibliotecas.bibliotecaForm', compact('biblioteca_id', 'biblioteca'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Biblioteca  $biblioteca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $biblioteca_id, Biblioteca $biblioteca)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Biblioteca  $biblioteca
     * @return \Illuminate\Http\Response
     */
    public function destroy($biblioteca_id, Biblioteca $biblioteca)
    {
        //
    }
}
