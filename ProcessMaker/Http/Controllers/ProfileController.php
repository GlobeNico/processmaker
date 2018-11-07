<?php

namespace ProcessMaker\Http\Controllers;

use Illuminate\Http\Request;
use ProcessMaker\Models\User;
use ProcessMaker\Models\JsonData;
use ProcessMaker\Models\Permission;
use ProcessMaker\Models\PermissionAssignment;

class ProfileController extends Controller
{

    /**
     * edit your profile.
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View
     */
    public function edit()
    {
        $current_user = \Auth::user();
        $states = JsonData::states();
        $timezones = JsonData::timezones();
        $countries = JsonData::countries();
        return view('profile.edit',
            compact('current_user', 'states', 'timezones', 'countries'));
    }

    /**
     * show other users profile
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $permission_ids = $user->permissionAssignments()->pluck('permission_id')->toArray();
        $all_permissions = Permission::all();
        $users_permission_ids = $this->user_permission_ids($user);
        return view('profile.show', compact('user', 'all_permissions', 'users_permission_ids', 'permission_ids'));
    }

    private function user_permission_ids($user) 
    {
        return $user->permissionAssignments()->pluck('permission_id')->toArray();
    }
}