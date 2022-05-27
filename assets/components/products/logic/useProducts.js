import {getIDvalue,response,loading} from '../../Modules.js';
import Stocks from '../../Stocks.js';
import {formatDate,ymdslash} from '../../utils/DateFormats.js'
import format_number from '../../utils/format_number.js'
import Select from '../../utils/Select.js'
import StocksCallback from '../../utils/StocksCallback.js'
import getCategories from '../../utils/getCategories.js';

const prodOutput = data => Object.values(data).map( (v,i) => {
    i++
    const date = v.updated_on === undefined ? v.date : v.updated_on;
    return ` 
    <div class="text-dark  row">
        <div class="col-sm-12 col-md-1">	
            <div class="custom-control custom-checkbox" style="margin-top: -14px;">
                <input type="checkbox" class="custom-control-input prods"  id="${v.prodid}${i}" 
                data-prod_name = "${v.prod_name}"
                data-prod_qty = "${v.prod_qty}"
                data-selling_price = "${v.selling_price}"
                data-sold = "${v.sold}"
                data-remaining = "${v.remaining}"
                data-date = "${date}"
                >
                <label class="custom-control-label badge badge-success" for="${v.prodid}${i}">
                ${i}
                </label>
                </div>
                </div>

                <div class="col-sm-12 col-md-3 searchp_word" data-prod_qty = "${v.prod_qty}">
                ${v.prod_name}
                </div>

                <div class="col-sm-12 col-md-1">${format_number(v.selling_price)}</div>
                <div class="col-sm-12 col-md-1">${v.prod_qty}</div>
                <div class="col-sm-12 col-md-1">${v.sold}</div>
                <div class="col-sm-12 col-md-1">${v.remaining}</div>
                <div class="col-sm-12 col-md-2">${formatDate(date)}</div>

                <div class="col-sm-12 col-md-1">
                <div class="row p-0">
                <div class="col-sm-12 col-md-6 p-0 ">
                <a href="javascript:void(0);" class="editproduct" data-prod_id = "${v.prod_id}">
                <i class="fa fa-edit editprod" data-prod_id="${v.prod_id}" data-toggle="modal" data-target="#editproduct"  style="font-size: 11px;"></i>
                </a>
                </div>

                <div class="col-sm-12 col-md-6  p-0 text-right">
                <a href="javascript:void(0);">
                <i class="deleteproduct fa fa-trash" data-prod_id = "${v.prod_id}" style="font-size: 11px;"></i>
                </a>
                </div>

            </div>
        </div>
    </div>
    ` }
).join('')


const editProductMod = async (e) => { 
    const prod_id = e.target.dataset.prod_id; 
    const cresp = await fetch('router.php?controller=products&task=categories');
    const cdata = await cresp.json();
    const cararr = Object.values(cdata).map(v => { return {[v.cat_id] : v.cat_name}})
    //return data;
    StocksCallback(( data )=>{
    const v = Object.values(data).find( v => v.prod_id == prod_id);
    document.getElementById('uprod_name').value = v.prod_name;
    document.getElementById('uselling_price').value = v.selling_price;
    document.getElementById('prod_id').value = v.prod_id;
    Select([...cararr],{id: v.cat_id, text: v.cat_name},'ucat_id');   
    document.getElementById('upackage').value = v.packages
    //document.getElementById('uprod_qty').value = v.remaining;
    const ud = new Date();
    document.getElementById('udate').value = ymdslash(ud);
    })

}

const getProducts = () => {
    StocksCallback(( data )=>{
        let i = 1
        document.getElementById('products').innerHTML = prodOutput(data,i);
    })
}

const addProducts = async () => {
    const fd = new FormData();
    fd.append('prod_name', getIDvalue('prod_name'));
    fd.append('selling_price', getIDvalue('selling_price'));
    fd.append('cat_id', getIDvalue('cat_id'));
    fd.append('package', getIDvalue('package'));
    fd.append('prod_qty', getIDvalue('prod_qty'));
    fd.append('date', getIDvalue('datex'));
    fd.append('controller', 'products');
    fd.append('task', 'add_product');
    loading();

    const xhr = new XMLHttpRequest();
    xhr.open('POST','router.php', true);
    xhr.onload = function(){
        if(this.status == 200){
            response('presult', this.responseText);
            const arr = ['prod_name','selling_price', 'cat_id', 'package', 'prod_qty', 'datex', 'products']
            arr.forEach(v => document.getElementById(`${v}`).value = null)
            getProducts();

        }  
    }
    xhr.send(fd);
}

const editProducts = async (e) => {
    const fd = new FormData();
    fd.append('prod_name', getIDvalue('uprod_name'));
    fd.append('selling_price', getIDvalue('uselling_price'));
    fd.append('prod_id', getIDvalue('prod_id'));
    fd.append('cat_id', getIDvalue('ucat_id'));
    fd.append('package', getIDvalue('upackage'));
    fd.append('prod_qty', getIDvalue('uprod_qty'));
    fd.append('date', getIDvalue('udate'));
    fd.append('controller', 'products');
    fd.append('task', 'update_product');
    loading();

    const xhr = new XMLHttpRequest();
    xhr.open('POST','router.php', true);
    xhr.onload = function(){
        if(this.status == 200){
            response('upresult', this.responseText);
            getProducts();
        }    
        console.log(this.responseText)
    }
    xhr.send(fd);
}

const deleteProducts = async (e) => {
    const prod_id = e.target.dataset.prod_id;
    fetch(`router.php?controller=products&task=delete_product&prod_id=${prod_id}`);
    getProducts();
}

const get_category = () => {
   getCategories((data)=>{
       document.querySelector('.categoryx').innerHTML = '<option value="" hidden>Category</option>'+data;
   })
}

const products_search = async (e) => { 
    const {value} = e.target;
    StocksCallback(( data )=>{
        const obj = Object.values(data).filter( v => {
            return Object.values(v).join('').toLowerCase().includes(value.toLowerCase());
        } );
        let i = 1
        document.getElementById('products').innerHTML = prodOutput(obj,i);  
    })
}

const products_cat_filter = async (e) => { 
    const cat_id = e.target.dataset.cat_id;
    StocksCallback(( data )=>{
        const obj = Object.values(data).filter( v => {
            return v.cat_id == cat_id;
        } );

        let i = 1
        document.getElementById('products').innerHTML = prodOutput(obj,i); 
    })
}

export { getProducts,addProducts,editProducts,deleteProducts,products_search,get_category,editProductMod,products_cat_filter };