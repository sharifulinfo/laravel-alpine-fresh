<div class="modal fade" id="updateUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="brand-logo"><img src="{{url('backend')}}/images/logo.png" alt="logo"></div>
                <span type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></span>
            </div>
            <div class="modal-body">
                <form class="row g-3" autocomplete="off" @submit.prevent="updateUser">
                    <div class="col-md-6">
                        <label for="fName" class="form-label">First Name <span>*</span></label>
                        <input type="text" x-model="updateUserData.first_name" class="form-control" id="fName" placeholder="Enter first Name">
                    </div>
                    <div class="col-md-6">
                        <label for="lname" class="form-label">Last Name <span>*</span></label>
                        <input type="text" x-model="updateUserData.last_name" class="form-control" id="lname" placeholder="Enter last Name">
                    </div>
                    <div class="col-md-6">
                        <label for="memberContactNumber" class="form-label">Contact Number</label>
                        <input type="text" x-model="updateUserData.phone" class="form-control" id="memberContactNumber" placeholder="Enter User Phone Number">
                    </div>
                    <div class="col-md-6">
                        <label for="memberWebsite" class="form-label">Website</label>
                        <input type="text" x-model="updateUserData.website" class="form-control" id="memberWebsite" placeholder="example.com">
                    </div>
                     <div class="col-md-6">
                        <label for="memberPassword" class="form-label">Password</label>
                        <input type="password" x-model="updateUserData.password" class="form-control" id="memberPassword" placeholder="********" autocomplete="new-password">
                        <small class="fs-xs">Keep empty if you don't want to change the password.</small>
                    </div>
                    <div class="col-md-6">
                        <label for="memberCompany" class="form-label">Company</label>
                        <input type="text" x-model="updateUserData.company" class="form-control" id="memberCompany" placeholder="Choose User Company">
                    </div>
                    <div class="col-12 text-end">
                        <span class="btn btn-sm-outline-secondary btn-modal" data-bs-dismiss="modal">Cancel</span>
                        <button type="submit" class="btn btn-sm btn-secondary btn-modal updating_user">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
