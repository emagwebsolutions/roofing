import getCustomers from "../utils/getCustomers.js"
import { classSelector } from '../utils/Selectors.js'

getCustomers( data => {

    //GET TOTAL CUSTOMERS
    const cust = Object.values(data).map(v => v).length
    classSelector('tcust').innerHTML = cust

    //GET TOTAL PERMANENT CUSTOMERS
    const permanent = Object.values(data).map(v => {
            return Object.values(v.sales).map(vv => {
                if( (vv.cust_id === v.cust_id) && (vv.trans_type === 'invoice')){
                    return v.fullname
                }
            }).filter(Boolean)
    })
    const res = permanent.flat(Infinity)
    const comb = [...new Set(res)].length
    classSelector('perm-cust').textContent = comb


    //GET TOTAL PROSPECTIVE CUSTOMERS 
    const prosp = Number(cust) - Number(comb)
    classSelector('prosp').textContent = prosp



})

const Totalcustomers = ()=>{
    return `
    <div class="mini-report totalcustomers">
    <div class="mini-report-inner">
                <h1 class="tcust"></h1>
                <h3>Total Customers</h3>
                <p>
                <span>Permanent: <strong class="perm-cust"></strong></span> <span>Prospective: <strong class="prosp"></strong></span>
                </p>
            </div>
        </div>
    `
}

export default Totalcustomers


