<script setup>
import { RouterLink, RouterView,useRouter } from "vue-router";
import { ref, onMounted } from "vue";
import axios from "axios";

const form = ref({ id: "" });
const router = useRouter();

const props = defineProps({
  id: {
    type: String,
    default: "",
  },
});


let allCustomer = ref([]);
let customerId = ref([]);

 onMounted(async() =>{
    getInvoiceData();
    customerData();
 })

const getInvoiceData = async () => {
  let response = await axios.get(`/api/get_invoice_data_for_edit/${props.id}`);
  console.log("form", response.data.invoice);
  form.value = response.data.invoice;
};
const customerData = async () => {
  let response = await axios.get("/api/customers");
  // console.log("response", response.data.customers);
  allCustomer.value = response.data.customers;
};
</script>


<template lang="">
    <div>
      <div class="container">
        <div class="invoices">
        
        <div class="card__header">
            <div>
                <h2 class="invoice__title">Edit Invoice</h2>
            </div>
            <div>
                
            </div>
        </div>

        <div class="card__content">
            <div class="card__content--header">
                <div>
                    <p class="my-1">Customer</p>
                    <select class="input" v-model="form.customer_id" >
              <option disabled>Select Customer</option>
              <option
                :value="customer.id"
                v-for="customer in allCustomer"
                :key="customer.id"
              >
                {{ customer.first_name }}
              </option>
            </select>
                </div>
                <div>
                    <p class="my-1">Date</p> 
                    <input id="date" placeholder="dd-mm-yyyy" type="date" class="input" v-model="form.date"> <!---->
                    <p class="my-1">Due Date</p> 
                    <input id="due_date" type="date" class="input" v-model="form.due_date">
                </div>
                <div>
                    <p class="my-1">Numero</p> 
                    <input type="text" class="input" v-model="form.invoice_number"> 
                    <p class="my-1">Reference(Optional)</p> 
                    <input type="text" class="input" v-model="form.reference">
                </div>
            </div>
            <br><br>
            <div class="table">

                <div class="table--heading2">
                    <p>Item Description</p>
                    <p>Unit Price</p>
                    <p>Qty</p>
                    <p>Total</p>
                    <p></p>
                </div>
    
                <!-- item 1 -->
                <div class="table--items2" v-for="(itemCart,i) in form.invoiceitem" :key="itemCart.product_id">
                    <p v-if="itemCart.product">#{{ itemCart.product.item_code }} {{ itemCart.product.description }}</p>
                    <p v-else>#{{ itemCart.item_code }} {{ itemCart.description }}</p>
                    <p>
                        <input type="text" class="input" v-model="itemCart.unit_price">
                    </p>
                    <p>
                        <input type="text" class="input"  v-model="itemCart.quantity">
                    </p>
                    <p>
                        $ {{ itemCart.unit_price * itemCart.quantity }}
                    </p>
                    <p style="color: red; font-size: 24px;cursor: pointer;">
                        &times;
                    </p>
                </div>
                <div style="padding: 10px 30px !important;">
                    <button class="btn btn-sm btn__open--modal">Add New Line</button>
                </div>
            </div>

            <div class="table__footer">
                <div class="document-footer" >
                    <p>Terms and Conditions</p>
                    <textarea cols="50" rows="7" class="textarea" ></textarea>
                </div>
                <div>
                    <div class="table__footer--subtotal">
                        <p>Sub Total</p>
                        <span>$ 1000</span>
                    </div>
                    <div class="table__footer--discount">
                        <p>Discount</p>
                        <input type="text" class="input">
                    </div>
                    <div class="table__footer--total">
                        <p>Grand Total</p>
                        <span>$ 1200</span>
                    </div>
                </div>
            </div>

           
        </div>
        <div class="card__header" style="margin-top: 40px;">
            <div>
                
            </div>
            <div>
                <a class="btn btn-secondary">
                    Save
                </a>
            </div>
        </div>
        
    </div>
      </div>
    </div>
</template>

<style lang="">
</style>