<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div>
                    <br>
                    <div class="card card-default">
                        <div class="card-header">Favourite</div>
                        <div class="card-body row">
                            <div class="col-md-6">
                                <div v-for="company in companies" :key="company.id">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" v-bind:value="company.id" v-bind:id="company.name" v-model="checkedIds.company_ids">
                                      <label class="form-check-label" v-bind:for="company.name">
                                        {{ company.name }}
                                      </label>
                                    </div>
                                </div>
                                <div class="">
                                    <button class="btn btn-primary" v-on:click="updateFavourite">Update Favourite</button> &nbsp; &nbsp;
                                    <span class="success" v-if="successMsg">
                                        Updated successfully
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-offset-6 col-md-6">
                                <b>Favourite List</b>
                                <ul id="example-1">
                                    <li v-for="company in favouriteCompanies" :key="company.id">
                                        {{ company.name }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="card card-default">
                        <div class="card-header">Search Companies</div>
                        <div class="card-body">
                            <form @submit.prevent="search">
                                <div class="row">
                                    <div class="col-md-10">
                                    <input class="form-control full" v-model="company_name.name" placeholder="Company Name" name="search2">
                                    </div>
                                    
                                    <div class="col-md-offset-10 col-md-2">
                                        <input class="btn btn-primary" type="submit" value="Search">
                                    </div>
                                </div>
                            </form>

                            <table class="table" v-if="searchBox">
                                <thead>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                </thead>
                                <tbody>
                                    <template v-if="!searchedCompanies.length">
                                        <tr>
                                            <td colspan="4" class="text-center">No Companies Available</td>
                                        </tr>
                                    </template>
                                    <template v-else>
                                        <tr v-for="company in searchedCompanies" :key="company.id">
                                            <td>{{ company.name }}</td>
                                            <td>{{ company.phone }}</td>
                                            <td>{{ company.address }}</td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'list',
        data() {
            return {
                companies: [],
                favouriteCompanies: [],
                searchedCompanies: [],
                checkedIds: {
                    company_ids: []
                },
                successMsg: false,
                searchBox: false,
                company_name:  {
                    name: ''
                }
            };
        },
        mounted() {
            let userId = this.$store.getters.currentUser.id;
            
            axios.get('/api/company')
            .then((response) => {
                this.companies = response.data.data;
            })

            axios.get('/api/user/'+userId+'/favourite')
            .then((response) => {
                this.favouriteCompanies = response.data.data;
                this.favouriteCompanies.forEach((element) => {
                  this.checkedIds.company_ids.push(element.id);
                })
            })
        },
        computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            }
        },
        methods: {
            updateFavourite: function (event) {
                let userId = this.$store.getters.currentUser.id;
                let checkedIds = this.checkedIds;

                axios.post('/api/user/'+userId+'/update-favourite', checkedIds)
                .then((response) => {
                    this.successMsg = true;
                    this.favouriteCompanies = response.data.data;
                })
                .catch((err) =>{
                })                
            },
            search: function (event) {
                let company_name = this.company_name;

                axios.post('/api/company/search', company_name)
                .then((response) => {
                    this.searchBox = true;
                    this.searchedCompanies = response.data.data;
                })
                .catch((err) =>{
                })              
            }
        }
    }
</script>

<style scoped>
.btn-wrapper {
    text-align: right;
    margin-bottom: 20px;
}
.success {
    text-align: center;
    color: green;
}
.full {
    width: 100%;
}
</style>
