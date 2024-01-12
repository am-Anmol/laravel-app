<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserExport implements FromCollection
{
    private $data;
    public function __construct($data) 
    {
        $this->data = $data;
    }
    public function headings():array{
        return[
            'Id',
            'Name',
            'Email',
            'Gender',
            'Created_at',
        ];
    } 
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {   
        $request=$this->data;
        dd($request);
        return User::all();

        // return User::where(function($query) use ($request) {
        //     $query->where('name', 'like', '%'. $request->search .'%')
        //           ->orWhere('email', 'like', '%'. $request->search .'%');
        // })
        // ->when($request->date, function($query, $date) {
        //     $query->whereDate('created_at', $date);
        // })
        // ->when($request->gender, function($query, $gender) {
        //     $query->where('gender', $gender);
        // })
        // ->get();
        // // return User::all();
    }
}
