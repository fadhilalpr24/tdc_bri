<?php

namespace App\Models\Deployment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeploymentServerType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        // 'module_id',
        'is_active',
    ];

    // Relationships
    // public function module()
    // {
    //     return $this->belongsToMany(DeploymentModule::class,'deployments', 'module_id', 'server_type_id')->withTimeStamps();
    // }

    // public function deployment()
    // {
    //     return $this->hasMany(Deployment::class);
    // }

    public function module()
    {
        return $this->hasMany(DeploymentModule::class);
    }

    public function deployments()
    {
        return $this->hasMany(Deployment::class);
    }
}
