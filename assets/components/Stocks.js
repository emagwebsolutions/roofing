
//PRODUCTS
// const resp = await fetch('router.php?controller=products&task=all_products');
// const data = await resp.json();
// const products = Array.from(data);

// //SALES
// const sales = await fetch('router.php?controller=products&task=get_sales');
// const sdata = await sales.json();
// const sale = sdata;
// const stk = Stocks(products,sale);
  
// const v = stk.find( v => v.prod_id == prod_id);
  
const Stocks = (products,sale) => {
    return  products.map( (v,i) => {

        const prod_id = v.prod_id;
        const cat_id = v.cat_id;
        const cat_name = v.cat_name;
        const prod_name = v.prod_name;
        const prod_qty = v.prod_qty;
        const selling_price = v.selling_price;
        const packages = v.package;
        const date = v.date;
        const updated_on = v.updated_on;
 
        const sales = Object.values(sale).filter(val => (val.prod_id === v.prod_id) && (val.date >= v.date) );
 
        const sold = Array.from(sales).map(vv => vv).map(vs => vs.qty).reduce((a,b)=>{
            return Number(a) + Number(b) 
        },[]);

        const expiries = Array.from(sales).map(vss => {
            const curdate = new Date().getTime();
            const exp_date = new Date(vss.exp_date).getTime();
            const sub = exp_date - curdate;
            const day = Math.floor(sub / (1000*60*60*24));
            if( (day > 0) && (day < 7) ){
                return {
                    invoice_no : vss.invoice_no,
                    fullname: vss.fullname,
                    phone: vss.phone,
                    email: vss.email,
                    days: day,
                    expdate: vss.exp_date,
                    project: vss.project
                }
            }

        }).filter(Boolean)
        const remaining = prod_qty - sold;
        const prodid = `ps${prod_id}${cat_id}`;
        return {prod_id,cat_id,cat_name,prod_name,prod_qty,selling_price,date,sold,remaining,prodid,expiries,packages} 
    });

}

export default Stocks;
