
//clearUserCheckboxAndDataset = ()
const clearUserCheckboxAndDataset = () => {

    Array.from(document.querySelectorAll('.previllege')).forEach( v =>{
        v.checked = false
        v.classList.remove('checkClick')
        v.removeAttribute('data-menu_id')
        v.removeAttribute('data-user_id')

    })

}

export default clearUserCheckboxAndDataset