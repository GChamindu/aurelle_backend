<?php

namespace App\Observers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSearchIndex;

class ProductObserver
{
    /**
     * CREATED
     */
    public function created(Product $product): void
    {
        // Existing logic (KEEP)
        Category::where('id', $product->category_id)->increment('product_count');

        // New: add to search index
        $this->syncSearchIndex($product);
    }

    /**
     * UPDATED
     */
    public function updated(Product $product): void
    {
        // If category changed, update counters safely
        if ($product->isDirty('category_id')) {
            Category::where('id', $product->getOriginal('category_id'))->decrement('product_count');
            Category::where('id', $product->category_id)->increment('product_count');
        }

        // If soft-deleted, remove from search
        if ($product->deleted_at) {
            ProductSearchIndex::where('product_id', $product->id)->delete();
            return;
        }

        // Otherwise re-sync search text
        $this->syncSearchIndex($product);
    }

    /**
     * SOFT DELETED
     */
    public function deleted(Product $product): void
    {
        // Existing logic (KEEP)
        Category::where('id', $product->category_id)->decrement('product_count');

        // Remove from search index
        ProductSearchIndex::where('product_id', $product->id)->delete();
    }

    /**
     * RESTORED
     */
    public function restored(Product $product): void
    {
        // Restore category count
        Category::where('id', $product->category_id)->increment('product_count');

        // Restore search index
        $this->syncSearchIndex($product);
    }

    /**
     * FORCE DELETED
     */
    public function forceDeleted(Product $product): void
    {
        ProductSearchIndex::where('product_id', $product->id)->delete();
    }

    /**
     * Build & Sync Search Text
     */
    private function syncSearchIndex(Product $product): void
    {
        ProductSearchIndex::updateOrCreate(
            ['product_id' => $product->id],
            [
                'search_text' => collect([
                    $product->name,
                    strip_tags($product->description), // recommended
                    optional($product->category)->name,
                    $product->collections->pluck('name')->implode(' '),
                    $this->normalizeKeywords($product->keywords),
                ])
                    ->filter()
                    ->implode(' ')
            ]
        );
    }



    private function normalizeKeywords($keywords): string
    {
        if (is_array($keywords)) {
            return implode(' ', $keywords);
        }

        if (is_string($keywords)) {
            return str_replace(',', ' ', $keywords);
        }

        return '';
    }
}
