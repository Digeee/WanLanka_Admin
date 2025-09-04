<?php
namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        return view('admin.ui_management.slider.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.ui_management.slider.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
            'caption' => 'required|string|max:255',
            'description' => 'required|string',
            'button_name' => 'required|string|max:255',
            'button_link' => 'required|url',
        ]);

        $imagePath = $request->file('image')->store('slider_images', 'public');

        Slider::create([
            'image' => $imagePath,
            'caption' => $request->caption,
            'description' => $request->description,
            'button_name' => $request->button_name,
            'button_link' => $request->button_link,
        ]);

        return redirect()->route('admin.sliders.index');

    }

    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.ui_management.slider.edit', compact('slider'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable|image',
            'caption' => 'required|string|max:255',
            'description' => 'required|string',
            'button_name' => 'required|string|max:255',
            'button_link' => 'required|url',
        ]);

        $slider = Slider::findOrFail($id);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('slider_images', 'public');
            $slider->image = $imagePath;
        }

        $slider->caption = $request->caption;
        $slider->description = $request->description;
        $slider->button_name = $request->button_name;
        $slider->button_link = $request->button_link;
        $slider->save();

        return redirect()->route('admin.sliders.index');
    }

    public function destroy($id)
    {
        Slider::destroy($id);
        return redirect()->route('admin.sliders.index');
    }
}
