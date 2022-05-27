
import StocksCallback from "../utils/StocksCallback.js"
import { classSelector } from '../utils/Selectors.js'

StocksCallback( data =>{

    //TOTAL STOCKS
    const qty = Object.values(data).map( v => v.prod_qty).filter(Boolean)
    const total_qty = qty.reduce((a,b)=>{
        return Number(a) + Number(b)
    },0)

    //TOTAL SOLD
    const sold = Object.values(data).map( v => v.sold).filter(Boolean)
    const total_sold = sold.reduce((a,b)=>{
        return Number(a) + Number(b)
    },0)

    //TOTAL SOLD
    const remain = Object.values(data).map( v => v.remaining).filter(Boolean)
    const total_remain = remain.reduce((a,b)=>{
            return Number(a) + Number(b)
    },0)

    classSelector('totprod').textContent = total_qty
    classSelector('tsold').textContent = total_sold
    classSelector('tremain').textContent = total_remain

})


const Totalstocks = ()=>{
    return `
    <div class="mini-report totalstocks">
    <div class="mini-report-inner">
                <h1 class="totprod"></h1>
                <h3>Total Stocks</h3>
                <p>
                <span>Sold: <strong class="tsold"></strong></span> <span>Remaining: <strong class="tremain"></strong></span>
                </p>
            </div>
        </div>
    `
}

export default Totalstocks