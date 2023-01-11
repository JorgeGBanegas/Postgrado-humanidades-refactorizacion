<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ListUser extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {

        $users = User::where('name', 'ilike', '%' . $this->search . '%')
            ->orwhere('last_name', 'ilike', '%' . $this->search . '%')
            ->orwhere('email', 'ilike', '%' . $this->search . '%')

            ->paginate(5);
        return view('livewire.list-user', [
            'users' => $users
        ]);
    }
}
