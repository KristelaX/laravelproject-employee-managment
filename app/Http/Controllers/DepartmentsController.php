<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departments;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departamente = Departments::where('parent_id', '=', 0)->get();
        $alldep= Departments::all();
        $alldepartments = Departments::pluck('dep_name','dep_id')->all();
$man=User::all();
        $tree='<ul id="browser" class="filetree"><li class="tree-view"></li>';
        foreach ($departamente as $depart) {
            $tree .='<li class="tree-view closed"><a class="tree-name" href="dep/crud/'.$depart->dep_id.'">'.$depart->dep_name.'</a>';
            if(count($depart->childs)) {
                $tree .=$this->childView($depart);
            }
        }
        $tree .='<ul>';
        //return $tree;
        return view('departamente.departamente',compact('tree'), ['alldep'=>$alldep, 'man'=>$man]);
    }

    public function childView($dep){
        $html ='<ul>';
        foreach ($dep->childs as $arr) {
            if(count($arr->childs)){
                $html .='<li class="tree-view closed"><a class="tree-name" href="dep/crud/'.$arr->dep_id.'">'.$arr->dep_name.'</a>';
                $html.= $this->childView($arr);
            }else{
                $html .='<li class="tree-view"><a class="tree-name" href="dep/crud/'.$arr->dep_id.'">'.$arr->dep_name.'</a>';
                $html .="</li>";
            }

        }

        $html .="</ul>";
        return $html;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            'departamenti' => 'required|integer',
            'location' =>'required|string'

        ]);

        $newdep =new Departments();
        $newdep->dep_name=$request->name;
        $newdep->parent_id=$request->departamenti;
        $newdep->location=$request->location;
        $newdep->manager_id=$request->manager;
        $newdep->save();
        return redirect()->route('admin.jquery.treeview');
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
        $one_dep = DB::table('departments')
            ->select('departments.*')->where('departments.dep_id', '=', $id)
            ->get();
        $u=User::all();
        $d_all=Departments::all();
        return view('departamente.update_form', array('dep_to_update' => $one_dep, 'allusers'=>$u, 'alldep' =>$d_all));
    }

    public function editDepartament(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'departamenti' => 'required|integer',
            'location' =>'required|string'

        ]);
        /*$dep = Departments::where('dep_id','=',$id)->first();
        $dep->dep_id = $id;
       $dep->dep_name=$request->name;
        $dep->parent_id=$request->departamenti;
        $dep->location=$request->location;
        $dep->manager_id=$request->manager;

        $dep->save();*/
        DB::table('departments')
            ->where('dep_id', '=', $id)
            ->update(['dep_name' => $request->name,
                'parent_id' => $request->departamenti,
                'location' => $request->location,
                'manager_id' => $request->manager]);
        return redirect()->route('admin.jquery.treeview');


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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getUsersofDep(Request $request)
    {
       //print_r($request->all());

        $columns = array(
            0 =>'id',
            1 =>'name',
            2 =>'last_name',
            3 =>'email',
            4 =>'adresa',
            5 =>'is_admin',
            6 =>'dep_fk',


        );

        $id=$request->input('id_id');
        $totalData = User::where('dep_fk', $id)->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))){
            $posts = DB::table('users')
                ->join('departments', 'users.dep_fk', '=', 'departments.dep_id')
                ->where('dep_fk', '=', $id)
                ->select('users.*', 'departments.dep_name as dep_name','departments.dep_id')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,'desc')
                ->get();
            $totalFiltered = DB::table('users')
                ->join('departments', 'users.dep_fk', '=', 'departments.dep_id')
                ->where('dep_fk', '=', $id)->count();
        }else{
            $search = $request->input('search.value');
            $posts = DB::table('users')
                ->join('departments', 'users.dep_fk', '=', 'departments.dep_id')
                ->select('users.*', 'departments.dep_name as dep_name','departments.dep_id')
                ->where([
                    ['dep_fk', '=', $id],
                    ['name', 'like', "%{$search}%"],
                ])
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = User::where('name', 'like', "%{$search}%")
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

                $nestedData['dep_fk'] = $r->dep_name;

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

    public function getdepcrud($id)
    {
        $tedhena = DB::table('departments')
            ->select('departments.*')->where('departments.dep_id', '=', $id)
            ->get();
        return view('departamente.dep_crud', array('departament'=>$tedhena));
    }

    public function deteledep_withid($id)
    {
        $query = DB::table('departments')->select('departments.*')->where('parent_id', '=', $id)->count();

            if ($query >=1) {
                \Session::flash('message','You can"t delete this department because other departments rely on it.');
                return redirect()->route('admin.showdepcrud', array('id'=>$id));
            } else {
                DB::table('departments')->where('dep_id', '=', $id)->delete();
                return redirect()->route('admin.jquery.treeview');
            }

    }
}
