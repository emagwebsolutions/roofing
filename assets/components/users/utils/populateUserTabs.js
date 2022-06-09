
//populateUserTabs(classSelector,data,Table,formatDate,id)

const populateUserTabs = (classSelector,data,Table,formatDate,id) => {

    //BEGIN NOTE
    const notes = Object.values(data).map( v => v.note.map(v => ({
        note_id: v.note_id,
        id: v.id,
        message: v.message,
        date: v.date
    }))).flat(Infinity)

    const getDetailsOfUserNote = notes.filter( v => v.id === id ).map( v => (`
        <ul>
            <li class="col-100">${formatDate(v.date)}</li>
            <li class="col-600 view-note cursor" data-id="${v.note_id}">${v.message.substring(0,50)}......</li>
            <li class="col-100 flex gap-2">
                <i class="fa fa-edit edit-note cursor" title="EDIT" data-id="${v.note_id}"></i>
                <i class="fa fa-trash delete-note cursor" title="DELETE" data-id="${v.note_id}"></i>
            </li>
        </ul>
    `)).join('')

    
    const tablehead = `
    <ul>
    <li class="col-100">Date</li>
    <li class="col-600">Message</li>
    <li class="col-100">Action</li>
    </ul>
    `

    const tablebody = getDetailsOfUserNote

    classSelector('tabs-content').innerHTML = `
    <div id="tab1" class="active hide-tab">
    ${Table(tablehead,tablebody)}
    </div>
    `
    //END NOTE

}

export default populateUserTabs