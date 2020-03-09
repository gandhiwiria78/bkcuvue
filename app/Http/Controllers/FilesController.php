<?php

namespace App\Http\Controllers;

use DB;
use File;
use App\Support\Helper;
use Illuminate\Http\Request;
use App\Files;
use App\FilesDraft;

class FilesController extends Controller
{   
    protected $filepath = 'files/';
	protected $message = 'Files';
    
    public function index()
    {
        
        $table_data = Files::advancedFilter();
      
        return response()
            ->json([
            'model'=>$table_data
        ]);
    }

    
    public function store(Request $request)
    {
		// $name = $request->name;
        // processing single image upload
        
        $files= "";
        $table_ids = [];
        
		if(!empty($request->files)){
            $files = Helper::file_processing($this->filepath,$request,'files');
            foreach ($files as $key) {
               // dd($key);
                $table = new FilesDraft;
                $table->name = $key['name'];
                $table->path = $key['path'];
                $table->jenis = $key['jenis'];
                $table->size = $key['size'];
                $table->save();

                $table_ids[] = $table->id;
            }
        }
        else{
            $files = '';
        }
       
        return response()
            ->json([
            'model'=>$table_ids,
            'saved'=> true,
        ]);
    }

    public function destroyAllDraft(Request $request){
         // menindahkan dari files_draft ke files proper
         
    }

  
    public function show($id)
    {
        //

    }
   
    public function update(Request $request, $id)
    {
        //

    }

    public function destroy($id)
    {
        //
        $kelas = Files::where('id',$id)->first();
        $name='';
        $deleted= false;
        $idx='';
		if(!empty($kelas)){
            $name = $kelas->name;
            $idx = $kelas->idx;
            $deleted=true;
            $path = public_path('files/files/'.$name);
           
            File::delete($path);
            $kelas->delete();
        }

        return response()
			->json([
				'deleted' => $deleted,
                'message' => 'File ' .$name,
                'id' => $idx
			]);

    }

    public function destroyDraft($id){

        $kelas = FilesDraft::findOrFail($id);
		$name = $kelas->name;

		if(!empty($kelas->name)){
            $path = public_path('files/files/'.$name);
            //dd($path);
            File::delete($path);
        }

        $kelas->delete();
        
        return response()
			->json([
				'deleted' => true,
                'message' => 'File ' .$name. 'berhasil dihapus',
                'id' => $id
			]);
    }
}
