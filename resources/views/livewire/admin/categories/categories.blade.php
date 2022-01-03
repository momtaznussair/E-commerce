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
                @forelse ($categories as $category)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$category->name}}</td>
                        <td>
                            @can('Category_edit')
                            <div class="custom-control custom-switch">
                                <input wire:change="toggleActive({{$category->active}})" wire:click="selectCategory({{$category}})"
                                type="checkbox" {{ $category->active ? 'checked' : '' }} {{ $category->deleted_at ? 'disabled' : '' }} class="custom-control-input" id="{{$category->id}}">
                                <label class="custom-control-label" for="{{$category->id}}"></label>
                            </div>
                            @endcan
                        </td>
                        <td>
                            @can('Category_edit')
                            @empty($category->deleted_at)
                                 <a  
                                    wire:click="selectCategory({{$category}}, true)"
                                    data-toggle="modal" href="#updateOrCreate" class="btn btn-sm btn-info"
                                    title="{{__('Edit')}}"><i class="las la-pen"></i></a> 
                            @endempty
                               
                            @endcan
                            @can('Category_delete')
                                @if ($category->deleted_at)
                                    <a  
                                        wire:click="restore({{$category}})" class="btn btn-sm btn-info"
                                        title="{{__('Restore')}}"><i class="fas fa-trash-restore tx-white"></i>
                                    </a> 
                                    <a
                                        wire:click="selectCategory({{$category}})"
                                        class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                        data-toggle="modal" href="#forceDelete" title="{{__('Delete Permanently')}}"><i
                                        class="far fa-trash-alt"></i>
                                    </a>
                                    @else
                                    <a
                                        wire:click="selectCategory({{$category}})"
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
    <div class="row mx-3">{{$categories->links()}} </div>
    {{-- modal --}}
    @livewire('admin.categories.update-or-create-category')
    <x-crud-by-name-modal mode="forceDelete" title="{{__('Delete Permanently')}}"/>
    <x-crud-by-name-modal mode="delete" title="{{__('Delete')}}"/>
</div>