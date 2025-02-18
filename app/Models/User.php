<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Les attributs assignables en masse.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Les attributs qui doivent être cachés pour la sérialisation.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    /**
     * Relation : Un utilisateur peut appartenir à plusieurs projets.
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class)->withPivot('role');
    }

    /**
     * Relation : Un utilisateur peut avoir plusieurs tâches assignées.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }
}
