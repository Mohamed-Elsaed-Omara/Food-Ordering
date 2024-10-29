<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SliderDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SliderCreateRequest;
use App\Http\Requests\Admin\SliderUpdateRequest;
use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Slider;
use App\Traits\FileUploadTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Component\HttpKernel\Exception\ControllerDoesNotReturnResponseException;

class SliderController extends Controller
{
    use FileUploadTrait;

    public function index(SliderDataTable $dataTable)
    {
        return $dataTable->render('admin.slider.index');
    }
    public function create() : View
    {
        return view('admin.slider.create');
    }
    public function store(SliderCreateRequest $request)
    {
        //Handle image upload
        $imagePath = $this->updateImage($request,'image');

        $inputData = $request->all();
        $inputData['image'] = $imagePath;

        Slider::create($inputData);

        toastr()->success('Created Successfully');

        return to_route('admin.slider.index');
    }

    public function edit(Slider $slider)
    {
        return view('admin.slider.edit',compact('slider'));
    }

    public function update(SliderUpdateRequest $request ,Slider $slider) : RedirectResponse
    {
        //Handle image upload
        $newPath = $this->updateImage($request, 'image', $slider->image);

        $inputData = $request->all();
        $inputData['image'] = !empty($newPath) ? $newPath : $slider->image;

        $slider->update($inputData);

        toastr()->success('Update Successfully');

        return back();

    }

    public function destroy(Slider $slider)
    {
        try {
            $this->removeImage($slider->image);//image path
            $slider->delete();
            return response(['status' => 'success' , 'message' => 'Deleted Successfully!']);

        } catch (\Exception $e) {
            return response(['status' => 'error' , 'message' => 'something went wrong!']);
        }

    }
}
