<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Company;
use App\Models\BranchOffice;

class DutyStation extends Model
{
    use HasFactory;

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function branchOffice()
    {
        return $this->belongsTo(BranchOffice::class);
    }
}
