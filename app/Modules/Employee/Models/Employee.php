<?php

namespace App\Modules\Employee\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Employee extends Model
{
    use HasApiTokens, HasFactory;
    
    protected $fillable = ['email','name','position','company_id'];
    public function company()
    {
        return $this->belongsTo(Company::class,'company_id','id');
    }
}