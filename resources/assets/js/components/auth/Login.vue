<template>
    <div class="login row justify-content-center">
        <div class="col-md-4">
            <br>
            <div class="card">
                <div class="card-header">login</div>
                <div class="card-body">
                    <form @submit.prevent="authenticate">
                        <div class="form-group row">
                            <label for="email">Email:</label>
                            <input type="email" v-model="form.email" class="form-control" placeholder="Email Address">
                        </div>
                        <div class="form-group row">
                            <label for="password">Password:</label>
                            <input type="password" v-model="form.password" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group row">
                            <input type="submit" value="Login">
                        </div>
                        <div class="form-group row" v-if="authError">
                            <p class="error">
                                Invalid email or password
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {login} from '../../helpers/auth';

    export default {
        name: "login",
        data() {
            return {
                form: {
                    email: '',
                    password: ''
                },
                error: null,
                authError: false
            };
        },
        methods: {
            authenticate() {

                login(this.$data.form)
                    .then((res) => {
                        this.$store.commit("loginSuccess", res);
                        this.$router.push({path: '/search'});
                    })
                    .catch((error) => {
                        this.authError = true;
                    });
            }
        },
        computed: {
        }
    }
</script>

<style scoped>
.error {
    text-align: center;
    color: red;
}
</style>

