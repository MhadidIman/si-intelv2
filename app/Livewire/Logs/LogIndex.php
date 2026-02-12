<?php

namespace App\Livewire\Logs;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;

class LogIndex extends Component
{
    use WithPagination;

    public $search = '';

    #[Layout('layouts.app')]
    public function render()
    {
        $logs = DB::table('activity_logs')
            // Gunakan LEFT JOIN agar log tanpa user (Gagal Login) tetap muncul
            ->leftJoin('users', 'activity_logs.user_id', '=', 'users.id')
            ->select(
                'activity_logs.*',
                'users.name as user_name',
                'users.role as user_role'
            )
            ->where(function ($query) {
                $query->where('activity_logs.activity', 'like', '%' . $this->search . '%')
                    ->orWhere('activity_logs.description', 'like', '%' . $this->search . '%')
                    ->orWhere('users.name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('activity_logs.created_at', 'desc')
            ->paginate(10);

        return view('livewire.logs.log-index', [
            'logs' => $logs
        ]);
    }
}
