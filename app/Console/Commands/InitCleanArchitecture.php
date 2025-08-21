<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InitCleanArchitecture extends Command
{
    protected $signature = 'init:clean-architecture';
    protected $description = 'Generate directory structure for Clean Architecture';

    public function handle()
    {
        $structure = [
            'app/Core/Domain',
            'app/Core/UseCases',
            'app/Core/Contracts',
            'app/Infrastructure/Repositories',
            'app/Http/Controllers',
            'app/Http/Requests',
        ];

        foreach ($structure as $dir) {
            if (!File::exists(base_path($dir))) {
                File::makeDirectory(base_path($dir), 0755, true);
                $this->info("Created: {$dir}");
            } else {
                $this->info("Already exists: {$dir}");
            }
        }

        $this->info('✅ Clean Architecture directory structure initialized successfully.');
    }
}

