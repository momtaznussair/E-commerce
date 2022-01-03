<?php

namespace App\Traits\Scopes;

trait ActiveScope {
    
    public function scopeIsActive($query, bool $active = true)
    {
        return $query->where('active', $active);
    }
}
