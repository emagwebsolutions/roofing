import format_number from '../utils/format_number.js'

export const addTaxes = ()=>{
    const subtotal = document.getElementById('subtotal').value

    let obj = {}
    const amnt = Array.from(document.querySelectorAll('.graTaxes')).forEach( v => {
        obj[v.id] = Number(v.value)
    })

    //DISCOUNT%: discount * subtotal / 100
    const discount = Number(subtotal) * Number(obj.discountinpt) /100
    document.getElementById('discount').value = discount.toFixed(2)

    //Gross: subtotal - discount
    const gross = Number(subtotal) - Number(discount)

    //Covid%: covid * gross / 100
    const covid =  Number(gross) * Number(obj.covid) /100
    document.getElementById('covids').value = covid.toFixed(2)

    //Getfund%: getfund * gross / 100
    const getfund =  Number(gross) * Number(obj.getfund) /100
    document.getElementById('getfunds').value = getfund.toFixed(2)

    //NHIL%: nhil * gross / 100
    const nhil =  Number(gross) * Number(obj.nhil) /100
    document.getElementById('nhils').value = nhil.toFixed(2)


    //VAT%: vat * (gross+covid+getfund+nhil) / 100
    const vat =  Number(obj.vatinp) * (gross+covid+getfund+nhil) / 100
    document.getElementById('vat').value = vat.toFixed(2)
}


export const sumAmountTax = ()=>{
    let obj = {}
    Array.from(document.querySelectorAll('.totalall')).forEach( v => {
        obj[v.id] = Number(v.value)
    })
    const amnt = Number(obj.covids) + Number(obj.getfunds) + Number(obj.nhils) + Number(obj.subtotal) + Number(obj.vat)
    document.querySelector('.grandtotal').value = format_number(amnt)
}
