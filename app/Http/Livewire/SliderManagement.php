<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Slider;
use Livewire\WithFileUploads;

class SliderManagement extends Component
{
    use WithFileUploads;

    public $sliders, $image, $main_text, $description, $button_name, $button_link, $slider_id;

    public function mount()
    {
        $this->sliders = Slider::all(); // Retrieve all sliders
    }

    public function render()
    {
        return view('livewire.slider-management');
    }

    // Store new slider
    public function store()
    {
        $this->validate([
            'image' => 'required|image|max:1024', // 1MB Max image size
            'main_text' => 'required|string|max:255',
            'description' => 'required|string',
            'button_name' => 'required|string|max:255',
            'button_link' => 'required|url',
        ]);

        $imagePath = $this->image->store('sliders', 'public'); // Save image in the storage

        Slider::create([
            'image' => $imagePath,
            'main_text' => $this->main_text,
            'description' => $this->description,
            'button_name' => $this->button_name,
            'button_link' => $this->button_link,
        ]);

        session()->flash('message', 'Slider created successfully!');
        $this->resetForm();
        $this->mount(); // Refresh the sliders list
    }

    // Edit existing slider
    public function edit($id)
    {
        $slider = Slider::find($id);
        $this->slider_id = $slider->id;
        $this->main_text = $slider->main_text;
        $this->description = $slider->description;
        $this->button_name = $slider->button_name;
        $this->button_link = $slider->button_link;
    }

    // Update existing slider
    public function update()
    {
        $this->validate([
            'main_text' => 'required|string|max:255',
            'description' => 'required|string',
            'button_name' => 'required|string|max:255',
            'button_link' => 'required|url',
        ]);

        $slider = Slider::find($this->slider_id);

        if ($this->image) {
            $imagePath = $this->image->store('sliders', 'public');
            $slider->image = $imagePath;
        }

        $slider->main_text = $this->main_text;
        $slider->description = $this->description;
        $slider->button_name = $this->button_name;
        $slider->button_link = $this->button_link;

        $slider->save();

        session()->flash('message', 'Slider updated successfully!');
        $this->resetForm();
        $this->mount(); // Refresh the sliders list
    }

    // Delete slider
    public function delete($id)
    {
        $slider = Slider::find($id);
        if ($slider->image) {
            unlink(storage_path('app/public/' . $slider->image)); // Remove the image file
        }
        $slider->delete();

        session()->flash('message', 'Slider deleted successfully!');
        $this->mount(); // Refresh the sliders list
    }

    // Reset form fields
    public function resetForm()
    {
        $this->image = '';
        $this->main_text = '';
        $this->description = '';
        $this->button_name = '';
        $this->button_link = '';
    }
}
