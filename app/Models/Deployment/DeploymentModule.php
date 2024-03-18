<?php

namespace App\Models\Deployment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DeploymentModule extends Model
{
    use HasFactory;

    //@return 
    protected $fillable = [
        'name',
        'is_active',
    ];

    // Relationships
    
    public function serverTypes()
    {
        return $this->belongsToMany(DeploymentServerType::class, 'deployments', 'module_id', 'server_type_id')->withTimeStamps();
    }

    // public function deployment() : BelongsToMany
    // {
    //     return $this->belongsToMany(Deployment::class, 'deployments', 'modules_id', 'server_types_id');
    // }
}
