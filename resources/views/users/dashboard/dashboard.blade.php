@extends('layouts.app-layout')
@section('content')
    <div x-data="dashboardObj">
         <p> welcome to dashboard </p>
    </div>
@endsection
@push('css')
    <link href="https://github.hubspot.com/odometer/themes/odometer-theme-default.css" rel="stylesheet">
    <style>
    #odometer {
        display: block;
        margin: 0;
        padding: 0 20px;
    }

    .odometer-inside {
        min-width: 32px;
        display: flex;
    }

    .odometer-digit {
        width: 100%;
    }

    .odometer-value {
        text-align: left !important;
    }
</style>
@endpush
@push('js')
    <script src="https://github.hubspot.com/odometer/odometer.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script>
        const dashboardObj = {
            summaryLoading : true,
            summaryStats: {
                sequences: 0,
                emails: 0,
                prospects: 0,
                sent: 0,
                opened: 0,
                replied: 0,
                clicked: 0,
                warmup_sent: 0,
                warmup_spam: 0,
                warmup_replied: 0,
                warmup_other: 0,
            },
            init() {
                let self = this;
                this.$watch('summaryStats', (value) => {
                    odo_sent.innerHTML = value.sent;
                    odo_opened.innerHTML = value.opened;
                    odo_replied.innerHTML = value.replied;
                    odo_clicked.innerHTML = value.clicked;
                    odo_warmup_sent.innerHTML = value.warmup_sent;
                    odo_warmup_replied.innerHTML = value.warmup_replied;
                    odo_warmup_spam.innerHTML = value.warmup_spam;
                    odo_warmup_other.innerHTML = value.warmup_other;
                });
            },
            warmupPieChart() {
                let self = this;
                Highcharts.chart('warmup-analytics', {
                    credits: {
                        enabled: false
                    },
                    chart: {
                        type: 'pie'
                    },
                    title: {
                        text: ''
                    },
                    tooltip: {
                        headerFormat: '',
                        pointFormat: '<span style="color:{point.color}">\u25CF</span> <b> {point.name} </b> - {point.y}'
                    },
                    plotOptions: {
                        pie: {
                            size: "80%",
                            showInLegend: true
                        }
                    },
                    series: [{
                        minPointSize: 4,
                        innerSize: '20%',
                        zMin: 0,
                        name: 'SentInfo',
                        data: [{
                            name: 'Sent',
                            y: self.summaryStats.warmup_sent === 0 ? 0 : self.summaryStats.warmup_sent,
                            z: 60,
                            color: "#4B21EE",
                            sliced: true,
                        }, {
                            name: 'Reply',
                            y: self.summaryStats.warmup_replied,
                            z: 70,
                            color: "#34A853"
                        }, {
                            name: 'Spam',
                            y: self.summaryStats.warmup_spam,
                            z: 100,
                            color: "#EA4335"
                        }, {
                            name: 'Others',
                            y: self.summaryStats.warmup_other,
                            z: 80,
                            color: "#EEB221"
                        }]
                    }]
                });
            },
            warmupDailyChart(resData) {
                Highcharts.chart('warmup-chart', {
                    credits: {
                        enabled: false
                    },
                    chart: {
                        type: 'spline'
                    },
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
                        name: 'SENT',
                        data: resData.sent,
                        color: "#4B21EE"
                    }, {
                        name: 'REPLIES',
                        data: resData.replied,
                        color: "#34A853"
                    }, {
                        name: 'MOVE FROM SPAM',
                        data: resData.spam,
                        color: "#EA4335",
                        type: 'areaspline'
                    }, {
                        name: 'MOVE FROM OTHERS',
                        data: resData.other,
                        color: "#EEB221"
                    }]
                });
            },
            sequenceDailyChart(resData) {
                Highcharts.chart('sequence-chart', {
                    credits: {
                        enabled: false
                    },
                    chart: {
                        type: 'column'
                    },
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
                        name: 'SENT',
                        data: resData.sent,
                        color: "#4B21EE"
                    }, {
                        name: 'OPENED',
                        data: resData.opened,
                        color: "#34A853"
                    }, {
                        name: 'CLICKED',
                        data: resData.clicked,
                        color: "#84D2C5"
                    }, {
                        name: 'REPLIED',
                        data: resData.replied,
                        color: "#707070"
                    }, {
                        type: 'areaspline',
                        name: 'BOUNCED',
                        data: resData.bounced,
                        color: 'rgba(234, 67, 53, 0.5)'
                    }]
                });
            },
            getSummeryStats() {
                let self = this;
                // self.summaryLoading = true;
                makeAjaxPost({}, '#', false).then(function (res) {
                    if (res.success) {
                        self.summaryStats = res.data;
                        self.warmupPieChart();
                    }
                    self.summaryLoading = false;
                })
            },
            warmupChartStats() {
                let self = this;
                makeAjaxPost({}, '#', false).then(function (res) {
                    if (res.success) {
                        self.warmupDailyChart(res.data);
                    }
                })
            },
            sequenceChartStats() {
                let self = this;
                makeAjaxPost({}, '#', false).then(function (res) {
                    if (res.success) {
                        self.sequenceDailyChart(res.data);
                        //     self.invitationData = res.data;
                    }
                })
            },
            emails: [],
            emailLoading: true,
            getEmails() {
                let self = this;
                this.emailLoading = true;
                makeAjaxPost({}, '#', false).then(function (res) {
                    if (res.success) {
                        self.emails = res.data;
                    }
                    self.emailLoading = false;
                })
            },
            sequences: [],
            sequenceLoading: true,
            getSequences() {
                let self = this;
                self.sequenceLoading = true;
                makeAjaxPost({}, '#', false).then(function (res) {
                    if (res.success) {
                        self.sequences = res.data;
                    }
                    self.sequenceLoading = false;
                })
            },

            //--------------------------------------------------------------------- Workspace Invitation
            invitationData: [],
            getWorkspaceInvitation() {
                let self = this;
                makeAjax('#', false).then(function (res) {
                    if (res.success) {
                        $('#joinWorkspace').modal('show');
                        self.invitationData = res.data;
                    }
                })
            },
            acceptInvitation($id, $wId) {
                makeAjaxPost({
                    id: $id,
                    workspace_id: $wId
                }, '#', false).then(function (res) {
                    if (res.success) {
                        $('#joinWorkspace').modal('hide');
                        swalSuccess(res.msg, "Invitation Accepted Success!")
                        setTimeout(() => {
                            window.location.href = "{{url('dashboard')}}";
                        }, 2000)
                    } else {
                        swalError(res.msg, "Invitation Accepted Failed!")
                    }
                })
            },
            rejectInvitation($id) {
                swalConfirm("Are you sure to cancel the request", 'Invitation Rejected!').then(s => {
                    makeAjaxPost({id: $id}, '#', false).then(function (res) {
                        if (res.success) {
                            $('#joinWorkspace').modal('hide');
                            swalSuccess(res.msg, "Invitation Rejected Success!")
                        } else {
                            swalError(res.msg, "Invitation Rejected Failed!")
                        }
                    })
                })
            }
        }
    </script>
@endpush

