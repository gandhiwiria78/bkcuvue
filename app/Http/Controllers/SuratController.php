<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Support\Helper;
use Illuminate\Support\Facades\Storage;
use App\Surat;
use App\SuratMasuk;
use App\Files;
use App\FIlesDraft;
use App\SuratFiles;
use File;

class SuratController extends Controller
{
    protected $filePath = 'files/Surat/';
    protected $message = "Surat";
    
    
    public function indexSuratKeluar(){

        $table_data = Surat::with('Pengelola')->advancedFilter();
        return response()
            ->json([
            'model'=>$table_data
        ]);
    }

    public function indexSuratMasuk(){

        $table_data = SuratMasuk::select('id','kode','perihal','tujuan','penerima','pengirim','terima_melalui','created_at','updated_at')->advancedFilter();
       
        return response()
            ->json([
            'model'=>$table_data
        ]);
    }
    
    public function indexTranceSuratKeluar(){

        $table_data = Surat::with('Pengelola')->onlyTrashed()->advancedFilter();
        return response()
            ->json([
            'model'=>$table_data
        ]);
    }

    public function indexTranceSuratMasuk(){

        $table_data = SuratMasuk::select('id','kode','perihal','tujuan','penerima','pengirim','terima_melalui','created_at','updated_at')->onlyTrashed()->advancedFilter();
       
        return response()
            ->json([
            'model'=>$table_data
        ]);
    }

    public function getnomor(){
        $table_data = Surat::all();
        return response()
            ->json([
            'model'=>$table_data
        ]);
    }

    public function getsuratMasuk($id){
        $table_data = SuratMasuk::where('id',$id)->get(); 
        return response()
            ->json([
                'model'=>$table_data
        ]);
    }

    public function indexSurat($id)
	{
		$table_data = Surat::with('Pengelola')->where('id',$id)->advancedFilter();
    	return response()
		->json([
			'model' => $table_data
        ]);
        
    }
    
    public function create(){
        return response()
			->json([
                'form' => Surat::initialize(),
                'rules' => Surat::$rules,
                'option' => []
			]);
    }

    public function store(Request $request)
    {
        $this->validate($request,Surat::$rulesBoking);
        $dataYears = Surat::orderBy('created_at','DESC')->first();
        if($dataYears){
            if($this->chectYear($dataYears->created_at)){
                $request->no_surat=1;
            }
        }
        $kelas = Surat::create($request->all());
		return response()
		->json([
            'saved' => true,
            'message' => 'Surat berhasil ditambah',
            'id' => $kelas->id
        ]);
    }

    public function storeSuratMasuk(Request $request){
        
        $this->validate($request,SuratMasuk::$rules);
        $kelas = SuratMasuk::create($request->all());
        if(!empty($request->id_files)){
            $files = $request->id_files;
            $file_data = explode(',',$files);

            foreach($file_data as $key){
                $table = new SuratFiles;
                $table->id_surat = $kelas->id;
                $table->id_file = $key;
                $table->tipe =  $request->tipe; 
                $table->save();

                if(!empty($key)){ // key
                
                    $filesDraft = FilesDraft::findOrFail($key);
                    $table = new Files;
                    $table->idx = $filesDraft->id;
                    $table->name = $filesDraft->name;
                    $table->path = $filesDraft->path;
                    $table->jenis = $filesDraft->jenis;
                    $table->size = $filesDraft->size;
                    $table->save();
                    
                    $filesDraft->delete();
                    
                }
            }
        }

        return response()
		->json([
            'saved' => true,
            'message' => 'Surat berhasil ditambah',
            'id' => $kelas->id
        ]);
    }

    public function show($id)
    {
        // ==================
        
    }   
     
    ///======================
    public function update(Request $request, $id)
    {
        $this->validate($request,Surat::$rules);
        $kelas = Surat::findOrFail($id);

        $kelas->update($request->all());
        if(!empty($request->id_files)){
           
            $files= $request->id_files;
            $file_data = explode(',',$files);
            foreach($file_data as $key){
                $table = new SuratFiles;
                $table->id_surat = $id;
                $table->id_file = $key;
                $table->tipe =  $request->tipe; 
                $table->save();
                if(!empty($key)){ // key
                
                    $filesDraft = FilesDraft::findOrFail($key);
                    $table = new Files;
                    $table->idx = $filesDraft->id;
                    $table->name = $filesDraft->name;
                    $table->path = $filesDraft->path;
                    $table->jenis = $filesDraft->jenis;
                    $table->size = $filesDraft->size;
                    $table->save();
                    
                    $filesDraft->delete();
                    
                }
            }
        }
        
        return response()
            ->json([
            'saved' => true,
            'message' => 'Surat berhasil dilengkapkan',
            'id' => $kelas->id
        ]);
    }

    public function updateSuratmasuk(Request $request,$id){

        // dd($request);
        $this->validate($request,SuratMasuk::$rules);
        $kelas = SuratMasuk::findOrFail($id);

        $kelas->update($request->all());

        $files= $request->id_files;
        if(!empty($request->id_files)){
            $file_data = explode(',',$files);
            foreach($file_data as $key){
                $table = new SuratFiles;
                $table->id_surat = $id;
                $table->id_file = $key;
                $table->tipe =  $request->tipe; 
                $table->save();
                if(!empty($key)){ // key
                    $filesDraft = FilesDraft::findOrFail($key);
                    $table = new Files;
                    $table->idx = $filesDraft->id;
                    $table->name = $filesDraft->name;
                    $table->path = $filesDraft->path;
                    $table->jenis = $filesDraft->jenis;
                    $table->size = $filesDraft->size;
                    $table->save();
                    $filesDraft->delete();
                }
            }
        }
        
        return response()
            ->json([
            'saved' => true,
            'message' => 'Surat berhasil dilengkapkan',
            'id' => $kelas->id
        ]);

    }

    public function getFilesSurat(Request $request, $id){
        $tipe = $request->tipe;
       
        $pivot = SuratFiles::where('id_surat',$id)->where('tipe',$tipe)->get();
        if($pivot){
            foreach ($pivot as $key) {
                $table_data[] = Files::where('idx',$key->id_file)->get();  
            }
            
            if(empty($table_data)){
                $table_data[]="";
            }  
        }else{
            $table_data[]="";
        }

        return response()
            ->json([
            'model'=>$table_data,
        ]);
        
    }

    public function destroy($id)
    {
        //
    }
    public function destroySuratMasukPermanent($id)
    {
        $kelas = SuratMasuk::findOrFail($id);
        // hapus file yang berkaitan dengan surat , 
        $name = $kelas->kode;
        $files = SuratFiles::where('id_surat',$id)->where('tipe',0)->get();
    
        if(!empty($files)){
            foreach ($files as $key ) {
                $file = Files::where('idx',$key->id_file);
                $file->delete();
                $key->delete();
                // delete File path
                
            }
        }
        $kelas->forceDelete();
      
		return response()
			->json([
				'deleted' => true,
				'message' => $this->message.' '.$name. 'berhasil dihapus'
			]);
    }
    public function destroySuratKeluarPermanent($id)
    {
        $kelas = Surat::findOrFail($id);
        // hapus file yang berkaitan dengan surat, 
        $name = $kelas->kode;
        $files = SuratFiles::where('id_surat',$id)->where('tipe',1)->get();
    
        if(!empty($files)){
            foreach ($files as $key ) {
                $file = Files::where('idx',$key->id_file);
                $file->delete();
                $key->delete();
                // delete File path

            }
        }
        $kelas->forceDelete();
      
		return response()
			->json([
				'deleted' => true,
				'message' => $this->message.' '.$name. 'berhasil dihapus'
			]);
    }


    // untuk menghandle file yang ada di pivot table
    public function destroyPivot($id){
        $pivot = SuratFiles::where('id_file',$id)->first();
        $pivot->delete();
        return response()
            ->json([
                'deleted' => true,
              
        ]);
    }

    public function softDestroySuratMasuk($id){
        $table = SuratMasuk::where('id',$id)->first() ;
        $table->delete();
        return response()
            ->json([
                'deleted'=> true,
                'message'=> 'test'.$id
        ]);
    }
    public function softDestroySuratKeluar($id){
        $table = Surat::where('id',$id)->first();
       $table->delete();
        
        return response()
            ->json([
                'deleted'=> true,
                'message'=> 'test'.$id
        ]);
    }


    function chectYear($data){
        $yearNow = now();
        $yearTable = date($data);

        if($yearTable<$yearNow){
            return true;
        }else{
            return false;
        }
    }
}
