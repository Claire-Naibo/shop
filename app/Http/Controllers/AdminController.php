<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
	public function login(Request $request){
		if ($request->isMethod('post')) {
			$data = $request ->input();
			if (Auth::attempt(['email'=>$data['email'],'password'=>$data['password'],'admin'=>'1'])) {
				// echo "success";die;
				Session::put('adminSession',$data['email']);
				return redirect('/admin/dashboard');
			}else{
				// echo "Failed";die;
				return redirect('/admin')->with('flash_message_error','Invlaid Username or Password');
			}
		}
		return view('admin.admin_login');
	}
	public function dashboard(){
		if (Session::has('adminSession')) {
			//perform all dashboard tasks

		}else{
			return redirect('admin')->with('flash_message_error','Please login to access');
		}
		return view('admin.dashboard');
	}
	public function settings(){
		return view('admin.settings');
	}
	public function chkPassword(Request $request){
		$data = $request->all();
		$current_password = $data['current_pwd'];
		$check_password = User::where(['admin'=>'1'])->first();
		if (Hash::check($current_password,$check_password->password)) {
			echo "true";die;
		}else{
			echo "false";die;
		}
	}
	 public function updatePassword(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $check_password = User::where(['email' => Auth::user()->email])->first();
            $current_password = $data['current_pwd'];
            if(Hash::check($current_password,$check_password->password)){
                $password = bcrypt($data['new_pwd']);
                User::where('id','1')->update(['password'=>$password]);
                return redirect('/admin/settings')->with('flash_message_success','Password updated Successfully!');
            }else {
                return redirect('/admin/settings')->with('flash_message_error','Incorrect Current Password!');
            }
        }
    }
    public function viewUsers(Request $request) {
        $users = User::where(['admin'=>'0'])->latest()->get();
        //dd($users);
        $users = json_decode(json_encode($users));
        return view('admin.users.index')->with(compact('users'));
    }
    public function editUser(Request $request, $id=null){

        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>";print_r($data);die;

            User::where(['id'=>$id])->update(['name'=>$data['name'],'email'=>$data['email']]);

            return redirect('/admin/users/view_users')->with('flash_message_success', 'User Details Updated Successfully!');

        }

        $userDetails = User::where(['id'=>$id])->first();

        return view('/admin/users.edit')->with(compact('userDetails'));
    }
    public function deleteUser($id = null){
        if (!empty($id)) {
            User::where(['id'=>$id])->delete();
            return redirect()->back()->with('flash_message_success','User deleted Successfully!');
        }
   }
	public function logout() {
		Session::flush();
		return redirect('/admin')->with('flash_message_success','Logged out Succesfully');
	}
}
