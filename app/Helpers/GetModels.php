<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;

class GetModels {

    public function __invoke()
    {
        $models_files = File::files(app_path('Models'));
        return  collect($models_files)->map(function ($file) {
              return basename($file, '.php');
          });
    }
}