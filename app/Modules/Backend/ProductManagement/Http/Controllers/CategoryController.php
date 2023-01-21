<?php

namespace App\Modules\Backend\ProductManagement\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Mockery\CountValidator\Exception;
use App\Modules\Backend\ProductManagement\Entities\Category;

class CategoryController extends Controller
{
    use ResponseMessage;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('productmanagement::categories.index');
    }

    /* Process ajax request */
    public function categoryList(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // total number of rows per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        $query = Category::query();
        // Total records
        $totalRecords = $query->count();
        $totalRecordswithFilter = $totalRecords;
        // Get records, also we have included search filter as well
        if (!empty($searchValue)) {
            $query
                ->where('name', 'like', '%' . $searchValue . '%')
                ->orWhere('order', 'like', '%' . $searchValue . '%')
                ->orWhere('id', 'like', '%' . $searchValue . '%');
            $totalRecordswithFilter = $query->count();
        }
        $records = $query
            ->with('parents')
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $checked = '';
            if ($record->is_active)
                $checked = 'checked';
            $display = '';
            if ($record->show_in_home)
                $display = 'checked';
            $parent = 'ROOT';
            if ($record->category_id)
                $parent = $record->parents->name ?? '';
            $image = '<img src="' . URL::to('uploads/categories/32x32/' . $record->icon) . '" width="60px"
                                             height="60px" alt="logo">';

            $edit_route = auth('seller')->user() ? route('seller.categories.edit', $record->id) : route('backend.categories.edit', $record->id);
            $delete_route = auth('seller')->user() ? route('seller.categories.destroy', $record->id) : route('backend.categories.destroy', $record->id);
            $edit_button = '';
            $delete_button = '';
            if(auth()->user()->can('edit_categories') || auth()->user()->hasRole('super-admin'))
                $edit_button = '<li>
                                            <a class="p-0 action" href="' . $edit_route . '">
                                                <button title="Edit">
                                                    <svg viewBox="0 0 11 11" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M8.72031 5.31576C8.48521 5.31576 8.29519 5.50625 8.29519 5.74089V9.1421C8.29519 9.37634 8.1047 9.56722 7.87007 9.56722H1.91801C1.68331 9.56722 1.49289 9.37634 1.49289 9.1421V3.19C1.49289 2.95575 1.68331 2.76487 1.91801 2.76487H5.3192C5.5543 2.76487 5.74432 2.57438 5.74432 2.33975C5.74432 2.10504 5.5543 1.91455 5.3192 1.91455H1.91801C1.21483 1.91455 0.642578 2.4868 0.642578 3.19V9.1421C0.642578 9.84529 1.21483 10.4175 1.91801 10.4175H7.87007C8.57326 10.4175 9.14551 9.84529 9.14551 9.1421V5.74089C9.14551 5.50579 8.95541 5.31576 8.72031 5.31576Z"/>
                                                        <path d="M4.62759 4.9274C4.59785 4.95714 4.57785 4.99497 4.56936 5.03577L4.26879 6.53916C4.25477 6.60884 4.27688 6.68069 4.32702 6.73129C4.36742 6.77169 4.42184 6.79333 4.47758 6.79333C4.49112 6.79333 4.50521 6.79209 4.51923 6.78913L6.02218 6.48856C6.06383 6.48 6.10167 6.46007 6.13101 6.43025L9.49487 3.06645L7.99192 1.5636L4.62759 4.9274Z"/>
                                                        <path d="M10.5329 0.525254C10.1184 0.110723 9.444 0.110723 9.02982 0.525254L8.44141 1.11362L9.94444 2.61652L10.5329 2.02808C10.7336 1.82786 10.8441 1.56084 10.8441 1.27686C10.8441 0.992876 10.7336 0.725864 10.5329 0.525254Z"/>
                                                    </svg>
                                                </button>
                                            </a>
                                </li>';
            if(auth()->user()->can('delete_categories') || auth()->user()->hasRole('super-admin'))
                $delete_button = '<li>
                                             <form user="deleteForm" method="POST"
                                                      action="' . $delete_route . '">
                                                    ' . csrf_field() . method_field("DELETE") . '
                                                    <a class="p-0 action" href="javascript:void(0);"
                                                       onclick="deleteWithSweetAlert(event,parentNode);">
                                                        <button title="Delete">
                                                            <svg viewBox="0 0 10 11" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M8.65184 10.2545C8.63809 10.5288 8.36791 10.7452 8.03934 10.7452H2.31625C1.98768 10.7452 1.7175 10.5288 1.70375 10.2545L1.29504 3.04834H9.06055L8.65184 10.2545ZM3.88317 4.83823C3.88317 4.7234 3.77169 4.63027 3.63416 4.63027H3.23589C3.09844 4.63027 2.98688 4.72338 2.98688 4.83823V8.95529C2.98688 9.07014 3.09835 9.16324 3.23589 9.16324H3.63416C3.77163 9.16324 3.88317 9.07019 3.88317 8.95529V4.83823ZM5.62591 4.83823C5.62591 4.7234 5.51444 4.63027 5.37693 4.63027H4.97866C4.84121 4.63027 4.72968 4.72338 4.72968 4.83823V8.95529C4.72968 9.07014 4.84112 9.16324 4.97866 9.16324H5.37693C5.51441 9.16324 5.62591 9.07019 5.62591 8.95529V4.83823ZM7.36871 4.83823C7.36871 4.7234 7.25724 4.63027 7.11973 4.63027H6.72143C6.58396 4.63027 6.47245 4.72338 6.47245 4.83823V8.95529C6.47245 9.07014 6.58393 9.16324 6.72143 9.16324H7.11973C7.25721 9.16324 7.36871 9.07019 7.36871 8.95529V4.83823Z"/>
                                                                <path d="M1.0213 1.09395H3.66155V0.677051C3.66155 0.617846 3.71902 0.569824 3.78994 0.569824H6.56248C6.63337 0.569824 6.69083 0.617846 6.69083 0.677051V1.09393H9.33112C9.5436 1.09393 9.71582 1.23779 9.71582 1.41526V2.42468H0.636597V1.41528C0.636597 1.23782 0.808817 1.09395 1.0213 1.09395Z"/>
                                                            </svg>
                                                        </button>
                                                    </a>
                                                </form>
                                    </li>';
            $data_arr[] = array(
                "id" => $record->id,
                "name" => $record->name,
                "image" => $image,
                "category_id" => $parent,
                "show_in_home" => '<div class="form-switch"><input class="form-check-input display_out_website" type="checkbox"
                                data-id="' . $record->id . '"' . $display . '></div>',
                "order" => $record->order,
                "is_active" => '<div class="form-switch"><input class="form-check-input status" type="checkbox"
                                data-id="' . $record->id . '"' . $checked . '></div>',
                "action" => '<ul>
                                '.$edit_button.'
                                '.$delete_button.'
                            </ul>'
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );

        return json_encode($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = new Category();
        $categories = Category::select('id', 'name')->get();
        return view('productmanagement::categories.create', compact('category', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required |string|max:200|unique:categories,name,NULL,id,deleted_at,NULL',
                'slug' => 'required |string|max:200|unique:categories,slug,NULL,id,deleted_at,NULL',
                'order' => 'required',
                'banner' => 'required|mimes:jpeg,png,jpg,gif,svg',
                'icon' => 'required|mimes:jpeg,png,jpg,gif,svg',
                'meta_title' => 'required',
            ]);
            $data = $request->only(['name', 'category_id', 'order', 'meta_title', 'meta_description', 'slug', 'commission_rate']);
            $banner = $request->file('banner');
            $icon = $request->file('icon');
            if ($banner) {
                $banner_path = Storage::putFile('categories/200x200', $banner);
                $pattern = "/categories\/200x200\//";
                $banner_path = preg_replace($pattern, '', $banner_path);
            } else {
                $banner_path = 'default_banner.jpg';
            }
            $data['banner'] = $banner_path;
            if ($icon) {
                $icon_path = Storage::putFile('categories/32x32', $icon);
                $pattern = "/categories\/32x32\//";
                $icon_path = preg_replace($pattern, '', $icon_path);
            } else {
                $icon_path = 'default_icon.jpg';
            }
            $data['icon'] = $icon_path;
            $data['is_active'] = 0;
            $data['show_in_home'] = 0;
            $category = Category::create($data);
            if ($category) {
                if (auth('seller')->user())
                    return redirect()->route('seller.categories.index')->with($this->create_success_message);
                else
                    return redirect()->Route('backend.categories.index')->with($this->create_success_message);
            } else {
                if (auth('seller')->user())
                    return redirect()->Route('seller.categories.create')->withInput()->with($this->create_fail_message);
                else
                    return redirect()->Route('backend.categories.create')->withInput()->with($this->create_fail_message);
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return back()->withInput()->with($this->create_fail_message);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Backend\Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /* change status*/
    public function changeStatus(Request $request)
    {
        $category = Category::find($request->cat_id);
        if ($category) {
            if ($request->field == 'is_active')
                $category->is_active = $request->status;
            if ($request->field == 'show_in_home')
                $category->show_in_home = $request->status;
            $category->save();
            return response()->json($this->update_success_message);
        } else {
            return response()->json($this->not_found_message);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Backend\Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::select('id', 'name')->where('id', '!=', $category->id)->get();
        return view('productmanagement::categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Backend\Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
            $request->validate([
                'name' => 'required |string|max:200|unique:categories,name,' . $category->id. ',id,deleted_at,NULL',
                'slug' => 'required |string|max:200|unique:categories,slug,' . $category->id. ',id,deleted_at,NULL',
                'order' => 'required',
                'banner' => 'nullable|mimes:jpeg,png,jpg,gif,svg',
                'icon' => 'nullable| mimes:jpeg,png,jpg,gif,svg',
                'meta_title' => 'required',
            ]);
            $data = $request->only(['name', 'category_id', 'order', 'meta_title', 'meta_description', 'slug', 'commission_rate']);

            $category->update($data);
            $category->refresh();
            $banner = $request->file('banner');
            $icon = $request->file('icon');
            if ($banner) {
                $banner_path = Storage::putFile('categories/200x200', $banner);
                $pattern = "/categories\/200x200\//";
                $banner_path = preg_replace($pattern, '', $banner_path);
                if (file_exists(storage_path('app/public/categories/200x200/') . $category->banner)) {
                    Storage::delete('categories/200x200/' . $category->banner);
                }
                $category->banner = $banner_path;
                $category->save();
            }
            if ($icon) {
                $icon_path = Storage::putFile('categories/32x32', $icon);
                $pattern = "/categories\/32x32\//";
                $icon_path = preg_replace($pattern, '', $icon_path);
                if (file_exists(storage_path('app/public/categories/32x32/') . $category->icon))
                    Storage::delete('categories/32x32/' . $category->icon);
                $category->icon = $icon_path;
                $category->save();
            }
            if ($category) {
                if (auth('seller')->user())
                    return redirect()->route('seller.categories.index')->with($this->update_success_message);
                else
                    return redirect()->Route('backend.categories.index')->with($this->update_success_message);
            } else {
                if (auth('seller')->user())
                    return redirect()->Route('seller.categories.edit')->withInput()->with($this->update_fail_message);
                else
                    return redirect()->Route('backend.categories.edit')->withInput()->with($this->update_fail_message);
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return back()->withInput()->with($this->update_fail_message);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Backend\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if ($category) {
            if (file_exists(storage_path('app/public/categories/200x200/') . $category->banner))
                Storage::delete('categories/200x200/' . $category->banner);
            if (file_exists(storage_path('app/public/categories/32x32/') . $category->icon))
                Storage::delete('categories/32x32/' . $category->icon);
            $category->delete();
            if (auth('seller')->user())
                return redirect()->route('seller.categories.index')->with($this->delete_success_message);
            else
                return redirect()->route('backend.categories.index')->with($this->delete_success_message);
        } else {
            return back()->with($this->not_found_message);
        }
    }
}
