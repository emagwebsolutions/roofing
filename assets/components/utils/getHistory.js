const getHistory = async ( callback )=>{

    const fch = await fetch('router.php?controller=Widget&task=gethistory')

    const data = await fch.json()

    const user = Object.values(data).map(v => {
            return {
                activity: v.activity,
                fullname: v.firstname+' '+v.lastname,
                date: v.date,
                link: v.link,
                user_id: v.user_id
            }
    }).filter(Boolean)

    user.sort((a,b)=>{
        if(a.date < b.date) return 1
        if(b.date < a.date) return -1
        return 0
    })

    return callback(user)
}

export default getHistory