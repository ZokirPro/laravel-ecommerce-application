<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Contracts\AttributeContract;

class AttributeController extends BaseController
{
    protected $attributeRepository;

    public function __construct(AttributeContract $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }
    /*****************INDEX*************/
    public function index()
    {
        $attributes = $this->attributeRepository->listAttributes();

        $this->setPageTitle('Attributes', 'List of all attributes');
        return view('admin.attributes.index', compact('attributes'));
    }


    /***************CREATE******************/
    public function create()
    {
        $this->setPageTitle('Attributes', 'Create Attribute');
        return view('admin.attributes.create');
    }

    /***************STORE******************/
    public function store(Request $request)
    {
        $this->validate($request, [
            'code'          =>  'required',
            'name'          =>  'required',
            'frontend_type' =>  'required'
        ]);

        $params = $request->except('_token');

        $attribute = $this->attributeRepository->createAttribute($params);

        if (!$attribute) {
            return $this->responseRedirectBack('Error occurred while creating attribute.', 'error', true, true);
        }
        return $this->responseRedirect('admin.attributes.index', 'Attribute added successfully' ,'success',false, false);
    }

    /***************EDIT******************/
    public function edit($id)
    {
        $attribute = $this->attributeRepository->findAttributeById($id);

        $this->setPageTitle('Attributes', 'Edit Attribute : '.$attribute->name);
        return view('admin.attributes.edit', compact('attribute'));
    }

    /***************UPDATE******************/
    public function update(Request $request)
    {
        $this->validate($request, [
            'code'          =>  'required',
            'name'          =>  'required',
            'frontend_type' =>  'required'
        ]);

        $params = $request->except('_token');

        $attribute = $this->attributeRepository->updateAttribute($params);

        if (!$attribute) {
            return $this->responseRedirectBack('Error occurred while updating attribute.', 'error', true, true);
        }
        return $this->responseRedirectBack('Attribute updated successfully' ,'success',false, false);
    }

    /***************DELETE******************/
    public function delete($id)
    {
        $attribute = $this->attributeRepository->deleteAttribute($id);

        if (!$attribute) {
            return $this->responseRedirectBack('Error occurred while deleting attribute.', 'error', true, true);
        }
        return $this->responseRedirect('admin.attributes.index', 'Attribute deleted successfully' ,'success',false, false);
    }
}
