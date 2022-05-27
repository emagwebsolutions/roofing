import getCustomers from '../utils/getCustomers.js'
import { classSelector } from '../utils/Selectors.js'
import number_format from '../utils/format_number.js'

import { salesdate } from './logic/Logic.js'

getCustomers(( data )=>{
    const sales = [...new Map(data.map( v => v.sales)).values()].filter(Boolean)

    const dd = new Date()
    const mm = dd.getMonth()+1
    const yy = dd.getFullYear()

    const rr = Object.values(sales).map( v => {
        const d = new Date(v.date)
        const mnth = d.getMonth() + 1;
        const yr = d.getFullYear()

        if( (mm === mnth) && (yy === yr) ){
            return v.grandtotal
        }
        
    }).filter(Boolean)

   const calc = rr.reduce((a,b)=>{
        return Number(a) + Number(b)
   },0)

   classSelector('tsales').innerHTML = 'GH¢ '+number_format(calc)
})


//formatDate(dateObject)

const Totalsales = ()=>{
    return `
        <div class="mini-report totalsales">
            <div class="mini-report-inner">
                <h1 class="tsales"></h1>
                <h3>Total Sales</h3>
                <p class="salesdate">
                    ${salesdate()}
                </p>
            </div>
        </div>
    `
}

export default Totalsales