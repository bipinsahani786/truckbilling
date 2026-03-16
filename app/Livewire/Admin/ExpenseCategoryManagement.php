<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ExpenseCategory;
use App\Services\ExpenseCategoryService;
use Illuminate\Support\Facades\Auth;

/**
 * ExpenseCategoryManagement Livewire Component
 *
 * Manages expense categories with role-based access control:
 * - Super-admin: Can manage system-wide default categories (visible to all owners)
 * - Owner: Can manage their own custom categories (private to them)
 *
 * Business logic is delegated to ExpenseCategoryService.
 * This component only handles UI state, validation, and flash messaging.
 */
class ExpenseCategoryManagement extends Component
{
    use WithPagination;

    // --- Search & Form Properties ---
    /** @var string Search query for filtering categories by name */
    public $search = '';
    /** @var int|null Category ID (set during edit mode) */
    public $category_id;
    /** @var string Category name */
    public $name;
    /** @var bool Whether the form is in edit mode */
    public $isEditMode = false;

    /** Reset pagination when search query changes */
    public function updatedSearch()
    {
        $this->resetPage();
    }

    /**
     * Validate and save a new category or update an existing one.
     *
     * Super-admin created categories are marked as system defaults.
     * Owner-created categories are private to that owner.
     */
    public function saveCategory()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        $isSuperAdmin = Auth::user()->hasRole('super-admin');

        try {
            $categoryService = app(ExpenseCategoryService::class);
            $categoryService->createOrUpdate(
                ['name' => $this->name],
                Auth::id(),
                $isSuperAdmin,
                $this->isEditMode ? $this->category_id : null
            );

            if ($this->isEditMode) {
                session()->flash('success', 'Category Updated!');
            } else {
                session()->flash('success', $isSuperAdmin ? 'Global System Category Added!' : 'New Expense Category Added!');
            }

            $this->resetForm();
        } catch (\InvalidArgumentException $e) {
            $this->addError('name', $e->getMessage());
        }
    }

    /**
     * Populate the form with an existing category's data for editing.
     * Normal owners cannot edit system default categories.
     *
     * @param int $id The category ID to edit
     */
    public function editCategory($id)
    {
        $isSuperAdmin = Auth::user()->hasRole('super-admin');
        $query = ExpenseCategory::query();

        // Normal owners can only edit their own non-system categories
        if (!$isSuperAdmin) {
            $query->where('owner_id', Auth::id())->where('is_system_default', false);
        }

        $category = $query->findOrFail($id);
        $this->category_id = $category->id;
        $this->name = $category->name;
        $this->isEditMode = true;
    }

    /**
     * Delete a category with role-based access control.
     * System default categories cannot be deleted by normal owners.
     *
     * @param int $id The category ID to delete
     */
    public function deleteCategory($id)
    {
        $isSuperAdmin = Auth::user()->hasRole('super-admin');

        try {
            $categoryService = app(ExpenseCategoryService::class);
            $categoryService->delete($id, Auth::id(), $isSuperAdmin);
            session()->flash('success', 'Category Deleted!');
        } catch (\InvalidArgumentException $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    /**
     * Reset the category form to its initial state.
     */
    public function resetForm()
    {
        $this->reset(['category_id', 'name', 'isEditMode']);
        $this->resetValidation();
    }

    /**
     * Render the component view with paginated category list.
     * System default categories appear at the top of the list.
     */
    public function render()
    {
        $isSuperAdmin = Auth::user()->hasRole('super-admin');
        $categoryService = app(ExpenseCategoryService::class);

        $categories = $categoryService->getFilteredCategories(Auth::id(), $isSuperAdmin, $this->search);

        return view('livewire.admin.expense-category-management', [
            'categories' => $categories,
        ]);
    }
}