<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Permission;
use App\Models\Province;
use \Exception;
use Auth;
use DB;

class UserController extends Controller
{
    // Return login page
    public function login()
    {
        return view('auth.login');
    }

    // Sign In the user
    public function signIn(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Email is required',
            'password.required' => 'Password is required',
        ]);

        $email    = $request->email;
        $password = $request->password;

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->back()->with('error', 'Operation Faild.');
        }
    }

    // Return the register page
    public function register()
    {
        return view('auth.register');
    }

    // Register the users
    public function signUp(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required',
            'password' => 'required|min:6',
        ], [
            'name.required' => 'Full Name is required',
            'email.required' => 'Email is required',
            'email.unique' => 'Email already exists',
            'role.required' => 'Role is required',
            'password.required' => 'Password is required',
            'password.min'      => 'Password must be at least 6 characters',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
        $user->save();

        return redirect()->route('login')->with('success', 'Operation Done.');
    }

    // Logout the user
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }

    // Returning the users to management
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = User::latest();

        if (request('name')) {
            $users = $users->where('name', 'like', '%' . request('name') . '%');
        }

        if (request('email')) {
            $users = $users->where('email', 'like', '%' . request('email') . '%');
        }

        if (request('role')) {
            $users = $users->where('role', 'like', '%' . request('role') . '%');
        }

        $users = $users->paginate(15);
        return view('dashboard.users.index', compact('users'));
    }

    // Return the specific user to view
    public function show($id)
    {
        $this->authorize('view',  User::class);

        $user = User::find($id);

        $sections = DB::table('permissions')
            ->select('section')
            ->whereNull('deleted_at')
            ->distinct('section')
            ->get();

        $permissions = DB::table('permissions')
            ->select('id', 'permission', 'section')
            ->get();

        $branches = DB::table('branches')
            ->select('id', 'name',)
            ->get();

        return view('dashboard.users.show', compact(['user', 'permissions', 'sections', 'branches']));
    }

    // return the register page to dashboard
    public function create()
    {
        $this->authorize('create',  User::class);
        return view('dashboard.users.create');
    }

    // Register the users by manager
    public function store(Request $request)
    {
        $this->authorize('create',  User::class);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required',
            'password' => 'required|min:6',
        ], [
            'name.required' => 'Full Name is required',
            'email.required' => 'Email is required',
            'email.unique' => 'Email already exists',
            'role.required' => 'Role is required',
            'password.required' => 'Password is required',
            'password.min'      => 'Password must be at least 6 characters',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
        $user->save();

        return redirect()->route('users')->with('success', 'Operation Done.');
    }

    // return the edit page to dashboard
    public function edit($id)
    {
        $user = User::find($id);
        $this->authorize('update',  $user);
        return view('dashboard.users.edit', compact('user'));
    }

    // Register the users by manager
    public function update(Request $request, $id)
    {
        $this->authorize('update', User::class);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
        ], [
            'name.required' => 'Full Name is required',
            'email.required' => 'Email is required',
            'role.required' => 'Role is required',
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('users')->with('success', 'Operation Done.');
    }

    // Set access level to users
    public function setAccess(Request $request, $id)
    {
        $this->authorize('view', User::class);
        try {
            DB::beginTransaction();
            DB::table('user_permission')->where('user_id', $id)->delete();
            if (!is_null($request->permission)) {
                foreach ($request->permission as $branch => $permissions) {
                    foreach ($permissions as $permission) {
                        DB::table('user_permission')->insert([
                            'user_id' => $id,
                            'branch_id' => $branch,
                            'permission_id' =>  $permission,
                        ]);
                    }
                }
            }
            DB::commit();
            return redirect()->back()->with('success', 'Operation Done.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild.');
        }
    }

    // trash the user
    public function destroy($id)
    {
        $this->authorize('delete', User::class);
        $user = User::find($id);
        $user->delete();
        return redirect()->route('users')->with('success', 'Operation Done.');
    }

    // return the trash users
    public function trashed()
    {
        $users = User::onlyTrashed()->orderby('id', 'desc')->paginate(15);
        return view('dashboard.users.trashed', compact('users'));
    }

    // restore back the user
    public function restore($id)
    {
        $this->authorize('restore', User::class);
        User::withTrashed()->find($id)->restore();
        return redirect()->route('users')->with('success', 'Operation Done.');
    }

    // return the edit page to dashboard
    public function profile($id)
    {
        $user = User::find($id);
        return view('dashboard.users.profile', compact('user'));
    }

    // Register the users by manager
    public function updateProfile(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ], [
            'name.required' => 'Full Name is required',
            'email.required' => 'Email is required',
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Operation Done.');
    }
}
