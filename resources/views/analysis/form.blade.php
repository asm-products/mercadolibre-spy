<div class="form-group">
  {!! Form::label('name', 'Name: ') !!}
  {!! Form::text('name', null, ['class'=>'form-control']) !!}
</div>

<div class="form-group">
  {!! Form::label('site', 'Site: ') !!}
  {!! Form::select('site', ['MLA'=>'Argentina', 'MLB'=>'Brasil']) !!}

</div>

<div class="form-group">
  <h5>Status</h5>
  <div class="radio">
    <label class="radio-inline">
      {!! Form::radio('status', 'active', true) !!}
      active
    </label>

    <label class="radio-inline">
      {!! Form::radio('status', 'inactive') !!}
      inactive
    </label>
  </div>
</div>

<div class="form-group">

  {!! Form::submit($submitButton, ['class'=>'btn btn-primary form-control']) !!}

</div>
