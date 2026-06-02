<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\File;

class ViewLogs extends Component
{
    public string $logContent = '';
    public string $status = '';

    public function mount()
    {
        $this->loadLogs();
    }

    public function loadLogs()
    {
        $logPath = storage_path('logs/laravel.log');

        if (!File::exists($logPath)) {
            $this->logContent = __('No log file found at: storage/logs/laravel.log');
            return;
        }

        $this->logContent = File::get($logPath);
    }

    public function clear()
    {
        $logPath = storage_path('logs/laravel.log');

        if (!File::exists($logPath)) {
            $this->status = __('⚠️ No log file found.');
            return;
        }

        File::put($logPath, '');

        $this->status = __('✅ Logs cleared successfully.');
        $this->loadLogs();
    }

    public function refreshLogs()
    {
        $this->loadLogs();
        $this->status = __('🔄 Logs refreshed.');
    }

    public function render()
    {
        return view('livewire.view-logs');
    }
}
