@extends('layouts.auth-layout')
@section('content')
    <div class="col-md-8 offset-xl-0 offset-md-2" x-data="resetPassword">
        <div class="brand-logo d-block d-xl-none">
            <img src="{{url('auth')}}/images/logo.png" alt="logo" class="img-fluid">
        </div>
        <div class="auth-form-wrap m-auto">
            <div class="auth-form-inner">
                <div class="alert alert-danger alert-dismissible fade d-flex" :class="errorAlert ? 'show' : ''" role="alert">
                    <svg width="24" height="24" viewBox="0 0 140 141" fill="none" xmlns="http://www.w3.org/2000/svg"><rect opacity="0.11" y="0.00341797" width="140" height="140" rx="70" fill="#EA4335"/><rect opacity="0.21" x="16" y="16" width="108" height="108" rx="54" fill="#EA4335"/><path d="M70 108C49.0381 108 32 90.9619 32 70C32 49.0381 49.0381 32 70 32C90.9619 32 108 49.0381 108 70C108 90.9619 90.9619 108 70 108ZM70 37.3023C51.9721 37.3023 37.3023 51.9721 37.3023 70C37.3023 88.0279 51.9721 102.698 70 102.698C88.0279 102.698 102.698 88.0279 102.698 70C102.698 51.9721 88.0279 37.3023 70 37.3023Z" fill="#EA4335"/><path d="M70 76.186C68.5507 76.186 67.3488 74.9842 67.3488 73.5349V55.8605C67.3488 54.4112 68.5507 53.2093 70 53.2093C71.4493 53.2093 72.6512 54.4112 72.6512 55.8605V73.5349C72.6512 74.9842 71.4493 76.186 70 76.186Z" fill="#EA4335"/><path d="M70 87.674C69.5405 87.674 69.0809 87.568 68.6567 87.3912C68.2326 87.2145 67.8437 86.967 67.4902 86.6489C67.1721 86.2954 66.9247 85.9419 66.7479 85.4824C66.5712 85.0582 66.4651 84.5987 66.4651 84.1391C66.4651 83.6796 66.5712 83.2201 66.7479 82.7959C66.9247 82.3717 67.1721 81.9828 67.4902 81.6294C67.8437 81.3112 68.2326 81.0638 68.6567 80.887C69.5051 80.5335 70.4949 80.5335 71.3433 80.887C71.7674 81.0638 72.1563 81.3112 72.5098 81.6294C72.8279 81.9828 73.0753 82.3717 73.2521 82.7959C73.4288 83.2201 73.5349 83.6796 73.5349 84.1391C73.5349 84.5987 73.4288 85.0582 73.2521 85.4824C73.0753 85.9419 72.8279 86.2954 72.5098 86.6489C72.1563 86.967 71.7674 87.2145 71.3433 87.3912C70.9191 87.568 70.4595 87.674 70 87.674Z" fill="#EA4335"/></svg>
                    <p class="description text-danger ms-2" x-html="alertMsg"></p>
                    <button type="button" class="btn-close" @click="errorAlert = false"></button>
                </div>
                <div class="alert alert-success alert-dismissible fade d-flex align-items-center" :class="successAlert ? 'show' : ''"  role="alert">
                    <svg width="24" height="24" viewBox="0 0 140 141" fill="none" xmlns="http://www.w3.org/2000/svg"><rect opacity="0.11" y="0.00341797" width="140" height="140" rx="70" fill="#34A853"/><rect opacity="0.21" x="16" y="16" width="108" height="108" rx="54" fill="#34A853"/><path d="M70 108C49.0381 108 32 90.9619 32 70C32 49.0381 49.0381 32 70 32C90.9619 32 108 49.0381 108 70C108 90.9619 90.9619 108 70 108ZM70 37.3023C51.9721 37.3023 37.3023 51.9721 37.3023 70C37.3023 88.0279 51.9721 102.698 70 102.698C88.0279 102.698 102.698 88.0279 102.698 70C102.698 51.9721 88.0279 37.3023 70 37.3023Z" fill="#34A853"/><path d="M65.0298 82.2581C64.3297 82.2581 63.6647 81.9707 63.1747 81.4679L53.2692 71.304C52.2542 70.2625 52.2542 68.5386 53.2692 67.4971C54.2843 66.4556 55.9643 66.4556 56.9794 67.4971L65.0298 75.7575L83.0206 57.2973C84.0357 56.2557 85.7157 56.2557 86.7308 57.2973C87.7458 58.3388 87.7458 60.0627 86.7308 61.1042L66.8849 81.4679C66.3948 81.9707 65.7298 82.2581 65.0298 82.2581Z" fill="#34A853"/></svg>
                    <p class="description ms-2 text-success" x-html="alertMsg"></p>
                    <button type="button" class="btn-close" @click="successAlert = false"></button>
                </div>

                <div class="reset-password-step" :class="activeStep === 'email' ? 'active-step' : ''">
                    <h3 class="title pb-3">Type your email</h3>
                    <form @submit.prevent="checkEmail()">
                        <div class="mt-3">
                            <label for="email" class="form-label">Email <span>*</span></label>
                            <input type="email" x-model="formData.email" class="form-control" id="email" placeholder="example@gmail.com">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 check-email mt-3">Verify email</button>
                        <p class="mt-2">Already have an account? <a href="{{url('/')}}" class="btn-link ff-body fw-medium"> Log in</a></p>
                    </form>
                </div>

                <div class="reset-password-step" :class="activeStep === 'code' ? 'active-step' : ''">
                    <h3 class="title pb-4">Enter your code</h3>
                    <form @submit.prevent="checkCode()">
                        <div class="d-flex mt-3 align-items-center">
                            <input class="otp form-control border text-center text-uppercase fw-bold p-2 rounded-2" @input="checkVal" x-model="data.one" type="text" @keyup="tabChange(1)" maxlength=1>
                            <input class="otp form-control border text-center text-uppercase fw-bold p-2 rounded-2" @input="checkVal" x-model="data.two" type="text" @keyup="tabChange(2)" maxlength=1>
                            <input class="otp form-control border text-center text-uppercase fw-bold p-2 rounded-2" @input="checkVal" x-model="data.three" type="text" @keyup="tabChange(3)" maxlength=1>
                            <input class="otp form-control border text-center text-uppercase fw-bold p-2 rounded-2" @input="checkVal" x-model="data.four" type="text" @keyup="tabChange(4)" maxlength=1>
                            <input class="otp form-control border text-center text-uppercase fw-bold p-2 rounded-2" @input="checkVal" x-model="data.five" type="text" @keyup="tabChange(5)" maxlength=1>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 btn-loading mt-3 check-code">Continue</button>
                        <p class="mt-2">Already have an account? <a href="{{url('/')}}" class="btn-link ff-body fw-medium"> Log in</a></p>
                        <div class="mt-3 d-flex align-items-center gap-3">
                            <p >Don't get any code : </p>
                            <span :class="timer > 0 ? 'disabled' : ''" class="btn btn-sm btn-primary check-email py-2" @click="checkEmail">Resend <span x-text="timer > 0 ? timer : ''"></span> </span>
                        </div>
                    </form>
                </div>

                <div class="reset-password-step" :class="activeStep === 'password' ? 'active-step' : ''">
                <h3 class="title pb-4">Reset your password</h3>
                <form @submit.prevent="resetPasswordAction()" autocomplete="off">
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password <span>*</span></label>
                        <input type="password" x-model="formData.password" class="form-control" id="newPassword" placeholder="********">
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm Password <span>*</span></label>
                        <input type="password" x-model="formData.password_confirmation" class="form-control" id="confirmPassword" placeholder="********">
                    </div>
                        <button type="submit" class="btn btn-primary w-100 update-password">Continue</button>
                        <p class="mt-3">Already have an account? <a href="{{url('/')}}" class="btn-link ff-body fw-medium"> Log in</a></p>
                </form>
            </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            const resetPassword = {
                errorAlert : false,
                successAlert : false,
                alertMsg : false,
                formData: {
                    email: '',
                    code: '',
                    password: '',
                    password_confirmation: '',
                },
                error: {},
                resendLoading: false,
                timer: 5,
                allFilledUp: false,
                data: {
                    one: '',
                    two: '',
                    three: '',
                    four: '',
                    five: '',
                },
                activeStep: 'email',//code,password

                initOTP() {
                    // this.countdown();
                },
                // closeAlert(){
                //     let self = this;
                //     setTimeout(()=>{
                //         self.successAlert = false;
                //         self.errorAlert = false;
                //     },5000)
                // },
                tabChange(val) {
                    let ele = document.querySelectorAll('.otp');
                    if (ele[val - 1].value !== '') {
                        if (val !== 5) {
                            ele[val].focus()
                            ele[val].select();
                        }
                    } else if (ele[val - 1].value === '') {
                        ele[val - 2].focus()
                        ele[val - 2].select();
                    }
                },

                countdown() {
                    let self = this;
                    setInterval(function () {
                        if (self.timer !== 0) {
                            self.timer = self.timer - 1;
                        }
                    }, 1000);
                },
                checkVal() {
                    this.allFilledUp = this.data.one !== '' && this.data.two !== '' && this.data.three !== '' && this.data.four !== '' && this.data.five !== '';
                },

                checkEmail() {
                    let self = this;
                    let err = false;
                    this.error.email = validation(this.formData.email, ['required', 'email'],'Email');
                    for (let i in this.error){
                        if (this.error[i].length > 0){
                            err = true;
                            self.errorAlert = true;
                            self.successAlert = false;
                            self.alertMsg = this.error[i];
                            break;
                        }
                    }
                    if (!err) {
                        let url = "{{route('checkEmail')}}";
                        makeAjaxPost(this.formData, url,'check-email').done(res => {
                            if (res.success) {
                                self.timer = 10;
                                self.countdown();
                                self.successAlert = true;
                                self.errorAlert = false;
                                self.activeStep = 'code';
                            } else {
                                self.errorAlert = true;
                                self.successAlert = false;
                            }
                            self.alertMsg = res.msg;
                        });
                    }
                },
                checkCode() {
                    let self = this;
                    let err = false;
                    this.formData.code = this.data.one+this.data.two+this.data.three+this.data.four+this.data.five;
                    this.error.email = validation(this.formData.email, ['required', 'email'],'Email');
                    this.error.code = validation(this.formData.code, ['required', 'min:5','max:5'],'Code');
                    for (let i in this.error){
                        if (this.error[i].length > 0){
                            err = true;
                            self.errorAlert = true;
                            self.successAlert = false;
                            self.alertMsg = this.error[i];
                            break;
                        }
                    }
                    if (!err) {
                        let url = "{{route('checkCode')}}";
                        makeAjaxPost(this.formData, url,'check-code').done(res => {
                            if (res.success) {
                                self.successAlert = false;
                                self.errorAlert = false;
                                self.activeStep = 'password';
                            } else {
                                self.errorAlert = true;
                                self.successAlert = false;
                            }
                            self.alertMsg = res.msg;
                        });
                    }
                },
                resetPasswordAction() {
                    let self = this;
                    let err = false;
                    this.error.email = validation(this.formData.email, ['required', 'email'],'Email');
                    this.error.code = validation(this.formData.code, ['required', 'min:5','max:5'],'Code');
                    this.error.password = validation(this.formData.password, ['required', 'min:8'],'Password');
                    this.error.password = validation(this.formData.password_confirmation, ['required', 'min:8'],'Confirm password');
                    for (let i in this.error){
                        if (this.error[i].length > 0){
                            err = true;
                            self.errorAlert = true;
                            self.successAlert = false;
                            self.alertMsg = this.error[i];
                            break;
                        }
                    }
                    if(this.formData.password_confirmation !== this.formData.password){
                        self.errorAlert = true;
                        self.successAlert = false;
                        self.alertMsg = 'Password & confirm password does not match!';
                        return;
                    }
                    if (!err) {
                        let url = "{{route('resetPassword')}}";
                        makeAjaxPost(this.formData, url,'update-password').done(res => {
                            if (res.success) {
                                self.successAlert = true;
                                self.errorAlert = false;
                                setTimeout(()=>{
                                    window.location.href = "{{route('login')}}";
                                },2000)
                            } else {
                                self.errorAlert = true;
                                self.successAlert = false;
                            }
                            self.alertMsg = res.msg;
                        });
                    }
                },
            }
        </script>
    @endpush
@endsection
