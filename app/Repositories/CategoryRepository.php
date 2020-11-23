<?php

namespace App\Repositories;

use App\Models\Category;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\CategoryContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use TypiCMS\NestableTrait; 
/**
 * Class CategoryRepository
 *
 * @package \App\Repositories
 */
class CategoryRepository extends BaseRepository implements CategoryContract
{
    use UploadAble;
    use NestableTrait;

    //constructor
    /**
     * CategoryRepository constructor.
     * @param Category $model
     */
    public function __construct(Category $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }


    //list categories
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listCategories(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }


    //find category by id
    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findCategoryById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }


    //create category
    /**
     * @param array $params
     * @return Category|mixed
     */
    public function createCategory(array $params)
    {
        try {
            $collection = collect($params);
            
            $image = null;

            if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {
                $image = $this->uploadOne($params['image'], 'categories');
            }

            $featured = $collection->has('featured') ? 1 : 0;
            $menu = $collection->has('menu') ? 1 : 0;

            $merge = $collection->merge(compact('menu', 'image', 'featured'));

            $category = new Category($merge->all());

            $category->save();

            return $category;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }


    //update category  
    /**
     * @param array $params
     * @return mixed
     */
    public function updateCategory(array $params)
    {
        $category = $this->findCategoryById($params['id']);

        $collection = collect($params)->except('_token');

        $featured = $collection->has('featured') ? 1 : 0;
        $menu = $collection->has('menu') ? 1 : 0;

        if ($collection->has('image') && ($params['image'] instanceof UploadedFile)) {

            if ($category->image != null)
            {
                 $this->deleteOne($category->image);
            }

            $image = $this->uploadOne($params['image'], 'categories');
            $merge = $collection->merge(compact(['menu', 'image' , 'featured']));
        }
        else
        {
            $merge = $collection->merge(compact(['menu', 'featured']));
        }

        $category->update($merge->all());

        return $category;
    }

    //delete category
    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteCategory($id)
    {
        $category = $this->findCategoryById($id);

        if ($category->image != null) {
            $this->deleteOne($category->image);
        }

        $category->delete();

        return $category;
    }
    //for nested categories
    /**
     * @return mixed
     */
    public function treeList()
    {
        return Category::orderByRaw('-name ASC')
            ->get()
            ->nest()
            ->setIndent('|–– ')
            ->listsFlattened('name');
    }
    public function findBySlug($slug)
    {
        return Category::with('products')
            ->where('slug', $slug)
            ->where('menu', 1)
            ->first();
    }
    
}