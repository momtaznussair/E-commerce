<div class="card-body">
    <x-filters />
    <div class="table-responsive">
        <table id="rolesTable" class="table text-md-nowrap">
            <thead>
                <tr class="text-center">
                    <th class="border-bottom-0">#</th>
                    <th class="border-bottom-0">{{__('Name')}}</th>
                    <th class="border-bottom-0">{{__('Price')}}</th>
                    <th class="border-bottom-0">{{__('Description')}}</th>
                    <th class="border-bottom-0">{{__('Active')}}</th>
                    <th class="border-bottom-0">{{__('Operations')}}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->price}}</td>
                        <td>{{$product->description}}</td>
                        <td>
                            @can('Product_edit')
                            <div class="custom-control custom-switch">
                                <input wire:change="toggleActive({{$product->active}})" wire:click="select({{$product}})"
                                type="checkbox" {{ $product->active ? 'checked' : '' }} {{ $product->deleted_at ? 'disabled' : '' }} class="custom-control-input" id="{{$product->id}}">
                                <label class="custom-control-label" for="{{$product->id}}"></label>
                            </div>
                            @endcan
                        </td>
                        <td>
                            @can('Product_edit')
                            @empty($product->deleted_at)
                                 <a  
                                    wire:click="select({{$product}}, true)"
                                    data-toggle="modal" href="#updateOrCreate" class="btn btn-sm btn-info"
                                    title="{{__('Edit')}}"><i class="las la-pen"></i></a> 
                            @endempty
                               
                            @endcan
                            @can('Product_delete')
                                @if ($product->deleted_at)
                                    <a  
                                        wire:click="restore({{$product}})" class="btn btn-sm btn-info"
                                        title="{{__('Restore')}}"><i class="fas fa-trash-restore tx-white"></i>
                                    </a> 
                                    <a
                                        wire:click="select({{$product}})"
                                        class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                        data-toggle="modal" href="#forceDelete" title="{{__('Delete Permanently')}}"><i
                                        class="far fa-trash-alt"></i>
                                    </a>
                                    @else
                                    <a
                                        wire:click="select({{$product}})"
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
                    <td colspan="6">{{__('No results found.')}}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="row mx-3">{{$products->links()}} </div>
    {{-- modal --}}
    @livewire('admin.products.update-or-create-product')
    <x-crud-by-name-modal mode="forceDelete" title="{{__('Delete Permanently')}}"/>
    <x-crud-by-name-modal mode="delete" title="{{__('Delete')}}"/>
</div>