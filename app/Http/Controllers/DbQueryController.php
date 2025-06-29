<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DbQueryController extends Controller
{
    public function insertData(){
        $data=DB::insert('INSERT INTO students(name,email,age) VALUES(?,?,?)',['kamal','kamal@.com',20]);
        return $data;
    }
    public function showData(){
        $data=DB::select("SELECT * FROM students WHERE age < 40 and name LIKE '%N%'");
        return $data;
    }
    public function updateData($id){
        $update=DB::update("UPDATE students SET name='Kasim' WHERE id=?",[$id]);
        return $update;
    }
    public function deleteData($id){
        $delete=DB::delete("DELETE FROM students WHERE id=?",[$id]);
        $name='Nirobfggf';
        return $delete;
    }
}
