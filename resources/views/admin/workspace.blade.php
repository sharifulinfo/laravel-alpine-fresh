@extends('layouts.app-layout')
@section('content')
    <div x-data="xConst">
        <div class="d-flex justify-content-end mb-3">
            <div style="max-width: 320px; width: 100%">
                <form class="d-flex align-items-center" @submit.prevent="searchWorkspace">
                    <div class="position-relative theme-search-box-wrap d-inline-block" style="max-width: 320px;">
                        <span class="position-absolute top-50 start-3 translate-middle-y d-flex">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </span>
                        <input x-model="meta.filter.search" type="text" class="form-control" placeholder="Search by name, desc, plan">
                        <span style="display: none" x-show="meta.filter.search != ''" class="cursor-pointer position-absolute top-50 end-3 translate-middle-y text-danger lh-1" @click="meta.filter.search = ''; searchWorkspace()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <div class="theme-data-table table-responsive">
            <div x-html="getPlaceHolder(wsLoading)"></div>
            <table class="table table-hover" x-show="!wsLoading && workspaces.length > 0" style="display: none">
                <thead>
                    <tr>
                        <th class="table-header">Name</th>
                        <th class="table-header">Description</th>
                        <th class="table-header">Owner</th>
                        <th class="table-header">Member</th>
                        <th class="table-header">Plan Name</th>
                        <th class="table-header" width="300px">Sending limit</th>
                        <th class="table-header" width="300px">Uploads limit</th>
                        <th class="table-header text-end" width="120">Created at</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(getN,i) in workspaces">
                        <tr>
                            <td class="table-details text-nowrap hover-element">
                                <span x-text="getN.name" class="me-1"></span>
                                <svg @click="copyText(getN.id,'effect_id_'+i)" :class="'effect_id_'+i" class="show-in-hover" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.833 6.615c-.71 0-1.288.574-1.288 1.282V19.18c0 .707.577 1.282 1.288 1.282h8.243c.711 0 1.288-.575 1.288-1.282v-7.87c0-.34-.136-.666-.378-.906L11.557 6.99a1.29 1.29 0 0 0-.91-.376H5.832ZM3 7.897a2.827 2.827 0 0 1 2.833-2.82h4.813a2.84 2.84 0 0 1 2.004.826l3.43 3.414c.53.529.83 1.246.83 1.994v7.869A2.827 2.827 0 0 1 14.075 22H5.833A2.827 2.827 0 0 1 3 19.18V7.897Z" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M7.121 2.77c0-.426.346-.77.773-.77h4.298a2.84 2.84 0 0 1 2.003.826l4.975 4.952c.531.53.83 1.247.83 1.995v7.355c0 .425-.346.77-.773.77a.771.771 0 0 1-.773-.77V9.773c0-.34-.135-.666-.377-.907l-4.974-4.952a1.29 1.29 0 0 0-.911-.376H7.894a.771.771 0 0 1-.773-.769Z" fill="currentColor"/></svg>
                            </td>
                            <td class="table-details" x-text="shortStr(getN.description,50)"></td>
                            <td class="table-details">
                                <template x-if="users[getN.user_id] !== undefined">
                                    <a class="text-link" target="_blank" :href="$url+'/admin/users?filter[search]='+users[getN.user_id].email" x-text="users[getN.user_id].name"></a>
                                </template>
                                <template x-if="users[getN.user_id] === undefined">
                                    <span>Unknown</span>
                                </template>
                            </td>
                            <td class="table-details" x-text="getN.members"></td>

                            <td class="table-details" x-text="getN.plan_name === '' ? 'Free' : getN.plan_name"></td>
                            <td class="table-details">
                                <div class="d-flex align-items-center w-100 justify-content-between">
                                    <div class="progress bg-warning-light w-100">
                                        <div class="progress-bar bg-warning d-block lh-1" role="progressbar" aria-label="warning example" :style="'width: '+parseInt(getN.email_sending_used)*100/parseInt(getN.email_sending_limit)+'%'" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="description-sm w-max-content ms-2 text-nowrap"> <span x-text="getSuffixedNumber(getN.email_sending_used)"></span> / <span x-text="getSuffixedNumber(getN.email_sending_limit)"></span></div>
                                </div>
                            </td>
                            <td class="table-details">
                                <div class="d-flex align-items-center w-100 justify-content-between">
                                    <div class="progress bg-success-light w-100">
                                        <div class="progress-bar bg-success d-block lh-1" role="progressbar" aria-label="Success example" :style="'width: '+parseInt(getN.contacts_upload_used)*100/parseInt(getN.contacts_upload_limit)+'%'" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="description-sm w-max-content ms-2 text-nowrap"> <span x-text="getSuffixedNumber(getN.contacts_upload_used)"></span> / <span x-text="getSuffixedNumber(getN.contacts_upload_limit)"></span></div>
                                </div>
                            </td>
                            <td class="table-details text-end" x-text="getN.created_at"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        <div style="display: none" x-show="!wsLoading && workspaces.length > 0">
            @include('layouts.includes.pagination',['loadData' => 'getWorkspaces'])
        </div>
    </div>
@endsection

@push('js')
    <script>
        const xConst = {
            selectedUserIndex: 0,
            selectedUser: [],
            init() {
                paginationLoader.metaInitiation(this);
                this.getWorkspaces()
            },
            wsLoading: true,
            workspaces : [],
            users : [],
            meta: {
                filter: {
                    search: ''
                },
                page: 1,
                perPage: '{{$_GET["perPage"] ?? 20}}',
                markPoint: '',
                total: 0,
            },
            searchWorkspace() {
                this.meta.page = 1;
                this.markPoints = [];
                this.meta.perPage = 25;
                this.getWorkspaces();
            },
            markPoints: [],
            getWorkspaces() {
                let self = this;
                self.wsLoading = true;
                makeAjaxPost(this.meta, '{{route("getWorkspaceList")}}', false).done(res => {
                    if (res.success) {
                        self.workspaces = res.data;
                        self.users = res.meta.users;
                        paginationLoader.updateMetaAfterLoad(res.meta, self)
                    } else {
                        self.workspaces = [];
                        self.users = [];
                    }
                    self.wsLoading = false;
                })
            },
        }
    </script>
@endpush
