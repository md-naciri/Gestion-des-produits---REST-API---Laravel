<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;


class RoleController extends Controller
{
    public function assignRole(Request $request, $id)
    {
        $user = User::find($id);
        if(!$user){
            return response()->json(['message' => "This user doesn't exist!"]);
        }
        $user->assignRole($request->name);
        return response()->json([
            'status' => true,
            'message' => 'Role assigned successfully!',
        ]);
    }
}
