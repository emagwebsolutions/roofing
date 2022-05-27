
import getCRM from "../utils/getCRM.js"
import { classSelector } from "../utils/Selectors.js"
import { ymd } from '../utils/DateFormats.js'

    getCRM( data => {



        const d = ymd(new Date())

        let cnt = 0

        const res = data.map( v => {
            const nd =   ymd(v.date)
            if( (v.category === 'Lead') && (d === nd)){
                cnt++
                const ass = v.note.filter(va => v.crm_id === va.reference)[0]

                return `
                <div class="ageingbx flex gap-1">
                    <div class="ageing-details">
                        <h3>${v.contactname}</h3>
                        <small><i class="fa fa-phone fa-lg"></i> ${v.mobile}</small>
                        <strong >City: ${v.city}</strong>
                        <a href="javascript:void(0);" class="leadslink" 
                            data-company="${v.company}" 
                            data-contactname="${v.contactname}" 
                            data-city="${v.city}" 
                            data-description="${v.description}" 
                            data-mobile="${v.mobile}" 
                            data-industry="${v.industry}" 
                            data-lead_source="${v.lead_source}" 
                            data-lead_status="${v.lead_status}" 
                            data-stage="${v.sales_stage}" 
                            data-note="${ass.message}"
                        >
                        VIEW DETAILS
                        </a>
                    </div>
                </div>
            `
            }
        }).join('')

        classSelector('leadsParent').innerHTML = res
        classSelector('leadcount').innerHTML = cnt

        
    })


const Todayleads = ()=>{

return `
<div class="leadsParent"></div>
`
}

export default Todayleads