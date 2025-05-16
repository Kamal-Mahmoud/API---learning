<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\QueryParam;
use Knuckles\Scribe\Attributes\BodyParam;
use Illuminate\Support\Facades\Cache;


#[Group('Categories', 'Managing Categories')]
class CategoryController extends Controller
{
    #[Endpoint('Get Categories', <<<DESC
    Getting the list of the categories
    DESC)]
    #[QueryParam('page', 'int', 'Which page to show.', example: 12)]
    public function index()
    {
        // return Category::all();
        abort_if(! auth()->user()->tokenCan('categories-list'), 403);
        // return CategoryResource::collection(Category::all());
        return CategoryResource::collection(Cache::remember('categories', 60*60*24, function () { 
            return Category::all();
        }));
    }

    public function show(Category $category)
    {
        // return $category;
        abort_if(! auth()->user()->tokenCan('categories-show'), 403);
        return new CategoryResource($category);
    }



    public function list()
    {
        return CategoryResource::collection(Category::all());
    }
    #[BodyParam('name', 'string', 'Name of the category.', true, 'Clothing')]
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $name = "categories/" . Str::uuid() . '' . $file->extension();
            $file->storePubliclyAs('public', $name);
            $data['photo'] = $name;
        }
        $category = Category::create($data);
        return new CategoryResource($category);
    }
    public function update(Category $category, StoreCategoryRequest $request)
    {
        $category->update($request->all());

        return new CategoryResource($category);
    }
    public function destroy(Category $category)
    {
        $category->delete();
        //  return response()->noContent();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
