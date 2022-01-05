<div wire:ignore.self class="modal" id="updateOrCreate">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">{{$mode == 'create' ? __('Add New') : __('Edit')}}</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            {!! Form::open(['wire:submit.prevent' => $mode]) !!}

            <div class="modal-body">
                {{-- name --}}
                <div class="row form-group">
                    <div class="col">
                        {!! Form::label('product_name', __('Product'), ['class' => 'label-required']) !!}
                        {!! Form::text('name', null, ['wire:model' => 'name','id' => 'product_name', 'class' => ['form-control']]) !!}
                        @error('name') <div class="tx-danger mt-1"><strong>{{ $message }}</strong></div> @enderror
                    </div>
                </div>
                {{-- price --}}
                <div class="row form-group">
                    <div class="col">
                        {!! Form::label('price', __('Price'), ['class' => 'label-required']) !!}
                        {!! Form::number('name', null, ['wire:model' => 'price','id' => 'price','min' => 0,'step' => .01, 'class' => ['form-control']]) !!}
                        @error('price') <div class="tx-danger mt-1"><strong>{{ $message }}</strong></div> @enderror
                    </div>
                </div>
                {{-- description --}}
                <div class="row form-group">
                    <div class="col">
                        {!! Form::label('description', __('Description')) !!}
                        {!! Form::textarea('name', null, ['wire:model' => 'description','id' => 'description','rows' => 3, 'class' => ['form-control']]) !!}
                        @error('description') <div class="tx-danger mt-1"><strong>{{ $message }}</strong></div> @enderror
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
</script>
@endsection