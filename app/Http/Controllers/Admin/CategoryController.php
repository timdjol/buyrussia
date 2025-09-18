<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-category|edit-category|delete-category', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-category', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-category', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-category', ['only' => ['destroy']]);
    }

    private function buildOptions($nodes, array $exceptIds = [], string $prefix = '')
    {
        $out = collect();

        foreach ($nodes as $cat) {
            if (in_array($cat->id, $exceptIds)) {
                continue;
            }

            $out->push(['id' => $cat->id, 'title' => $prefix.$cat->title]);

            $children = $cat->children()->with('children')->orderBy('title')->get();
            if ($children->isNotEmpty()) {
                $out = $out->merge($this->buildOptions($children, $exceptIds, $prefix.'— '));
            }
        }

        return $out;
    }



    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = \App\Models\Category::with(['parent','children'])
            ->orderByRaw('parent_id IS NOT NULL') // сначала корневые (NULL), потом остальные
            ->orderBy('title')
            ->paginate(20);
        $roots = \App\Models\Category::with('children.children')
            ->roots()
            ->orderBy('title')
            ->get();
        return view('auth.categories.index', compact('categories', 'roots'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $tree = Category::with('children')->roots()->orderBy('title')->get();
        $options = $this->buildOptions($tree);
        return view('auth.categories.form', compact('options'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $request['code'] = Str::slug($request->title);
        $params = $request->all();
        unset($params['image']);
        if ($request->has('image')) {
            $path = $request->file('image')->store('categories');
            $params['image'] = $path;
        }
        Category::create($params);
        session()->flash('success', 'Category ' . $request->title . ' created');
        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     */

    public function edit(Request $request, Category $category)
    {
        $category->load('children.descendants'); // загрузим дерево для descendantsIds()
        $except = array_merge([$category->id], $category->descendantsIds());

        $tree = Category::with('children')->roots()->orderBy('title')->get();
        $options = $this->buildOptions($tree, $except);
        return view('auth.categories.form', compact('category',
        'options'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $request['code'] = Str::slug($request->title);
        $params = $request->all();
        unset($params['image']);
        if ($request->has('image')) {
            //Storage::delete($category->image);
            $params['image'] = $request->file('image')->store('categories');
        }
        $category->update($params);
        session()->flash('success', 'Category ' . $request->title . ' updated');
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash('success', 'Category ' . $category->title . ' deleted');
        return redirect()->route('categories.index');
    }
}
