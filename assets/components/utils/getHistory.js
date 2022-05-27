const getHistory = async ( callback )=>{

    const fch = await fetch('router.php?controller=widget&task=gethistory')

    const data = await fch.json()

    const user = Object.values(data).map(v => {
            return {
                activity: v.activity,
                fullname: v.firstname+' '+v.lastname,
                date: v.date,
                link: v.link,
                type: v.type,
                user_id: v.user_id,
                user_mang: v.user_mang
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