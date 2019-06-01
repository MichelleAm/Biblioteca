<?php

namespace App\Http\Controllers;

use App\Libro;
use App\Biblioteca;
use Illuminate\Http\Request;


class LibroController extends Controller
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
    public function index(Request $request)
    {
        //
        // dd($request->buscar);
        if(!empty($request->buscar)){
            $libros = Libro::where('titulo', 'like', '%'.$request->buscar.'%')
            ->with('ejemplares')
            ->orderBy('titulo')
            ->paginate(10);
        }
        else{
            $libros = Libro::with('ejemplares')->paginate(10);
        }
        return view('libros.libroIndex', compact('libros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $bibliotecas = Biblioteca::all();
        return view('libros.libroForm', compact('bibliotecas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'isbn' =>['required','numeric','digits_between:10,13' ] ,
            'titulo' => ['required','max:255', 'string'],
            'subtitulo' => ['nullable', 'max:200'],
            'autor' =>['required','max:255','string'],
            'editorial' =>['required','max:255', 'string'],
            'anio' => ['required', 'date_format:Y'],
            'genero' => ['nullable', 'string', 'max:200'],
            'idioma' => ['required', 'string'],
            'seccion' => ['nullable', 'alpha_num'],
            'ejemplar' => ['nullable', 'numeric'],
            'diasMaxPrestamo' => ['required', 'numeric'],
            'link' => ['nullable'],
            'biblioteca_id' => ['required'],
        ]);
        $libro = Libro::create($request->except('numEjemp', 'origen', 'estado', 'comentario') + ['link' => $request->link]);

        if($request->hasFile('link'))
        {
            $file = $request->file('link');
            ///No se repetira el nombre del archivo
            $nombre = time().$file->getClientOriginalName();
        //  Es en la carpeta public ahí se almacenarán las imagenes 
            $file->move(public_path().'/images-database/', $nombre);
            $libro->update(['link' => $nombre]);
        }

        // $libro->link = $nombre;
        
        
        return redirect()->route('libros.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function show(Libro $libro)
    {
        //
        return view('libros.libroShow', compact('libro'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function edit(Libro $libro)
    {
        //
        // $ejemplares = $libro->ejemplares();
        // $bibliotecas = Biblioteca::all();
        // return view('libros.libroForm', compact('bibliotecas', 'ejemplares', 'libro'));

        // return view('bibliotecas.librosB.edit', [$libro->biblioteca_id, $libro]);
        return redirect()->route('bibliotecas.libros.edit', [$libro->biblioteca_id, $libro]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Libro $libro)
    {
        //
        $request->validate([
            'isbn' => 'required',
            'titulo' => 'required',
            // 'subtitulo' => 'nullable',
            'autor' => 'required',
            'editorial' => 'required',
            'anio' => 'required',
            'genero' => 'nullable',
            'idioma' => 'required',
            'seccion' => 'nullable',
            'ejemplar' => 'nullable',
            'diasMaxPrestamo' => 'required',
            'link' => 'nullable',
            'biblioteca_id' => 'required',
        ]);

        $libro->update($request->except('numEjemp', 'origen', 'estado', 'comentario'));

       

        return redirect()->route('libros.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Libro $libro)
    {
        //
        $libro->delete();
        return redirect()->route('libros.index')
            >with([
                'mensaje' => 'Libro Eliminado',
                'alert-class' => 'alert-warning',
            ]);
    }
}
