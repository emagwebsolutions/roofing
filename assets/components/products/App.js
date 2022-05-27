
"use strict"

import Products from './Products.js'
import { addCats,editCats,deleteCats,catOutput } from '../utils/logic/useCategories.js'
import { getProducts,addProducts,editProducts,deleteProducts,products_search,editProductMod,get_category,products_cat_filter } from './logic/useProducts.js';


const App = ()=>{

    document.addEventListener("click", e => {

        if(e.target.matches('.prods')){
            if(e.target.checked){
                document.querySelector('.prodpdf').style.display = 'block'
            }
            else{
                const arrs= Array.from(document.querySelectorAll('.prods')).some( v => v.checked)
                if(arrs)  document.querySelector('.prodpdf').style.display = 'block'
                else document.querySelector('.prodpdf').style.display = 'none'
            }
        }
    
        if(e.target.matches('.checkall')){
            const arrs= Array.from(document.querySelectorAll('.prods'))
            if(e.target.checked){
                arrs.forEach( v => v.checked = true)
                document.querySelector('.prodpdf').style.display = 'block'
            }
            else{
                arrs.forEach( v => v.checked = false)
                document.querySelector('.prodpdf').style.display = 'none'
            }
        
        }

        if(e.target.matches('.prodpdf')){

            document.getElementById('genresult').innerHTML = 'Processing wait....'
            
            let arrp = [];
            Array.from(document.querySelectorAll('.prods')).forEach( v => {
                if(v.checked){
                    const {prod_name,prod_qty,selling_price,sold,remaining,date} = v.dataset
                    arrp.push({
                        prod_name,
                        prod_qty,
                        selling_price,
                        sold,
                        remaining,
                        date
                    })
                }
            })

            const fd = new FormData()
            fd.append('data', JSON.stringify(arrp))
            fetch('router.php?controller=products&task=create_prod_file',{
                method: 'Post',
                body: new URLSearchParams(fd)
            })
            .then( resp => resp.text())
            .then( data => window.location = `assets/pdf/products.php`)
        } 


        if(e.target.matches('.AddCategory')){
            addCats()
        }
        if(e.target.matches('.UpdateCategory')){
            editCats();
        }
        if(e.target.matches('.vcategory')){
            const cat_id = e.target.dataset.cat_id;
            const data = JSON.parse(localStorage.getItem('catData'));
            const obj = Object.values(data).find( v => v.cat_id == cat_id);
            document.getElementById('editcateg').value = obj.cat_name;
            document.getElementById('ctid').value = obj.cat_id
        }
        if(e.target.matches('.deletecategory')){
            const cat_id = e.target.dataset.cat_id;
            if(confirm('Are you sure you want to delete this category!')){
                deleteCats(cat_id);
            }
        }
        if(e.target.matches('.AddProduct')){
            addProducts();
        }
        if(e.target.matches('.editprod')){
            editProductMod(e);
        }
        if(e.target.matches('.EditProduct')){
            editProducts(e);
        }
        if(e.target.matches('.deleteproduct')){
            if(confirm("Are you sure you want to delete!")) {
                deleteProducts(e);
            }
        }
        if(e.target.matches('.pCats')){
            products_cat_filter(e);
        }
    });

    document.addEventListener('keyup', e => {
        if(e.target.matches('.searchcat')){
            const {value} = e.target;
            const data = JSON.parse(localStorage.getItem('catData'));
            const obj = Object.values(data).filter( v => {
                return Object.values(v).join('').toLowerCase().includes(value.toLowerCase());
            } );
            const output = catOutput(obj);
            document.getElementById('category').innerHTML = output;
        }
        if(e.target.matches('.searchprod')){
            products_search(e);
        }
    });

    window.addEventListener('load', e => {
        getProducts();
        get_category();
    })

    return `
    ${Products()}
    `
}

export default App
