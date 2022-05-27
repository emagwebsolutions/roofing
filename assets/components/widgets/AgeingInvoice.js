
import StocksCallback from "../utils/StocksCallback.js"
import { classSelector } from "../utils/Selectors.js"

    StocksCallback( data => {

        let n = 0
        const res = data.map( v => {
        
            return v.expiries.map( v => {
                n++
                return `
              
                <div class="ageingbx flex gap-1">
                    <div class="ageing-details">
             
                        <h3>${v.fullname}</h3>
                        <small><i class="fa fa-phone fa-lg"></i> ${v.phone}</small>
                        <strong class="lastseen">Expiry date: ${v.expdate}</strong>

                        <a href="javascript:void(0);" class="ageinglink" 
                            data-days="${v.days}"  
                            data-email="${v.email}" 
                            data-expdate="${v.expdate}" 
                            data-fullname="${v.fullname}" 
                            data-invoice_no="${v.invoice_no}" 
                            data-phone="${v.phone}"     
                            data-project="${v.project}"  
                        >
                        VIEW DETAILS
                        </a>


                    </div>
                </div>
        
            `
            })

        }).join('')

        classSelector('invcount').textContent = n

        classSelector('ageinginv').innerHTML = res
    })


const AgeingInvoice = ()=>{

return `
<div class="ageinginv"></div>
`
}

export default AgeingInvoice