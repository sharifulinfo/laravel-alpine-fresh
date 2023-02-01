const root = {
    loadingStatus: false,
    activeWorkspace: {},
    timeZones: {
        "Etc/GMT+12": "(UTC-12:00) International Date Line West",
        "Etc/GMT+11": "(UTC-11:00) Coordinated Universal Time-11",
        "Etc/GMT+10": "(UTC-10:00) Hawaii",
        "America/Anchorage": "(UTC-09:00) Alaska",
        "America/Santa_Isabel": "(UTC-08:00) Baja California",
        "America/Los_Angeles": "(UTC-08:00) Pacific Standard Time (US & Canada)",
        "America/Creston": "(UTC-07:00) Arizona",
        "America/Chihuahua": "(UTC-07:00) Chihuahua, La Paz, Mazatlan",
        "America/Boise": "(UTC-07:00) Mountain Time (US & Canada)",
        "America/Belize": "(UTC-06:00) Central America",
        "America/Chicago": "(UTC-06:00) Central Time (US & Canada)",
        "America/Bahia_Banderas": "(UTC-06:00) Guadalajara, Mexico City, Monterrey",
        "America/Regina": "(UTC-06:00) Saskatchewan",
        "America/Bogota": "(UTC-05:00) Bogota, Lima, Quito",
        "America/Detroit": "(UTC-04:00) Eastern Daylight Time (US & Canada)",
        "America/Indiana/Marengo": "(UTC-05:00) Indiana (East)",
        "America/Caracas": "(UTC-04:30) Caracas",
        "America/Asuncion": "(UTC-04:00) Asuncion",
        "America/Glace_Bay": "(UTC-04:00) Atlantic Time (Canada)",
        "America/Campo_Grande": "(UTC-04:00) Cuiaba",
        "America/Anguilla": "(UTC-04:00) Georgetown, La Paz, Manaus, San Juan",
        "America/Santiago": "(UTC-04:00) Santiago",
        "America/St_Johns": "(UTC-03:30) Newfoundland",
        "America/Sao_Paulo": "(UTC-03:00) Brasilia",
        "America/Argentina/La_Rioja": "(UTC-03:00) Buenos Aires",
        "America/Araguaina": "(UTC-03:00) Cayenne, Fortaleza",
        "America/Godthab": "(UTC-03:00) Greenland",
        "America/Montevideo": "(UTC-03:00) Montevideo",
        "America/Bahia": "(UTC-03:00) Salvador",
        "America/Noronha": "(UTC-02:00) Coordinated Universal Time-02",
        "America/Scoresbysund": "(UTC-01:00) Azores",
        "Atlantic/Cape_Verde": "(UTC-01:00) Cape Verde Is.",
        "Africa/Casablanca": "(UTC) Casablanca",
        "America/Danmarkshavn": "(UTC) Coordinated Universal Time",
        "Europe/Isle_of_Man": "(UTC+01:00) Edinburgh, London",
        "Atlantic/Canary": "(UTC) Dublin, Lisbon",
        "Africa/Abidjan": "(UTC) Monrovia, Reykjavik",
        "Arctic/Longyearbyen": "(UTC+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna",
        "Europe/Belgrade": "(UTC+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague",
        "Africa/Ceuta": "(UTC+01:00) Brussels, Copenhagen, Madrid, Paris",
        "Europe/Sarajevo": "(UTC+01:00) Sarajevo, Skopje, Warsaw, Zagreb",
        "Africa/Algiers": "(UTC+01:00) West Central Africa",
        "Africa/Windhoek": "(UTC+01:00) Windhoek",
        "Asia/Nicosia": "(UTC+02:00) E. Europe",
        "Asia/Beirut": "(UTC+02:00) Beirut",
        "Africa/Cairo": "(UTC+02:00) Cairo",
        "Asia/Damascus": "(UTC+02:00) Damascus",
        "Africa/Blantyre": "(UTC+02:00) Harare, Pretoria",
        "Europe/Helsinki": "(UTC+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius",
        "Europe/Istanbul": "(UTC+03:00) Istanbul",
        "Asia/Jerusalem": "(UTC+02:00) Jerusalem",
        "Africa/Tripoli": "(UTC+02:00) Tripoli",
        "Asia/Amman": "(UTC+03:00) Amman",
        "Asia/Baghdad": "(UTC+03:00) Baghdad",
        "Europe/Kaliningrad": "(UTC+02:00) Kaliningrad",
        "Asia/Aden": "(UTC+03:00) Kuwait, Riyadh",
        "Africa/Addis_Ababa": "(UTC+03:00) Nairobi",
        "Europe/Kirov": "(UTC+03:00) Moscow, St. Petersburg, Volgograd, Minsk",
        "Europe/Astrakhan": "(UTC+04:00) Samara, Ulyanovsk, Saratov",
        "Asia/Tehran": "(UTC+03:30) Tehran",
        "Asia/Dubai": "(UTC+04:00) Abu Dhabi, Muscat",
        "Asia/Baku": "(UTC+04:00) Baku",
        "Indian/Mahe": "(UTC+04:00) Port Louis",
        "Asia/Tbilisi": "(UTC+04:00) Tbilisi",
        "Asia/Yerevan": "(UTC+04:00) Yerevan",
        "Asia/Kabul": "(UTC+04:30) Kabul",
        "Antarctica/Mawson": "(UTC+05:00) Ashgabat, Tashkent",
        "Asia/Yekaterinburg": "(UTC+05:00) Yekaterinburg",
        "Asia/Karachi": "(UTC+05:00) Islamabad, Karachi",
        "Asia/Kolkata": "(UTC+05:30) Chennai, Kolkata, Mumbai, New Delhi",
        "Asia/Colombo": "(UTC+05:30) Sri Jayawardenepura",
        "Asia/Kathmandu": "(UTC+05:45) Kathmandu",
        "Antarctica/Vostok": "(UTC+06:00) Nur-Sultan (Astana)",
        "Asia/Dhaka": "(UTC+06:00) Dhaka",
        "Asia/Rangoon": "(UTC+06:30) Yangon (Rangoon)",
        "Antarctica/Davis": "(UTC+07:00) Bangkok, Hanoi, Jakarta",
        "Asia/Novokuznetsk": "(UTC+07:00) Novosibirsk",
        "Asia/Hong_Kong": "(UTC+08:00) Beijing, Chongqing, Hong Kong, Urumqi",
        "Asia/Krasnoyarsk": "(UTC+08:00) Krasnoyarsk",
        "Asia/Brunei": "(UTC+08:00) Kuala Lumpur, Singapore",
        "Antarctica/Casey": "(UTC+08:00) Perth",
        "Asia/Taipei": "(UTC+08:00) Taipei",
        "Asia/Choibalsan": "(UTC+08:00) Ulaanbaatar",
        "Asia/Irkutsk": "(UTC+08:00) Irkutsk",
        "Asia/Dili": "(UTC+09:00) Osaka, Sapporo, Tokyo",
        "Asia/Pyongyang": "(UTC+09:00) Seoul",
        "Australia/Adelaide": "(UTC+09:30) Adelaide",
        "Australia/Darwin": "(UTC+09:30) Darwin",
        "Australia/Brisbane": "(UTC+10:00) Brisbane",
        "Australia/Melbourne": "(UTC+10:00) Canberra, Melbourne, Sydney",
        "Antarctica/DumontDUrville": "(UTC+10:00) Guam, Port Moresby",
        "Australia/Currie": "(UTC+10:00) Hobart",
        "Asia/Chita": "(UTC+09:00) Yakutsk",
        "Antarctica/Macquarie": "(UTC+11:00) Solomon Is., New Caledonia",
        "Asia/Sakhalin": "(UTC+11:00) Vladivostok",
        "Antarctica/McMurdo": "(UTC+12:00) Auckland, Wellington",
        "Etc/GMT-12": "(UTC+12:00) Coordinated Universal Time+12",
        "Pacific/Fiji": "(UTC+12:00) Fiji",
        "Asia/Anadyr": "(UTC+12:00) Magadan",
        "Asia/Kamchatka": "(UTC+12:00) Petropavlovsk-Kamchatsky - Old",
        "Etc/GMT-13": "(UTC+13:00) Nuku'alofa",
        "Pacific/Apia": "(UTC+13:00) Samoa"
    },
    siteInit() {
        // this.customSelectBoxInit();
        this.countNotifications();
    },

    reloadCustomSelectBox(){
        setTimeout(()=>{
            $("div.theme-select-box").each(function( index ) {
                let val = $(this).find('div.dropdown-menu span.active').text();
                if(val !== ''){
                    $(this).find(".selected-value").text(val);
                }
            });
        },200)
    },

    getContentWithVariableValue(content,customVariables) {
        let self = this;
        if (typeof content !== 'object') {
            return this.replaceContent(content, customVariables);
        } else {
            return '---';
        }
    },
    getQueryParams(qs) {
        qs = qs.split('+').join(' ');
        var params = {},
            tokens,
            re = /[?&]?([^=]+)=([^&]*)/g;
        while (tokens = re.exec(qs)) {
            params[decodeURIComponent(tokens[1])] = decodeURIComponent(tokens[2]);
        }
        return params;
    },
    formatPhone(phoneNumberString) {
        var cleaned = ('' + phoneNumberString).replace(/\D/g, '');
        var match = cleaned.match(/^(\d{1})?(\d{3})(\d{3})(\d{4})$/);
        if (match) {
            var intlCode = (match[1] ? '+' + match[1] + ' ' : '');
            return [intlCode, '(', match[2], ') ', match[3], '-', match[4]].join('');
        }
        return phoneNumberString;
    },
    formatAmount(x, currency = true) {
        if (currency) {
            var parts = x.toFixed(2).toString().split(".");
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return '$' + parts.join(".");
        }
        var parts = x.toString().split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return parts.join(".");
    },
    formatTime(time,onlyDate=false) {
        //Sample: Tue, Jan 3, 2023 11:57 AM
        let date = new Date(time * 1000);
        let str = date.toDateString();
        let t = str.slice(0, 3);
        t += ', '+str.slice(3, 10);
        t += ', '+str.slice(10, 15);
        t += ' '+date.toLocaleTimeString().slice(0, 4);
        t += ' '+date.toLocaleTimeString().slice(7, 10);
        return t;
    },

    get_gravatar( $email, $s = 80, $d = 'mp', $r = 'g', $img = false ) {
        if($email !== undefined) {
            $email = $email.toLowerCase().trim();
            let $url = 'https://www.gravatar.com/avatar/';
            $url += md5($email)
            // $url += '205e460b479e2e5b48aec07710c08d50'
            $url += `?s=${$s}&d=${$d}&r=${$r}`;
            console.log($url);
            return $url;
        }
        return 'https://app.outreachbin.com/images/no_image.png';
    },
    time_ago(time) {
        switch (typeof time) {
            case 'number':
                break;
            case 'string':
                time = +new Date(time);
                break;
            case 'object':
                if (time.constructor === Date) time = time.getTime();
                break;
            default:
                time = +new Date();
        }
        var time_formats = [
            [60, 'seconds', 1], // 60
            [120, '1 minute ago', '1 minute from now'], // 60*2
            [3600, 'minutes', 60], // 60*60, 60
            [7200, '1 hour ago', '1 hour from now'], // 60*60*2
            [86400, 'hours', 3600], // 60*60*24, 60*60
            [172800, 'Yesterday', 'Tomorrow'], // 60*60*24*2
            [604800, 'days', 86400], // 60*60*24*7, 60*60*24
            [1209600, 'Last week', 'Next week'], // 60*60*24*7*4*2
            [2419200, 'weeks', 604800], // 60*60*24*7*4, 60*60*24*7
            [4838400, 'Last month', 'Next month'], // 60*60*24*7*4*2
            [29030400, 'months', 2419200], // 60*60*24*7*4*12, 60*60*24*7*4
            [58060800, 'Last year', 'Next year'], // 60*60*24*7*4*12*2
            [2903040000, 'years', 29030400], // 60*60*24*7*4*12*100, 60*60*24*7*4*12
            [5806080000, 'Last century', 'Next century'], // 60*60*24*7*4*12*100*2
            [58060800000, 'centuries', 2903040000] // 60*60*24*7*4*12*100*20, 60*60*24*7*4*12*100
        ];
        var seconds = (+new Date() - time) / 1000,
            token = 'ago',
            list_choice = 1;
        if (seconds == 0) {
            return 'Just now'
        }
        if (seconds < 0) {
            seconds = Math.abs(seconds);
            token = 'from now';
            list_choice = 2;
        }
        var i = 0,
            format;
        while (format = time_formats[i++])
            if (seconds < format[0]) {
                if (typeof format[2] == 'string')
                    return format[list_choice];
                else
                    return Math.floor(seconds / format[2]) + ' ' + format[1] + ' ' + token;
            }
        return time;
    },
    greeting() {
        var ndate = new Date();
        var hours = ndate.getHours();
        var message = hours < 12 ? 'Good, Morning' : hours < 18 ? 'Good, Afternoon' : 'Good, Evening';
        return message;
    },

    replaceContent(str, variableValues) {
        return str.replaceAll(/{{(.+?)}}/g, (match) => {
            let word = match.replaceAll('{{', '');
            word = word.replaceAll('}}', '');
            word = word.replace(/(<([^>]+)>)/ig, '');
            let wordArr = word.split("??");
            let variable = wordArr[0].trim();
            variable = variable.replace("$", "");
            if(variable === 'firstName') variable = 'first_name';
            if(variable === 'lastName') variable = 'last_name';
            if (typeof variableValues[variable] !== 'undefined' && variableValues[variable] !== "") {
                //console.log(variable)
                return variableValues[variable];
            } else {
                if (typeof wordArr[1] !== 'undefined') {
                    let fallback = wordArr[1].trim();
                    fallback = fallback.replace(/^"(.*)"$/, '$1');
                    return fallback;
                    //return fallback.toLowerCase() !== 'fallback' ? fallback : "";
                } else {
                    return '';
                }
            }
        });
    },
    getRandomArbitrary(min, max) {
        let dd = Math.random() * (max - min) + min;
        return parseInt(dd);
    },

    getPlaceHolder(isLoading = true, length = 5, interVal = true) {
        let self = this;
        let html = ``;
        if (isLoading) {
            html += `<div class="placeholder-loader">`;
            for (let i = 0; i < length; i++) {
                html += `<div class="placeholder-content" style="width:` + self.getRandomArbitrary(30, 80) + `%;"></div>`;
            }
            html += `</div>`;
            // if(interVal){
            // console.log('1');
            // setInterval(() => {
            //     $('.placeholder-content').each(function () {
            //         // let $h = self.getRandomArbitrary(30, 50);
            //         let $w = self.getRandomArbitrary(30, 100);
            //         $(this).css('width', $w + '%');
            //     });
            // }, 1500);
            // }
        }
        return html;
    },
    loadingInit(isLoading = true) {
        let self = this;
        $('.placeholder-content').each(function () {
            let $h = self.getRandomArbitrary(30, 80);
            let $w = self.getRandomArbitrary(30, 100);
            $(this).css('width', $w + '%');
        });
        setInterval(() => {
            if (isLoading) {
                $('.placeholder-content').each(function () {
                    let $h = self.getRandomArbitrary(30, 50);
                    let $w = self.getRandomArbitrary(30, 100);
                    $(this).css('width', $w + '%');
                });
            }
        }, 1000);
    },

    plansName: [],
    planNameLoading: true,
    loadPlanName() {
        let self = this;
        if (this.planNameLoading) {
            makeAjax($url + '/billing/get-plans-name', false).done(res => {
                self.plansName = res.data;
                self.planNameLoading = false;
            });
        }
    },

    notifications: [],
    notifyLoading: true,
    loadNotifications() {
        let self = this;
        if (this.notifyLoading) {
            makeAjax($url + '/notification/get').done(res => {
                self.notifications = res.data;
                self.notifyLoading = false;
                self.notificationCount = 0;
            });
        }
    },
    notificationCount: 0,
    countNotifications(count = false) {
        let self = this;
        makeAjax($url + '/notification/count').done(res => {
            self.notificationCount = res.data.count;
            self.notifyLoading = true;
        });
    },
    readNotification($id,all = false) {
        let self = this;
        let url = $url+"/notification/read";
        makeAjaxPost({
            id: $id,
            readAll: all,
        }, url,false).done(res => {
            if (res.success) {

                if(all){
                    $('.notification-item').removeClass('unread-item');
                }else{
                    $('#nId_'+$id).removeClass('unread-item');
                }
                self.countNotifications(true);
            } else {
                swalError(res.msg,'Notification can\'t read!');
            }
        }).fail(res => {
            swalError()
        })
    }
}
