"use strict";
(() => {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name=polyuno]').attr('content')
        }
    });
    // header responsive js
    let headerHeight = $('#headerArea').outerHeight();
    // $('#mainContent').css({ 'min-height': 'calc(100vh - ' + headerHeight + 'px)', 'margin-top': headerHeight + 'px' });
    // scrolling animation for header
    $(window).on('scroll', function () {
        var scroll = $(window).scrollTop();
        if (scroll < 50) {
            $(".header-area").removeClass("sticky");
        } else {
            $(".header-area").addClass("sticky");
        }
    });
    // dropdown js
    $('.header-profile-info').on('click', function () {
        $('.pro-dropdown-potion').slideToggle(200);
    });

    tippy('.show-tooltip', {
        followCursor: 'horizontal',
    });

    tippy('.bottomToolTip', {
        theme: 'outreachbin',
        followCursor: 'horizontal',
        placement: 'bottom',
        interactive: true
    });
    tippy('.TopToolTip', {
        theme: 'primary',
        followCursor: 'horizontal',
        placement: 'top',
        interactive: true
    });
    tippy('.rightToolTip', {
        theme: 'Warning',
        followCursor: 'vertical',
        placement: 'right',
        interactive: true
    });
})();

function canvasLoader(status = true, loadingText = 'SalesMix Loading...') {
    if (status) {
        $('.canvas-loading-page').fadeIn(100);
    } else {
        $('.canvas-loading-page').fadeOut(100);
    }
}


function loader(e = !0, a = "SalesMix Loading...") {
    let i,o,tt = 0;
    if (e) {
        let o = randomNumber(1, 9), d = 0;
        function g() {
            tt = 0;
            if (o <= randomNumber(85, 90)) {
                $(".loading-page div .loading-page-title").text(a);
                $(".loading-page div .loading-page-count").html(o + "%");
                $(".loading-page div .progress .progress-bar").css("width", o + "%");
                tt = setTimeout(g, d);
                d = randomNumber(250, 500);
                o += randomNumber(1, 10);
            }
        }
        g(), $(".custom-loader").fadeIn(100);
    } else {
        let l = 90;
        let ff = 0;
        function gg() {
            if (l <= 100) {
                $(".loading-page div .loading-page-title").text("Almost done ..."),
                    $(".loading-page div .loading-page-count").html(l + "%"),
                    $(".loading-page div .progress .progress-bar").css("width", l + "%");
                ff = setTimeout(gg, randomNumber(10, 100)),
                    l++
            } else {
                clearTimeout(ff);
                $(".custom-loader").fadeOut(100)
            }
        }
        setTimeout(gg, 500);
    }
}

/**************************************DROPDOWN**********************************************/
/********************************************************************************************/
$(document).on("click", ".theme-select-value", function (e) {
    let t = $(this);
    $(".theme-select-value").not(this).parent().removeClass("show"), t.parent().toggleClass("show"), t.parent().find(".dropdown-menu span").each((e, n) => {
        t.text() === $(n).text() ? $(n).addClass("active") : $(n).removeClass("active")
    })
}), $(document).on("click", ".dropdown-menu span", function () {
    let e = $(this), t = e.text();
    e.parent().parent().find(".theme-select-value").text(t), e.parent().parent().removeClass("show")
}), $(document).mouseup(function (e) {
    $(this);
    let t = $("div.theme-select-box");
    t.is(e.target) || 0 !== t.has(e.target).length || t.removeClass("show")
}), $(".dropdown-menu span.active").each(function (e) {
    let t = $(this);
    t.parent().parent().find(".theme-select-value").text(t.text())
});

$(document).on("input propertychange paste change", '.theme-select-search', function(e) {
    let value = $(this).val().toLowerCase();
    let $ul = $('.select-2-value');
    //get all lis but not the one having search input
    let $li = $ul.find('span');
    //hide all lis
    $li.addClass('d-none');
    $li.filter(function() {
        let text = $(this).text().toLowerCase();
        // console.log(text);
        return text.indexOf(value)>=0;
    }).removeClass('d-none');

});

/********************************************************************************************/
/********************************************************************************************/

/****************************************Ajax************************************************/

/********************************************************************************************/
function makeAjax(url, buttonLoaderClassName = 'btn-loading', dataType = 'json') {
    let button_load = [];
    if (typeof buttonLoaderClassName != "undefined" && buttonLoaderClassName !== null) {
        let elements = document.querySelectorAll('.' + buttonLoaderClassName);
        elements.forEach((el, i) => {
            button_load[i] = Ladda.create(el);
        });
    }
    return $.ajax({
        url: url,
        type: 'get',
        dataType: dataType,
        cache: false,
        beforeSend: function () {
            if (button_load.length > 0) {
                button_load.forEach((el, i) => {
                    button_load[i].start();
                })
            }
        }
    }).always(function () {
        if (button_load.length > 0) {
            button_load.forEach((el, i) => {
                button_load[i].stop();
            })
        }
    }).fail(function (res) {
        swalError(res.responseJSON.message);
        if (button_load.length > 0) {
            button_load.forEach((el, i) => {
                button_load[i].stop();
            })
        }
    });
}

function makeAjaxWithData(data, url, buttonLoaderClassName = 'btn-loading') {
    let button_load = [];
    if (typeof buttonLoaderClassName != "undefined" && buttonLoaderClassName !== null) {
        let elements = document.querySelectorAll('.' + buttonLoaderClassName);
        elements.forEach((el, i) => {
            button_load[i] = Ladda.create(el);
        });
    }
    return $.ajax({
        url: url,
        type: 'get',
        data: data,
        cache: false,
        beforeSend: function () {
            if (button_load.length > 0) {
                button_load.forEach((el, i) => {
                    button_load[i].start();
                })
            }
        }
    }).always(function () {
        if (button_load.length > 0) {
            button_load.forEach((el, i) => {
                button_load[i].stop();
            })
        }
    }).fail(function (res) {
        swalError(res.responseJSON.message);
        if (button_load.length > 0) {
            button_load.forEach((el, i) => {
                button_load[i].stop();
            })
        }
    });
}

function makeAjaxPostFile(data, url, buttonLoaderClassName = 'btn-loading') {
    let button_load = [];
    if (typeof buttonLoaderClassName != "undefined" && buttonLoaderClassName !== null) {
        let elements = document.querySelectorAll('.' + buttonLoaderClassName);
        elements.forEach((el, i) => {
            button_load[i] = Ladda.create(el);
        });
    }
    return $.ajax({
        url: url,
        type: 'post',
        data: data,
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            if (button_load.length > 0) {
                button_load.forEach((el, i) => {
                    button_load[i].start();
                })
            }
        }
    }).always(function () {

        if (button_load.length > 0) {
            button_load.forEach((el, i) => {
                button_load[i].stop();
            })
        }
    }).fail(function (res) {
        swalError(res.responseJSON.message);

        if (button_load.length > 0) {
            button_load.forEach((el, i) => {
                button_load[i].stop();
            })
        }
    });
}

function makeAjaxPost(data, url, buttonLoaderClassName = 'btn-loading') {
    let button_load = [];
    if (typeof buttonLoaderClassName != "undefined" && buttonLoaderClassName !== null) {
        let elements = document.querySelectorAll('.' + buttonLoaderClassName);
        elements.forEach((el, i) => {
            button_load[i] = Ladda.create(el);
        });
    }
    return $.ajax({
        url: url,
        type: 'post',
        //dataType: 'json',
        data: data,
        cache: false,
        beforeSend: function () {
            if (button_load.length > 0) {
                button_load.forEach((el, i) => {
                    button_load[i].start();
                })
            }
        }
    }).always(function () {
        if (button_load.length > 0) {
            button_load.forEach((el, i) => {
                button_load[i].stop();
            })
        }
    }).fail(function (res) {
        loader(false);
        if (res.responseJSON.message !== undefined) {
            swalError(res.responseJSON.message);
        }
        if (button_load.length > 0) {
            button_load.forEach((el, i) => {
                button_load[i].stop();
            })
        }
    });
}

/********************************************************************************************/
/********************************************************************************************/

/***********************************Sweet alerts (swal)**************************************/

/********************************************************************************************/
function swalError(message = "your action has been failed due to an unexpected reason", title = 'SalesMix Warning!') {
    if (message === 'permission denied') {
        swalError('Sorry! you don\'t have permission to access that page. Please contact your team owner for access it.', 'Permission Denied!');
    } else {


        let html = `
        <div class="text-center">
        <svg width="80" height="80" viewBox="0 0 140 141" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect opacity="0.11" y="0.00341797" width="140" height="140" rx="70" fill="#EA4335"/>
        <rect opacity="0.21" x="16" y="16" width="108" height="108" rx="54" fill="#EA4335"/>
        <path d="M70 108C49.0381 108 32 90.9619 32 70C32 49.0381 49.0381 32 70 32C90.9619 32 108 49.0381 108 70C108 90.9619 90.9619 108 70 108ZM70 37.3023C51.9721 37.3023 37.3023 51.9721 37.3023 70C37.3023 88.0279 51.9721 102.698 70 102.698C88.0279 102.698 102.698 88.0279 102.698 70C102.698 51.9721 88.0279 37.3023 70 37.3023Z" fill="#EA4335"/>
        <path d="M70 76.186C68.5507 76.186 67.3488 74.9842 67.3488 73.5349V55.8605C67.3488 54.4112 68.5507 53.2093 70 53.2093C71.4493 53.2093 72.6512 54.4112 72.6512 55.8605V73.5349C72.6512 74.9842 71.4493 76.186 70 76.186Z" fill="#EA4335"/>
        <path d="M70 87.674C69.5405 87.674 69.0809 87.568 68.6567 87.3912C68.2326 87.2145 67.8437 86.967 67.4902 86.6489C67.1721 86.2954 66.9247 85.9419 66.7479 85.4824C66.5712 85.0582 66.4651 84.5987 66.4651 84.1391C66.4651 83.6796 66.5712 83.2201 66.7479 82.7959C66.9247 82.3717 67.1721 81.9828 67.4902 81.6294C67.8437 81.3112 68.2326 81.0638 68.6567 80.887C69.5051 80.5335 70.4949 80.5335 71.3433 80.887C71.7674 81.0638 72.1563 81.3112 72.5098 81.6294C72.8279 81.9828 73.0753 82.3717 73.2521 82.7959C73.4288 83.2201 73.5349 83.6796 73.5349 84.1391C73.5349 84.5987 73.4288 85.0582 73.2521 85.4824C73.0753 85.9419 72.8279 86.2954 72.5098 86.6489C72.1563 86.967 71.7674 87.2145 71.3433 87.3912C70.9191 87.568 70.4595 87.674 70 87.674Z" fill="#EA4335"/>
        </svg>

            <div class="pt-4">
                <h6 class="popup-title">${title}</h6>
                <p class="description text-body">${message}</p>
            </div>
        </div>
        `;
        Swal.fire({
            html: html,
            showConfirmButton: false,
            showCloseButton: true,
            //timer: 2500
        });
    }
}

function swalWarning(message = "We are not able to do this action!", title = 'SalesMix says!') {
    if (message === 'permission denied') {
        swalError('Sorry! you don\'t have permission to access that page. Please contact your team owner for access it.', 'Permission Denied!');
    } else {
        let html = `
        <div class="text-center">
        <svg width="80" height="80" viewBox="0 0 140 141" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect opacity="0.11" y="0.00341797" width="140" height="140" rx="70" fill="#EEB221"/>
        <rect opacity="0.21" x="16" y="16" width="108" height="108" rx="54" fill="#EEB221"/>
        <path d="M70 108C49.0381 108 32 90.9619 32 70C32 49.0381 49.0381 32 70 32C90.9619 32 108 49.0381 108 70C108 90.9619 90.9619 108 70 108ZM70 37.3023C51.9721 37.3023 37.3023 51.9721 37.3023 70C37.3023 88.0279 51.9721 102.698 70 102.698C88.0279 102.698 102.698 88.0279 102.698 70C102.698 51.9721 88.0279 37.3023 70 37.3023Z" fill="#EEB221"/>
        <path d="M70 76.186C68.5507 76.186 67.3488 74.9842 67.3488 73.5349V55.8605C67.3488 54.4112 68.5507 53.2093 70 53.2093C71.4493 53.2093 72.6512 54.4112 72.6512 55.8605V73.5349C72.6512 74.9842 71.4493 76.186 70 76.186Z" fill="#EEB221"/>
        <path d="M70 87.674C69.5405 87.674 69.0809 87.568 68.6567 87.3912C68.2326 87.2145 67.8437 86.967 67.4902 86.6489C67.1721 86.2954 66.9247 85.9419 66.7479 85.4824C66.5712 85.0582 66.4651 84.5987 66.4651 84.1391C66.4651 83.6796 66.5712 83.2201 66.7479 82.7959C66.9247 82.3717 67.1721 81.9828 67.4902 81.6294C67.8437 81.3112 68.2326 81.0638 68.6567 80.887C69.5051 80.5335 70.4949 80.5335 71.3433 80.887C71.7674 81.0638 72.1563 81.3112 72.5098 81.6294C72.8279 81.9828 73.0753 82.3717 73.2521 82.7959C73.4288 83.2201 73.5349 83.6796 73.5349 84.1391C73.5349 84.5987 73.4288 85.0582 73.2521 85.4824C73.0753 85.9419 72.8279 86.2954 72.5098 86.6489C72.1563 86.967 71.7674 87.2145 71.3433 87.3912C70.9191 87.568 70.4595 87.674 70 87.674Z" fill="#EEB221"/>
        </svg>

            <div class="pt-4">
                <h6 class="popup-title">${title}</h6>
                <p class="description text-body">${message}</p>
            </div>
        </div>`;
        Swal.fire({
            html: html,
            showConfirmButton: false,
            showCloseButton: true,
            //timer: 2500
        });
    }
}

function swalSuccess(message = 'Action has been Applied Successfully', title = 'Successfully Applied!') {
    let html = `
    <div class="text-center">
    <svg width="80" height="80" viewBox="0 0 140 141" fill="none" xmlns="http://www.w3.org/2000/svg">
    <rect opacity="0.11" y="0.00341797" width="140" height="140" rx="70" fill="#34A853"/>
    <rect opacity="0.21" x="16" y="16" width="108" height="108" rx="54" fill="#34A853"/>
    <path d="M70 108C49.0381 108 32 90.9619 32 70C32 49.0381 49.0381 32 70 32C90.9619 32 108 49.0381 108 70C108 90.9619 90.9619 108 70 108ZM70 37.3023C51.9721 37.3023 37.3023 51.9721 37.3023 70C37.3023 88.0279 51.9721 102.698 70 102.698C88.0279 102.698 102.698 88.0279 102.698 70C102.698 51.9721 88.0279 37.3023 70 37.3023Z" fill="#34A853"/>
    <path d="M65.0298 82.2581C64.3297 82.2581 63.6647 81.9707 63.1747 81.4679L53.2692 71.304C52.2542 70.2625 52.2542 68.5386 53.2692 67.4971C54.2843 66.4556 55.9643 66.4556 56.9794 67.4971L65.0298 75.7575L83.0206 57.2973C84.0357 56.2557 85.7157 56.2557 86.7308 57.2973C87.7458 58.3388 87.7458 60.0627 86.7308 61.1042L66.8849 81.4679C66.3948 81.9707 65.7298 82.2581 65.0298 82.2581Z" fill="#34A853"/>
    </svg>
        <div class="pt-4">
            <h6 class="popup-title">${title}</h6>
            <p class="description text-body">${message}</p>
        </div>
    </div>
    `;
    Swal.fire({
        html: html,
        showConfirmButton: false,
        showCloseButton: true,
        //timer: 2500
    });
}

function swalSuccessConfirm(title, msg) {
    var message = typeof (msg) != "undefined" && msg !== null ? msg : "You won't be able to revert this!";
    var title = typeof (title) != "undefined" && title !== null ? msg : "Successfully Applied!";
    let html = `<div class="d-flex">`;
    html += `<div><svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="56" height="56" rx="3" fill="#F8F8F8"/>
                <path d="M28 40C34.612 40 40 34.612 40 28C40 21.388 34.612 16 28 16C21.388 16 16 21.388 16 28C16 34.612 21.388 40 28 40ZM28.9 32.8C28.9 33.292 28.492 33.7 28 33.7C27.508 33.7 27.1 33.292 27.1 32.8L27.1 26.8C27.1 26.308 27.508 25.9 28 25.9C28.492 25.9 28.9 26.308 28.9 26.8L28.9 32.8ZM26.896 22.744C26.956 22.588 27.04 22.468 27.148 22.348C27.268 22.24 27.4 22.156 27.544 22.096C27.688 22.036 27.844 22 28 22C28.156 22 28.312 22.036 28.456 22.096C28.6 22.156 28.732 22.24 28.852 22.348C28.96 22.468 29.044 22.588 29.104 22.744C29.164 22.888 29.2 23.044 29.2 23.2C29.2 23.356 29.164 23.512 29.104 23.656C29.044 23.8 28.96 23.932 28.852 24.052C28.732 24.16 28.6 24.244 28.456 24.304C28.168 24.424 27.832 24.424 27.544 24.304C27.4 24.244 27.268 24.16 27.148 24.052C27.04 23.932 26.956 23.8 26.896 23.656C26.836 23.512 26.8 23.356 26.8 23.2C26.8 23.044 26.836 22.888 26.896 22.744Z" fill="#707070"/>
                </svg></div>`;
    html += `<div class="px-3">`;
    html += `<h6>${title}</h6>`;
    html += `<p>${message}</p>`;
    html += `</div>`;
    html += `</div>`;
    return Swal.fire({
        html: html,
        reverseButtons: true,
        showCancelButton: false,
        showCloseButton: true,
        confirmButtonText: 'Okay',
        buttonsStyling: false,
        customClass: {
            cancelButton: 'btn btn-secondary w-100 me-2',
            confirmButton: 'btn btn-primary w-100 ms-2',
        },
    });
}

function swalRedirect(url, msg, mode, confirmButton = "Thank you", title = 'Successfully Applied!') {
    let message = typeof (msg) != "undefined" && msg !== null ? msg : "Action has been Applied Successfully";
    let icon = `<div><svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
    <rect width="56" height="56" rx="3" fill="#F8F8F8"/>
    <path d="M28 16C21.388 16 16 21.388 16 28C16 34.612 21.388 40 28 40C34.612 40 40 34.612 40 28C40 21.388 34.612 16 28 16ZM33.736 25.24L26.932 32.044C26.764 32.212 26.536 32.308 26.296 32.308C26.056 32.308 25.828 32.212 25.66 32.044L22.264 28.648C21.916 28.3 21.916 27.724 22.264 27.376C22.612 27.028 23.188 27.028 23.536 27.376L26.296 30.136L32.464 23.968C32.812 23.62 33.388 23.62 33.736 23.968C34.084 24.316 34.084 24.88 33.736 25.24Z" fill="#707070"/>
    </svg></div>`; // success
    let button = 'btn btn-secondary';
    if (typeof (mode) != "undefined" && mode !== null) {
        if (mode === 'danger') {
            icon = `<div><svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="56" height="56" rx="3" fill="#e4017225"/>
            <path d="M39.2185 33.3097L31.8621 19.812C30.8736 17.9959 29.5058 17 28 17C26.4942 17 25.1264 17.9959 24.1379 19.812L16.7815 33.3097C15.8505 35.0321 15.747 36.6842 16.4942 37.9847C17.2413 39.2853 18.7126 40 20.6436 40H35.3564C37.2874 40 38.7587 39.2853 39.5058 37.9847C40.253 36.6842 40.1495 35.0204 39.2185 33.3097ZM27.1379 25.2017C27.1379 24.7213 27.5287 24.323 28 24.323C28.4713 24.323 28.8621 24.7213 28.8621 25.2017V31.0601C28.8621 31.5405 28.4713 31.9389 28 31.9389C27.5287 31.9389 27.1379 31.5405 27.1379 31.0601V25.2017ZM28.8161 35.407C28.7586 35.4539 28.7012 35.5008 28.6437 35.5476C28.5747 35.5945 28.5058 35.6296 28.4368 35.6531C28.3678 35.6882 28.2989 35.7117 28.2184 35.7234C28.1494 35.7351 28.069 35.7468 28 35.7468C27.931 35.7468 27.8506 35.7351 27.7701 35.7234C27.7011 35.7117 27.6322 35.6882 27.5632 35.6531C27.4942 35.6296 27.4253 35.5945 27.3563 35.5476C27.2988 35.5008 27.2414 35.4539 27.1839 35.407C26.977 35.1844 26.8506 34.8798 26.8506 34.5751C26.8506 34.2705 26.977 33.9659 27.1839 33.7433C27.2414 33.6964 27.2988 33.6495 27.3563 33.6026C27.4253 33.5558 27.4942 33.5206 27.5632 33.4972C27.6322 33.462 27.7011 33.4386 27.7701 33.4269C27.9195 33.3917 28.0805 33.3917 28.2184 33.4269C28.2989 33.4386 28.3678 33.462 28.4368 33.4972C28.5058 33.5206 28.5747 33.5558 28.6437 33.6026C28.7012 33.6495 28.7586 33.6964 28.8161 33.7433C29.023 33.9659 29.1494 34.2705 29.1494 34.5751C29.1494 34.8798 29.023 35.1844 28.8161 35.407Z" fill="#E40173"/>
            </svg></div>`;
            button = `btn btn-danger`;
        } else if (mode === 'warning') {
            icon = `<div><svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="56" height="56" rx="3" fill="#F8F8F8"/>
            <path d="M39.2185 33.3097L31.8621 19.812C30.8736 17.9959 29.5058 17 28 17C26.4942 17 25.1264 17.9959 24.1379 19.812L16.7815 33.3097C15.8505 35.0321 15.747 36.6842 16.4942 37.9847C17.2413 39.2853 18.7126 40 20.6436 40H35.3564C37.2874 40 38.7587 39.2853 39.5058 37.9847C40.253 36.6842 40.1495 35.0204 39.2185 33.3097ZM27.1379 25.2017C27.1379 24.7213 27.5287 24.323 28 24.323C28.4713 24.323 28.8621 24.7213 28.8621 25.2017V31.0601C28.8621 31.5405 28.4713 31.9389 28 31.9389C27.5287 31.9389 27.1379 31.5405 27.1379 31.0601V25.2017ZM28.8161 35.407C28.7586 35.4539 28.7012 35.5008 28.6437 35.5476C28.5747 35.5945 28.5058 35.6296 28.4368 35.6531C28.3678 35.6882 28.2989 35.7117 28.2184 35.7234C28.1494 35.7351 28.069 35.7468 28 35.7468C27.931 35.7468 27.8506 35.7351 27.7701 35.7234C27.7011 35.7117 27.6322 35.6882 27.5632 35.6531C27.4942 35.6296 27.4253 35.5945 27.3563 35.5476C27.2988 35.5008 27.2414 35.4539 27.1839 35.407C26.977 35.1844 26.8506 34.8798 26.8506 34.5751C26.8506 34.2705 26.977 33.9659 27.1839 33.7433C27.2414 33.6964 27.2988 33.6495 27.3563 33.6026C27.4253 33.5558 27.4942 33.5206 27.5632 33.4972C27.6322 33.462 27.7011 33.4386 27.7701 33.4269C27.9195 33.3917 28.0805 33.3917 28.2184 33.4269C28.2989 33.4386 28.3678 33.462 28.4368 33.4972C28.5058 33.5206 28.5747 33.5558 28.6437 33.6026C28.7012 33.6495 28.7586 33.6964 28.8161 33.7433C29.023 33.9659 29.1494 34.2705 29.1494 34.5751C29.1494 34.8798 29.023 35.1844 28.8161 35.407Z" fill="#707070"/>
            </svg></div>`;
            button = `btn btn-warning`;
        }
    }

    let html = `<div class="d-flex">`;
    html += icon;
    html += `<div class="px-3">`;
    html += `<h6>${title}</h6>`;
    html += `<p>${message}</p>`;
    html += `</div>`;
    html += `</div>`;

    return Swal.fire({
        html: html,
        showCloseButton: true,
        showCancelButton: false,
        buttonsStyling: false,

        customClass: {
            cancelButton: 'btn btn-secondary w-100 me-2',
            confirmButton: button + ' w-100 ms-2',
        },
        focusConfirm: false,
        confirmButtonText: confirmButton,
        allowOutsideClick: false
    }).then(function (s) {
        if (s.value) {
            if (typeof (url) != "undefined" && url !== null) {
                window.location.replace(url);
            } else {
                location.reload();
            }
        }
    });
}

function swalConfirm(
    msg,
    title = 'Are you sure want do this action?',
    confirm_text = 'Yes',
    cancel_text = 'No',
    is_delete = false,
    confirm_width_class = 'w-100',
    cancel_width_class = 'w-100'
) {
    let message = typeof (msg) != "undefined" && msg !== null ? msg : "You won't be able to revert this!";
    let html = `
        <div class="text-center">
        <svg width="80" height="80" viewBox="0 0 140 141" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect opacity="0.11" y="0.00341797" width="140" height="140" rx="70" fill="#EEB221"/>
        <rect opacity="0.21" x="16" y="16" width="108" height="108" rx="54" fill="#EEB221"/>
        <path d="M70 108C49.0381 108 32 90.9619 32 70C32 49.0381 49.0381 32 70 32C90.9619 32 108 49.0381 108 70C108 90.9619 90.9619 108 70 108ZM70 37.3023C51.9721 37.3023 37.3023 51.9721 37.3023 70C37.3023 88.0279 51.9721 102.698 70 102.698C88.0279 102.698 102.698 88.0279 102.698 70C102.698 51.9721 88.0279 37.3023 70 37.3023Z" fill="#EEB221"/>
        <path d="M70 76.186C68.5507 76.186 67.3488 74.9842 67.3488 73.5349V55.8605C67.3488 54.4112 68.5507 53.2093 70 53.2093C71.4493 53.2093 72.6512 54.4112 72.6512 55.8605V73.5349C72.6512 74.9842 71.4493 76.186 70 76.186Z" fill="#EEB221"/>
        <path d="M70 87.674C69.5405 87.674 69.0809 87.568 68.6567 87.3912C68.2326 87.2145 67.8437 86.967 67.4902 86.6489C67.1721 86.2954 66.9247 85.9419 66.7479 85.4824C66.5712 85.0582 66.4651 84.5987 66.4651 84.1391C66.4651 83.6796 66.5712 83.2201 66.7479 82.7959C66.9247 82.3717 67.1721 81.9828 67.4902 81.6294C67.8437 81.3112 68.2326 81.0638 68.6567 80.887C69.5051 80.5335 70.4949 80.5335 71.3433 80.887C71.7674 81.0638 72.1563 81.3112 72.5098 81.6294C72.8279 81.9828 73.0753 82.3717 73.2521 82.7959C73.4288 83.2201 73.5349 83.6796 73.5349 84.1391C73.5349 84.5987 73.4288 85.0582 73.2521 85.4824C73.0753 85.9419 72.8279 86.2954 72.5098 86.6489C72.1563 86.967 71.7674 87.2145 71.3433 87.3912C70.9191 87.568 70.4595 87.674 70 87.674Z" fill="#EEB221"/>
        </svg>
            <div class="pt-4">
                <h6 class="popup-title">${title}</h6>
                <p class="description text-body">${message}</p>
            </div>
        </div>`
    return Swal.fire({
        html: html,
        reverseButtons: true,
        showCancelButton: true,
        buttonsStyling: false,
        customClass: {
            cancelButton: 'btn btn-link text-body btn-popup me-2 ',
            confirmButton: 'btn btn-warning ms-2 btn-popup ',
        },
        confirmButtonText: confirm_text,
        cancelButtonText: cancel_text,
        showCloseButton: true
    });
}

/********************************************************************************************/
/********************************************************************************************/

/*******************************custom validation function***********************************/

/********************************************************************************************/
/**
 *
 * @param value
 * @param $rule
 * @param field
 * @returns {string|*|string|((...values: number[]) => number)|number|string|boolean|Intl.RelativeTimeFormatNumeric}
 *
 * eg. validation(field_value,
 *     ['required|custom msg',
 *     'required',
 *     'min:2|custom msg',
 *     'max:5',
 *     'numeric'],
 *     field name // optional
 *    );
 */
function validation(value, $rule = ['required'], field = 'This field') {
    if (value === undefined) {
        return field + ' is undefined';
    }
    let x = '';
    let min = 1;
    let max = 10;
    let strong = 50;
    let $msg = [];
    for (x in $rule) {
        let $filter = [];
        let msgFilter = $rule[x].split("|");
        if (msgFilter[1] !== undefined) {
            $filter = msgFilter[0].split(":");
            $msg[$filter[0]] = msgFilter[1];
        } else {
            $filter = $rule[x].split(":");
        }
        if ($filter[0] === 'min') {
            min = parseInt($filter[1]);
        }
        if ($filter[0] === 'max') {
            max = parseInt($filter[1]);
        }
        if ($filter[0] === 'strong') {
            strong = parseInt($filter[1]);
        }
        $rule[x] = $filter[0];
    }

    if ($rule.includes('required')) {
        if (value.length === 0) {
            if ($msg.required !== undefined) {
                return $msg.required;
            }
            return field + ' is required';
        }
    }

    if ($rule.includes('min')) {
        if (value.length < min) {
            if ($msg.min !== undefined) {
                return $msg.min;
            }
            return 'At least ' + min + ' character required';
        }
    }

    if ($rule.includes('max')) {
        if (value.length > max) {
            if ($msg.max !== undefined) {
                return $msg.max;
            }
            return 'Maximum ' + max + ' character allowed';
        }
    }

    if ($rule.includes('strong')) {
        if (strong >= scorePassword(value)) {
            if ($msg.strong !== undefined) {
                return $msg.strong;
            }
            return 'At least 1 special character and both uppercase & lowercase are required';
        }
    }

    if ($rule.includes('email')) {
        if (!ValidateEmail(value)) {
            if ($msg.email !== undefined) {
                return $msg.email;
            }
            return 'Valid email address is required';
        }
    }
    if ($rule.includes('numeric')) {
        if (!isNumeric(value)) {
            if ($msg.numeric !== undefined) {
                return $msg.numeric;
            }
            return field + ' is required alpha numeric character';
        }
    }
    if ($rule.includes('domain')) {
        if (!/^[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9]\.[a-zA-Z]{2,}$/.test(value)) {
            return "Please enter a valid domain name";
        }
    }
    if ($rule.includes('phone')) {
        if (!/^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d+)\)?)[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/.test(value)) {
            return "Please enter a valid phone number";
        }
    }
    return '';
}

function isNumeric(i) {
    return "string" == typeof i && !isNaN(i) && !isNaN(parseFloat(i))
}

function scorePassword(r) {
    let t = 0;
    if (!r) return t;
    for (let $ = {}, e = 0; e < r.length; e++) $[r[e]] = ($[r[e]] || 0) + 1, t += 5 / $[r[e]];
    let a = {digits: /\d/.test(r), lower: /[a-z]/.test(r)}, n = 0;
    for (let o in a) n += !0 == a[o] ? 1 : 0;
    return parseInt(t += (n - 1) * 10)
}

function ValidateEmail(t) {
    return !!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,5})+$/.test(t)
}

/********************************************************************************************/

/********************************************************************************************/

function arrayRemove(arr, value) {
    return arr.filter(function (ele) {
        return ele !== value;
    });
}
function arrayRemoveByKey(arr, key) {
    return arr.splice(key, 1);
    // return arr.filter(function (ele) {
    //     return ele !== value;
    // });
}

function slugify(str) {
    //replace all special characters | symbols with a space
    str = str.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ').toLowerCase();
    // trim spaces at start and end of string
    str = str.replace(/^\s+|\s+$/gm, '');
    // replace space with dash/hyphen
    str = str.replace(/\s+/g, '_');
    return str;
    //return str;
}

function randomStr(length) {
    for (var s = ''; s.length < length; s += 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'.charAt(Math.random() * 62 | 0)) ;
    return s;
}

function randomNumber(min, max) { // min and max included
    return Math.floor(Math.random() * (max - min + 1) + min)
}


function shortStr(str, count, insertDots = true) {
    // console.log(str)
    if (str !== undefined) {
        str = `<p>` + str + `</p>`;
        let short_message = $(str).text();
        return short_message.slice(0, count) + (((short_message.length > count) && insertDots) ? "..." : "");
    }
    return 'undefined data';
}

let SUFFIXES = 'KMBTqQsSOND' // or whatever you'd like them to be
function getSuffixedNumber(num) {
    if(num === 0){
        return 0;
    }
    var power = Math.floor(Math.log10(num));
    var index = Math.floor(power / 3);
    num = Math.round(num / Math.pow(10, (index * 3))); // first 3 digits of the number
    return num + (SUFFIXES[index - 1] || ''); // default to no suffix if we get an out of bounds index
}

function copyText(text, cl = 'copy_effect') {
    navigator.clipboard.writeText(text).then(() => {
        cl = $('.' + cl);
        cl.css('transform', 'scale(1.3)');
        cl.css('color', 'green');
        setTimeout(() => {
            cl.css('transform', 'scale(1)');
            cl.css('color', '#707070');
        }, 300)
    });
}

function validDomain(domain) {
    if (/^(?:(?:(?:[a-zA-z\-]+)\:\/{1,3})?(?:[a-zA-Z0-9])(?:[a-zA-Z0-9\-\.]){1,61}(?:\.[a-zA-Z]{2,})+|\[(?:(?:(?:[a-fA-F0-9]){1,4})(?::(?:[a-fA-F0-9]){1,4}){7}|::1|::)\]|(?:(?:[0-9]{1,3})(?:\.[0-9]{1,3}){3}))(?:\:[0-9]{1,5})?$/.test(domain)) {
        return true;
    }
    return false;
}

function ucFirst(str) {
    if (str !== undefined && str !== '') {
        let st = str.replaceAll('_', ' ');
        let s = st.charAt(0).toUpperCase();
        return s + st.slice(1);
    }
    return str;
}

function ucWords(str) {
    if (str !== undefined && str !== '') {
        str = str.replace(/_/g, " ");
        return str.toLowerCase().replace(/\b[a-z]/g, function (letter) {
            return letter.toUpperCase();
        });
    }
    return str;
}

function scrollToDiv(element) {
    $("#" + element).animate({scrollTop: 0}, "fast");
    // window.scroll({
    //     top: element.offsetTop,
    //     left: 0,
    //     behavior: 'smooth'
    // });
}
