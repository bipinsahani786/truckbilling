<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\Auth;

class ExpenseCategoryManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $category_id;
    public $name;
    public $isEditMode = false;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function saveCategory()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        // Check if user is Superadmin
        $isSuperAdmin = Auth::user()->hasRole('super-admin');

        $data = [
            'name' => $this->name,
            'owner_id' => Auth::id(),
            // Agar superadmin hai toh system default true hoga
            'is_system_default' => $isSuperAdmin ? true : false,
        ];

        if ($this->isEditMode) {
            // Edit Security: Superadmin sab kuch edit kar sakta hai, 
            // Owner sirf apni banai hui (non-system) category.
            $query = ExpenseCategory::query();
            if (!$isSuperAdmin) {
                $query->where('owner_id', Auth::id())->where('is_system_default', false);
            }

            $category = $query->findOrFail($this->category_id);
            $category->update(['name' => $this->name]);
            session()->flash('success', 'Category Updated!');
        } else {
            ExpenseCategory::create($data);
            session()->flash('success', $isSuperAdmin ? 'Global System Category Added!' : 'New Expense Category Added!');
        }

        $this->resetForm();
    }

    public function editCategory($id)
    {
        $isSuperAdmin = Auth::user()->hasRole('super-admin');
        $query = ExpenseCategory::query();

        if (!$isSuperAdmin) {
            // Normal Owner system default edit nahi kar sakta
            $query->where('owner_id', Auth::id())->where('is_system_default', false);
        }

        $category = $query->findOrFail($id);
        $this->category_id = $category->id;
        $this->name = $category->name;
        $this->isEditMode = true;
    }

    public function deleteCategory($id)
    {
        $isSuperAdmin = Auth::user()->hasRole('super-admin');
        $category = ExpenseCategory::findOrFail($id);

        // Security Check: System defaults cannot be deleted by normal owners
        if (!$isSuperAdmin && $category->is_system_default) {
            session()->flash('error', 'Action Denied: System default categories cannot be deleted.');
            return;
        }

        // Agar owner hai toh sirf apni hi delete kar sake
        if (!$isSuperAdmin && $category->owner_id !== Auth::id()) {
            session()->flash('error', 'Unauthorized action.');
            return;
        }

        $category->delete();
        session()->flash('success', 'Category Deleted!');
    }

    public function resetForm()
    {
        $this->reset(['category_id', 'name', 'isEditMode']);
        $this->resetValidation();
    }

    public function render()
    {
        // 1. Fresh Query shuru karein
        $query = ExpenseCategory::query();

        // 2. Role Check
        if (!Auth::user()->hasRole('super-admin')) {
            // Normal Owner ke liye: (Meri ID wali OR Jo System Default ho)
          
            $query->where(function ($q) {
                $q->where('owner_id', Auth::id())
                    ->orWhere('is_system_default', 1); // 1 = true
            });
            // dd($query);
        }

        // 3. Search Filter
        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        // 4. Sorting: System Default hamesha top par (desc), fir latest
        $categories = $query->orderBy('is_system_default', 'desc')
            ->latest()
            ->paginate(15);

        return view('livewire.admin.expense-category-management', [
            'categories' => $categories
        ]);
    }
}