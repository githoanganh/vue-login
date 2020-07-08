<template>
    <div class="container-register">
        <div class="header">MicroOffice</div>
        <form action>
            <h5>Registration form</h5>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <i class="fa fa-user form-icon" aria-hidden="true"></i>
                        <input
                            type="text"
                            class="input-text"
                            placeholder="First name..."
                            v-model="$v.form.first_name.$model"
                        />
                        <div class="form-feedback" v-if="$v.form.$dirty">
                            <span v-if="!$v.form.first_name.required">Bạn chưa nhập first name</span>
                        </div>
                    </div>
                    <div class="col">
                        <i class="fa fa-user form-icon" aria-hidden="true"></i>
                        <input
                            type="text"
                            class="input-text"
                            placeholder="Last name..."
                            v-model="$v.form.last_name.$model"
                        />
                        <div class="form-feedback" v-if="$v.form.$dirty">
                            <span v-if="!$v.form.last_name.required">Bạn chưa nhập last name</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <i class="fa fa-envelope form-icon" aria-hidden="true"></i>
                <input
                    type="email"
                    class="input-text"
                    v-model="$v.form.email.$model"
                    placeholder="Email address"
                />
                <div class="form-feedback" v-if="$v.form.$dirty">
                    <span v-if="!$v.form.email.required">Bạn chưa nhập email</span>
                    <span v-if="!$v.form.email.email">Địa chỉ email không đúng</span>
                </div>
            </div>
            <div class="form-group">
                <i class="fa fa-user form-icon" aria-hidden="true"></i>
                <input
                    type="text"
                    class="input-text"
                    placeholder="Nickname"
                    v-model="$v.form.nickname.$model"
                />
                <div class="form-feedback" v-if="$v.form.$dirty">
                    <span v-if="!$v.form.nickname.required">Bạn chưa nhập nickname</span>
                </div>
            </div>
            <div class="form-group">
                <i class="fa fa-lock form-icon" aria-hidden="true"></i>
                <input
                    type="password"
                    class="input-text"
                    placeholder="Create a password"
                    v-model="$v.form.password.$model"
                />
                <div class="form-feedback" v-if="$v.form.$dirty">
                    <span v-if="!$v.form.password.required">Bạn chưa nhập password</span>
                </div>
            </div>
            <div class="form-group">
                <i class="fa fa-unlock-alt form-icon" aria-hidden="true"></i>
                <input
                    type="password"
                    class="input-text"
                    placeholder="Retype your password"
                    v-model="$v.form.password_confirmation.$model"
                />
                <div class="form-feedback" v-if="$v.form.$dirty">
                    <span v-if="!$v.form.password_confirmation.required">Bạn chưa nhập lại password</span>
                    <span
                        v-if="!$v.form.password_confirmation.sameAsPassword"
                    >Password không trùng khớp</span>
                </div>
            </div>
            <div class="form-group" style="margin-top:20px">
                <div class="row">
                    <div class="col">
                        <label class="checkbox-label">
                            I agree to the
                            <a href>terms of use.</a>
                            <input type="checkbox" v-model="$v.form.agreement.$model" />
                            <span class="checkmark"></span>
                        </label>
                    </div>

                    <div class="col">
                        <button @click.prevent="submit">I ACCEPT-CREATE ACCOUNT</button>
                    </div>
                </div>
                <div class="form-feedback" v-if="$v.form.$dirty">
                    <span v-if="!$v.form.agreement.sameAs">Bạn chưa đồng ý</span>
                </div>
            </div>
            <div class="form-feedback" style="text-align:center;margin-top:10px;">
                <span v-if="errorEmail">Địa chỉ email đã có người sử dụng</span>
                <br />
                <span v-if="errorNickname">Nickname đã có người sử dụng</span>
            </div>
        </form>
    </div>
</template>

<script>
import { validationMixin } from "vuelidate";
import { required, email, sameAs } from "vuelidate/lib/validators";
import { setTimeout } from "timers";
export default {
    mixins: [validationMixin],
    data() {
        return {
            form: {
                first_name: "",
                last_name: "",
                email: "",
                nickname: "",
                password: "",
                password_confirmation: "",
                agreement: ""
            },
            errorNickname: false,
            errorEmail: false
        };
    },
    validations: {
        form: {
            first_name: {
                required
            },
            last_name: {
                required
            },

            email: {
                required,
                email
            },
            nickname: {
                required
            },
            password: {
                required
            },

            password_confirmation: {
                required,
                sameAsPassword: sameAs("password")
            },
            agreement: {
                sameAs: sameAs(() => true)
            }
        }
    },
    methods: {
        submit() {
            this.$v.form.$touch();
            if (this.$v.form.$anyError) {
                return;
            }
            console.log(this.form);
            this.register();
        },
        async register() {
            try {
                let registerInfo = await axios
                    .post("/auth/register", this.form)
                    .then();
                this.$router.push("/login");
            } catch (error) {
                if (error.response.status === 422) {
                    if (error.response.data.errors.email) {
                        this.errorEmail = true;
                    }
                    if (error.response.data.errors.nickname) {
                        this.errorNickname = true;
                    }
                } else console.log(error);
                this.resetForm();
            }
        },
        resetForm() {
            this.form.password = "";
            this.form.password_confirmation = "";
        }
    },
    watch: {
        errorEmail: function(value) {
            setTimeout(() => (this.errorEmail = false), 2000);
        },
        errorNickname: function(value) {
            setTimeout(() => (this.errorNickname = false), 2000);
        }
    }
};
</script>

<style>
</style>
