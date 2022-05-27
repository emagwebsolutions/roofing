const showButton = ()=>{
    const subtotal = document.getElementById('subtotal').value
    const save_invoice = document.querySelector('.save_invoice')
    if(subtotal > 0){
        save_invoice.style.display = 'block'
    }
    else{
        save_invoice.style.display = 'none'
    }
}
export default showButton