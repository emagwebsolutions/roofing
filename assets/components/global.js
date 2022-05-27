//USERS ONLINE 
import timeAgo from './utils/timeAgo.js'


export const getUsersOnline = async ()=>{

    const user_id = sessionStorage.getItem('zsdf')

    const ftch = await fetch('router.php?controller=widget&task=getusersonline')
    const users = await ftch.json()

    const d = new Date().getTime()

    const res =  Object.values(users).map( v => {
        const times = new Date(v.date).getTime()
        const calc = Number(d) - Number(times)  
        const sec = Number(calc)/1000
        const time = Math.floor(sec)
        if(time < 15){
                return {
                    date: v.date,
                    department: v.department,
                    fullname: v.firstname+' '+v.lastname,
                    photo: v.photo,
                    user_id: v.user_id,
                    user_mang: v.user_mang,
                    status: 'onlinenow',
                    sorting: user_id === v.user_id? 'AAA' : v.firstname+' '+v.lastname
                }
        }
        else{
            return {
                date: v.date,
                department: v.department,
                fullname: v.firstname+' '+v.lastname,
                photo: v.photo,
                user_id: v.user_id,
                user_mang: v.user_mang,
                status: 'offlinenow',
                sorting: user_id === v.user_id? 'ZZZ' : v.firstname+' '+v.lastname
            }
        }
    })

    res.sort((a,b)=>{
        if(a.sorting > b.sorting) return 1
        if(b.sorting > a.sorting) return -1
        return 0
    })

    const online =  Object.values(res).map( v => {
        return `
            <div class="online-bx flex gap-1">
                <div class="prof-img">
                    <img src="assets/images/${v.photo}" alt="Profile pic" /> 
                </div>
                <div class="online-indicator ${v.status.toLowerCase()}"></div>
                <div class="online-details">
                    <h3>${v.fullname}</h3>
                    <small>(${v.department})</small>
                    <br>
                    <strong class="lastseen ${v.status.toLowerCase()}">Last seen: ${timeAgo(v.date)}</strong>
                </div>
            </div>
        `
    }).join('')

    if(document.querySelector('.online')){
        document.querySelector('.online').innerHTML = online
    }

    setTimeout(()=>{
        getUsersOnline()
    },8000)
}

getUsersOnline()


document.addEventListener('click', e =>{
    if(e.target.matches('.fminpt')){
        e.target.removeAttribute('readonly')
    }
})


