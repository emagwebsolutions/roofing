import { getAllProducts, searchProds, searchCategory } from "./Prodfilter.js";
import invoiceTableHeader from "./invoiceTableHeader.js";
import invoiceTableBody from "./invoiceTableBody.js";
import calculateAllAmount from "./calculateAllAmount.js";
import { addTaxes, sumAmountTax } from "./sumAmountTax.js";
import taxesInputFields from "./taxesInputFields.js";
import discountDateInputFields from "./discountDateInputFields.js";
import invoiceTableFooter from "./invoiceTableFooter.js";
import showButton from "./showButton.js";
import { CustomerSearchBox,searchCustomers } from './Customers.js'
import getCustomers from "../utils/getCustomers.js";
import { addCustomer,validateRequiredFields} from './logic/Customerlogic.js'


document.addEventListener("keyup", (e) => {

  validateRequiredFields()

  if(e.target.matches('.cust-search-inpt')){
    searchCustomers(e.target.value)
  }
  if (e.target.matches(".p_qty")) {
    const remaining = Number(e.target.dataset.remaining);
    const qty = Number(e.target.value);

    if (remaining) {
      console.log("Remaining " + remaining);
      console.log("Qty: " + qty);
      if (qty > remaining) {
        alert("You have exceeded remaining Quantity!");
        e.target.value = null;
        return;
      }
    }
  }
  if (e.target.matches(".graTaxes")) {
    addTaxes();
    sumAmountTax();
  }
  if (e.target.matches(".filter-prods")) {
    searchProds(e.target.value);
    document.querySelector(".prod-filter-wrapper").style.display = "block";
  }
  if (e.target.matches(".cat-search")) {
    searchCategory(e.target.value);
    document.querySelector(".cat-list-wrapper").style.display = "block";
  }
  if (e.target.matches(".calc")) {
    //Calculate each row
    let obj = {};
    Array.from(e.target.parentElement.parentElement.children).forEach((v) => {
      return (obj[v.children[0].id] = v.children[0].value
        ? v.children[0].value
        : 0);
    });

    let calc;
    if (obj.qty > 0 && obj.duration > 0) {
      calc = Number(obj.qty) * Number(obj.duration) * Number(obj.selling_price);
    } else if (obj.qty > 0 && obj.duration < 1) {
      calc = Number(obj.qty) * Number(obj.selling_price);
    } else if (obj.qty < 1 && obj.duration < 1) {
      calc = Number(obj.selling_price);
    } else if (obj.qty < 1 && obj.duration > 0) {
      calc = Number(obj.duration) * Number(obj.selling_price);
    }

    e.target.parentElement.parentElement.children[4].children[0].value = calc;

    calculateAllAmount();
    sumAmountTax();
    showButton();
  }
});

document.addEventListener("click", (e) => {

  addCustomer(e)

  if(e.target.matches('.cust-row')){
    const cust_id = e.target.dataset.cust_id
    const customer = e.target.textContent
    document.querySelector('.invto').textContent = customer 
    document.querySelector('.cust_id').value = cust_id
    document.querySelector('.cust-search-res-wrapper').style.display='none'
  }

  if(e.target.matches('.cust-search-close-button')){
    document.querySelector('.cust-search-res-wrapper').style.display='none'
  }


  if(e.target.matches('.cust-search-inpt')){
    document.querySelector('.cust-search-res-wrapper').style.display='block'
  }
  if (e.target.matches(".deleteRow")) {
    const s_id = e.target.dataset.s_id;
    if (s_id) {
    } else {
      e.target.parentElement.parentElement.parentElement.remove();
    }
    calculateAllAmount();
    sumAmountTax();
    showButton();
  }

  if (e.target.matches(".filter-prods")) {
    document.querySelector(".prod-filter-wrapper").style.display = "block";
  }

  if (e.target.matches(".cat-search")) {
    document.querySelector(".cat-list-wrapper").style.display = "block";
  }

  if (e.target.matches(".cat-link")) {
    searchProds(e.target.textContent.trim());
  }
  if (e.target.matches(".prodfilter-link")) {
    const { prod_name, unit_price, prod_qty } = e.target.dataset;

    //PREVENT DUPLICATE VALUES
    const pname = Array.from(document.querySelectorAll(".prod_name")).find(
      (v) => v.value == prod_name
    );
    if (pname) {
      alert("Avoid duplicate names!");
      return;
    }

    const row = document.createElement("div");
    row.className = "row prodInvoice";
    row.innerHTML = invoiceTableBody({
      prod_name,
      selling_price: unit_price,
      remaining: prod_qty,
    });
    document.querySelector(".tBody").appendChild(row);

    calculateAllAmount();
    sumAmountTax();
    showButton();

    if (document.querySelector(".cat-list-wrapper")) {
      document.querySelector(".cat-list-wrapper").style.display = "none";
      document.querySelector(".cat-search").value = null;
    }
  }
  if (e.target.matches(".prod-filter-top-btn")) {
    const row = document.createElement("div");
    row.className = "row prodInvoice";
    row.innerHTML = invoiceTableBody();
    document.querySelector(".tBody").appendChild(row);
    document.querySelector(".prod-filter-wrapper").style.display = "none";
  }
  if (e.target.matches(".close-cat-box")) {
    document.querySelector(".cat-list-wrapper").style.display = "none";
  }
  if (e.target.matches(".close-prod-box")) {
    document.querySelector(".prod-filter-wrapper").style.display = "none";
  }
});

window.addEventListener("load", (e) => {
  getAllProducts();
  invoiceTableHeader();
  taxesInputFields();
  discountDateInputFields();
  invoiceTableFooter();
  getCustomers((data)=>{
    CustomerSearchBox(data)
  })
  document.querySelector(".pro_date").valueAsDate = new Date();
  document.querySelector(".exp_date").valueAsDate = new Date();
});
