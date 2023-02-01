<!-- theme pagination start -->
<div x-data="{{ $pagination_loader ?? 'paginationLoader' }}" class="d-flex align-items-center justify-content-end mt-3">
    <div class="total-pages me-2">
        <p class="description-sm text-body fw-medium">Per Page</p>
    </div>

    <div class="border rounded-1 d-flex align-items-center cursor-pointer position-relative" style="height:26px">
        <div class="theme-select-value py-0 fs-2 dropdown-toggle" x-text="meta.perPage"  data-bs-toggle="dropdown"></div>
        <div class="dropdown-menu">
            @if(isset($pages) && count($pages) > 0)
                @foreach($pages as $p)
                    <span @click="dataDisplayReload({{$p}})">{{$p}}</span>
                @endforeach
            @else
                <span class="dropdown-item" @click="dataDisplayReload(10)">10</span>
                <span class="dropdown-item" @click="dataDisplayReload(25)" id="default-pagination-item">25</span>
                <span class="dropdown-item" @click="dataDisplayReload(50)">50</span>
                <span class="dropdown-item" @click="dataDisplayReload(100)">100</span>
            @endif
        </div>
    </div>
    <div class="total-pages me-2">
        <p class="description-sm text-body ms-2 fw-medium">
            <span x-text="(parseInt(meta.perPage) * parseInt(meta.page) - parseInt(meta.perPage))"></span>–<span x-text="meta.perPage*meta.page"></span>
            of <b x-text="meta.total"></b> Records
        </p>
    </div>
    <div class="theme-pagination-btn d-flex align-items-center">
        <span @click="prevPage()" class="btn btn-xs btn-outline-light me-2">
            <svg width="7" height="11" viewBox="0 0 7 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7 9.7075L2.67341 5.5L7 1.2925L5.66802 0L0 5.5L5.66802 11L7 9.7075Z" fill="currentColor" fill-opacity="1"/>
            </svg>
        </span>
        <span @click="nextPage" class="btn btn-xs btn-outline-light me-2">
            <svg width="7" height="11" viewBox="0 0 7 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 9.7075L4.32659 5.5L0 1.2925L1.33198 0L7 5.5L1.33198 11L0 9.7075Z" fill="currentColor" fill-opacity="1"/>
            </svg>
        </span>
    </div>
</div>

@push('js')
    <script>
        const {{ $pagination_loader ?? 'paginationLoader' }} = {
            // Pagination part ----------------------------------------------------------------------------------------------------------- START
            dataDisplayReload(perPage = 25) {
                this.meta.page = 1;
                this.markPoints = [];
                this.meta.perPage = perPage;
                this.{{$loadData}}();
            },
            updateMetaAfterLoad(metaResponse, self) {
                // let self = this;

                if (metaResponse !== undefined) {
                    // if (self.historypush) {
                        self.markPoints.push(metaResponse.newMarkPoint);
                        self.meta = {
                            page: metaResponse.page,
                            perPage: metaResponse.perPage,
                            total: metaResponse.total,
                            markPoint: '',
                        }
                        const params = new URLSearchParams(window.location.search);
                        // params.set('pages', self.markPoints);
                        // params.set('perPage', metaResponse.perPage);

                        let arr = {};
                        for (el in metaResponse.filter) {
                            arr[el] = metaResponse.filter[el];
                            params.set('filter[' + el + ']', metaResponse.filter[el]);
                        }
                        self.meta.filter = arr;
                        window.history.replaceState({}, "", decodeURIComponent(`${window.location.pathname}?${params}`));
                    // } else {
                    //     self.historypush = true;
                    // }
                }else{
                    self.meta.total = 0;
                }
            },

            metaInitiation(self) {
                let query = self.getQueryParams(window.location.search);
                let arr = {};
                let oldFilter = self.meta.filter;
                for (el in self.meta.filter) {
                    arr[el] = (query['filter[' + el + ']'] === undefined) ? '' : query['filter[' + el + ']'];
                }
                self.meta.filter = arr;
                for (let i in self.meta.filter) {
                    if(self.meta.filter[i] === ''){
                        self.meta.filter[i] = oldFilter[i];
                    }
                }

                let urlString = '{{$_GET["pages"] ?? ""}}';
                let splitUrlString = urlString.split(",");
                splitUrlString.map((el, i) => {
                    self.markPoints.push([el]);
                });
                self.meta.page = parseInt(self.markPoints.length);
                if (self.markPoints.length > 0) {
                    self.markPoints.pop();
                    self.meta.markPoint = self.markPoints[self.markPoints.length - 1];
                }
            },
            // Back to previous page
            prevPage() {
                let self = this;
                if (self.meta.page > 1) {
                    self.meta.page = parseInt(this.meta.page) - 1
                    self.markPoints.splice(-2, 2);
                    self.meta.markPoint = this.markPoints[this.markPoints.length - 1];
                    this.{{$loadData}}();
                }
            },
            // Go to next page
            nextPage() {
                // console.log(this.meta);
                let total_page = Math.ceil(parseInt(this.meta.total) / parseInt(this.meta.perPage));
                if (parseInt(this.meta.page) < total_page) {
                    this.meta.page = parseInt(this.meta.page) + 1;
                    this.meta.markPoint = this.markPoints[this.markPoints.length - 1];
                    this.{{$loadData}}();
                } else {
                    swalError("No more Data remaining");
                }
            },

            // Pagination part ---------------------------------------------------------------------------------------------------------  END
        }
    </script>
@endpush
