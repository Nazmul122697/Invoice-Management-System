import { createWebHistory, createRouter } from "vue-router";

// imported files list
import InvoiceIndex from "../component/invoice/index.vue";
import Notfound from "../component/Notfound.vue";
import CreateInvoice from "../component/invoice/CreateInvoice.vue";
import ShowInvoice from "../component/invoice/ShowInvoice.vue";
import EditInvoice from "../component/invoice/EditInvoice.vue";

// routes list
const routes = [
    {
        path: "/",
        name: "Home",
        component: InvoiceIndex,
    },
    {
        path: "/create-invoice",
        name: "CreateInvoice",
        component: CreateInvoice,
    },
    {
        path:'/show/invoice/:id',
        name:'ShowInvoice',
        component:ShowInvoice,
        props:true
    },
    {
        path:'/edit/invoice/:id',
        name:'EditInvoice',
        component:EditInvoice,
        props:true
    },
    {
        path: "/:pathMatch(.*)*",
        name: "Notfound",
        component: Notfound,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});
export default router;
