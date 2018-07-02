@if ($errors->any())
    @component('components.alert', ['color' => 'danger'])
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endcomponent
@endif
