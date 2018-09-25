<div class="btn-group btn-group-justified">
    {{ 
        Form::open([
            'url' => route('logout'),
            'method' => 'POST',
        ]) 
    }}
    {{ Form::submit('Logout', ['class' => 'btn btn-warning']) }}
    {{ Form::close() }}
    <a href="{{route('competitor.create')}}" class="btn btn-success">
        <i class="fa fa-user"></i>
    </a>
</div>
