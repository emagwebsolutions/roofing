
import Totalsales from "./Totalsales.js"
import Totalcustomers from "./Totalcustomers.js"
import Totalstocks from "./Totalstocks.js"
import AgeingInvoice from './AgeingInvoice.js'
import { getUsersOnline } from '../global.js'
import HistoryBox from './HistoryBox.js'
import { classSelector } from "../utils/Selectors.js"
import getHistory from "../utils/getHistory.js"
import timeAgo from '../utils/timeAgo.js'
import { formatDate } from '../utils/DateFormats.js'
import Todayleads from './Todayleads.js'
import Customerswhoowe from './Customerswhoowe.js'
import format_number from '../utils/format_number.js'


//classSelector('.searchhistory')

document.addEventListener( 'keyup', e =>{

    if(e.target.matches('.searchhistory')){

        const inpt = e.target.value
        getHistory( data => {
            const history = data.filter( v  => Object.values(v).join('').toLowerCase().includes(inpt.toLowerCase()))
            .map( v => {
                return `
                    <div class="rows">
                    <div>
                        ${v.fullname}
                    </div>
                    <div>
                    ${v.activity}
                    </div>
                    <div>
                    ${timeAgo(v.date)}
                    </div>
                    </div>
                `
            }).join('')
    
            classSelector('hist-bx').innerHTML = history
        })

    }

})

document.addEventListener( 'click', e => {
        if(e.target.matches('.ageinglink')){
            const bx = classSelector('display-invoice-details')
            const dst = bx.classList.add('show-invoice')

            const v = {...e.target.dataset}
            classSelector('invfullname').textContent = v.fullname
            classSelector('invphone').textContent = v.phone
            classSelector('invdays').textContent = v.days+' days remaining'
            classSelector('invproject').textContent = v.project
            classSelector('inv_no').textContent = v.invoice_no
            classSelector('invemail').textContent = v.email
            classSelector('invmessage').textContent = `Your invoice is due on ${formatDate(v.expdate)}`
            classSelector('invsubj').value = v.project      
        }





        if(e.target.matches('.owinginv')){
            const bx = classSelector('display-owings-details')
            const dst = bx.classList.add('show-invoice')

            const v = {...e.target.dataset}

            const balance = v.balance.split(',')
            const invoice_no = v.invoice_no.split(',')
            const owing = v.owing.split(',')
            const paid = v.paid.split(',')

            let arr = []
            for(let i=0; i < invoice_no.length; i++){
                if(balance[i] > 0){
                    arr.push({
                        balance : balance[i],
                        invoice_no: invoice_no[i],
                        owing: owing[i],
                        paid: paid[i],
                        email: v.email,
                        totaloweings: v.owings
                    })
                }
            }

            const resdata = Object.values(arr).map( v => {
                return {
                    email: v.email,
                    totaloweings: v.totaloweings,
                    output: [`
                    <tr>
                    <td>${v.invoice_no}</td>
                    <td>${format_number(v.owing)}</td>
                    <td>${format_number(v.paid)}</td>
                    <td>${format_number(v.balance)}</td>
                    </tr>
                    `]
                }
            })

            const email = [...new Set(resdata.map(v => v.email).filter(Boolean) )].join('')
            const owings = [...new Set(resdata.map(v => v.totaloweings).filter(Boolean) )].join('')
            const output = resdata.map(v => v.output).join('')

            classSelector('owingbody').innerHTML = output
            classSelector('owingemail').value = email
            classSelector('owingmessage').value = `This is to inform you that you have an unpaid arrears of GH¢ ${format_number(owings)}`
    
        }







        if(e.target.matches('.leadslink')){
            const bx = classSelector('display-leads-details')
            const dst = bx.classList.add('show-invoice')

            const v = {...e.target.dataset}

            classSelector('company').textContent = v.company
            classSelector('city').textContent = v.city
            classSelector('mobile').textContent = v.mobile
            classSelector('leadnote').textContent = v.note
            classSelector('stage').textContent = v.stage
        }

        if(e.target.matches('.close-inv-bx')){
            const bx = classSelector('display-invoice-details')
           bx.classList.remove('show-invoice')

            const bx2 = classSelector('display-leads-details')
            bx2.classList.remove('show-invoice')

            const bx3 = classSelector('display-owings-details')
            bx3.classList.remove('show-invoice')


            
        }
})


const Dashboard = ()=>{
    return `

    <div class="container mb-2">
    <div class="row gap-3">
        <div class="col-300">
        ${Totalsales()}
        </div>
        <div class="col-300 bg-warning">
        ${Totalcustomers()}
        </div>
        <div class="col-300 bg-success">
        ${Totalstocks()}
        </div>
    </div>
    </div>

    <div class="container">
        <div class="row gap-3">
            <div class="col-300">




                <div class="ageinginvoice-wrapper">
                    <h4 class="flex space-between"><span>AGING INVOICE</span> <span class="invcount"></span></h4>
                    <div class="ageinginvoice">
                        ${AgeingInvoice()}
        
                    </div>
                    <div class ="display-invoice-details">
                     <div class="invoice-details-title">
                        <a href="javascript:void(0)" title="Close" class="close-inv-bx">&times;</a>
                     </div>
                     <div class="invoice-details-body">


                     <ul class="invheading-wrapper">

                        <li class="invheading"><i class="fa fa-user fa-lg"></i> <span class="invfullname"></span></li>

                        <ul class="invlistcols">
                            <li><i class="fa fa-phone fa-lg"></i> <span class="invphone"></span></li>
                            <li><i class="fa fa-calendar fa-lg"></i> <span class="invdays"></span></li>
                        </ul>

                        <ul class="invlistcols">
                            <li><a href="" title="Invoice"><i class="fa fa-money fa-lg"></i> <span class="inv_no"></span></a></li>
     
                        </ul>
                        <li><i class="fa fa-book fa-lg"></i> <span class="invproject"></span></li>
                     </ul>


                     <div class="invemailbx">
                     <div class="invforminpt">
                     <input type="email" placeholder=" " class="invemail">
                     <label>Email</label>
                     </div>

                     <div class="invforminpt">
                     <input type="text"  placeholder=" " class="invsubj">
                     <label>Subject</label>
                     </div>
         
                     <textarea placeholder="Message" class="invmessage"></textarea>

                     <button>SEND NOTIFICATION</button>
                     </div>

                     </div>
                    </div>
                </div>




            </div>

            <div class="col-500">
                ${HistoryBox()}
            </div>
            <div class="col-300">
                <div class="online">
                    ${getUsersOnline()}
                </div>
            </div>
    </div>
<div class="mb-2"></div>
    <div class="container">
    <div class="row gap-3">

        <div class="col-300">
        <div class="ageinginvoice-wrapper">
        <h4 class="flex space-between"><span>TODAY'S LEADS</span> <span class="leadcount"></span></h4>
        <div class="leadsWrapper">
            ${Todayleads()}
        </div>
        <div class ="display-leads-details">
         <div class="invoice-details-title">
            <a href="javascript:void(0)" title="Close" class="close-inv-bx">&times;</a>
         </div>
         <div class="invoice-details-body">

        <div>
        <h2 class="company mb-1"> </h2>

        <strong class="d-block"> 
        <i class="fa fa-map-marker fa"></i>
        <span class="city"> </span>
        </strong>

        <strong class="d-block"> 
        <i class="fa fa-phone fa"></i>
        <span class="mobile"> </span>
        </strong>

        <strong class="d-block mb-1"> 
        <i class="fa fa-gear fa"></i>
        <span class="stage"> </span>
        </strong>

        <div class="leadnote d-block"> 
        </div>
        </div>

         </div>
        </div>
        </div>

        </div>



        <div class="col-500 bg-warning">
        
        </div>



        <div class="col-300">

        <div class="ageinginvoice-wrapper">
        <h4 class="flex space-between"><span>CUSTOMER'S WHO OWE</span> <span class="owingscount"></span></h4>
        <div class="ageinginvoice">
            ${Customerswhoowe()}

        </div>
        <div class ="display-owings-details">
         <div class="invoice-details-title">
            <a href="javascript:void(0)" title="Close" class="close-inv-bx">&times;</a>
         </div>
         <div class="invoice-details-body">

        <div class="owingtablewrapper">
         <table class="owingtable">
            <thead>
                <th>Invoice</th>
                <th>Amount</th>
                <th>Paid</th>
                <th>Balance</th>
            </thead>
            <tbody class="owingbody">
 

            </tbody>
         </table>
         </div>


         <div class="invemailbx">
         <div class="invforminpt">
         <input type="email" placeholder=" " class="owingemail">
         <label>Email</label>
         </div>

         <textarea placeholder="Message" class="owingmessage"></textarea>

         <button>SEND NOTIFICATION</button>
         </div>

         </div>
        </div>
        </div>

        </div>

    </div>
</div>
    `
}

document.querySelector('.root').innerHTML = Dashboard()