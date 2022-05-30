<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Registration Form</div>

                    <div class="card-body" v-if="page === 1">
                      <table>
                          <tr>
                              <td>
                                  First name:
                              </td>
                              <td>
                                  <input name="first_name" @change="debounceSession" class="form-control" v-model="formFields.firstName" type="text"/>
                              </td>
                          </tr>
                          <tr>
                              <td>
                                  Last name:
                              </td>
                              <td>
                                  <input name="last_name" @change="debounceSession" class="form-control" v-model="formFields.lastName" type="text"/>
                              </td>
                          </tr>
                          <tr>
                              <td>
                                  Telephone:
                              </td>
                              <td>
                                  <input name="telephone" @change="debounceSession" type="tel" v-model="formFields.telephone" class="form-control"/>
                              </td>
                          </tr>
                      </table>
                        <button class="btn btn-secondary text-right" @click="navigateForward">Next</button>
                    </div>

                    <!-- Page 2 -->
                    <div class="card-body" v-if="page === 2">
                        <table>
                            <tr>
                                <td>
                                    Street Address:
                                </td>
                                <td>
                                    <input name="street" @change="debounceSession" class="form-control" v-model="formFields.street" type="text"/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    House Number:
                                </td>
                                <td>
                                    <input name="house" @change="debounceSession" class="form-control" v-model="formFields.house" type="text"/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Zip Code:
                                </td>
                                <td>
                                    <input name="zip" @change="debounceSession" type="text" v-model="formFields.zip" class="form-control"/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    City:
                                </td>
                                <td>
                                    <input name="city" @change="debounceSession" type="text" v-model="formFields.city" class="form-control"/>
                                </td>
                            </tr>
                        </table>
                        <button class="btn btn-secondary text-right" @click="navigateBack">Previous</button>
                        <button class="btn btn-secondary text-right" @click="navigateForward">Next</button>
                    </div>

                    <!-- Page 3 -->
                    <div class="card-body" v-if="page === 3">
                        <table>
                            <tr>
                                <td>
                                    Account Owner:
                                </td>
                                <td>
                                    <input name="accOwner" @change="debounceSession" class="form-control" v-model="formFields.accOwner" type="text"/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    IBAN:
                                </td>
                                <td>
                                    <input name="iban" @change="debounceSession" class="form-control" v-model="formFields.iban" type="text"/>
                                </td>
                            </tr>
                        </table>
                        <button  @click="navigateBack" class="btn btn-secondary text-right">Previous</button>
                        <input type="submit" @click="submit" class="btn btn-secondary text-right" value="Submit"><br>
                        <span v-if="error" class="btn-danger"> Please fill all form fields</span>
                    </div>

                    <!-- Page 4 -->
                    <div class="card-body" v-if="page === 4">
                        <table>
                            <tr>
                                <td>
                                    Payment ID:
                                </td>
                                <td>
                                    {{paymentDataId}}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { debounce } from "debounce";
import VueCookies from 'vue-cookies';

    export default {
        data: function(){
            return {
                page: 1,
                formFields: {
                    firstName: '',
                    lastName: '',
                    telephone: '',
                    street: '',
                    house: '',
                    zip: '',
                    city: '',
                    accOwner: '',
                    iban: ''
                },
                paymentDataId: '',
                error: false
            }
        },
        mounted() {
            const cookieData = $cookies.get('_wunder_mobility_task');
            if(cookieData !== null) {
                this.formFields = cookieData.fields;
                this.page = cookieData.page;
            }
        },
        methods: {
            navigateForward: function() {
                this.page++;
            },
            navigateBack: function(){
                this.page--;
            },
            submit: function(){
                const validated = this.validate();
                if(validated) {
                    axios.post('/submit', this.formFields).then(response => {
                        if(response.data.success){
                            this.page++;
                            $cookies.remove('_wunder_mobility_task');
                            this.paymentDataId = response.data.paymentId;
                        }
                    })
                }
            },
            validate: function(){
                for(const i in this.formFields) {
                    if(this.formFields[i] === ''){
                        this.error = true;
                        return false;
                    }
                }
                return true;
            },
            debounceSession: _.debounce(function(e) {
                $cookies.set('_wunder_mobility_task', {fields: this.formFields, page: this.page});
            }, 500)
        }
    }
</script>
