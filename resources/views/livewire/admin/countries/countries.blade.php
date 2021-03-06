<div class="card-body">
    <x-filters />
    <div class="table-responsive">
        <table id="rolesTable" class="table text-md-nowrap">
            <thead>
                <tr class="text-center">
                    <th class="border-bottom-0">#</th>
                    <th class="border-bottom-0">{{__('Name')}}</th>
                    <th class="border-bottom-0">{{__('Active')}}</th>
                    <th class="border-bottom-0">{{__('Operations')}}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($countries as $country)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$country->name}}</td>
                        <td>
                            @can('Country_edit')
                            <div class="custom-control custom-switch">
                                <input wire:change="toggleActive({{$country->active}})" wire:click="select({{$country}})"
                                type="checkbox" {{ $country->active ? 'checked' : '' }} {{ $country->deleted_at ? 'disabled' : '' }} class="custom-control-input" id="{{$country->id}}">
                                <label class="custom-control-label" for="{{$country->id}}"></label>
                            </div>
                            @endcan
                        </td>
                        <td>
                            @can('Country_delete')
                                @if ($country->deleted_at)
                                    <a  
                                        wire:click="restore({{$country->id}})" class="btn btn-sm btn-info"
                                        title="{{__('Restore')}}"><i class="fas fa-trash-restore tx-white"></i>
                                    </a> 
                                    <a
                                        wire:click="select({{$country}})"
                                        class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                        data-toggle="modal" href="#forceDelete" title="{{__('Delete Permanently')}}"><i
                                        class="far fa-trash-alt"></i>
                                    </a>
                                    @else
                                    <a
                                        wire:click="select({{$country}})"
                                        class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                        data-toggle="modal" href="#delete" title="{{__('Delete')}}"><i
                                        class="las la-trash"></i>
                                    </a>
                                @endif
                            @endcan     
                        </td>
                    </tr>
                @empty
                <tr class="tx-center">
                    <td colspan="4">{{__('No results found.')}}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="row mx-3">{{$countries->links()}} </div>
    {{-- delete modal --}}
    <x-crud-by-name-modal mode="delete" title="{{__('Delete')}}"/>
    <x-crud-by-name-modal mode="forceDelete" title="{{__('Delete Permanently')}}"/>

    {{--add  modal --}}
    <div wire:ignore.self class="modal" id="save">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{__('Add New')}}</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                {!! Form::open(['wire:submit.prevent' => 'save']) !!}

                <div class="modal-body">
                    <div class="row form-group">
                        <div class="col">
                            <div wire:ignore>
                                {!! Form::label('CountryName', __('Name'), ['class' => 'label-required']) !!}
                                <select name="name" id="CountryName" class="select2" style="width: 100%">\
                                    <option value="">{{__('Select one')}}</option>
                                    @foreach ($allCountries as $country)
                                        <option value="{{$country}}">{{$country}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('name') <div class="tx-danger mt-1"><strong>{{ $message }}</strong></div>@enderror
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
    {{--end of add modal --}}
</div>

@section('js')
<script>
    $(document).ready(function() {
        $('#CountryName').select2();
        $('#CountryName').on('change', function(e) {
            let data = $('#CountryName').select2("val");
            @this.set('name', data);
        });

        @this.on('reset-add-form', function() {
            $('#CountryName').val(null).trigger('change');
        })
    });
</script>
@endsection