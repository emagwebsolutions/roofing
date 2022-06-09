

// addNoteToDatabase(
//     classSelector,
//     getUsers,
//     populateUserTabs,
//     Error,
//     Success,
//     Table,
//     formatDate
// )

const addNoteToDatabase = async (
    classSelector,
    getUsers,
    populateUserTabs,
    Error,
    Success,
    Table,
    formatDate
) => {

    const fd = new FormData()

    const id = classSelector('uid').value
    const message = classSelector('notemessage').value
    fd.append('id', id)
    fd.append('message', message)
    fd.append('date', classSelector('notedate').value)

    const resp = await fetch('router.php?controller=Note&task=add_note',
    {
        method: 'Post',
        body: new URLSearchParams(fd)
    })

    const data = await resp.text()

    if( data.indexOf('errors') != -1 ){
        Error('addNoteModalClass', data)
    }
    else{
        Success('addNoteModalClass',data,'modal-wrapper2')
        classSelector('notemessage').value = null

        getUsers( data => {
            populateUserTabs(classSelector,data,Table,formatDate,id)
        })
    }

}

export default addNoteToDatabase