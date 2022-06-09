
//getCheckInputValues1( user_id )

const getCheckInputValues1 = ( user_id ) => {
    const previlleges = Array.from(document.querySelectorAll('.previllege'))

    let obj = []
    previlleges.forEach( v => {
        if(v.checked ){

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

    const menus = [
        {
            menu_name: 'Dashboard',	
            menu_parent: 'null',	
            meun_id: '1',		
            user_id
        },
        {
            menu_name: 'Sales',	
            menu_parent: 'null',	
            meun_id: '2',		
            user_id
        },
        {
            menu_name: 'Contacts',	
            menu_parent: 'null',	
            meun_id: '5',		
            user_id
        },
        {
            menu_name: 'Note',	
            menu_parent: 'null',	
            meun_id: '6',		
            user_id
        },
    ]

    const menu_items = Object.values([...menus,...obj]).map( v => Object.values(v)).flat(Infinity)
    return menu_items

}

export default getCheckInputValues1