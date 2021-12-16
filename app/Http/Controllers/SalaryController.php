<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Departments;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function index()
    {
        
    }

    public function getUsers(Request $request){
        //print_r($request->all());
       $columns = array(
           0 =>'id',
           1 =>'name',
           2 =>'last_name',
           3 =>'email',
           4 =>'adresa',
           5 =>'is_admin',
           6 =>'dep_name',
           7=> 'action1',
           8=> 'action2',

        );

        $totalData = User::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))){
            $posts = DB::table('users')
                ->join('departments', 'users.dep_fk', '=', 'departments.dep_id')
                ->select('users.*', 'departments.dep_name as dep_name','departments.dep_id')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
            $totalFiltered = User::count();
        }else{
            $search = $request->input('search.value');
            $posts = DB::table('users')
                ->join('departments', 'users.dep_fk', '=', 'departments.dep_id')
                ->select('users.*', 'departments.dep_name as dep_name','departments.dep_id')
                -> where('name', 'like', "%{$search}%")
                ->orWhere('email','like',"%{$search}%")
                ->orWhere('last_name','like',"%{$search}%")
                ->orWhere('adresa','like',"%{$search}%")
                ->orWhere('dep_name','like',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = User::where('name', 'like', "%{$search}%")
                ->orWhere('email','like',"%{$search}%")
                ->count();
        }


        $data = array();

        if($posts){
            foreach($posts as $r){
                $nestedData['id'] = $r->id;
                $nestedData['name'] = $r->name;
                $nestedData['last_name'] = $r->last_name;
                $nestedData['email'] = $r->email;
                $nestedData['adresa'] = $r->adresa;
                if($r->is_admin) { $nestedData['is_admin'] = "Admin";} else {$nestedData['is_admin'] ="Punonjes";} ;

                    $nestedData['dep_name'] = $r->dep_name;

                $nestedData['action1'] = '<a href = "showeditform/'.$r->id.' "
 class="btn btn-warning btn-xs">Edit</a>';

                $nestedData['action2'] ='<a onclick="return confirm(\'Are you sure you want to delete?\')" href="delete/user/'. $r->id.' "
class="btn btn-danger btn-xs">Delete</a>';
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"			=> intval($request->input('draw')),
            "recordsTotal"	=> intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"			=> $data
        );

        echo json_encode($json_data);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {    $deps=Departments::all();
        return view('crud_users.create_form', array('dep' => $deps));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
            'foto' => 'required|image',
            'adresa' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);
        $newuser=new User();

        $image=$request->file('foto')->getClientOriginalName();
        $filename= pathinfo($image,PATHINFO_FILENAME);
        $extension= $request->file('foto')->getClientOriginalExtension();
        $filetostore=$filename.'_'.time().'.'.$extension;
        $path= $request->file('foto')->storeAs('public/images', $filetostore);

        $newuser->name=$request->name;
        $newuser->last_name=$request->last_name;
        $newuser->email=$request->email;
        $newuser->password=Hash::make($request->password);
        $newuser->picture=$filetostore;
        $newuser->adresa=$request->adresa;
        $newuser->is_admin=$request->tipi;
        $newuser->dep_fk=$request->departamenti;

        $newuser->save();
        return redirect()->route('admin.showcrud');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $one_user = DB::table('users')
            ->join('departments', 'users.dep_fk', '=', 'departments.dep_id')
            ->select('users.*', 'departments.dep_name as dep_name', 'departments.dep_id')->where('users.id', '=', $id)
            ->get();
        $departamenet=Departments::all();


        return view('crud_users.edit_form', array('edit_user' => $one_user), array('departament'=>$departamenet));
    }


    public function updateUser(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'adresa' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'tipi' => 'required',
            'departamenti' => 'required',
        ]);
        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->last_name = $request->input('last_name');
        $user->adresa = $request->input('adresa');
        $user->is_admin = $request->input('tipi');
        $user->dep_fk = $request->input('departamenti');
        $user->id = $id;
        $user->save();
        return redirect()->route('admin.showcrud');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        User::destroy($id);
        return redirect('/admin/crud');
    }

}
