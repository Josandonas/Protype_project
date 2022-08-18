<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class FileController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:file-list|file-create|file-edit|file-delete', ['only' => ['index','show']]);
         $this->middleware('permission:file-create', ['only' => ['create','store']]);
         $this->middleware('permission:file-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:file-delete', ['only' => ['destroy']]);
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
            'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048',
        ]);
        $saveFile= new File;
        if($request->file()) {
            $fileName = $request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
            $saveFile->name = $request->file->getClientOriginalName();
            $saveFile->file_path = '/storage/' . $filePath;
            $saveFile->save();
            return redirect()->route('files.index')->with('success','Arquivo Salvo.');
        }
    }

    /*
    Download fuction for especific file
    */
    public function download_File($path){
        $nameFile = File::where('id',$path)->firstOrFail();
        if (file_exists(public_path().'/storage/uploads/'.$nameFile->name)){
            $headers =[
                'Content-Type' =>'application/pdf',
            ];
            $filePath=public_path().'/storage/uploads/'.$nameFile->name;
            return response()->download($filePath, $nameFile->name, $headers);
            // ->with('success','Download Concluído.');
        };
        return ['status' => false,
         'message' => 'Não foi possível gerar o arquivo.'];
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
    public function update(Request $request, File $path)
    {
         request()->validate([
            'name' => 'required',
            'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048',
        ]);

        $path->update($request->all());

        return redirect()->route('files.index')
                        ->with('success','Arquivo editado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $path)
    {
        $path->delete();

        return redirect()->route('files.index')
                        ->with('success','Arquivo excluido com sucesso');
    }
}
