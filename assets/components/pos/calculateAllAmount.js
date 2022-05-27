const calculateAllAmount = ()=>{
    const amnt = Array.from(document.querySelectorAll('.calc-amount')).reduce((state,arr)=>{
    return Number(state) + Number(arr.value)
    },[0])
    document.querySelector('.subtotal').value = amnt
}
export default calculateAllAmount