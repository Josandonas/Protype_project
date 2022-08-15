<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
class FileController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:files-list|files-create|files-edit|files-delete', ['only' => ['index','show']]);
         $this->middleware('permission:files-create', ['only' => ['create','store']]);
         $this->middleware('permission:files-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:files-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $path = File::latest()->paginate(5);
        return view('files.index',compact('path'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('files.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'file_path' => 'required',
        ]);

        File::create($request->all());

        return redirect()->route('files.index')
                        ->with('success','Arquivo Salvo.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(File $path)
    {
        return view('files.show',compact('path'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(File $path)
    {
        return view('files.edit',compact('path'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $product)
    {
         request()->validate([
            'name' => 'required',
            'file_path' => 'required',
        ]);

        $product->update($request->all());

        return redirect()->route('files.index')
                        ->with('success','Arquivo editado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $product)
    {
        $product->delete();

        return redirect()->route('files.index')
                        ->with('success','Arquivo excluido com sucesso');
    }
}
