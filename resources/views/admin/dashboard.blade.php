@extends('layouts.app-layout')
@section('content')
{{-- <p class="title-lg">Dashboard Coming Soon</p> --}}
<div x-data="dashboardObj">
    <div class="row mb-4 flex-xxl-row flex-column-reverse gy-4">
        <div class="col-xxl-7 col-12">
            <div class="bg-light p-4 pt-3 rounded-4 h-100 dashboard-chart-height">
                <h5 class="title mb-3 fw-medium">INBOX WARMING PLANS</h5>
                <div id="warmup-chart"></div>
            </div>
        </div>
        <div class="col-xxl-5 col-12">
            <div class="bg-light p-4 pt-3 rounded-4 h-100">
                <h5 class="title mb-3 fw-medium">INBOX WARMING PLANS</h5>
                <div class="row g-3">
                    <div class="col-xxl-6 col-xl-3 col-lg-4 col-sm-6">
                        <div class="px-2 py-3 rounded-4 w-100 text-center bg-white">
                            <h6 class="description-sm mb-2 fw-semi-bold text-body">Total Users</h6>
                            <div class="d-flex align-items-center justify-content-center">
                                <span class="me-3 text-primary">
                                    <svg width="20" height="20" viewBox="0 0 23 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8.07948 0C5.07263 0 2.62812 2.556 2.62812 5.7C2.62812 8.784 4.93491 11.28 7.94176 11.388C8.03357 11.376 8.12538 11.376 8.19424 11.388C8.21719 11.388 8.22867 11.388 8.25162 11.388C8.2631 11.388 8.2631 11.388 8.27458 11.388C11.2126 11.28 13.5193 8.784 13.5308 5.7C13.5308 2.556 11.0863 0 8.07948 0Z" fill="currentColor"></path>
                                        <path d="M13.9096 14.58C10.7076 12.348 5.48578 12.348 2.26088 14.58C0.803357 15.6 0 16.98 0 18.456C0 19.932 0.803357 21.3 2.2494 22.308C3.85611 23.436 5.96779 24 8.07948 24C10.1912 24 12.3028 23.436 13.9096 22.308C15.3556 21.288 16.159 19.92 16.159 18.432C16.1475 16.956 15.3556 15.588 13.9096 14.58Z" fill="currentColor"></path>
                                        <path d="M20.6922 6.408C20.8758 8.736 19.292 10.776 17.1 11.052C17.0886 11.052 17.0886 11.052 17.0771 11.052H17.0426C16.9738 11.052 16.9049 11.052 16.8475 11.076C15.7343 11.136 14.7129 10.764 13.944 10.08C15.1261 8.976 15.8032 7.32 15.6655 5.52C15.5851 4.548 15.2638 3.66 14.7818 2.904C15.2179 2.676 15.7228 2.532 16.2393 2.484C18.4887 2.28 20.4971 4.032 20.6922 6.408Z" fill="currentColor"></path>
                                        <path d="M22.9875 17.508C22.8957 18.672 22.1841 19.68 20.9906 20.364C19.8429 21.024 18.3969 21.336 16.9623 21.3C17.7886 20.52 18.2706 19.548 18.3624 18.516C18.4772 17.028 17.8001 15.6 16.4459 14.46C15.6769 13.824 14.7818 13.32 13.8063 12.948C16.3426 12.18 19.533 12.696 21.4955 14.352C22.5514 15.24 23.0908 16.356 22.9875 17.508Z" fill="currentColor"></path>
                                    </svg>
                                </span>
                                <h4 class="odometer title-lg" id="users"></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-3 col-lg-4 col-sm-6">
                        <div class="px-2 py-3 rounded-4 w-100 text-center bg-white">
                            <h6 class="description-sm mb-2 fw-semi-bold text-body">Total Emails</h6>
                            <div class="d-flex align-items-center justify-content-center">
                                <span class="me-3 text-primary">
                                    <svg width="20" height="20" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.5 0H3.5C1.4 0 0 1.05882 0 3.52941V8.47059C0 10.9412 1.4 12 3.5 12H10.5C12.6 12 14 10.9412 14 8.47059V3.52941C14 1.05882 12.6 0 10.5 0ZM10.829 4.29882L8.638 6.06353C8.176 6.43765 7.588 6.62118 7 6.62118C6.412 6.62118 5.817 6.43765 5.362 6.06353L3.171 4.29882C2.947 4.11529 2.912 3.77647 3.087 3.55059C3.269 3.32471 3.598 3.28235 3.822 3.46588L6.013 5.23059C6.545 5.66118 7.448 5.66118 7.98 5.23059L10.171 3.46588C10.395 3.28235 10.731 3.31765 10.906 3.55059C11.088 3.77647 11.053 4.11529 10.829 4.29882Z" fill="currentColor" />
                                    </svg>
                                </span>
                                <h4 class="odometer title-lg" id="emails"></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-3 col-lg-4 col-sm-6">
                        <div class="px-2 py-3 rounded-4 w-100 text-center bg-white">
                            <h6 class="description-sm mb-2 fw-semi-bold text-body">Total Sequences</h6>
                            <div class="d-flex align-items-center justify-content-center">
                                <span class="me-3 text-primary">
                                    <svg width="16" height="16" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.069 0.294079L3.37486 2.51877C-1.12495 4.02414 -1.12495 6.47871 3.37486 7.97666L5.3616 8.63665L6.02137 10.624C7.51884 15.1253 9.98002 15.1253 11.4775 10.624L13.7089 3.93515C14.7022 0.931822 13.0713 -0.70703 10.069 0.294079ZM10.3062 4.28368L7.48918 7.11645C7.37799 7.22768 7.23714 7.27959 7.09628 7.27959C6.95543 7.27959 6.81458 7.22768 6.70339 7.11645C6.4884 6.9014 6.4884 6.54545 6.70339 6.3304L9.5204 3.49763C9.73538 3.28257 10.0912 3.28257 10.3062 3.49763C10.5212 3.71268 10.5212 4.06863 10.3062 4.28368Z" fill="currentColor"></path>
                                    </svg>
                                </span>
                                <h4 class="odometer title-lg" id="sequences"></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-3 col-lg-4 col-sm-6">
                        <div class="px-2 py-3 rounded-4 w-100 text-center bg-white">
                            <h6 class="description-sm mb-2 fw-semi-bold text-body">Total Prospects</h6>
                            <div class="d-flex align-items-center justify-content-center">
                                <span class="me-3 text-primary">
                                    <svg width="20" height="20" viewBox="0 0 23 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8.07948 0C5.07263 0 2.62812 2.556 2.62812 5.7C2.62812 8.784 4.93491 11.28 7.94176 11.388C8.03357 11.376 8.12538 11.376 8.19424 11.388C8.21719 11.388 8.22867 11.388 8.25162 11.388C8.2631 11.388 8.2631 11.388 8.27458 11.388C11.2126 11.28 13.5193 8.784 13.5308 5.7C13.5308 2.556 11.0863 0 8.07948 0Z" fill="currentColor"></path>
                                        <path d="M13.9096 14.58C10.7076 12.348 5.48578 12.348 2.26088 14.58C0.803357 15.6 0 16.98 0 18.456C0 19.932 0.803357 21.3 2.2494 22.308C3.85611 23.436 5.96779 24 8.07948 24C10.1912 24 12.3028 23.436 13.9096 22.308C15.3556 21.288 16.159 19.92 16.159 18.432C16.1475 16.956 15.3556 15.588 13.9096 14.58Z" fill="currentColor"></path>
                                        <path d="M20.6922 6.408C20.8758 8.736 19.292 10.776 17.1 11.052C17.0886 11.052 17.0886 11.052 17.0771 11.052H17.0426C16.9738 11.052 16.9049 11.052 16.8475 11.076C15.7343 11.136 14.7129 10.764 13.944 10.08C15.1261 8.976 15.8032 7.32 15.6655 5.52C15.5851 4.548 15.2638 3.66 14.7818 2.904C15.2179 2.676 15.7228 2.532 16.2393 2.484C18.4887 2.28 20.4971 4.032 20.6922 6.408Z" fill="currentColor"></path>
                                        <path d="M22.9875 17.508C22.8957 18.672 22.1841 19.68 20.9906 20.364C19.8429 21.024 18.3969 21.336 16.9623 21.3C17.7886 20.52 18.2706 19.548 18.3624 18.516C18.4772 17.028 17.8001 15.6 16.4459 14.46C15.6769 13.824 14.7818 13.32 13.8063 12.948C16.3426 12.18 19.533 12.696 21.4955 14.352C22.5514 15.24 23.0908 16.356 22.9875 17.508Z" fill="currentColor"></path>
                                    </svg>
                                </span>
                                <h4 class="odometer title-lg" id="prospects"></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-3 col-lg-4 col-sm-6">
                        <div class="px-2 py-3 rounded-4 w-100 text-center bg-white">
                            <h6 class="description-sm mb-2 fw-semi-bold text-body">Warm Up Queued</h6>
                            <div class="d-flex align-items-center justify-content-center">
                                <span class="me-3 text-primary">
                                    <svg width="16" height="16" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8.66667 0H3.33333C1 0 0 1.4 0 3.5V10.5C0 12.6 1 14 3.33333 14H8.66667C11 14 12 12.6 12 10.5V3.5C12 1.4 11 0 8.66667 0ZM3.33333 7.175H6C6.27333 7.175 6.5 7.413 6.5 7.7C6.5 7.987 6.27333 8.225 6 8.225H3.33333C3.06 8.225 2.83333 7.987 2.83333 7.7C2.83333 7.413 3.06 7.175 3.33333 7.175ZM8.66667 11.025H3.33333C3.06 11.025 2.83333 10.787 2.83333 10.5C2.83333 10.213 3.06 9.975 3.33333 9.975H8.66667C8.94 9.975 9.16667 10.213 9.16667 10.5C9.16667 10.787 8.94 11.025 8.66667 11.025ZM10.3333 5.075H9C7.98667 5.075 7.16667 4.214 7.16667 3.15V1.75C7.16667 1.463 7.39333 1.225 7.66667 1.225C7.94 1.225 8.16667 1.463 8.16667 1.75V3.15C8.16667 3.633 8.54 4.025 9 4.025H10.3333C10.6067 4.025 10.8333 4.263 10.8333 4.55C10.8333 4.837 10.6067 5.075 10.3333 5.075Z" fill="currentColor" />
                                    </svg>
                                </span>
                                <h4 class="odometer title-lg" id="warm_up_queued"></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-3 col-lg-4 col-sm-6">
                        <div class="px-2 py-3 rounded-4 w-100 text-center bg-white">
                            <h6 class="description-sm mb-2 fw-semi-bold text-body">Warm Up Processing</h6>
                            <div class="d-flex align-items-center justify-content-center">
                                <span class="me-3 text-primary">
                                    <svg width="16" height="16" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8.66667 0H3.33333C1 0 0 1.4 0 3.5V10.5C0 12.6 1 14 3.33333 14H8.66667C11 14 12 12.6 12 10.5V3.5C12 1.4 11 0 8.66667 0ZM3.33333 7.175H6C6.27333 7.175 6.5 7.413 6.5 7.7C6.5 7.987 6.27333 8.225 6 8.225H3.33333C3.06 8.225 2.83333 7.987 2.83333 7.7C2.83333 7.413 3.06 7.175 3.33333 7.175ZM8.66667 11.025H3.33333C3.06 11.025 2.83333 10.787 2.83333 10.5C2.83333 10.213 3.06 9.975 3.33333 9.975H8.66667C8.94 9.975 9.16667 10.213 9.16667 10.5C9.16667 10.787 8.94 11.025 8.66667 11.025ZM10.3333 5.075H9C7.98667 5.075 7.16667 4.214 7.16667 3.15V1.75C7.16667 1.463 7.39333 1.225 7.66667 1.225C7.94 1.225 8.16667 1.463 8.16667 1.75V3.15C8.16667 3.633 8.54 4.025 9 4.025H10.3333C10.6067 4.025 10.8333 4.263 10.8333 4.55C10.8333 4.837 10.6067 5.075 10.3333 5.075Z" fill="currentColor" />
                                    </svg>
                                </span>
                                <h4 class="odometer title-lg" id="warm_up_processing"></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-3 col-lg-4 col-sm-6">
                        <div class="px-2 py-3 rounded-4 w-100 text-center bg-white">
                            <h6 class="description-sm mb-2 fw-semi-bold text-body">Sequence Queued</h6>
                            <div class="d-flex align-items-center justify-content-center">
                                <span class="me-3 text-primary">
                                    <svg width="16" height="16" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.069 0.294079L3.37486 2.51877C-1.12495 4.02414 -1.12495 6.47871 3.37486 7.97666L5.3616 8.63665L6.02137 10.624C7.51884 15.1253 9.98002 15.1253 11.4775 10.624L13.7089 3.93515C14.7022 0.931822 13.0713 -0.70703 10.069 0.294079ZM10.3062 4.28368L7.48918 7.11645C7.37799 7.22768 7.23714 7.27959 7.09628 7.27959C6.95543 7.27959 6.81458 7.22768 6.70339 7.11645C6.4884 6.9014 6.4884 6.54545 6.70339 6.3304L9.5204 3.49763C9.73538 3.28257 10.0912 3.28257 10.3062 3.49763C10.5212 3.71268 10.5212 4.06863 10.3062 4.28368Z" fill="currentColor"></path>
                                    </svg>
                                </span>
                                <h4 class="odometer title-lg" id="sequence_queued"></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-3 col-lg-4 col-sm-6">
                        <div class="px-2 py-3 rounded-4 w-100 text-center bg-white">
                            <h6 class="description-sm mb-2 fw-semi-bold text-body">Sequence Processing</h6>
                            <div class="d-flex align-items-center justify-content-center">
                                <span class="me-3 text-primary">
                                    <svg width="16" height="16" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.069 0.294079L3.37486 2.51877C-1.12495 4.02414 -1.12495 6.47871 3.37486 7.97666L5.3616 8.63665L6.02137 10.624C7.51884 15.1253 9.98002 15.1253 11.4775 10.624L13.7089 3.93515C14.7022 0.931822 13.0713 -0.70703 10.069 0.294079ZM10.3062 4.28368L7.48918 7.11645C7.37799 7.22768 7.23714 7.27959 7.09628 7.27959C6.95543 7.27959 6.81458 7.22768 6.70339 7.11645C6.4884 6.9014 6.4884 6.54545 6.70339 6.3304L9.5204 3.49763C9.73538 3.28257 10.0912 3.28257 10.3062 3.49763C10.5212 3.71268 10.5212 4.06863 10.3062 4.28368Z" fill="currentColor"></path>
                                    </svg>
                                </span>
                                <h4 class="odometer title-lg" id="sequence_processing"></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="bg-light p-4 pt-3 rounded-4 h-100">
                <h5 class="title mb-3 fw-medium">INBOX WARMING PLANS</h5>
                <div id="sequence-chart"></div>
            </div>
        </div>
    </div>
</div>
@push('css')
<style>
    #odometer {
        display: block;
        margin: 0;
        padding: 0 20px;
    }

    .odometer-inside {
        min-width: 30px;
        display: flex;
    }

    .odometer-digit {
        width: 100%;
    }

    .odometer-value {
        text-align: left !important;
    }
</style>
<link href="https://github.hubspot.com/odometer/themes/odometer-theme-default.css" rel="stylesheet">
@endpush
@push('js')
<script src="https://github.hubspot.com/odometer/odometer.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    const dashboardObj = {
                stats : {
                    users : 0,
                    emails : 0,
                    sequences : 0,
                    prospects : 0,
                    warm_up_queued : 0,
                    warm_up_processing : 0,
                    sequence_queued : 0,
                    sequence_processing : 0,
                },
                init(){
                    let self = this;
                    this.$watch('stats', (value) => {
                        users.innerHTML = value.users;
                        emails.innerHTML = value.emails;
                        sequences.innerHTML = value.sequences;
                        prospects.innerHTML = value.prospects;
                        warm_up_queued.innerHTML = value.warm_up_queued;
                        warm_up_processing.innerHTML = value.warm_up_processing;
                        sequence_queued.innerHTML = value.sequence_queued;
                        sequence_processing.innerHTML = value.sequence_processing;
                    });

                    let preData = this.preGraphChartData();
                    this.warmupChart(preData);
                    this.sequenceChart(preData);
                    this.getStats();
                    this.getWarmupChartData();
                    this.getSequenceChartData();
                    setInterval(function(){
                        self.getStats();
                    }, 60 * 1000);

                },
                getStats(){
                    let self = this;
                    let url = "{{route('getStats')}}";
                    makeAjaxPost({}, url).done(res => {
                        if(res.success){
                            self.stats = res.data;
                        }
                    });
                },
                getWarmupChartData(){
                    let self = this;
                    let url = "{{route('getWarmupChartData')}}";
                    makeAjaxPost({}, url).done(res => {
                        if(res.success){
                            self.warmupChart(res.data);
                        }
                    });
                },
                getSequenceChartData(){
                    let self = this;
                    let url = "{{route('getSequenceChartData')}}";
                    makeAjaxPost({}, url).done(res => {
                        if(res.success){
                            self.sequenceChart(res.data);
                        }
                    });
                },
                preGraphChartData(){
                    let preData = {
                        date : [],
                        jobs : [],
                        success : [],
                        failed : [],
                        replied : [],
                    };
                    for(let i=0; i<=7;i++){
                        preData.date[i] = i;
                        preData.jobs[i] = 0;
                        preData.success[i] = 0;
                        preData.failed[i] = 0;
                        preData.replied[i] = 0;
                    }
                    return preData;
                },
                warmupChart(resData) {
                    Highcharts.chart('warmup-chart', {
                        credits: {
                            enabled: false
                        },
                        // chart: {
                        //     type: 'column'
                        // },
                        title: {
                            text: ''
                        },
                        xAxis: {
                            categories: resData.date,
                        },
                        yAxis: {
                            title: {
                                text: ''
                            },
                            stackLabels: {
                                enabled: false,
                            }
                        },
                        tooltip: {
                            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b><br/>',
                            shared: true
                        },
                        plotOptions: {
                            line: {
                                dataLabels: {
                                    enabled: false
                                },
                                enableMouseTracking: true
                            }
                        },
                        series: [{
                            type: 'spline',
                            name: 'Total Jobs',
                            data: resData.jobs,
                            color: "#4B21EE"
                        }, {
                            type: 'column',
                            name: 'Success',
                            data: resData.success,
                            color: "#34A853"
                        }, {
                            type: 'areaspline',
                            name: 'Failed',
                            data: resData.failed,
                            color: "#EA4335"
                        }, {
                            type: 'column',
                            name: 'Replied',
                            data: resData.replied,
                            color: "#EEB221"
                        }]
                    });
                },
                sequenceChart(resData) {
                    Highcharts.chart('sequence-chart', {
                        credits: {
                            enabled: false
                        },
                        // chart: {
                        //     type: 'column'
                        // },
                        title: {
                            text: ''
                        },
                        xAxis: {
                            categories: resData.date,
                        },
                        yAxis: {
                            title: {
                                text: ''
                            },
                            stackLabels: {
                                enabled: false,
                            }
                        },
                        tooltip: {
                            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b><br/>',
                            shared: true
                        },
                        plotOptions: {
                            line: {
                                dataLabels: {
                                    enabled: false
                                },
                                enableMouseTracking: true
                            }
                        },
                        series: [{
                            type: 'spline',
                            name: 'Total Jobs',
                            data: resData.jobs,
                            color: "#4B21EE"
                        }, {
                            type: 'column',
                            name: 'success',
                            data: resData.success,
                            color: "#34A853"
                        }, {
                            type: 'areaspline',
                            name: 'Failed',
                            data: resData.failed,
                            color: "#EA4335"
                        }]
                    });
                },
            }
</script>
@endpush
@endsection