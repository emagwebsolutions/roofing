
// getCheckInputValues2( user_id )

const getCheckInputValues2 = ( user_id ) => {

    const previlleges = Array.from(document.querySelectorAll('.previllege'))

    let obj = []

    previlleges.forEach( v => {
        if(v.checked && !v.dataset.menu_id ){

            const meun_id = v.value === 'Products'? 4 : v.value === 'Leads' ? 8 : v.value === 'SMS' ? 7 : 10

            const menu_parent = v.value === 'Salesinvoice'? 'Privileges' : 'null'

            obj.push(
                {
                    menu_name: v.value,	
                    menu_parent,
                    meun_id,	
                    user_id,
                }
            )
        }
    })

    const menu_items = Object.values([...obj]).map( v => Object.values(v)).flat(Infinity)

    return menu_items

}

export default getCheckInputValues2
