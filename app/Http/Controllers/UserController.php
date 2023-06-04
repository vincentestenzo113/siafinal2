<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\ApiResponser;
use DB;

Class UserController extends Controller {
private $request;
public function __construct(Request $request){
$this->request = $request;
}
    public function UserGetAll(){
        $users = User::all();
        return response()->json(['data' => $users, 'Site' => 2], 200);
    
    }
    public function userShowID($id)
    {
        //
        $users = User::findOrFail($id);
        return response()->json(['data' => $users, 'Site' => 2], 200);
        
    }
    public function userAdd(Request $request ){
        $rules = [
        'studentFname' => 'required|max:50',
        'studentLname' => 'required|max:50',
        'studentMname' => 'required|max:50',
        'birth' => 'required|date_format:Y/m/d|max:50',
        ];
        $this->validate($request,$rules);
        $users = User::create($request->all());
        return response()->json(['data' => $users, 'Site' => 2], 200);
       
}
    public function userUpdate(Request $request,$id)
    {
    $rules = [
    'studentFname' => 'required|max:50',
    'studentLname' => 'required|max:50',
    'studentMname' => 'required|max:50',
    'birth' => 'required|date_format:Y/m/d|max:50',
    ];
    $this->validate($request, $rules);
    $user = User::findOrFail($id);
    $user->fill($request->all());

    // if no changes happen
    if ($user->isClean()) {
    return $this->errorResponse('At least one value must
    change', Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    $user->save();
    return $user;
}
public function userDelete($id)
{

 $user = User::findOrFail($id);
 $user = User::where('studentID', $id)->first();
 $user->delete();
 return response()->json(['This user is deleted' => $user, 'Site' => 2], 200);
}}