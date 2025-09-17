<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'title',
        'code',
        'image',
        'parent_id'
    ];

    public function posts(){
        return $this->belongsToMany(Post::class);
    }


    public function parent()   {
        return $this->belongsTo(self::class, 'parent_id');
    }
    public function children() {
        return $this->hasMany(self::class, 'parent_id');
    }

    // Рекурсивные потомки (для исключения из селекта)
    public function descendants()
    {
        return $this->children()->with('descendants');
    }

    public function descendantsIds(): array
    {
        $ids = [];
        foreach ($this->children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $child->descendantsIds());
        }
        return $ids;
    }

    // Проверка цикла: будет ли категория предком newParentId
    public static function hasCycle(?int $categoryId, ?int $newParentId): bool
    {
        if (!$categoryId || !$newParentId) return false;
        if ($categoryId === $newParentId) return true;

        $current = self::with('parent')->find($newParentId);
        while ($current) {
            if ($current->id === $categoryId) return true;
            $current = $current->parent;
        }
        return false;
    }

    public function scopeRoots($q) {
        return $q->whereNull('parent_id');
    }
}
