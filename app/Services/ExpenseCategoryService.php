<?php

namespace App\Services;

use App\Models\ExpenseCategory;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * ExpenseCategoryService
 *
 * Handles expense category management with role-based access control.
 *
 * Access rules:
 * - Super-admin: Can create/edit/delete system-wide default categories visible to all owners.
 * - Owner: Can create/edit/delete their own custom categories. Cannot modify system defaults.
 * - Driver: View-only access (enforced at the component/controller level).
 */
class ExpenseCategoryService
{
    /**
     * Create a new expense category or update an existing one.
     *
     * Super-admin categories are marked as system defaults and are visible to all owners.
     * Owner-created categories are private to that owner only.
     *
     * @param array    $data         Category attributes (primarily 'name')
     * @param int      $userId       The authenticated user's ID
     * @param bool     $isSuperAdmin Whether the current user has the super-admin role
     * @param int|null $categoryId   If provided, updates the existing category; otherwise creates new
     * @return ExpenseCategory The created or updated category instance
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If category not found or access denied
     */
    public function createOrUpdate(array $data, int $userId, bool $isSuperAdmin, ?int $categoryId = null): ExpenseCategory
    {
        // Check for duplicate category name within the same scope
        $duplicateQuery = ExpenseCategory::withoutGlobalScopes()->where('name', $data['name']);
        if ($categoryId) {
            $duplicateQuery->where('id', '!=', $categoryId);
        }

        if ($isSuperAdmin) {
            // Super-admin scope: check duplicates among system default categories only
            $duplicateQuery->where('is_system_default', true);
        } else {
            // Owner scope: check duplicates among their own categories only
            $duplicateQuery->where('owner_id', $userId);
        }

        if ($duplicateQuery->exists()) {
            throw new \InvalidArgumentException('This category name already exists!');
        }

        $categoryData = [
            'name' => $data['name'],
            'owner_id' => $userId,
            'is_system_default' => $isSuperAdmin,
        ];

        if ($categoryId) {
            // Update mode: enforce access control based on role
            $query = ExpenseCategory::query();
            if (!$isSuperAdmin) {
                // Normal owners can only edit their own non-system categories
                $query->where('owner_id', $userId)->where('is_system_default', false);
            }

            $category = $query->findOrFail($categoryId);
            $category->update(['name' => $data['name']]);
            return $category;
        }

        // Create mode
        return ExpenseCategory::create($categoryData);
    }

    /**
     * Delete an expense category with role-based access control.
     *
     * Super-admin can delete any category. Normal owners can only delete
     * their own non-system-default categories.
     *
     * @param int  $categoryId   The category ID to delete
     * @param int  $userId       The authenticated user's ID
     * @param bool $isSuperAdmin Whether the current user has the super-admin role
     * @return bool True if deleted successfully
     *
     * @throws \InvalidArgumentException If access is denied
     */
    public function delete(int $categoryId, int $userId, bool $isSuperAdmin): bool
    {
        $category = ExpenseCategory::findOrFail($categoryId);

        // Security: System default categories cannot be deleted by normal owners
        if (!$isSuperAdmin && $category->is_system_default) {
            throw new \InvalidArgumentException('System default categories cannot be deleted.');
        }

        // Security: Owners can only delete their own categories
        if (!$isSuperAdmin && $category->owner_id !== $userId) {
            throw new \InvalidArgumentException('Unauthorized action.');
        }

        $category->delete();
        return true;
    }

    /**
     * Get a filtered and paginated list of expense categories.
     *
     * For normal owners: shows their own categories AND system defaults.
     * For super-admin: shows all categories.
     * Results are sorted with system defaults at the top, then by newest first.
     *
     * @param int         $userId       The authenticated user's ID
     * @param bool        $isSuperAdmin Whether the user has the super-admin role
     * @param string|null $search       Optional search term to filter by name
     * @return LengthAwarePaginator Paginated category results
     */
    public function getFilteredCategories(int $userId, bool $isSuperAdmin, ?string $search = null): LengthAwarePaginator
    {
        $query = ExpenseCategory::query();

        // Apply ownership filter: owners see their own + system defaults
        if (!$isSuperAdmin) {
            $query->where(function ($q) use ($userId) {
                $q->where('owner_id', $userId)
                  ->orWhere('is_system_default', 1);
            });
        }

        // Apply search filter
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Sort: system defaults first, then newest
        return $query->orderBy('is_system_default', 'desc')
            ->latest()
            ->paginate(15);
    }
}
