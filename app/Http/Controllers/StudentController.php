<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Book;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class StudentController extends Controller
{
    function index(){
    //    return $books=Book::with('user')->where('author_id','=',10)->get();
    // DB::table('students')->get();
    // $users= DB::table('users')->where('age','<=',40)->get();
    // $users=collect();
    // Student::chunk(3,function($new)  use (&$users){
    //     foreach($new as $user){
    //         $users->push($user);
    //     }
    // });
    // return $alusers;
    $users=Student::paginate(5);

    return view('users',compact('users'));
       
    }

    public function users(){
        $users=DB::table('users')->paginate(4);
        // return  DB::select('Select name,email from users where id=1');
        
        return view('users',compact('users'));
    }
    public function view(string $id){
        $user=DB::table('users')->select('name','email')->where('id','=',$id)->first();
        return view('singleuser',compact('user'));
    }

    public function update(string $id){
        $user=DB::table('users')->where('id','=',$id)->first();
        return view('updateuser',compact('user'));
    }

    public function updateUser(Request $request,string $id){
        $request->validate([
            'name'=>['required','max:20','min:3'],
            'email'=>['required','email','unique:users,email,'.$id],
        ]);
        DB::table('users')->where('id','=',$id)->update([
            'name'=>$request->name,
            'email'=>$request->email
        ]);

        return redirect()->route('users')->with('success',"$request->name Your Data Updated Successfully");
    }

    public function stData(){
        // $students=DB::table('students')
        // ->leftJoin('books','books.author_id','=','students.id')
        // ->select('students.*','books.title')
        // ->get();
        $students = DB::table('students')
                    ->leftJoin('books', 'books.author_id', '=', 'students.id')
                    ->select(
                        'students.id',
                        'students.name',
                        'students.email',
                        'students.photo',
                        DB::raw("GROUP_CONCAT(books.title SEPARATOR ', ') as book_titles")
                    )
                    ->groupBy('students.id', 'students.name', 'students.email','students.photo')
                    ->get();
        // return $students;
        return view('student',compact('students'));
    }
    public function authorView(string $id){
        $author=DB::table('students')
        ->leftJoin('books','books.author_id','=','students.id')
        ->where('students.id','=',$id)
        ->select('students.*','books.title')
        ->first();
        return view('studentView',compact('author'));
    }

    public function UnionItem(){
        $students=DB::table('students')
                  ->select('name as title',DB::raw("'student' as type"));
        $books=DB::table('books')
                    ->select('title as title',DB::raw("'book' as type"))
                    ->union($students)->get();
        return $books;
    }

    public function updateStudent($id){
        $student=Student::findOrFail($id);
        return view('studenupdate',compact('student'));
    }


    public function studentUpdate(Request $request, $id){
       $request->validate([
        'name'=>['required'],
        'email'=>['required','unique:students,email,'.$id]
       ]);
    //    return $request->all();

       $data=[
        'name'=>$request->name,
        'email'=>$request->email,
       ];

       if($request->hasFile('photo')){     
            $photo=$request->photo;
            $photo_Ex=$photo->extension();
            $photo_name=time() . '.' . $photo_Ex;
            $manager = new ImageManager(new Driver());
            $image = $manager->read($photo);
            // $image->resize(200, 200);
            $image->save(public_path('uploads/students/'.$photo_name));
            $data['photo']=$photo_name;
        }

        Student::findOrFail($id)->update($data);
        return redirect()->route('students')->with('success', ucfirst($request->name) . ' Your Data Updated Successfully');

    }

    public function studentSearch(Request $request){
        $query=$request->get('search');
        // $students=Student::where(function($q) use ($query){
        //    $q->where('name','like','%'.$query.'%')
        //    ->orWhere('email','like','%'.$query.'%');
        // })->get();
        
    $students = Student::where(function($q) use ($query) {
        $q->where('name', 'like', '%' . $query . '%')
          ->orWhere('email', 'like', '%' . $query . '%');
        })->with('books')->get();

        // return $students;

        return response()->json($students);
    }

    public function test(){
        $collect=collect([1,2,3,4])->map(function($i){
            return $i;
        });
        $number=collect([1,2,3,4,5,6,7,8,9,10]);
        $number2=collect([1,5,9,7,8,6,4,3,2,10]);
        $filter=$number->filter(function($i){
            return $i%2==0;
        });
        $skipWhile=$number->skipWhile(function($i){
            return $i <=3;
        });
        // $each=$number->each(function($i){
        //     echo $i*2 ."<br>";
        // });
        $slice=$number->slice(3);
        $sliding=$number->sliding(2);
        $contains=$number->isEmpty();
        $sort=$number2->sort();
        // return $sort->values();
        $splice=$number->splice(5);

        $number3=collect([1,2,3,4,5,6,7,8,9,10]);
        $splice2=$number3->splice(offset: 2,length: 2,replacement: [11,12]);
        

        // return $number->average();
        return $splice2;
    }
    
 

}
