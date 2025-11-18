<h1>Mis Games</h1>
@if($alphabet->isEmpty())
    <p>No hay games para mostrar.</p>
@else
    <ul>
        @foreach($alphabet as $panel)
            <li>
                {{ $panel->letter }} - {{ $panel->consonant }}
            </li>
        @endforeach
    </ul>
@endif

    
    
    
    
   
