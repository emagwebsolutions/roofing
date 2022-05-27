import { textInput } from '../utils/InputFields.js'
import timeAgo from '../utils/timeAgo.js'
import { classSelector } from '../utils/Selectors.js'
import getHistory from '../utils/getHistory.js'



const historyData = ()=>{

     getHistory( user => {

        const history = user.map( v => {
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

        setTimeout(()=>{
            historyData()
        },1000)
    })

}

historyData()



const HistoryBox = ()=>{
    return `
    <div class="hist-wrapper">
        ${
            textInput({
                type: 'text',
                classname: 'searchhistory',
                required: true,
                label: 'Search activities'
            })
        }
        <div class="hist-bx"></div>
    </div>
    `
}

export default HistoryBox