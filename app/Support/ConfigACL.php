<?php

namespace App\Support;
use Alexusmai\LaravelFileManager\Services\ConfigService\ConfigRepository;

class TestConfigRepository implements ConfigRepository
{
    // implement all methods from interface
    
    /**
     * Get disk list
     *
     * ['public', 'local', 's3']
     *
     * @return array
     */
    public function getDiskList(): array
    {
        if (\Auth::id() === 1) {
            return [
                ['public', 'local', 's3'],
            ];
        }
        
        return ['public'];
    }
    ...
}