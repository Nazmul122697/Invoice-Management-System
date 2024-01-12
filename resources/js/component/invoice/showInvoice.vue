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

onMounted(async () => {
  getInvoiceData();
});

const getInvoiceData = async () => {
  const response = await axios.get(`/api/show/invoice/${props.id}`);
  console.log("form", response.data.invoice);
  form.value = response.data.invoice;
};

const print = () =>{

  window.print();
  router.push('/').catch(()=> {

  })
}

const editInvoice = ($id) =>{
  router.push('/edit/invoice/'+$id)
}
</script>

<template>
  <div class="container">
    <!--==================== SHOW INVOICE ====================-->
    <div class="invoices">
      <div class="card__header">
        <div>
          <h2 class="invoice__title">Invoice</h2>
        </div>
        <div></div>
      </div>
      <div>
        <div class="card__header--title">
          <h1 class="mr-2">#{{ form.id }}</h1>
          <p>{{ form.created_at }}</p>
        </div>

        <div>
          <ul class="card__header-list">
            <li>
              <!-- Select Btn Option -->
              <button class="selectBtnFlat" @click="print()">
                <i class="fas fa-print"></i>
                Print
              </button>
              <!-- End Select Btn Option -->
            </li>
            <li>
              <!-- Select Btn Option -->
              <button class="selectBtnFlat" @click="editInvoice(form.id )">
                <i class="fas fa-reply"></i>
                Edit
              </button>
              <!-- End Select Btn Option -->
            </li>
            <li>
              <!-- Select Btn Option -->
              <button class="selectBtnFlat">
                <i class="fas fa-pencil-alt"></i>
                Delete
              </button>
              <!-- End Select Btn Option -->
            </li>
          </ul>
        </div>
      </div>

      <div class="table invoice">
        <div class="logo">
          <!-- <img src="assets/img/logo.png" alt="" style="width: 200px" /> -->
        </div>
        <div class="invoice__header--title">
          <p></p>
          <p class="invoice__header--title-1">Invoice</p>
          <p></p>
        </div>

        <div class="invoice__header--item">
          <div>
            <h2>Invoice To:</h2>
            <p v-if="form.customer">{{ form.customer.first_name }}</p>
          </div>
          <div>
            <div class="invoice__header--item1">
              <p>Invoice#</p>
              <span>#{{ form.invoice_number }}</span>
            </div>
            <div class="invoice__header--item2">
              <p>Date</p>
              <span>{{ form.date }}</span>
            </div>
            <div class="invoice__header--item2">
              <p>Due Date</p>
              <span>{{ form.due_date }}</span>
            </div>
            <div class="invoice__header--item2">
              <p>Reference</p>
              <span>{{ form.reference }}</span>
            </div>
          </div>
        </div>

        <div class="table py1">
          <div class="table--heading3">
            <p>#</p>
            <p>Item Description</p>
            <p>Unit Price</p>
            <p>Qty</p>
            <p>Total</p>
          </div>

          <!-- item 1 -->
          <div
            class="table--items3"
            v-for="(item, i) in form.invoiceitem"
            :key="item.id"
          >
            <p>{{ i + 1 }}</p>
            <p>{{ item.product.item_code }}</p>
            <p>$ {{ item.product.unit_price }}</p>
            <p>{{ item.quantity }}</p>
            <p>$ {{ item.product.unit_price * item.quantity }}</p>
          </div>

          <div class="invoice__total">
            <div>
              <h2>Thank You For Your Busness</h2>
            </div>
            <div>
                <div class="grand__total--items">
                  <span>Sub Total &nbsp; $  {{ form.sub_total }}</span>
                </div>

                <div class="grand__total--items">
                  <span>Discount  &nbsp; $ {{ form.discount }}</span>
              </div>
            </div>
          </div>

          <div class="invoice__total">
            <div>
              <h2>Terms and Conditions</h2>
              <p>
                {{ form.terms_and_condition }}
              </p>
            </div>
            <div>
              <div class="grand__total">
                <div class="grand__total--items">
                  <p>Grand Total&nbsp;$ {{ form.total }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br />

  
</template>