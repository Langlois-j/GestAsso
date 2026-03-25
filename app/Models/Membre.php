<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class Membre extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'membres';

    protected $fillable = [
        'nom',
        'prenom',
        'date_naissance',
        'email',
        'telephone',
        'adresse',
        'n_licence_ffme',
        'saison_validite_licence',
        'licence_verifiee',
        'couleur_passeport',
        'date_validation_passeport',
        'validateur_passeport_id',
        'photo',
        'commentaire_interne',
        'password',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'date_naissance'            => 'date',
        'date_validation_passeport' => 'date',
        'licence_verifiee'          => 'boolean',
    ];

    // --- Accessors ---

    protected function isMineur(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->date_naissance
                ? Carbon::parse($this->date_naissance)->age < 18
                : false,
        );
    }

    protected function nomComplet(): Attribute
    {
        return Attribute::make(
            get: fn () => trim($this->prenom . ' ' . $this->nom),
        );
    }

    protected function iconeAutonomie(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->couleur_passeport) {
                'jaune'  => '🟡',
                'orange' => '🟠',
                'vert'   => '🟢',
                'bleu'   => '🔵',
                'violet' => '🟣',
                default  => '🔴',
            },
        );
    }

    // --- Relations ---

    public function responsablesLegaux(): BelongsToMany
    {
        return $this->belongsToMany(
            ResponsableLegal::class,
            'responsable_legal_membre',
            'membre_id',
            'responsable_legal_id'
        )->withPivot(['type', 'destinataire_documents', 'commentaire'])
         ->withTimestamps();
    }

    public function diplomes(): HasMany
    {
        return $this->hasMany(Diplome::class, 'membre_id');
    }

    public function validateurPasseport(): BelongsTo
    {
        return $this->belongsTo(Membre::class, 'validateur_passeport_id');
    }

    // --- Scopes ---

    public function scopeMineurs($query)
    {
        return $query->where('date_naissance', '>', Carbon::now()->subYears(18));
    }

    public function scopeMajeurs($query)
    {
        return $query->where('date_naissance', '<=', Carbon::now()->subYears(18));
    }

    // --- Helpers ---

    public static function saisonCourante(): string
    {
        $now  = Carbon::now();
        $year = $now->month >= 9 ? $now->year : $now->year - 1;
        return $year . '-' . ($year + 1);
    }
}