


<div class="container">
    <h1>Guiders List ✅</h1>

    @foreach($guiders as $guider)
        <p>{{ $guider->first_name }} {{ $guider->last_name }} - {{ $guider->email }}</p>
    @endforeach

    {{ $guiders->links() }}
</div>

