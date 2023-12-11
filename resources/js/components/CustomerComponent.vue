<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Customers</div>

                    <VueFinalModal
                        class="flex justify-center items-center"
                        content-class="flex flex-col p-4 bg-white dark:bg-black rounded border border-gray-100 dark:border-gray-800"
                        v-model="showAddCustomerModal"
                        >
                        <div style="width: min-content; margin: auto;">
                            <p><label>Name: </label><input v-model="full_name" /></p>
                            <p><label>Email: </label><input v-model="email_address" /></p>
                            <p><label>Phone Number: </label><input v-model="phone_number" /></p>
                            <p><label>Home Address: </label><input v-model="home_address" /></p>
                            <button class="btn btn-primary" @click="addCustomer()">Add Customer</button>
                            <div v-for="message in error_message">
                                <p>{{ message[0] }}</p>
                            </div>
                        </div>
                    </VueFinalModal>

                    <VueFinalModal
                        class="flex justify-center items-center"
                        content-class="flex flex-col p-4 bg-white dark:bg-black rounded border border-gray-100 dark:border-gray-800"
                        v-model="showEditCustomerModal"
                        >
                        <div style="width: min-content; margin: auto;">
                            <p><label>Name: </label><input v-model="edited_customer.full_name" /></p>
                            <p><label>Email: </label><input v-model="edited_customer.email_address" /></p>
                            <p><label>Phone Number: </label><input v-model="edited_customer.phone_number" /></p>
                            <p><label>Home Address: </label><input v-model="edited_customer.home_address" /></p>
                            <button class="btn btn-primary" @click="editCustomer()">Edit Customer</button>
                            <div v-for="message in error_message">
                                <p>{{ message[0] }}</p>
                            </div>
                        </div>
                    </VueFinalModal>

                    <div class="card-body">
                        <button class="btn btn-primary" @click="getCustomers">Load Customers</button>
                        <br />
                        <br />
                        <button class="btn btn-primary" @click="showAddCustomerModal = true; this.error_message = {};">Add Customer</button>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Full Name</td>
                                    <td>Email</td>
                                    <td>Phone Number</td>
                                    <td>Home Address</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="customer in customers">
                                    <td>{{ customer.full_name }}</td>
                                    <td>{{ customer.email_address }}</td>
                                    <td>{{ customer.phone_number }}</td>
                                    <td>{{ customer.home_address }}</td>
                                    <td>
                                        <button href="" class="btn btn-outline-secondary" 
                                            @click="editModalCustomer(customer.id)">
                                            Edit
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-secondary" type="submit"
                                            @click="deleteCustomer(customer.id)">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { VueFinalModal } from 'vue-final-modal';

    export default {
        name: 'Customer',
        data() {
            return {
                customers: [],
                added_customer: {},
                edited_customer: {},
                showAddCustomerModal: false,
                showEditCustomerModal: false,
                full_name: "",
                email_address: "",
                phone_number: "",
                home_address: "",
                id: "",
                error_message: {},
            }
        },
        methods: {
            getCustomers() {
                axios.get(`api/customer`).then(response => {
                    if (response.status === 200) {
                        this.customers = response.data;
                    }
                });
            },
            addCustomer() {
                this.added_customer = {
                    full_name: this.full_name,
                    email_address: this.email_address,
                    phone_number: this.phone_number,
                    home_address: this.home_address,
                };

                axios.post(`api/customer`, this.added_customer).then(response => {
                    if (response.status === 201) {
                        this.showAddCustomerModal = false;
                        alert("Successfully Submitted And Processed");
                        this.getCustomers();
                        this.added_customer = {};
                        this.full_name = "";
                        this.email_address = "";
                        this.phone_number = "";
                        this.home_address = "";
                        this.error_message = {};
                    }
                }).catch((error) => { // error is handled in catch block
                    if (error.response) { 
                        this.error_message = error.response.data.errors;
                        console.log("Status :" + error.response.status);
                    } else if (error.request) { // The request was made but no response was received
                        console.log(error.request);
                    } else {// Error on setting up the request
                        console.log('Error', error.message);
                    }
                });
            },
            editCustomer() {
                this.error_message = {};
                axios.put(`api/customer/${this.edited_customer.id}`, this.edited_customer).then(response => {
                    if (response.status === 201) {
                        this.showEditCustomerModal = false;
                        alert("Successfully Submitted And Processed");
                        this.getCustomers();
                        this.edited_customer = {};
                        this.error_message = {};
                    }

                    this.error_message = response.data.errors;
                }).catch((error) => { // error is handled in catch block
                    if (error.response) {
                        this.error_message = error.response.data.errors;
                        console.log("Status :" + error.response.status);
                    } else if (error.request) { // The request was made but no response was received
                        console.log(error.request);
                    } else {// Error on setting up the request
                        console.log('Error', error.message);
                    }
                });
            },
            deleteCustomer(customer_id) {
                axios.delete(`api/customer/${customer_id}`).then(response => {
                    if (response.status === 200) {
                        this.getCustomers();
                    }
                });
            },
            editModalCustomer(customer_id) {
                this.edited_customer = {
                    full_name: this.customers[customer_id].full_name,
                    email_address: this.customers[customer_id].email_address,
                    phone_number: this.customers[customer_id].phone_number,
                    home_address: this.customers[customer_id].home_address,
                    id: customer_id,
                };

                this.showEditCustomerModal = true;
            },
        },
        components: {
            VueFinalModal,
        },
    }
</script>
