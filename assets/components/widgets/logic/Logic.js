import { formatMonth } from '../../utils/DateFormats.js'

export const salesdate = ()=>{
    const d = new Date()
    const day = d.getDate()
    const year = d.getFullYear()
    const date = day===1? day: `1 - ${day}` 
    return `As of ${date} ${formatMonth()} ${year}`
}



