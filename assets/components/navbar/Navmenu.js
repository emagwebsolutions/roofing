import getMenu from "../utils/getMenu.js"

const Navmenu = ()=>{


    getMenu(( data )=>{

        function menus(data,parent){
            let obj = {}
            data.filter(v => v.menu_parent === parent).forEach(v => obj[v.menu_name] = menus(data,v.menu_name))
            return obj
        }
        const res = menus(data, 'null')


        const arr = Object.entries(res).map( v => {

            let haschildren = ''
            if(Object.keys(v[1]).length){
                haschildren +=`
               <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                ${
                    Object.keys(v[1]).map( c => {
                        const submenulink = c.split(' ').join('').toLowerCase()
                        return `
                        <li>
                        <a class="dropdown-item"  href="?page=${submenulink}">
                        ${c}		
                        </a>
                        </li>
                        `
                    }).join('')
                }
               </ul>
               `
            }

            const parentlink = v[0].split(' ').join('').toLowerCase()

            return `
                <li class="nav-item dropdown">
                    <a  href="${haschildren.length? '#' : `?page=${parentlink}` }"  class="nav-link  ${haschildren.length? 'carrat' : ''}" id="navbarDropdownMenuLink">
                        ${v[0]} 
                    </a>
                    ${ haschildren }
                </li>
            `
        }).join('')

        const otp = `
        <ul class="navbar-nav">
            ${arr}
        </ul>
        `
        document.getElementById('navbaritems').innerHTML = otp

    })

    return ` 

                <nav class="navbar">

           


                        <div id="navbaritems"></div>
    
                        <div>
                        <a class="logout" href="?logout=1">
                        <i class="fa fa-arrow-left fa-lg"></i> LOGOUT
                        </a>

                        <a class="bell-icon" href="#">
                        <i class="fa fa-bell fa-lg"></i>
                        </a>

                        <a class="profile-img" href="#">
                            <img  src="" alt="Profile Photo">
                        </a>
                        </div>


                </nav>
    
    `
}



document.querySelector('.nav-menu').innerHTML = Navmenu()