<?php

namespace App\Gestion;

use Illuminate\Support\Str;

class PhotoGestion
{
    public function save($image)
    {
        if ($image->isValid()) {
            $chemin = config('images.path');
            $extension = $image->getClientOriginalExtension();

            do {
                $nom = Str::random(10).'.'.$extension;
            } while (file_exists($chemin.'/'.$nom));

            return $image->move($chemin, $nom);
        }

        return false;
    }
}
