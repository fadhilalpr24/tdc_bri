<?php

namespace App\Models\Deployment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Deployment extends Model
{
    use HasFactory;
    // protected $primaryKey = 'id';
    // public $incrementing = false;
    protected $fillable = [
        'id_deployment',
        'title',
        'module_id',
        'server_type_id',
        'deploy_date',
        'document_status',
        'document_description',
        'cm_status',
        'cm_description',
    ];

    // Relationships
    public function module()
    {
        return $this->hasMany(DeploymentModule::class);
    }

    public function serverType()
    {
        return $this->hasMany(DeploymentServerType::class);
    }

    
}
