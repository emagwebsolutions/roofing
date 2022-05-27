
import { classValueSelector, classSelector, classModifyValue } from '../../utils/Selectors.js'
import FormSubmitUtils from '../../utils/FormSubmitUtils.js'
import getCustomers from "../../utils/getCustomers.js";

const inputsValues = ()=>{
    const fullname = classValueSelector('fullname')
    const phone = classValueSelector('phone')
    const email = classValueSelector('email')
    const location = classValueSelector('location')
    return { fullname,phone,email,location }
}

export const invoiceto = (fullname,location)=>{
    getCustomers((data)=>{
        const find = data.find( v => v.fullname == fullname && v.location==location)
        document.querySelector('.invto').textContent = fullname
        document.querySelector('.cust_id').value = find.cust_id

 
    })
}

export const addCustomer = async ( e )=>{
    const { Loader,ErrorResult,SuccessResult } = FormSubmitUtils()
    const { fullname,location } = inputsValues()

    if(e.target.matches('.saveCustomer')){

        const obj = Object.assign({
            fullname : '',
            phone: '',
            email: '',
            location: '' 
        },inputsValues())
        
        Loader('output1', 'assets/images/load2.gif')

        const fd = new FormData()
        fd.append('data',JSON.stringify(obj))

        const data = await fetch(`router.php?controller=customer&task=add_new_customer`, {
            method: 'Post',
            body: new URLSearchParams(fd)
        })
        const result = await data.text()

        const indxof = result.indexOf('errors')
        if(indxof != -1){
            ErrorResult('output1',result)
        }
        else{
            SuccessResult('output1',result)
            classModifyValue('fullname',null)
            classModifyValue('phone',null)
            classModifyValue('email',null)
            classModifyValue('location',null)
            const btn = classSelector('buttorn-rounded')
            btn.style.display = "none"
            invoiceto(fullname,location)
        }

    }
}


export const validateRequiredFields = ()=>{
    const { fullname,location } = inputsValues()
    const arr = [fullname,location].every(v => v)
    const btn = classSelector('buttorn-rounded')
    if(arr){
        btn.style.display = 'block'
    }
    else{
        btn.style.display = 'none'
    }
}




