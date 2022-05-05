<?php

namespace App\Modules\Company\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
use Laravel\Passport\HasApiTokens;
class Company extends Model
{
    use HasApiTokens, HasFactory;

    protected $table = "companies";
    protected $fillable = ['name','address'];

    public function employee()
    {
        return $this->hasMany(Employee::class,'company_id');
    }
}
