
//onclickDisplayAsingleUser( v,formatDate )

const onclickDisplayAsingleUser = ( v = [{hire_date: '', firstnae: '', lastname: '',date: ''}],formatDate = () => {} ) => {
    const date = v?.hire_date ? formatDate(v?.hire_date)  : ''
    return  `<ul>
    <li> 
        <ul>
            <li><i class="fa fa-user text-muted"></i> Fullname:</li> 
            <li>${v?.firstname || ''} ${v?.lastname || ''}</li>
        </ul>
    </li>

    <li> 
        <ul>
            <li><i class="fa fa-calendar text-muted"></i> Hire Date:</li> 
            <li>${date}</li>
        </ul>
    </li>

    <li> 
        <ul>
            <li><i class="fa fa-home text-muted"></i> Residence:</li> 
            <li>${v?.residence || ''}</li>
        </ul>
    </li>

    <li> 
        <ul>
            <li><i class="fa fa-phone text-muted"></i> Phone:</li> 
            <li>${v?.phone || ''}</li>
        </ul>
    </li>

</ul>`
}

export default onclickDisplayAsingleUser