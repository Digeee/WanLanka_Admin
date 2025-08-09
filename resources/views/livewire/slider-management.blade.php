<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="store">
        <input type="file" wire:model="image">
        @error('image') <span class="error">{{ $message }}</span> @enderror
        <input type="text" wire:model="main_text" placeholder="Main Text">
        @error('main_text') <span class="error">{{ $message }}</span> @enderror
        <textarea wire:model="description" placeholder="Description"></textarea>
        @error('description') <span class="error">{{ $message }}</span> @enderror
        <input type="text" wire:model="button_name" placeholder="Button Name">
        @error('button_name') <span class="error">{{ $message }}</span> @enderror
        <input type="url" wire:model="button_link" placeholder="Button Link">
        @error('button_link') <span class="error">{{ $message }}</span> @enderror
        <button type="submit">Add Slider</button>
    </form>

    <h2>Existing Sliders</h2>
    <ul>
        @foreach($sliders as $slider)
            <li>
                <img src="{{ Storage::url($slider->image) }}" alt="Slider Image" width="100">
                <p>{{ $slider->main_text }}</p>
                <p>{{ $slider->description }}</p>
                <p>{{ $slider->button_name }}</p>
                <p>{{ $slider->button_link }}</p>
                <button wire:click="edit({{ $slider->id }})">Edit</button>
                <button wire:click="delete({{ $slider->id }})">Delete</button>
            </li>
        @endforeach
    </ul>
</div>
