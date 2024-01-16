<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;

class UsersImport implements ToModel, WithChunkReading, ShouldQueue  
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {   
        return new User([
            "name"=> $row["0"],
            "email"=> $row["1"],
            "password"=> bcrypt($row["2"]),
            "gender" => $row["3"],
            "created_at"=> now()->timestamp,
            "user_type" => 'user',
        ]);
    }

    public function chunkSize(): int
    {
        return 10;
    }
}
