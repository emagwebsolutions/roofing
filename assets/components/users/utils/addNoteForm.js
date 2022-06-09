
//addNoteForm(textInput,textArea)

const addNoteForm = (textInput,textArea) => (`
    <br><br>
    ${
        textInput({
            type: 'date',
            classname: 'notedate',
            required: true,
            label: 'Date'
        })
    }

    ${
        textArea({
            classname: 'notemessage',
            placeholder: 'Message'
        })
    }
    <br>
`)

export default addNoteForm