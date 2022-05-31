
    document.addEventListener('click', e => {

        if(e.target.matches('[data-tab-target]')){
            const id = e.target.dataset.tabTarget

            Array.from(document.querySelectorAll('.active')).forEach( v => v.classList.remove('active'))   

            Array.from(document.querySelectorAll('[data-tab-target]')).forEach( v => v.classList.remove('active'))
            e.target.parentElement.classList.add('active')
            document.querySelector(id).classList.add('active')
        }

    })


const Tabs = ( tabbtn='',tabcontent='' ) => (
    `<div class="tabs">
        <div class="tabs-top">
            <!-- BEGIN TABS -->
            <div class="tabs-top-inner">
            ${tabbtn}
                <!--<ul>
                <li class="active">
                <a href="javascript:void(0);"            data-tab-target="#tab1">BOX ONE</a>
                </li>
                </ul>-->
            </div>
            <!-- END TABS -->
        </div>

        <div class="tabs-content">
             ${tabcontent}
            <!--<div id="tab1" class="active hide-tab">
            TAB CONTENT ONE
            </div>-->
        </div>
    </div>`

)

export default Tabs