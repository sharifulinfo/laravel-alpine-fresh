<div class="offcanvas offcanvas-end" data-bs-backdrop="true" tabindex="-1" id="userDetails" aria-labelledby="userDetailsLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="userDetailsLabel">User Details</h5>
    </div>
    <div class="offcanvas-body pt-2">
        <div class="table-responsive scrollbar-primary" style="max-height: calc(100vh - 100px);">
            <table class="table table-striped">
                <thead>
                    <template x-for="(getN,key) in selectedUser">
                        <tr>
                            <th class="table-header text-nowrap" x-text="key"></th>
                            <th class="table-header text-nowrap">:</th>
                            <td class="table-details text-nowrap" x-text="getN"></td>
                        </tr>
                    </template>

                </thead>
            </table>
        </div>
    </div>
    <div class="offcanvas-arrow rightToolTip" data-tippy-content="Close" id="closeOffCanvas" data-bs-dismiss="offcanvas" aria-label="Close" aria-expanded="false">
        <svg width="11" height="19" viewBox="0 0 11 19" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M5.38416e-07 9.5C5.71953e-07 8.73277 0.345449 7.96553 1.02355 7.38462L9.36551 0.23839C9.73655 -0.0794636 10.3507 -0.0794635 10.7217 0.238391C11.0928 0.556245 11.0928 1.08235 10.7217 1.4002L2.37976 8.54644C1.76563 9.07254 1.76563 9.92746 2.37976 10.4536L10.7217 17.5998C11.0928 17.9177 11.0928 18.4438 10.7217 18.7616C10.3507 19.0795 9.73655 19.0795 9.36551 18.7616L1.02355 11.6154C0.345449 11.0345 5.04879e-07 10.2672 5.38416e-07 9.5Z" fill="currentColor"></path>
        </svg>
    </div>
</div>
