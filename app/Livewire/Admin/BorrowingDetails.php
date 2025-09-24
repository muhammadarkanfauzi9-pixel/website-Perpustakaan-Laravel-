<?php

namespace App\Livewire\Admin;

use App\Models\Borrowing;
use Livewire\Component;

class BorrowingDetails extends Component
{
    public $showModal = false;
    public $borrowing = null;

    public function openModal($borrowingId)
    {
        $this->borrowing = Borrowing::with(['user', 'book'])->find($borrowingId);
        if (!$this->borrowing) {
            $this->borrowing = null;
            $this->showModal = false;
            return;
        }
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->borrowing = null;
    }

    public function render()
    {
        return view('livewire.admin.borrowing-details');
    }
}
