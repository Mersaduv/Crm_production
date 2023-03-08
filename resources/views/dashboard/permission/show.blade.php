@extends('dashboard.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Permissions</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('user',$user) }}
                    </div>
                    <div class="col-sm-6 historyBTN">
                        <button class="btn btn-primary btn-sm">
                            <a href="{{ url()->previous() }}" class="btn btn-ctr">
                                <i class="far fa-arrow-alt-circle-left"></i>
                                Go Back
                            </a>
                        </button>
                    </div>
                </div> <!-- /row -->

            </div>

        </div>
    </div>
    <div class="clearfix"></div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-sm-12">
        <div class="page-content-box">

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <form method="post" action="{{ route('users.setAccess',$user->id) }}">
                            @csrf
                            @method('put')
                            <div class="card-header">
                                <h4>Permissions</h4>
                            </div> <!-- /card-header -->
                            <div class="card-body">
                                <ul class="nav nav-tabs" role="tablist">
                                    @foreach ($branches as $branche)
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#tabs-{{$branche->id}}" role="tab">
                                            {{ $branche->name}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                <div class="tab-content">
                                    @foreach ($branches as $branche)
                                    <div class="tab-pane" id="tabs-{{$branche->id}}" role="tabpanel">
                                        @foreach($sections as $section)
                                        <div class="row section">
                                            <div class="col-sm-12 px-16">
                                                <div class="parent">
                                                    <label for="{{ $section->section }}">
                                                        <input type="checkbox" id="{{ $section->section }}"
                                                            class="permission_section" />
                                                        -
                                                        <span>{{ $section->section }}</span>
                                                    </label>
                                                </div> <!-- /parent -->

                                                <div>
                                                    <ul class="child">
                                                        @foreach($permissions as $permission)
                                                        @if($section->section == $permission->section)
                                                        <li>
                                                            <label for="{{$branche->id.'-'.$permission->id }}">
                                                                <input type="checkbox"
                                                                    name="section_access[{{$branche->id}}][]"
                                                                    value="{{ $permission->id }}"
                                                                    id="{{ $branche->id.'-'.$permission->id }}"
                                                                    class="{{ $section->section }}" {{
                                                                    hasBranchePermission($user->id,
                                                                $branche->id,
                                                                $permission->id) ? '
                                                                checked':'' }} />
                                                                -
                                                                {{ $permission->section_access }}

                                                            </label>
                                                        </li>
                                                        @endif
                                                        @endforeach
                                                    </ul>
                                                </div> <!-- /child -->
                                            </div>
                                        </div>
                                        @endforeach

                                    </div>
                                    @endforeach
                                </div>
                            </div><!-- /card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-danger">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div> <!-- /end of page content -->

@endsection

@section('style')
<style>
    .card-header {
        text-align: center;
    }

    .user_operation button {
        width: 100%;
        display: block;
        margin: 5px 0px;
    }

    .user_operation button a {
        color: #fff;
    }

    p {
        margin-bottom: unset;
    }

    .child {
        list-style: none;
        margin-bottom: 2px;
        margin-top: 2px;
        padding-left: 0
    }

    .modal-body {
        height: 500px;
        overflow-y: auto;
    }

    .parent label {
        width: 100%;
        padding: .6rem;
        background-color: #fff;
        display: flex;
        align-items: center;
        column-gap: 0.4rem;
    }

    .section {
        background-color: rgba(0, 0, 0, .03);
        margin: 0 1rem 1rem;
        text-transform: capitalize;
        padding: 1rem;
    }

    .section .child {
        display: grid;
        grid-template-columns: repeat(auto-fill, 10.6rem);
        column-gap: 1.5rem;
        row-gap: 1rem;
        flex-wrap: wrap;
    }

    .child li {
        flex-shrink: 0;
    }

    .child label {
        padding: .6rem;
        background-color: #fff;
        margin-bottom: 0;
        border-radius: .2rem;
        display: flex;
        align-items: center;
        column-gap: 0.4rem;
    }

    .section label:hover,
    .section input:hover {
        cursor: pointer;
    }

    #accordion:not(:last-child) {
        border-bottom: 1px solid rgba(0, 0, 0, .125);
    }

    button[data-target]:hover {
        background-color: rgba(0, 0, 0, .03);
    }

    .nav-tabs {
        column-gap: 0.2rem;
    }
</style>
@endsection

@section('script')
<script type="text/javascript">
    jQuery(document).on('ready',function(){


   		$(".parent input[type='checkbox']").on('change',function(){
            var _parent=$(this);
            var wrapper=$(this).closest('.col-sm-12');
            if(_parent.prop('checked')){
                wrapper.find("input[type='checkbox']").prop('checked',true);
            }
            else{
                wrapper.find("input[type='checkbox']").prop('checked',false);
            }
		});

		$(".child input[type='checkbox']").on('change',function(){

            var ths=$(this);
            var wrapper=ths.closest('.col-sm-12');
            var secion = wrapper.find('.permission_section');
            let isAllChecked = true;
            wrapper.find('.child input').each(function(){
                if(!$(this).prop('checked')) {
                    isAllChecked = false;
                }
            })

            secion.prop('checked',isAllChecked)

		});
   });
</script>
@endsection