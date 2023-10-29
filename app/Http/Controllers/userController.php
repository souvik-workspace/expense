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



class userController extends Controller
{

    
    public function userReg(Request $request){        
        if($request->submit !=""){
            $data=$request->validate([  
            'username' =>'required|min:5|max:255|unique:roles,username',
            'name'=>'required|min:5',
            'mobile'=>'required|digits:10',
            'email'=>'required|email',
            'password' => 'min:6|required_with:cnfpassword|same:cnfpassword',
            'cnfpassword' => 'min:6'   
            ]);  

            $role = new Role();
            $role->username = $request->username;
            $role->password = Hash::make($request->password);
            $role->role = 2; // 2 for user
            $role->save();

            $roleInsertId = $role->id; // here we collect roll table inserted id
            $user = new User();
            $user->id  = $roleInsertId; // id column is not auto increment
            $user->name = $request->name;
            $user->mobile = $request->mobile;
            $user->email = $request->email;
            $user->save();

            if($user){
                return redirect()->back()->with('success', 'Sucessfuly registered.');  
            }else{
                return redirect()->back()->with('error', 'Something went wrong');  
            }
        }else{
            return redirect('/');
        }
    }

    public function userlogin(Request $request){
        $user = Role::where('username',$request->username)->first();
        if(!empty($user)){
            if($user->status == 1 && $user->role == 2){
                if(Hash::check($request->password, $user->password)){
                    $user_data = User::find($user->id);
                    Session::put('user_id', $user->id);
                    Session::put('user_role', $user->role);
                    Session::put('user_name', $user_data->name);
                    return redirect('dashboard');                    
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

    public function logout(){ 
        Session::flush();       
        return redirect('/')->with(Auth::logout());
    }

    public function dashboard(){
        
        $user_id = session()->get('user_id');
        $data['total_expenses'] = Expense::where('user_id',$user_id)->sum('amount');
        $from = date('Y-m-01');
        $to = date('Y-m-t');
        $data['monthly_expenses'] = Expense::whereBetween('expense_date', [$from, $to])->where('user_id',$user_id)->sum('amount');
        $data['today_expenses'] = Expense::where('expense_date', '>=', Carbon::today())->where('user_id',$user_id)->sum('amount');
                
        /* calculate last 7 days sales report */
        $expensesReport = [];
        $expensesDate = [];
        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $totalExpenses = Expense::whereDate('expense_date', $date)->sum('amount');
            $expensesReport[$i] = $totalExpenses;
            $expensesDate[$i] = date('d-M-Y',strtotime($date));
        }
        $data['expensesReport'] =  $expensesReport;
        $data['expensesDate'] =  $expensesDate;
        // echo "<pre>";print_r($data);die;
        return view('user/dashboard',$data);
    }

    public function lastSevenDay(){
        $user_id = session()->get('user_id');
        $data = Expense::whereBetween('expense_date', ['2023-10-20','2023-10-27'])->where('user_id',$user_id);

        $data = Expense::whereDate('expense_date', Carbon::now()->subDays(7))->get();
        
        return $data;
        //  = [250,300,40,50,100,450,65];

    }

    public function addExpense(){ 
        $user_id = session()->get('user_id');
        $data['total_item'] = Item::where('status', 1)->count(); 
        $data['groups']  = Group::Where('status',1)->get(); 
        $data['total_expenses'] = Expense::where('user_id',$user_id)->sum('amount');
        $from = date('Y-m-01');
        $to = date('Y-m-t');
        $data['monthly_expenses'] = Expense::whereBetween('expense_date', [$from, $to])->where('user_id',$user_id)->sum('amount');
        $data['today_expenses'] = Expense::where('expense_date', '>=', Carbon::today())->where('user_id',$user_id)->sum('amount');
        
        return view('user/addExpense',$data);       
    }

    public function addExpenseSubmit(Request $request){
        
        if($request->submit !=""){
            $data=$request->validate([  
                'expense_date' =>'required',
                'group_id' =>'required',
                'item_id' =>'required',
                'amount' =>'required',
                'pay_method' =>'required',
            ]);

            $expense = new Expense();
            $expense->user_id = session()->get('user_id');
            $expense->group_id = $request->group_id;
            $expense->item_id = $request->item_id;
            $expense->amount = $request->amount;
            $expense->pay_method = $request->pay_method;   
            $expense->note = $request->note;         
            $expense->expense_date = $request->expense_date;            
            $expense->save();

            if($expense){
                return redirect()->back()->with('success', 'expenses record has been submitted'); 
            }
            
        }else{            
            return redirect('user/addExpense');
        }
    }

    public function getItem($id){
        $data = Item::where('group_id',$id)->get();
        return $data;
    }

    public function viewExpenses(){
        $user_id = session()->get('user_id');
        $data['expenses'] =  Expense::select('expenses.*','groups.group_name','items.item_name')
                            ->leftjoin('groups','groups.id','=','expenses.group_id')
                            ->leftjoin('items','items.id','=','expenses.item_id')
                            ->where('user_id',$user_id)
                            ->orderBy('expenses.expense_date','desc')
                            ->get();
        
        return view('user/viewExpenses',$data);
    }

    public function delExpense($id){
        $data = Expense::find($id);
        $data->delete();
        if($data){
            return redirect()->back()->with('success','Expense record has been deleted'); 
        }
    }

    public function editExpense($id){
        $user_id = session()->get('user_id');
        $data['expense'] = Expense::find($id);
        $data['groups']  = Group::Where('status',1)->get();
        $data['total_expenses'] = Expense::where('user_id',$user_id)->sum('amount');
        $from = date('Y-m-01');
        $to = date('Y-m-t');
        $data['monthly_expenses'] = Expense::whereBetween('expense_date', [$from, $to])->where('user_id',$user_id)->sum('amount');
        $data['today_expenses'] = Expense::where('expense_date', '>=', Carbon::today())->where('user_id',$user_id)->sum('amount'); 
        
        return view('user/editExpense',$data);

    }

    public function editExpenseSubmit(Request $request,$id){
        
        if($request->submit !=""){
            $data=$request->validate([  
                'expense_date' =>'required',
                'group_id' =>'required',
                'item_id' =>'required',
                'amount' =>'required',
                'pay_method' =>'required',
            ]);

            $expense = Expense::find($id);
            $expense->user_id = session()->get('user_id');
            $expense->group_id = $request->group_id;
            $expense->item_id = $request->item_id;
            $expense->amount = $request->amount;
            $expense->pay_method = $request->pay_method;   
            $expense->note = $request->note;         
            $expense->expense_date = $request->expense_date;            
            $expense->save();

            if($expense){
                return redirect()->back()->with('success', 'expenses record has been updated'); 
            }
            
        }else{            
            return redirect('user/viewExpenses/');
        }
    }

    // public function getWeekExpence(){
    //     $user_id = session()->get('user_id');
    //     //$data  = Expense::where('user_id',$user_id)->get();
    //     $data = array(20,50,30,40,50,60,70);

    //     return $data;
    // }






}
