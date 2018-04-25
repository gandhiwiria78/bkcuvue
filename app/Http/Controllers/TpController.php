<?php
namespace App\Http\Controllers;

use DB;
use App\Tp;
use App\Support\ImageProcessing;
use Illuminate\Http\Request;
use File;
use Image;

class TpController extends Controller{

	protected $imagepath = 'images/tp/';
	protected $width = 200;
	protected $height = 200;
	protected $message = "TP/KP";

	public function index()
	{
		$table_data = Tp::with('Cu','Villages','Districts','Regencies','Provinces')->select(
			'tp.*',
			DB::raw(
				'(SELECT name FROM cu WHERE tp.id_cu = cu.id) as cu_name,
				(SELECT name FROM villages WHERE tp.id_villages = villages.id) as villages_name,
				(SELECT name FROM districts WHERE tp.id_districts = districts.id) as districts_name,
				(SELECT name FROM regencies WHERE tp.id_regencies = regencies.id) as regencies_name,
				(SELECT name FROM provinces WHERE tp.id_provinces = provinces.id) as provinces_name'
			)
		)->filterPaginateOrder();

		return response()
		->json([
			'model' => $table_data
		]);
	}

	public function indexCu($id)
	{
		$table_data = Tp::with('Cu','Villages','Districts','Regencies','Provinces')->where('id_cu',$id)->select(
			'tp.*',
			DB::raw(
				'(SELECT name FROM cu WHERE tp.id_cu = cu.id) as cu_name,
				(SELECT name FROM villages WHERE tp.id_villages = villages.id) as villages_name,
				(SELECT name FROM districts WHERE tp.id_districts = districts.id) as districts_name,
				(SELECT name FROM regencies WHERE tp.id_regencies = regencies.id) as regencies_name,
				(SELECT name FROM provinces WHERE tp.id_provinces = provinces.id) as provinces_name'
			)
		)->filterPaginateOrder();

		return response()
			->json([
				'model' => $table_data
			]);
	}

	public function get()
	{
		$table_data = Tp::where('id','!=',0)->select('id','name')->orderby('name','asc')->get();

		return response()
			->json([
				'model' => $table_data
			]);
  }
  
  public function getCu($id)
	{
		$table_data = Tp::where('id_cu','=',$id)->select('id','no_tp','name')->orderby('name','asc')->get();

		return response()
			->json([
				'model' => $table_data
			]);
	}

	public function create()
	{
		return response()
			->json([
					'form' => Tp::initialize(),
					'rules' => Tp::$rules,
					'option' => []
			]);
	}

	public function store(Request $request)
	{
		$this->validate($request,Tp::$rules);

		$name = $request->name;

		// processing single image upload
		if(!empty($request->gambar))
			$fileName = ImageProcessing::image_processing($this->imagepath,$this->width,$this->height,$request);
		else
			$fileName = '';

		$kelas = Tp::create($request->except('gambar') + [
			'gambar' => $fileName
		]);
		
		return response()
			->json([
				'saved' => true,
				'message' => 'Tp ' .$name. ' berhasil ditambah',
				'id' => $kelas->id
			]);	
	}

	public function edit($id)
	{
		$kelas = Tp::findOrFail($id);

		return response()
				->json([
						'form' => $kelas,
						'option' => []
				]);
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, Tp::$rules);

		$name = $request->name;

		$kelas = Tp::findOrFail($id);

		// processing single image upload
		if(!empty($request->gambar))
			$fileName = ImageProcessing::image_processing($this->imagepath,$this->width,$this->height,$request,$kelas);
		else
			$fileName = '';

		$kelas->update($request->except('gambar') + [
			'gambar' => $fileName
		]);	

		return response()
			->json([
				'saved' => true,
				'message' => $this->message. ' ' .$name. ' berhasil diubah'
			]);
	}

	public function destroy($id)
	{
		$kelas = Tp::findOrFail($id);
		$name = $kelas->name;

		if(!empty($kelas->gambar)){
			File::delete($path . $kelas->gambar . '.jpg');
			File::delete($path . $kelas->gambar . 'n.jpg');
		}

		$kelas->delete();

		return response()
			->json([
				'deleted' => true,
				'message' =>  $this->message. ' ' .$name. 'berhasil dihapus'
			]);
	}
}