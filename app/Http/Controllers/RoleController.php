<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;


class RoleController extends Controller
{
    // public function test(Request $request, $id)
    // {
    //     $user = User::find($id);
    //     if(!$user){
    //         return response()->json(['message' => "This user doesn't exist!"]);
    //     }
    //     $user->assignRole($request->name);
    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Role assigned successfully!',
    //     ]);
    // }


        public function assignRole(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => "This user doesn't exist!"]);
        }

        $user->syncRoles([$request->name]); // remove all existing roles and assign the new one
        return response()->json([
            'status' => true,
            'message' => 'Role assigned successfully!',
        ]);
    }

    public function removeRole($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => "This user doesn't exist!"]);
        }

        $user->syncRoles([]); // remove all roles from user
        return response()->json([
            'status' => true,
            'message' => 'Role removed successfully!',
        ]);
    }


// public function assignRole(Request $request, $id)
// {
//     $user = User::find($id);
//     if (!$user) {
//         return response()->json(['message' => "This user doesn't exist!"]);
//     }

//     if ($request->name) {
//         $user->syncRoles([$request->name]); // remove all existing roles and assign the new one
//         $message = 'Role assigned successfully!';
//     } else {
//         $user->revokeAllRoles(); // remove all existing roles
//         $message = 'All roles removed successfully!';
//     }

//     return response()->json([
//         'status' => true,
//         'message' => $message,
//     ]);
// }


}
