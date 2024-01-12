<script setup>
import { RouterLink, RouterView, useRouter } from "vue-router";
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
const showModal = ref(false);
const hideModal = ref(true);
let listProducts = ref([]);

onMounted(async () => {
  getInvoiceData();
  customerData();
  getProducts()
});

const openModal = () => {
  showModal.value = !showModal.value;
};
const closeModal = () => {
  showModal.value = !hideModal.value;
};

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
const getProducts = async () => {
  let response = await axios.get("/api/products");
  // console.log("products", response.data.products);
  listProducts.value = response.data.products;
};
const invoiceItemDelete = (id, i) => {
  form.value.invoiceitem.splice(i, 1);
  if (id != undefined) {
    axios.get(`/api/invoice_item_delete/` + id);
  }
};

const addCart = (item) => {
  const itemCart = {
    product_id: item.id,
    item_code: item.item_code,
    description: item.description,
    unit_price: item.unit_price,
    quantity: item.quantity,
  };
  form.value.invoiceitem.push(itemCart);
  closeModal();
};

const subTotal = () => {
  let total = 0;
  if (form.value.invoiceitem) {
    form.value.invoiceitem.map((item) => {
      total = total + (item.quantity * item.unit_price)
    })
  }
  return total;
}

const total = () =>{
  if(form.value.invoiceitem){
    return subTotal() - form.value.discount
  }
}

const onEditUpdateFunction = (id) =>{
  console.log(JSON.stringify(form.value.invoiceitem))
  if(form.value.invoiceitem.length > 0){
    let subtotal = 0;
     subtotal = subTotal();
     let toTal = 0;
     toTal = total();

    const formData = new FormData();
     formData.append("invoice_item",JSON.stringify(form.value.invoiceitem))
     formData.append("customer_id",form.value.customer_id)
     formData.append("date",form.value.date)
     formData.append("due_date",form.value.due_date)
     formData.append("invoice_number",form.value.invoice_number)
     formData.append("reference",form.value.reference)
     formData.append("discount",form.value.discount)
     formData.append("sub_total",subtotal)
     formData.append("total",toTal)
     formData.append("terms_and_condition",form.value.terms_and_condition)
console.log(1)
    axios.post(`/api/invoice_update/${form.value.id}`,formData)
     form.value.invoiceitem = [];
     router.push('/')
     console.log(2)
  }
}

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
                    <p style="color: red; font-size: 24px;cursor: pointer;"  @click='invoiceItemDelete(itemCart.id,i)'>
                        &times;
                    </p>
                </div>
                <div style="padding: 10px 30px !important;">
                    <button class="btn btn-sm btn__open--modal"  @click="openModal()">Add New Line</button>
                </div>
            </div>

            <div class="table__footer">
                <div class="document-footer" >
                    <p>Terms and Conditions</p>
                    <textarea cols="50" rows="7" class="textarea" v-model="form.terms_and_condition"></textarea>
                </div>
                <div>
                    <div class="table__footer--subtotal">
                        <p>Sub Total</p>
                        <span>$ {{ subTotal() }}</span>
                    </div>
                    <div class="table__footer--discount">
                        <p>Discount</p>
                        <input type="text" class="input" v-model="form.discount">
                    </div>
                    <div class="table__footer--total">
                        <p>Grand Total</p>
                        <span>$ {{ total() }}</span>
                    </div>
                </div>
            </div>

           
        </div>
        <div class="card__header" style="margin-top: 40px;">
            <div>
                
            </div>
            <div>
                <a class="btn btn-secondary" @click="onEditUpdateFunction(form.id)">
                    Update
                </a>
            </div>
        </div>
        
    </div>
     <!--==================== add modal items ====================-->
     <div class="modal main__modal "  :class="{ show: showModal }">
        <div class="modal__content">
            <span class="modal__close btn__close--modal"  @click="closeModal()">×</span>
            <h3 class="modal__title">Add Item</h3>
            <hr><br>
            <div class="modal__items"><ul style="list-style: none">
            <li
              v-for="(item, i) in listProducts"
              :key="item.id"
              style="
                display: grid;
                grid-template-columns: 30px 350px 15px;
                align-items: center;
                padding-bottom: 5px;
              "
            >
              <p>{{ i + 1 }}</p>
              <a href="#" style="text-decoration: underline;color: blue;">{{ item.item_code }} {{ item.description }}</a>
              <button
                @click="addCart(item)"
                style="
                  border: 2px solid #e0e0e0;
                  width: 35px;
                  height: 35px;
                  cursor: pointer;
                "
              >+</button>
            </li>
          </ul>
            </div>
            <br><hr>
            <div class="model__footer">
                <button class="btn btn-light mr-2 btn__close--modal"   @click="closeModal()">
                    Cancel
                </button>
                <button class="btn btn-light btn__close--modal ">Save</button>
            </div>
        </div>
    </div>
      </div>
      
    </div>
    

</template>

<style lang="">
</style>