<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Validator;

class CategoriesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    	if($request->ajax())
    	{
    		$categories = App\Category::all();
    		return json_encode([
    			'data' => $categories
    		]);	
    	}

        return view('category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('errors.404');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $name = $this->sanitizeString($request->get('name'));

        $category = new App\Category;

        $validator = Validator::make([
            'Name' => $name
        ],$category->rules());

        if($validator->fails())
        {
            return redirect('category')
                    ->withInput()
                    ->withErrors($validator);
        }
        $category->name = $name;
        $category->save();

        \Alert::success('Category added')->flash();
        return redirect('category');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('room.category.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('errors.404');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->ajax())
        {
            $name = $this->sanitizeString($request->get('name'));
            $id = $this->sanitizeString($id);

            $category = App\Category::find($id);

            $validator = Validator::make([
                'Name' => $name
            ],$category->updateRules());

            if($validator->fails())
            {
                return redirect('category')
                        ->withInput()
                        ->withErrors($validator);
            }
            $category->name = $name;
            $category->save();

            return json_encode('success');
        }

        $name = $this->sanitizeString(Input::get('name'));

        $category = App\Category::find($name);

        $validator = Validator::make([
            'Name' => $category
        ],$category->rules());

        if($validator->fails())
        {
            return redirect('category')
                    ->withInput()
                    ->withErrors($validator);
        }
        $category->name = $name;
        $category->save();

        \Alert::success('Category updated')->flash();
        return redirect('category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if($request->ajax())
        {
            $category = App\Category::find($id);
            $category->delete();
            return json_encode('success');
        }

        $category = App\Category::find($id);
        $category->delete();

        \Alert::success('Category removed')->flash();
        return redirect('category');
    }
}
