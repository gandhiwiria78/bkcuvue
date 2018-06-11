<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Image; 
use File;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use App\Support\ImageProcessing;
use Illuminate\Notifications\DatabaseNotification;

class UserController extends Controller
{
  protected $imagepath = 'images/user/';
    
	public function userId()
	{
			$id = Auth::user()->getId();

			return response()
			->json([
					$id
			]);
	}

	public function profile()
	{
		$id = Auth::user()->getId();

		$kelas = User::with('pus','cu')->findOrFail($id);
		$notification = collect();
		$unreadNotification = count($kelas->unreadNotifications);

		$i = 0;
		foreach ($kelas->notifications as $notif) {
			$username = User::where('id',$notif->data['user'])->select('name')->first();
			
			$n = collect($notif);
			$n->put('user',$username);
			$notification->push($n);

			if (++$i == 15) break;
		}

		return response()
				->json([
						'model' => $kelas,
						'notification' => $notification,
						'unreadNotification' => $unreadNotification
				]);
	}

	public function index()
	{
			$table_data = User::with('Cu','pus','roles_custom')->select('id','id_cu','id_pus','name','email','username','gambar','status','created_at')->filterPaginateOrder();
			
    	return response()
			->json([
				'model' => $table_data
			]);
	}

	public function indexCu($id)
	{
			$table_data = User::with('Cu','pus','roles_custom')->where('id_cu',$id)->select('id','id_cu','id_pus','name','email','username','gambar','status','created_at')->filterPaginateOrder();
			
    	return response()
			->json([
				'model' => $table_data
			]);
	}
	
	public function create()
	{
		return response()
			->json([
					'form' => User::initialize(),
					'rules' => User::$rules,
					'option' => []
			]);
	}

	public function store(Request $request)
	{
		// validate request
		$this->validate($request,User::$rules);

		$username = $request->username;
		$password = $request->password;
		$passwordConfirm = $request->passwordConfirm;

		//check data
		$this->check_data($request);

		// processing single image upload
		if(!empty($request->gambar))
			$fileName = ImageProcessing::image_processing($this->imagepath,'300','200',$request);
		else
			$fileName = '';

		//password encryption	
		$password = Hash::make($password);

		// save user
		$kelas = User::create($request->except('gambar','password','status','id_pus') + [
			'gambar' => $fileName, 
			'password' => $password, 
			'status' => 1,
			'id_pus' => 1
			]);
		
		$role = Role::create(['name' => $username]);

		$this->hak_akses_save($request,$role);

		return response()
			->json([
				'saved' => true,
				'message' => 'User ' .$username. ' berhasil ditambah'
			]);
	}

	public function edit($id)
	{
		$kelas = User::with('Cu','pus','roles')->findOrFail($id);
		
		return response()
				->json([
						'form' => $kelas,
						'option' => []
				]);
	}

	public function update(Request $request, $id)
	{
		$this->validate($request,User::$rules);

		$username = $request->username;

			// processing single image upload
		if(!empty($request->gambar))
			$fileName = ImageProcessing::image_processing($this->imagepath,'300','200',$request,$kelas);
		else
			$fileName = '';

		$kelas = User::findOrFail($id);

		$kelas->update($request->except('gambar') + [
			'gambar' => $fileName
		]);

		return response()
			->json([
				'saved' => true,
				'message' => 'User ' .$username. ' berhasil diubah'
			]);
	}

  public function updateStatus($id)
	{
		$kelas = User::findOrFail($id);

		$username = $kelas->username;

		if($kelas->status == 1){
			$kelas->status = 0;
			$message = 'User ' .$username. ' berhasil dinon-aktifkan';
		}else{
			$kelas->status = 1;
			$message = 'User ' .$username. ' berhasil diaktifkan';
		}

		$kelas->update();

		return response()
			->json([
				'saved' => true,
				'message' => $message
			]);
	}

	public function resetPassword($id)
	{
		$kelas = User::findOrFail($id);
		$password = 'solusi';
		$password = Hash::make($password);

		$username = $kelas->username;

		$kelas->password = $password;
		$kelas->update();

		return response()
			->json([
				'saved' => true,
				'message' => 'Password user ' .$username. ' telah berhasil direset'
			]);
	}

	private function check_data($request)
	{
		$username = $request->username;
		$password = $request->password;
		$passwordConfirm = $request->passwordConfirm;

		//check username
		$checkUsername = User::where('username',$username)->first();
		if(!empty($checkUsername)){
			return response()
				->json([
					'saved' => false,
					'message' => 'Oops terjadi kesalahan: username tidak tersedia, silahkan coba username lain.'
				]);
		}

		//confirm password
		if($password != $passwordConfirm){
			return response()
				->json([
					'saved' => false,
					'message' => 'Oops terjadi kesalahan: password dengan password konfirmasi tidak sama.'
				]);
		}
	}

	private function image_processing($request)
	{
		$this->validate($request, [
    		'gambar' => 'image|mimes:jpeg,png,jpg|max:2048',
    	]);

		$path = public_path($this->imagepath);
		$imageData = $request->gambar;
		list($width, $height) = getimagesize($imageData);

		$formatedName = str_limit(preg_replace('/[^A-Za-z0-9\-]/', '',$request->name),10,'') . '_' .uniqid();
		$fileName =  $formatedName. '.jpg';
		$fileName2 =  $formatedName. 'n.jpg';

		//image
		if($width > 720){
				Image::make($imageData->getRealPath())->resize(720, null,
						function ($constraint) {
								$constraint->aspectRatio();
						})
						->save($path . $fileName);
		}else{
				Image::make($imageData->getRealPath())->save($path . $fileName);
		}

		//thumbnail image
		Image::make($imageData->getRealPath())->resize(200, 200,
						function ($constraint) {
								$constraint->aspectRatio();
						})
						->save($path . $fileName2);

		return $formatedName;
	}

	public function hak_akses($request,$permission,$role)
	{
		if($request == true) {
			$role->givePermissionTo($permission);
		}else{
			$role->revokePermissionTo($permission);
		}
	}
		
	public function hak_akses_save($request,$role)
	{
		$this->hak_akses($request->index_artikel,'index_artikel',$role);
		$this->hak_akses($request->create_artikel,'create_artikel',$role);
		$this->hak_akses($request->update_artikel,'update_artikel',$role);
		$this->hak_akses($request->destroy_artikel,'destroy_artikel',$role);
		$this->hak_akses($request->terbitkan_artikel,'terbitkan_artikel',$role);
	}
		
	public function markAllNotifRead()
	{
		$id = Auth::user()->getId();

		$kelas = User::findOrFail($id);

		$kelas->unreadNotifications->markAsRead();

		return response()
				->json([
						'marked' => true
				]);
	}

	public function markNotifRead($id)
	{
		auth()->user()->unreadNotifications->where('id', $id)->markAsRead();

		return response()
				->json([
						'marked' => true
				]);
	}
}
