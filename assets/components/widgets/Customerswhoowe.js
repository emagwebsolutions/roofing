
import getCustomers from "../utils/getCustomers.js"
import { classSelector } from "../utils/Selectors.js"
import format_number from '../utils/format_number.js'

getCustomers( data => {

        const res = data.map( v => {

            const sales = [...new Map(v.sales.map(v => {
                if(v.trans_type === 'invoice'){
                    return  [v.invoice_no, v.grandtotal]  
                }
            }).filter(Boolean) ).values()].reduce((a,b)=> Number(a) + Number(b),0)

            const receipts = v.receipts.map(v => v.amount).reduce((a,b)=> Number(a) + Number(b),0)
            const calc = Number(sales) - Number(receipts)

            const invoices = [...new Map(v.sales.map(v => [v.invoice_no, v.grandtotal]) )].map(vl=>{
                return {
                    invoice_no: vl[0],
                    owing: vl[1],
                    paid: v.receipts.map( vv => {
                        if(vv.invoice_no === vl[0]){
                            return vv.amount
                        }
                    }).filter(Boolean).reduce((a,b)=> Number(a)+Number(b),0),
                    balance: function(){
                        return Number(this.owing) - Number(this.paid)
                    }
                }
            })

            if(calc > 0){
                return {
                    fullname: v.fullname,
                    phone: v.phone,
                    email: v.email,
                    owing: calc,
                    invoices
                }
            }
        }).filter(Boolean)


        let n = 0
        const output = res.map( v => {
            n += v.owing
            const invoice_no = v.invoices.map( v => v.invoice_no).join(',')
            const owing = v.invoices.map( v => v.owing).join(',')
            const paid = v.invoices.map( v => v.paid).join(',')
            const balance = v.invoices.map( v => v.balance()).join(',')


            return `
          
            <div class="ageingbx flex gap-1">
                <div class="ageing-details">
         
                    <h3>${v.fullname}</h3>
                    <small><i class="fa fa-phone fa-lg"></i> ${v.phone}</small>
                    <strong class="lastseen">Owing: GH¢ ${format_number(v.owing)}</strong>
        
                    <a href="javascript:void(0);" class="owinginv" 
                        data-invoice_no="${invoice_no}"  
                        data-owing="${owing}" 
                        data-paid="${paid}" 
                        data-balance="${balance}",
                        data-email="${v.email}"
                        data-owings="${v.owing}"
                    >
                    VIEW DETAILS
                    </a>
        
        
                </div>
            </div>
        
        `
        }).join('')



        classSelector('owingscount').textContent = `GH¢ ${format_number(n)}`

        classSelector('owings').innerHTML = output
})


const Customerswhoowe = ()=>{

return `
<div class="owings"></div>
`
}

export default Customerswhoowe