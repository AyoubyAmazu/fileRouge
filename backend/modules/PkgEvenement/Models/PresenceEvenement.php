<?php

namespace Modules\pkgEvenement\Models;

use Illuminate\Database\Eloquent\Model;

class PresenceEvenement extends Model
{
protected $fillable = ['evenement_id', 'participant_id', 'statut'];

    public function evenement()
    {
        return $this->belongsTo(Evenement::class);
    }

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}
