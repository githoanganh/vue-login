<template>
    <div>
        <div class="container-login">
            <div class="header">
                <h5>SIMULOR</h5>
                <p>Enter your email address and password to access panel admin</p>
            </div>
            <form>
                <div class="form-group">
                    <label>Email Address</label>
                    <input
                        type="email"
                        v-model="$v.form.email.$model"
                        class="input-text"
                        placeholder="Enter your email"
                    />
                    <div class="form-feedback" v-if="$v.form.$dirty">
                        <span v-if="!$v.form.email.required">Bạn chưa nhập email</span>
                        <span v-if="!$v.form.email.email">Bạn hãy nhập email</span>
                    </div>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input
                        type="password"
                        v-model="$v.form.password.$model"
                        class="input-text"
                        placeholder="Enter your password"
                    />
                    <div class="form-feedback" v-if="$v.form.$dirty">
                        <span v-if="!$v.form.password.required">Bạn chưa nhập password</span>
                    </div>
                </div>
                <label class="checkbox-label" style="margin-top:16px">
                    Remember me
                    <input type="checkbox" checked="checked" />
                    <span class="checkmark"></span>
                </label>
                <button type="submit" @click.prevent="submit" style="margin-top:16px">Log in</button>
                <div
                    class="form-feedback"
                    style="text-align:center;margin-top:5px;"
                    v-if="error"
                >Sai tài khoản hoặc mật khẩu</div>
            </form>
        </div>
        <div class="link-action">
            <a href>Forgot your password?</a>
            <router-link to="/register">
                Don't have an account?
                <b>Sign Up</b>
            </router-link>
        </div>
    </div>
</template>

<script>
import { validationMixin } from "vuelidate";
import { required, email } from "vuelidate/lib/validators";
export default {
    mixins: [validationMixin],
    data() {
        return {
            form: {
                email: "",
                password: ""
            },
            error: false
        };
    },
    validations: {
        form: {
            email: {
                required,
                email
            },
            password: {
                required
            }
        }
    },
    methods: {
        submit() {
            this.$v.form.$touch();
            if (this.$v.form.$anyError) {
                return;
            }
            this.login();
        },
        async login() {
            try {
                let loginInfo = await axios.post("/auth/login", this.form);
                User.storeAfterLogin(loginInfo);
                this.$router.push("/");
            } catch (error) {
                if (error.response.status === 401) this.error = true;
                else console.log(error);
                this.resetForm();
            }
        },
        resetForm() {
            this.form.email = "";
            this.form.password = "";
            this.$v.form.$reset();
        }
    },

    watch: {
        error: function(value) {
            setTimeout(() => (this.error = false), 2000);
        }
    }
};
</script>





