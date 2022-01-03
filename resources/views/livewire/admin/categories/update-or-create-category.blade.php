<div wire:ignore.self class="modal" id="updateOrCreate">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">{{$mode == 'create' ? __('Add New') : __('Edit')}}</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            {!! Form::open(['wire:submit.prevent' => $mode]) !!}

            <div class="modal-body">
                <div class="row form-group">
                    <div class="col">
                        <div wire:ignore>
                            {!! Form::label('parent_id', __('Category'), []) !!}
                            {!! Form::select('parent_id', $categories, null, ['wire:model' => 'parent_id', 'id' => 'parent_id', 'class' => ['form-control', 'select2'], 'placeholder' => '', 'style' => 'width:100%']) !!}
                        </div>
                        @error('parent_id') <div class="tx-danger mt-1"><strong>{{ $message }}</strong></div> @enderror
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col">
                        <div wire:ignore>
                            {!! Form::label('CategoryName', __('Category'), ['class' => 'label-required']) !!}
                            {!! Form::text('name', null, ['wire:model' => 'name','id' => 'Categoryname', 'class' => ['form-control']]) !!}
                        </div>
                        @error('name') <div class="tx-danger mt-1"><strong>{{ $message }}</strong></div> @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Cancel')}}</button>
                {!! Form::submit(__('Confirm'), ['class' => ['btn btn-primary'], ]) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@section('js')
<script>
$('#updateOrCreate').on('hidden.bs.modal', function () {
    @this.resetAll();
})

$('#parent_id').select2({
    placeholder: "Select a Category",
    allowClear: true
});
$('#parent_id').on('change', function(e) {
    let data = $('#parent_id').select2("val");
    @this.set('parent_id', data);
});
</script>
@endsection