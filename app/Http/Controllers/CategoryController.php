<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\Category;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = \App\Category::paginate(10);


        return view('categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = \Validator::make($request->all(),[
            "name" => "required|min:5|max:100",
            "image" => "required"
        ])->validate();

        // Validate the input and return correct response


        $name = $request->get('name');
        $new_category = new \App\Category;
        $new_category->name = $name;
        if ($request->file('image')) {
            $image_path = $request->file('image')->store('category_images', 'public');
            $new_category->image = $image_path;
        } else {
            $new_category->image = null;
        }

        $new_category->created_by = \Auth::user()->id;

        $new_category->slug = str_slug($name, '-');

        $new_category->save();


        return response()->json([
            'success' => true,
            'message' => 'Category Created'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $category = \App\Category::findOrFail($id);
        return view('categories.show', ['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $category_to_edit = \App\Category::findOrFail($id);
        return $category_to_edit;
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
        //
        $validation = \Validator::make($request->all(),[
            "name" => "required|min:5|max:100"
        ])->validate();

        $name = $request->get('name');

        $category = \App\Category::findOrFail($id);

        $category->name = $name;
        if ($request->file('image')) {
            if ($category->image && file_exists(storage_path('app/public/' . $category->image))) {
                \Storage::delete('public/' . $category->name);
            }
            $new_image = $request->file('image')->store('category_images', 'public');
            $category->image = $new_image;
        }
        $category->updated_by = \Auth::user()->id;
        $category->slug = str_slug($name);
        $category->update();
        return response()->json([
            'success' => true,
            'message' => 'Category Created'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $category = \App\Category::findOrFail($id);
        if ($category->image != NULL){
            unlink(storage_path('app/public/' . $category->image));
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Contact Deleted'
        ]);


    }
    public function categorySearch(Request $request)
    {
        $keyword = $request->get('q');
        $categories = \App\Category::where("name", "LIKE", "%$keyword%")->get();
        return $categories;
    }

    public function apicategory()
    {
        $category = \App\Category::all();
        return Datatables::of($category)
            ->addColumn('show_photo', function($category){
                if ($category->image == NULL){
                    return 'No Image';
                }
                return '<img src="'.asset('storage/'.$category->image).'" width="120px" /><br>';
            })
            ->addColumn('action', function($category){
                return '' .
                       '<a onclick="editForm('. $category->id .')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a> ' .
                       '<a onclick="deleteData('. $category->id .')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            })
            ->rawColumns(['show_photo', 'action'])->make(true);
    }
}
