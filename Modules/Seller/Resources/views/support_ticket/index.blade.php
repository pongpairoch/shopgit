@extends('backEnd.master')
@section('mainContent')
<section class="admin-visitor-area">
    <div class="container-fluid p-0">
        <div class="row justify-content-between p-3">
            <div class="bc-pages">
                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('ticket.support_ticket')}}</h3>
            </div>

            <div class="bc-pages">
                <a href="{{ route('seller.support-ticket.create') }}" class="primary-btn small fix-gr-bg">
                    <span class="ti-plus pr-2"></span>
                    {{__('common.add_new')}}
                </a>
            </div>

        </div>

        <form action="{{ route('seller.support-ticket.index') }}" method="get">
            <div class="white_box">
                <div class="row">

                    <div class="col-lg-4">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">{{ __('common.category') }}</label>
                            <select name="category_id" id="category_id" class="primary_select mb-15">
                                <option value="" selected>{{__('common.select_one')}}</option>
                                @foreach ($CategoryList as $key => $item)
                                    <option {{isset($category_id)?$category_id == $item->id?'selected':'':''}} value="{{ $item->id }}">{{ $item->name }} </option>
                                @endforeach

                            </select>
                            @if ($errors->has('category_id'))
                            <span class="text-danger"  id="error_category_id">{{ $errors->first('category_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">{{ __('ticket.priority') }}</label>
                            <select name="priority_id" id="priority_id" class="primary_select mb-15">
                                <option value="" selected>{{__('common.select_one')}}</option>
                                @foreach ($PriorityList as $key => $item)
                                    <option {{isset($priority_id)?$priority_id == $item->id?'selected':'':''}} value="{{ $item->id }}">{{ $item->name }} </option>
                                @endforeach

                            </select>
                            @if ($errors->has('priority_id'))
                            <span class="text-danger"  id="error_priority_id">{{ $errors->first('priority_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">{{ __('common.status') }}</label>
                            <select name="status_id" id="status_id" class="primary_select mb-15">
                                <option value="" selected>{{__('common.select_one')}}</option>
                                @foreach ($StatusList as $key => $status)
                                    <option {{isset($status_id)?$status_id == $status->id?'selected':'':''}} value="{{ $status->id }}">{{ $status->name }} </option>
                                @endforeach

                            </select>
                            @if ($errors->has('status_id'))
                            <span class="text-danger"  id="error_status_id">{{ $errors->first('status_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-12 mt-20 text-right">
                        <button type="submit" class="primary-btn small fix-gr-bg">
                            <span class="ti-search pr-2"></span>
                            {{__('common.search')}}
                        </button>
                    </div>

                </div>
            </div>

        </form>

        <div class="row">
            <div class="col-lg-12 mt-20 no-gutters">
                <div class="main-title">
                    <h3 class="mb-0">{{__('ticket.ticket_list')}}</h3>
                </div>
            </div>
            <div class="col-lg-12">

                <div class="row  mt-40">
                    <div class="col-lg-12">

                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table ">

                                <div class="">
                                    <div id="model_list">
                                        <table class="table" id="dataListTable">
                                            <thead>
                                                @if(session()->has('message-success') != "" ||
                                                session()->get('message-danger') != "")
                                                <tr>
                                                    <td colspan="7">
                                                        @if(session()->has('message-success'))
                                                        <div class="alert alert-success">
                                                            {{ session()->get('message-success') }}
                                                        </div>
                                                        @elseif(session()->has('message-danger'))
                                                        <div class="alert alert-danger">
                                                            {{ session()->get('message-danger') }}
                                                        </div>
                                                         @endif
                                                    </td>
                                                </tr>
                                                @endif
                                                <tr>

                                                    <th scope="col">{{__('common.sl')}}</th>
                                                    <th scope="col">{{__('ticket.subject')}}</th>
                                                    <th scope="col">{{__('common.category')}}</th>
                                                    <th scope="col">{{__('ticket.priority')}}</th>
                                                    <th scope="col">{{__('common.status')}}</th>
                                                    <th scope="col">{{__('common.action')}}</th>
                                                </tr>
                                            </thead>





                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="url" id="url2" @if(strpos($_SERVER['REQUEST_URI'], '?') == true) value="{{explode('?',$_SERVER['REQUEST_URI'])[1]}}" @else value="0" @endif>
    </div>
</section>


@endsection

@push('scripts')
<script type="text/javascript">
    (function($){
        "use strict";
        $(document).ready(function(){

            var url = $('#url2').val();
            if (url == 0) {
                var new_url = '{{ route('seller.support-ticket.get-data') }}';
            }else {
                var base_url = $('#url').val();
                var new_url = base_url +'/seller/support-ticket/search?' + url;
            }

            console.log(new_url);


            $('#dataListTable').DataTable({
                    processing: true,
                    serverSide: true,
                    stateSave: true,
                    "ajax": ( {
                        url: new_url
                    } ),
                    columns: [
                        { data: 'DT_RowIndex', name: 'id' },
                        { data: 'subject', name: 'subject' },
                        { data: 'category', name: 'category' },
                        { data: 'priority', name: 'priority' },
                        { data: 'status', name: 'status' },
                        { data: 'action', name: 'action' }

                    ],

                    bLengthChange: false,
                    "bDestroy": true,
                    language: {
                        search: "<i class='ti-search'></i>",
                        searchPlaceholder: trans('common.quick_search'),
                        paginate: {
                            next: "<i class='ti-arrow-right'></i>",
                            previous: "<i class='ti-arrow-left'></i>"
                        }
                    },
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'copyHtml5',
                            text: '<i class="fa fa-files-o"></i>',
                            title: $("#header_title").text(),
                            titleAttr: 'Copy',
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            }
                        },
                        {
                            extend: 'excelHtml5',
                            text: '<i class="fa fa-file-excel-o"></i>',
                            titleAttr: 'Excel',
                            title: $("#header_title").text(),
                            margin: [10, 10, 10, 0],
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            },

                        },
                        {
                            extend: 'csvHtml5',
                            text: '<i class="fa fa-file-text-o"></i>',
                            titleAttr: 'CSV',
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="fa fa-file-pdf-o"></i>',
                            title: $("#header_title").text(),
                            titleAttr: 'PDF',
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            },
                            pageSize: 'A4',
                            margin: [0, 0, 0, 0],
                            alignment: 'center',
                            header: true,

                        },
                        {
                            extend: 'print',
                            text: '<i class="fa fa-print"></i>',
                            titleAttr: 'Print',
                            title: $("#header_title").text(),
                            exportOptions: {
                                columns: ':not(:last-child)',
                            }
                        },
                        {
                            extend: 'colvis',
                            text: '<i class="fa fa-columns"></i>',
                            postfixButtons: ['colvisRestore']
                        }
                    ],
                    columnDefs: [{
                        visible: false
                    }],
                    responsive: true,
            });
        });
    })(jQuery);
</script>




@endpush
