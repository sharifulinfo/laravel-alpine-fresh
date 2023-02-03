@extends('layouts.app-layout')
@section('content')
    <div x-data="xConst">
        <div class="d-lg-flex align-items-end justify-content-between mb-3">
            <div class="d-flex w-100">
                <div style="max-width: 140px; width:100%">
                    <label class="form-label mb-2 text-nowrap">Sort By</label>
                    <div class="border rounded-1 d-flex align-items-center cursor-pointer position-relative">
                        <div class="theme-select-value py-0 fs-2 dropdown-toggle" data-bs-toggle="dropdown" x-text="ucFirst(meta.filter.sort_by)"></div>
                        <div class="dropdown-menu">
                            <span class="dropdown-item" @click="meta.filter.sort_by = 'Last register';searchUsers()">Last Register</span>
                            <span class="dropdown-item" @click="meta.filter.sort_by = 'Last login';searchUsers()">Last Login</span>
                        </div>
                    </div>
                </div>
                <div class="ms-xxl-4 ms-3" style="max-width: 140px; width:100%">
                    <label class="form-label mb-2 text-nowrap">User Type</label>
                    <div class="border rounded-1 d-flex align-items-center cursor-pointer position-relative">
                        <div class="theme-select-value py-0 fs-2 dropdown-toggle" data-bs-toggle="dropdown" x-text="ucFirst(meta.filter.status)"></div>
                        <div class="dropdown-menu">
                            <span class="dropdown-item" @click="meta.filter.status = 'all';searchUsers()">All</span>
                            <span class="dropdown-item" @click="meta.filter.status = 'active';searchUsers()">Active</span>
                            <span class="dropdown-item" @click="meta.filter.status = 'inactive';searchUsers()">Blocked</span>
                        </div>
                    </div>
                </div>
                <div class="ms-xxl-4 ms-3" style="max-width: 140px; width:100%">
                    <label class="form-label mb-2 text-nowrap">Subscription Type</label>
                    <div class="border rounded-1 d-flex align-items-center cursor-pointer position-relative">
                        <div class="theme-select-value py-0 fs-2 dropdown-toggle" data-bs-toggle="dropdown" x-text="ucFirst(meta.filter.plan_type)"></div>
                        <div class="dropdown-menu">
                            <span class="dropdown-item" @click="meta.filter.plan_type = 'all';searchUsers()">All</span>
                            <span class="dropdown-item" @click="meta.filter.plan_type = 'free';searchUsers()">Free</span>
                            <span class="dropdown-item" @click="meta.filter.plan_type = 'trial';searchUsers()">Trial</span>
                            <span class="dropdown-item" @click="meta.filter.plan_type = 'subscription';searchUsers()">Subscription</span>
                            <span class="dropdown-item" @click="meta.filter.plan_type = 'lifetime';searchUsers()">Lifetime</span>
                        </div>
                    </div>
                </div>
                <div class="ms-xxl-4 ms-3" style="max-width: 320px; width: 100%">
                    <label class="form-label mb-2 text-nowrap">Search</label>
                    <form class="d-flex align-items-center" @submit.prevent="searchUsers">
                        <div class="position-relative theme-search-box-wrap d-inline-block" style="max-width: 320px;">
                            <span class="position-absolute top-50 start-3 translate-middle-y d-flex">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                            </span>
                            <input x-model="meta.filter.search" type="text" class="form-control" placeholder="Search">
                            <span style="display: none" x-show="meta.filter.search != ''" class="cursor-pointer position-absolute top-50 end-3 translate-middle-y text-danger lh-1" @click="meta.filter.search = ''; searchUsers()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="d-flex justify-content-lg-end gap-3 mt-lg-0 mt-3">
                <button class="btn btn-sm btn-outline-primary downloading" @click="downloadAllUsers">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    <span class="ms-2">Download All User (<b x-text="meta.total"></b>) </span>
                </button>
            </div>
        </div>
        {{-- Data Table --}}
        <div class="table-responsive scrollbar-primary" style="max-height: calc(100vh - 250px)">
            <div x-html="getPlaceHolder(userLoading)"></div>
            <table class="table table-hover" x-show="!userLoading && users.length > 0" style="display: none">
                <thead>
                    <tr>
                        <th class="table-header text-nowrap">Name</th>
                        <th class="table-header text-nowrap">Email</th>
                        <th class="table-header text-nowrap">Phone</th>
                        <th class="table-header text-nowrap text-end">Email/Seq.</th>
                        <th class="table-header text-nowrap user-current-plan">Current plan</th>
                        {{--                        <th class="table-header text-nowrap user-status">Status</th>--}}
                        <th class="table-header text-nowrap text-end user-register-form">Register from</th>
                        <th class="table-header text-nowrap text-end user-last-login">Last Login</th>
                        <th class="table-header text-nowrap text-end" width="200px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(getN,i) in users">
                        <tr :id="'row_'+i" :class="getN.deleting ? 'deleting blink-soft' : ''">
                            <td class="py-1 table-details text-nowrap hover-element">
                                <img class="user-profile-img mx-2" :src="$url+getN.profile_pic" alt="">
                                <span x-text="getN.name" class="me-1"></span>
                                <svg @click="copyText(getN.id,'effect_id_'+i)" :class="'effect_id_'+i" class="show-in-hover" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.833 6.615c-.71 0-1.288.574-1.288 1.282V19.18c0 .707.577 1.282 1.288 1.282h8.243c.711 0 1.288-.575 1.288-1.282v-7.87c0-.34-.136-.666-.378-.906L11.557 6.99a1.29 1.29 0 0 0-.91-.376H5.832ZM3 7.897a2.827 2.827 0 0 1 2.833-2.82h4.813a2.84 2.84 0 0 1 2.004.826l3.43 3.414c.53.529.83 1.246.83 1.994v7.869A2.827 2.827 0 0 1 14.075 22H5.833A2.827 2.827 0 0 1 3 19.18V7.897Z" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M7.121 2.77c0-.426.346-.77.773-.77h4.298a2.84 2.84 0 0 1 2.003.826l4.975 4.952c.531.53.83 1.247.83 1.995v7.355c0 .425-.346.77-.773.77a.771.771 0 0 1-.773-.77V9.773c0-.34-.135-.666-.377-.907l-4.974-4.952a1.29 1.29 0 0 0-.911-.376H7.894a.771.771 0 0 1-.773-.769Z" fill="currentColor"/></svg>
                            </td>
                            <td class="py-1 table-details text-nowrap hover-element">
                                <span x-text="getN.email" class="me-1 text-link" @click="userDetails(getN,i)"></span>
                                <svg @click="copyText(getN.email,'effect_'+i)" :class="'effect_'+i" class="show-in-hover" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.833 6.615c-.71 0-1.288.574-1.288 1.282V19.18c0 .707.577 1.282 1.288 1.282h8.243c.711 0 1.288-.575 1.288-1.282v-7.87c0-.34-.136-.666-.378-.906L11.557 6.99a1.29 1.29 0 0 0-.91-.376H5.832ZM3 7.897a2.827 2.827 0 0 1 2.833-2.82h4.813a2.84 2.84 0 0 1 2.004.826l3.43 3.414c.53.529.83 1.246.83 1.994v7.869A2.827 2.827 0 0 1 14.075 22H5.833A2.827 2.827 0 0 1 3 19.18V7.897Z" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M7.121 2.77c0-.426.346-.77.773-.77h4.298a2.84 2.84 0 0 1 2.003.826l4.975 4.952c.531.53.83 1.247.83 1.995v7.355c0 .425-.346.77-.773.77a.771.771 0 0 1-.773-.77V9.773c0-.34-.135-.666-.377-.907l-4.974-4.952a1.29 1.29 0 0 0-.911-.376H7.894a.771.771 0 0 1-.773-.769Z" fill="currentColor"/></svg>
                            </td>
                            <td class="py-1 table-details text-nowrap" x-text="getN.phone"></td>
                            <td class="py-1 table-details text-nowrap text-end">
                                <template x-if="Object.keys(userAnalytics).length > 0 && userAnalytics[getN.active_workspace] !== undefined">
                                    <div>
                                        <span x-text="userAnalytics[getN.active_workspace].email"></span>/
                                        <span x-text="userAnalytics[getN.active_workspace].sequence"></span>
                                    </div>
                                </template>
                                 <template x-if="Object.keys(userAnalytics).length === 0 && userAnalytics[getN.active_workspace] === undefined">
                                    <div>0/0</div>
                                </template>
                            </td>
                            <td class="py-1 table-details text-nowrap">
                                <template x-if="getN.plan_type === 'trial'">
                                    <span class="badge fs-sm w-100 bg-info">Trial</span>
                                </template>
                                <template x-if="getN.plan_type === 'subscription'">
                                    <span class="badge fs-sm w-100 bg-success">Subscription</span>
                                </template>
                                <template x-if="getN.plan_type === 'lifetime'">
                                    <span class="badge fs-sm w-100 bg-primary">Lifetime</span>
                                </template>
                                <template x-if="getN.plan_type === 'free'">
                                    <span class="badge fs-sm w-100 bg-light">Free</span>
                                </template>
                            </td>
                            <td class="py-1 table-details text-nowrap text-end fs-sm" x-text="getN.created_at"></td>
                            <td class="py-1 table-details text-nowrap text-end fs-sm" x-text="getN.last_login_at"></td>
                            <td class="py-1 table-details text-nowrap">
                                <div class="d-flex align-items-center justify-content-end">
                                    <button @click="spyUser(getN.id)" class="btn btn-xs btn-outline-primary me-2" :class="'spying'+getN.id" x-tooltip="{content:'Spy User',theme:'primary'}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-in"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                                    </button>
                                    <button @click="blockedUser(getN,i)" :class="getN.status === 'blocked' ? 'active blocking'+getN.id : 'blocking'+getN.id" class="btn btn-xs btn-outline-warning me-2" x-tooltip="{content:'Block User',theme:'warning'}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-slash">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line>
                                        </svg>
                                    </button>
                                    <button class="btn btn-xs btn-outline-light me-2" x-tooltip="{content:'Update User',theme:'body'}" @click="editUser(getN,i)">
                                        <svg width="13" height="13" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M14.4231 14.9994H0.576923C0.261538 14.9994 0 14.7444 0 14.4369C0 14.1295 0.261538 13.8745 0.576923 13.8745H14.4231C14.7385 13.8745 15 14.1295 15 14.4369C15 14.7444 14.7385 14.9994 14.4231 14.9994Z" fill="currentColor"></path>
                                            <path d="M12.9001 1.10569C11.4078 -0.34975 9.94625 -0.387261 8.41548 1.10569L7.48471 2.01347C7.40779 2.08849 7.37702 2.20853 7.40779 2.31356C7.9924 4.30167 9.62317 5.89216 11.6616 6.46233C11.6924 6.46983 11.7232 6.47733 11.7539 6.47733C11.8386 6.47733 11.9155 6.44733 11.977 6.38731L12.9001 5.47953C13.6616 4.74431 14.0309 4.03159 14.0309 3.31137C14.0386 2.56864 13.6693 1.84842 12.9001 1.10569Z" fill="currentColor"></path>
                                            <path d="M10.2767 7.14543C10.0536 7.0404 9.83822 6.93537 9.63053 6.81533C9.4613 6.7178 9.29976 6.61277 9.13822 6.50024C9.00745 6.41771 8.8536 6.29768 8.70745 6.17764C8.69206 6.17014 8.63822 6.12512 8.57668 6.0651C8.32283 5.85504 8.03822 5.58496 7.78437 5.28487C7.7613 5.26986 7.72283 5.21735 7.66899 5.14983C7.59206 5.0598 7.4613 4.90975 7.34591 4.7372C7.2536 4.62466 7.14591 4.45961 7.04591 4.29456C6.92283 4.092 6.81514 3.88944 6.70745 3.67938V3.67938C6.56491 3.38149 6.17398 3.29189 5.93757 3.52246L1.60745 7.74562C1.50745 7.84315 1.41514 8.0307 1.39206 8.15824L0.97668 11.0316C0.899757 11.5418 1.04591 12.0219 1.36899 12.3445C1.64591 12.6071 2.03053 12.7496 2.44591 12.7496C2.53822 12.7496 2.63053 12.7421 2.72283 12.7271L5.67668 12.322C5.81514 12.2995 6.00745 12.2095 6.09976 12.1119L10.428 7.89063C10.659 7.66534 10.5739 7.27104 10.2767 7.14543V7.14543Z" fill="currentColor"></path>
                                        </svg>
                                    </button>
                                    <button class="btn btn-xs btn-outline-success me-2" x-tooltip="{content:'Upgrade user',theme:'success'}" @click="upgradeUser(getN,i)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-upload">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                            <polyline points="17 8 12 3 7 8"></polyline>
                                            <line x1="12" y1="3" x2="12" y2="15"></line>
                                        </svg>
                                    </button>
                                    <button class="btn btn-xs btn-outline-danger me-2" @click="removeUser(getN.id,i)" x-tooltip="{content:'Remove User',theme:'danger'}">
                                        <svg width="9" height="12" viewBox="0 0 9 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0.642857 10.6667C0.642857 11.4 1.22143 12 1.92857 12H7.07143C7.77857 12 8.35714 11.4 8.35714 10.6667V2.66667H0.642857V10.6667ZM9 0.666667H6.75L6.10714 0H2.89286L2.25 0.666667H0V2H9V0.666667Z" fill="currentColor"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        <div style="display: none" x-show="!userLoading && users.length > 0">

        </div>
{{--        <!-- Update User Modal -->--}}
        @include('admin.modals.user_update_modal')
{{--        <!-- Upgrade User Modal -->--}}
{{--        @include('admin.modals.user_upgrade_modal')--}}
{{--        @include('admin.offcanvas.user_details')--}}

    </div>

@endsection

@push('js')
    <script>
        const xConst = {
            selectedUserIndex: 0,
            selectedUser: [],
            init() {
                // paginationLoader.metaInitiation(this);
                this.getUsers()
            },
            meta: {
                filter: {
                    search: '',
                    plan_type: 'all',
                    status: 'all',
                    sort_by: 'Last login',
                },
                page: 1,
                perPage: '{{$_GET["perPage"] ?? 25}}',
                markPoint: '',
                total: 0,
            },
            searchUsers() {
                this.meta.page = 1;
                this.markPoints = [];
                this.meta.perPage = 25;
                this.getUsers();
            },
            markPoints: [],
            users: [],
            usersIds: [],
            userAnalytics: {},
            // historypush: true,
            userLoading: true,
            getUsers() {
                let self = this;
                self.userLoading = true;
                makeAjaxPost(this.meta, '{{route("getUsers")}}', false).done(res => {
                    if (res.success) {
                        self.users = res.data;
                        // paginationLoader.updateMetaAfterLoad(res.meta, self)
                        for (i in self.users) {
                            self.usersIds[i] = self.users[i].active_workspace
                        }
                    } else {
                        self.users = [];
                    }
                    self.userLoading = false;
                })
            },
            updateUserData: {},
            editUser(getN, i) {
                this.selectedUser = getN;
                this.selectedUserIndex = i;
                this.updateUserData.id = getN.id;
                this.updateUserData.first_name = getN.first_name;
                this.updateUserData.last_name = getN.last_name;
                this.updateUserData.phone = getN.phone;
                this.updateUserData.password = getN.password;
                this.updateUserData.company = getN.company;
                this.updateUserData.website = getN.website;
                $('#updateUserModal').modal('show');
            },
            updateUser(){
                let self = this;
                let url = "#";
                makeAjaxPost(this.updateUserData, url, 'updating_user').done(res => {
                    if (res.success) {
                        self.users[self.selectedUserIndex].name = res.data.name;
                        self.users[self.selectedUserIndex].phone = res.data.phone;
                        $('#updateUserModal').modal('hide');
                    } else {
                        swalError(res.msg);
                    }
                }).error(err => {
                    swalError('not success');
                })
            },
            removeUser(id,i){
                let self = this;
                swalConfirm("Are you sure to remove this user. It will also remove all email/sequence/analytics/members/workspaces etc..", 'Remove Warning!').then(s => {
                    if (s.value) {
                        this.users[i]['deleting'] = true;
                        makeAjaxPost({id: id}, "#").done(res => {
                            if (res.success) {
                                $('#row_' + i).remove();
                            } else {
                                swalError(res.msg, 'Delete failed!');
                            }
                            loader(false);
                        });
                    }
                })
            },
            userDetails(getN,i){
                this.selectedUser = getN;
                this.selectedUserIndex = i;
                $("#userDetails").offcanvas('show');
            },
            downloadAllUsers() {
                let url = "#";
                makeAjaxPost({}, url,'downloading').done(res => {
                    if (res.success) {
                        window.location.href = "{{asset('downloads')}}/" + res.data.file;
                    } else {
                        swalError(res.msg);
                    }
                }).error(err => {
                    swalError('not success');
                })
            },
        }
    </script>
@endpush
