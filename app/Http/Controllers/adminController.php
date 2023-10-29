<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\User;
use App\models\Role;
use App\models\Group;
use App\models\Item;
use App\models\Expense;
use Illuminate\Support\Facades\Hash;
use Session;
use Auth;
use Carbon\Carbon;


class adminController extends Controller
{
    public function admin(){
        return view('admin/login');
    }

    public function adminlogin(Request $request){        
        $user = Role::where('username',$request->username)->first();
       
        if(!empty($user)){
            if($user->status == 1 && $user->role == 1){
                if(Hash::check($request->password, $user->password)){
                    $user_data = User::find($user->id);
                    Session::put('user_id', $user->id);
                    Session::put('user_role', $user->role);
                    Session::put('user_name', $user_data->name);
                    return redirect('admin/dashboard');                    
                }else{
                   return redirect()->back()->with('error', 'Wrong password !');
                }
            }else{
                return redirect()->back()->with('error', 'Account inactive, Contact to Admin');
            }
        }else{
            return redirect()->back()->with('error', 'Username not found'); 
        }
    }

    public function adminlogout(){ 
        Session::flush();       
        return redirect('admin')->with(Auth::logout());
    }

    public function dashboard(){
        $data['total_group'] = Group::where('status', 1)->count();
        $data['total_item'] = Item::where('status', 1)->count();
        $data['total_user'] = Role::where('role',2)
                              ->where('is_delete',0)
                              ->count();
        return view('admin/dashboard',$data);
    }

    public function addGroup(){   
        $data['total_group'] = Group::where('status', 1)->count();        
        return view('admin/addGroup',$data);       
    }
    public function addGroupSubmit(Request $request){
        if($request->submit !=""){
            $data=$request->validate([  
                'group_name' =>'required|unique:groups,group_name'
            ]);

            $group = new Group();
            $group->group_name = $request->group_name;
            $group->save();

            if($group){
                return redirect()->back()->with('success', '<b>'.$request->group_name.'</b> Group has been created'); 
            }
            
        }else{            
            return redirect('admin/addGroup');
        }
    }

    public function viewGroup(){
        $data['groups'] = Group::all();        
        return view('admin/viewGroup',$data);
    }
    public function delGroup($id){
        $data = Group::find($id);
        $data->delete();
        if($data){
            return redirect()->back()->with('success','Group has been deleted'); 
        }
    }
    public function editGroup($id){
        $data['total_group'] = Group::where('status', 1)->count(); 
        $data['group'] = Group::find($id);
        return view('admin/editGroup',$data);
    }

    public function editGroupSubmit(Request $request,$id){        
        if($request->submit !=""){
            $data=$request->validate([  
                'group_name' =>'required'
            ]);
            $group = Group::find($id);
            $group->group_name = $request->group_name;
            $group->status = $request->status;
            $group->save();

            if($group){
                return redirect()->back()->with('success', '<b>'.$request->group_name.'</b> Group has been Update'); 
            }
            
        }else{            
            return redirect('admin/addGroup');
        }
    }

    public function addItem(){   
        $data['total_item'] = Item::where('status', 1)->count(); 
        $data['groups']  = Group::get(); 
        return view('admin/addItem',$data);       
    }
    public function addItemSubmit(Request $request){
        if($request->submit !=""){
            $data=$request->validate([  
                'item_name' =>'required|unique:items,item_name',
                'group_id' =>'required'
            ]);

            $item = new Item();
            $item->group_id = $request->group_id;
            $item->item_name = $request->item_name;
            $item->save();

            if($item){
                return redirect()->back()->with('success', '<b>'.$request->item_name.'</b> Item has been created'); 
            }
            
        }else{            
            return redirect('admin/addItem');
        }
    }

    public function viewItem(){
        //$data['items'] = Item::with('getGroup')->get();          
        $data['items'] = Item::select('items.*','groups.group_name')
                        ->leftJoin('groups', 'groups.id', '=', 'items.group_id')
                        ->get();        
        return view('admin/viewItem',$data);
    }
    public function delItem($id){
        $data = Item::find($id);
        $data->delete();
        if($data){
            return redirect()->back()->with('success','item has been deleted'); 
        }
    }
    public function editItem($id){
        $data['total_item'] = Item::where('status', 1)->count(); 
        $data['item'] = Item::find($id);
        $data['groups']  = Group::all();
        return view('admin/edititem',$data);
    }

    public function editItemSubmit(Request $request,$id){  
        if($request->submit !=""){
            $data=$request->validate([  
                'item_name' =>'required',
                'group_id' =>'required'
            ]);
            $item = Item::find($id);
            $item->group_id = $request->group_id;
            $item->item_name = $request->item_name;
            $item->status = $request->status;
            $item->save();

            if($item){
                return redirect()->back()->with('success', '<b>'.$request->item_name.'</b> Group has been Update'); 
            }            
        }else{            
            return redirect('admin/addItem');
        }
    }

    public function viewUser(){
        $data['users'] = Role::select('roles.*','users.*')
                        ->leftjoin('users','users.id','=','roles.id')
                        ->where('roles.role',2)
                        ->where('roles.is_delete',0)
                        ->get(); 
        return view('admin/viewUser',$data);
    }

    public function delUser($id){
        $data = Role::find($id);
        $data->is_delete = 1;
        $data->save();
        if($data){
            return redirect()->back()->with('success','User has been deleted'); 
        }
    }

    public function editUser($id){
        $data['total_user'] = Role::where('role',2)->where('is_delete',0)->count();

        $data['user'] = Role::select('roles.*','users.*')
                            ->leftjoin('users','users.id','=','roles.id')
                            ->where('roles.role',2)
                            ->where('roles.is_delete',0)
                            ->where('roles.id',$id)
                            ->first();       
        return view('admin/editUser',$data);
    }

    public function editUserSubmit(Request $request,$id){ 
       
        if($request->submit !=""){
            $data=$request->validate([
                'name'=>'required|min:5',
                'mobile'=>'required|digits:10',
                'email'=>'required|email',
            ]);
            $user = User::find($id);
            $user->name = $request->name;
            $user->mobile = $request->mobile;
            $user->email = $request->email;
            $user->save();

            $role = Role::find($id);
            $role->status = $request->status;
            $role->save();

            if($user){
                return redirect()->back()->with('success', 'User details has been Update'); 
            }
            
        }else{            
            return redirect('admin/viewUser');
        }
    }

    public function viewExpenses($id){
        $data['user']     = User::find($id);
        $data['expenses'] =  Expense::select('expenses.*','groups.group_name','items.item_name')
                            ->leftjoin('groups','groups.id','=','expenses.group_id')
                            ->leftjoin('items','items.id','=','expenses.item_id')
                            ->where('user_id',$id)
                            ->get(); 

        $data['total_expenses'] = Expense::where('user_id',$id)->sum('amount');       
        $data['monthly_expenses'] = Expense::whereBetween('expense_date', [date('Y-m-01'),date('Y-m-t')])->where('user_id',$id)->sum('amount');
        $data['today_expenses'] = Expense::where('expense_date', '>=', Carbon::today())->where('user_id',$id)->sum('amount');
        
        return view('admin/viewExpenses',$data);
    }

}
