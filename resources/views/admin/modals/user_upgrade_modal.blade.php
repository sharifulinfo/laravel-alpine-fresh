<div class="modal fade" id="UpgradeUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="UpgradeUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="brand-logo"><img src="{{url('backend')}}/images/logo.png" alt="logo"></div>
                <span type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></span>
            </div>
            <div class="modal-body pt-3">
                <form class="row g-3" autocomplete="off" @submit.prevent="upgradeUserAction">
{{--                    <div class="col-md-12">--}}
{{--                        <label class="form-label mb-2">Plan Type</label>--}}
{{--                        <div class="border rounded-1 d-flex align-items-center cursor-pointer position-relative">--}}
{{--                            <div class="theme-select-value py-0 dropdown-toggle" data-bs-toggle="dropdown" x-text="upgradeUserData.plan_type"></div>--}}
{{--                            <div class="dropdown-menu">--}}
{{--                                <span class="dropdown-item" @click="upgradeUserData.plan_type = 'free'">Free</span>--}}
{{--                                <span class="dropdown-item" @click="upgradeUserData.plan_type = 'lifetime'">Life Time</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <div class="col-md-12">
                        <label class="form-label mb-2">Plan Type</label>
                        <div class="border rounded-1 d-flex align-items-center cursor-pointer position-relative">
                            <div class="theme-select-value py-0 dropdown-toggle" data-bs-toggle="dropdown" x-text="ucFirst(upgradeUserData.plan_type)"></div>
                            <div class="dropdown-menu">
                                <span class="dropdown-item" @click="upgradeUserData.plan_type = 'free'">Free</span>
                                <span class="dropdown-item" @click="upgradeUserData.plan_type = 'lifetime'">Lifetime</span>
                            </div>
                        </div>
                    </div>
                    <template x-if="upgradeUserData.plan_type !== 'free'">
                        <div class="col-12">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label mb-2">Select Plan</label>
                                    <div class="border rounded-1 d-flex align-items-center cursor-pointer position-relative">
                                        <div class="theme-select-value py-0 dropdown-toggle" data-bs-toggle="dropdown" x-text="ucFirst(upgradeUserData.selected_plan)"></div>
                                        <div class="dropdown-menu">
                                            <span class="dropdown-item" @click="upgradeUserData.selected_plan = 'starter';upgradeUserData.workspace=1">Starter</span>
                                            <span class="dropdown-item" @click="upgradeUserData.selected_plan = 'business';upgradeUserData.workspace=1">Business</span>
                                            <span class="dropdown-item" @click="upgradeUserData.selected_plan = 'team'">Team</span>
                                        </div>
                                    </div>
                                </div>
{{--                                <div class="col-md-6">--}}
{{--                                    <label for="planWorkspace" class="form-label mb-2">Workspace QTY</label>--}}
{{--                                    <div class="row g-1">--}}
{{--                                        <span :class="upgradeUserData.selected_plan !== 'team' ? 'disabled' : '' " class="btn col-sm-2 title-lg text-body fw-medium cursor-pointer text-center border bg-secondary-light" @click="upgradeUserData.workspace > 1 ? upgradeUserData.workspace -= 1 : upgradeUserData.workspace = 1"> - </span>--}}
{{--                                        <div class="col-sm-8">--}}
{{--                                            <input type="number" x-model="upgradeUserData.workspace" class="form-control border text-center p-0">--}}
{{--                                        </div>--}}
{{--                                        <span :class="upgradeUserData.selected_plan !== 'team' ? 'disabled' : '' " class="btn col-sm-2 title-lg text-body fw-medium cursor-pointer text-center border bg-secondary-light" @click="upgradeUserData.workspace += 1"> + </span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                                <div class="col-md-12">
                                    <div class="row g-3 align-items-center mb-2">
                                        <label for="inputPassword" class="col-sm-4 col-form-label">Verification</label>
                                        <div class="col-sm-2">
                                            <span class="border border w-100 d-block p-1 text-center" x-html="selectedUser.verification_balance"></span>
                                        </div>
                                        <div class="col-sm-1 title-lg text-body fw-medium text-center">+</div>
                                        <div class="col-sm-2">
                                            <input type="number" x-model="upgradeUserData.verification" @keyup="addVerification" class="form-control border text-center p-0" placeholder="333">
                                        </div>
                                        <div class="col-sm-1 title-lg text-body fw-medium text-center"> = </div>
                                        <div class="col-sm-2">
                                            <span class="border border w-100 d-block p-1 text-center" x-html="total_verification_balance"></span>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-items-center">
                                        <label for="inputPassword" class="col-sm-4 col-form-label">Leads</label>
                                        <div class="col-sm-2">
                                            <span class="border border w-100 d-block p-1 text-center" x-html="selectedUser.leads_balance"></span>
                                        </div>
                                        <div class="col-sm-1 title-lg text-body fw-medium text-center">+</div>
                                        <div class="col-sm-2">
                                            <input type="number" x-model="upgradeUserData.leads" @keyup="addLeads" class="form-control border text-center p-0" placeholder="333">
                                        </div>
                                        <div class="col-sm-1 title-lg text-body fw-medium text-center"> = </div>
                                        <div class="col-sm-2">
                                            <span class="border border w-100 d-block p-1 text-center" x-html="total_leads_balance"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    <div class="col-12 text-end">
                        <span class="btn btn-sm outline-secondary btn-modal" data-bs-dismiss="modal">Cancel</span>
                        <button type="submit" class="btn btn-sm btn-secondary btn-modal upgrading">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
