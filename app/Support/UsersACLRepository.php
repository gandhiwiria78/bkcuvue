<?php

namespace App\Support;

use Alexusmai\LaravelFileManager\Services\ACLService\ACLRepository;
use Illuminate\Support\Facades\Auth;
use App\User;
use Log;

class UsersACLRepository implements ACLRepository
{
    /**
     * Get user ID
     *
     * @return mixed
     */
    public function getUserID()
    {
      // dd(\Auth::id());
        return \Auth::id();

    }

    /**
     * Get ACL rules list for user
     *
     * @return array
     */
    public function getRules(): array
    {

        $id= Auth::id();
        //$kelas = User::with('pus','cu')->findOrFail($id);
        //dd($id);
        if ($id === 38) {
            //dd("Test ".$id);
            return [
                ['disk' => 'public', 'path' => 'BKCU', 'access' => 1],     
                ['disk' => 'public', 'path' => '/', 'access' => 1],                   // main folder - read
                         // read - user can't delete or rename folder
                ['disk' => 'public', 'path' => 'BKCU/*', 'access' => 2],       // read and write for all folders and files in "altena" folder
                //['disk' => 'BKCU', 'access' => 2],
                //['disk' => 'CUKB', 'access' => 2],
            ];
        }
        
        return [
            //['disk' => 'BKCU', 'path' => 'BKCU/','access' => 2],                                  // main folder - read
            //['disk' => 'CUKB', 'path' => 'CUKB/', 'access' => 2],                              // only read
            // ['disk' => 'disk-name', 'path' => 'users/'. \Auth::user()->name, 'access' => 1],        // only read
            // ['disk' => 'disk-name', 'path' => 'users/'. \Auth::user()->name .'/*', 'access' => 2],  // read and write
        ];
    }
}